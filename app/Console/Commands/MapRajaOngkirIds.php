<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Province;
use App\Models\Regency; // <-- Perbaikan 1: Gunakan huruf kapital
use App\Models\District;

class MapRajaOngkirIds extends Command
{
    protected $signature = 'map:rajaongkir-ids';
    protected $description = 'Fetch and map region IDs from RajaOngkir/Komerce API to the local database.';
    protected $apiKey;
    protected $baseUrl = 'https://rajaongkir.komerce.id/api/v1/destination/';

    public function __construct()
    {
        parent::__construct();
        $this->apiKey = env('RAJAONGKIR_API_KEY');
    }

    private function normalizeName($name)
    {
        $name = str_replace(['KABUPATEN ', 'KOTA '], '', strtoupper($name));
        return trim($name);
    }

    public function handle()
    {
        if (!$this->apiKey) {
            $this->error('RAJAONGKIR_API_KEY is not set in your .env file.');
            return 1;
        }

        $this->info('Starting to map RajaOngkir IDs...');
        $this->mapProvinces();
        $this->mapRegencies(); // <-- Perbaikan 2: Panggil method yang benar
        $this->mapDistricts();
        $this->info('All regions have been mapped successfully! ✅');
        return 0;
    }

    private function mapProvinces()
    {
        $this->line('Mapping provinces...');
        $response = Http::withHeaders(['key' => $this->apiKey])->get($this->baseUrl . 'province');
        if (!$response->successful() || $response->json()['meta']['status'] !== 'success') {
            $this->error('Failed to fetch provinces from API.');
            return;
        }

        $apiProvinces = $response->json()['data'];
        $localProvinces = Province::all();
        $progressBar = $this->output->createProgressBar(count($localProvinces));
        $progressBar->start();

        foreach ($localProvinces as $local) {
            foreach ($apiProvinces as $api) {
                if ($this->normalizeName($local->name) == $this->normalizeName($api['name'])) {
                    $local->rajaongkir_id = $api['id'];
                    $local->save();
                    break;
                }
            }
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);
    }

    // Mengganti nama method dari mapCities menjadi mapRegencies
    private function mapRegencies()
    {
        $this->line('Mapping regencies (cities)...');
        $localProvinces = Province::whereNotNull('rajaongkir_id')->get();
        
        foreach ($localProvinces as $localProvince) {
            $response = Http::withHeaders(['key' => $this->apiKey])->get($this->baseUrl . 'city/' . $localProvince->rajaongkir_id);
            if (!$response->successful() || !isset($response->json()['data']) || $response->json()['meta']['status'] !== 'success') {
                $this->warn("Could not fetch regencies for province: {$localProvince->name}");
                continue;
            }

            $apiRegencies = $response->json()['data'];
            // Mengganti relasi dari cities() menjadi regencies()
            $localRegencies = $localProvince->regencies()->get();
            
            if ($localRegencies->isEmpty()) continue;

            $progressBar = $this->output->createProgressBar(count($localRegencies));
            $this->line("-> Mapping for province: {$localProvince->name}");
            $progressBar->start();

            foreach ($localRegencies as $local) {
                foreach ($apiRegencies as $api) {
                    // API kadang menggunakan 'name', kadang 'city_name'
                    if ($this->normalizeName($local->name) == $this->normalizeName($api['city_name'] ?? $api['name'])) {
                        // API kadang menggunakan 'id', kadang 'city_id'
                        $local->rajaongkir_id = $api['city_id'] ?? $api['id'];
                        $local->save();
                        break;
                    }
                }
                $progressBar->advance();
            }
            $progressBar->finish();
            $this->newLine();
        }
        $this->newLine();
    }

    private function mapDistricts()
    {
        $this->line('Mapping districts...');
        $localRegencies = Regency::whereNotNull('rajaongkir_id')->get();

        foreach ($localRegencies as $localRegency) {
            $response = Http::withHeaders(['key' => $this->apiKey])->get($this->baseUrl . 'district/' . $localRegency->rajaongkir_id);
            if (!$response->successful() || !isset($response->json()['data']) || $response->json()['meta']['status'] !== 'success') {
                $this->warn("Could not fetch districts for regency: {$localRegency->name}");
                continue;
            }

            $apiDistricts = $response->json()['data'];
            $localDistricts = $localRegency->districts()->get();
            
            if ($localDistricts->isEmpty()) continue;

            $progressBar = $this->output->createProgressBar(count($localDistricts));
            $this->line("-> Mapping for regency: {$localRegency->name}");
            $progressBar->start();

            foreach ($localDistricts as $local) {
                foreach ($apiDistricts as $api) {
                    if ($this->normalizeName($local->name) == $this->normalizeName($api['district_name'] ?? $api['name'])) {
                        $local->rajaongkir_id = $api['district_id'] ?? $api['id'];
                        $local->save();
                        break;
                    }
                }
                $progressBar->advance();
            }
            $progressBar->finish();
            $this->newLine();
        }
        $this->newLine();
    }
}
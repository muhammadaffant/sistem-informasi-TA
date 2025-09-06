<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bahan;

class UpdateBahanWeightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing bahans with default weights
        $bahanWeights = [
            'Katun' => 150,         // gram per unit
            'Polyester' => 120,     // gram per unit
            'Cotton Combed' => 160, // gram per unit
            'PE' => 100,            // gram per unit
            'Spandex' => 140,       // gram per unit
            'Linen' => 180,         // gram per unit
            'Rayon' => 130,         // gram per unit
            'Denim' => 300,         // gram per unit
            'Fleece' => 250,        // gram per unit
            'Jersey' => 170,        // gram per unit
        ];

        foreach ($bahanWeights as $namaBahan => $weight) {
            Bahan::where('nama_bahan', 'LIKE', '%' . $namaBahan . '%')
                  ->update(['weight' => $weight]);
        }

        // Set default weight for any bahan that doesn't have weight set
        Bahan::whereNull('weight')->orWhere('weight', 0)->update(['weight' => 150]);
        
        $this->command->info('Bahan weights updated successfully!');
    }
}

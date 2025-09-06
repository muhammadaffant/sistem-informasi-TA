<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CustomOrder;

class MigrateOldDesignData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customorder:migrate-design-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate old custom order design data to new front/back design structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration of old design data...');
        
        // Ambil semua custom order yang belum memiliki front_design_file
        $customOrders = CustomOrder::whereNull('front_design_file')
                                   ->whereNotNull('file_design')
                                   ->get();

        $this->info("Found {$customOrders->count()} records to migrate.");

        $migrated = 0;
        
        foreach ($customOrders as $order) {
            try {
                // Pindahkan file_design ke front_design_file
                $order->update([
                    'front_design_file' => $order->file_design,
                    'front_position' => $order->position,
                    'has_back_design' => false
                ]);
                
                $migrated++;
                $this->line("Migrated order ID: {$order->id}");
                
            } catch (\Exception $e) {
                $this->error("Failed to migrate order ID {$order->id}: " . $e->getMessage());
            }
        }
        
        $this->info("Migration completed! {$migrated} records migrated successfully.");
        
        return 0;
    }
}

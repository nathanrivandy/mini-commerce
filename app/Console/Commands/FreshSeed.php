<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FreshSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fresh:seed {--force : Force the operation without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fresh migrate and seed the database with sample data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('This will delete all existing data and recreate the database. Do you want to continue?')) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        $this->info('🔄 Refreshing database...');
        $this->call('migrate:fresh');

        $this->info('🌱 Seeding database...');
        $this->call('db:seed');

        $this->newLine();
        $this->info('✅ Database refreshed and seeded successfully!');
        $this->newLine();
        
        $this->line('👑 Admin Credentials:');
        $this->line('   Email: admin@minicommerce.com');
        $this->line('   Password: password');
        $this->newLine();
        
        $this->line('👤 Test User Credentials:');
        $this->line('   Email: john@example.com');
        $this->line('   Password: password');
        $this->newLine();
        
        $this->line('🎉 Your Mini Commerce application is ready to use!');
        
        return 0;
    }
}

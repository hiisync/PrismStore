<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateAPIKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-key:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API key for the application';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $key = Str::random(32);

        $file = base_path('.env');

        if (file_exists($file)) {
            file_put_contents($file, str_replace(
                'APP_API_KEY=',
                'APP_API_KEY='.$key,
                file_get_contents($file)
            ));
        } elseif (! file_exists($file)) {
            $this->error('The environment file was not found. Please create one.');
        } else {
            file_put_contents($file, "APP_API_KEY={$key}");
        }

        $this->info('API key generated successfully.');
    }
}

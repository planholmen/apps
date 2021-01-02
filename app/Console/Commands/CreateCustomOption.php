<?php

namespace App\Console\Commands;

use App\CustomOption;
use Illuminate\Console\Command;

class CreateCustomOption extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'option:add {key : The key of the key-value pair} {value : The value of the key-value pair}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a custom option directly to the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $key = $this->argument('key');
        $value = $this->argument('value');

        if (strlen($key) < 2 || strlen($value) < 2) {
            $this->info('Key and value length should be at least 2 characters each. Exiting...');
            return;
        }

        if (CustomOption::find($key) != null) {
            $this->info('The specified custom option already exists. Exiting...');
            return;
        }

        CustomOption::create([
            'key' => $key,
            'value' => $value
        ]);

         $this->info('Added custom option with key: ' . strtoupper($key));
    }
}

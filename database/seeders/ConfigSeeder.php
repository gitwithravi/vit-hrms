<?php

namespace Database\Seeders;

use App\Models\Config\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = Config::firstOrCreate(['name' => 'system']);
        $config->value = [
            'show_setup_wizard' => true,
            'enable_dark_theme' => false,
        ];
        $config->save();
    }
}

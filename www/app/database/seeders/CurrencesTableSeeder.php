<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currence;

class CurrencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'USD', 'convert_name' => 'RUB', 'value' => 60],
            ['name' => 'RUB', 'convert_name' => 'USD', 'value' => 0.0165],
        ];

        foreach ($data as $item) {
            Currence::create($item);
        }
    }
}

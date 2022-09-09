<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(2)
            ->create()
            ->each(function ($user) {
                $currencyName = $user['id'] % 2 === 0 ? 'USD' : 'RUB';

                $data = ['user_id' => $user['id'], 'balance' => 50, 'currency_name' => $currencyName];

                Wallet::create($data);
            });
    }
}

<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'firstname' => 'hussein',
            'lastname' => 'halloum',
            'email' => 'hussein@example.com',
            'phone' => '+961 70700770',
            'password' => 'hussein123!',
        ]);
    }
}

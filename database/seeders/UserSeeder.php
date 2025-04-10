<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->admin()->create([
            'name' => 'Milka',
            'email' => 'kulak.rylut@gmail.com',
            'password' => bcrypt('agent007'),
        ]);

        //User::factory()->teacher()->count(5)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user if not exists
        User::firstOrCreate(
            ['email' => 'admin@papigpt.local'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Compte principal — créé ou mis à jour à chaque démarrage
        User::updateOrCreate(
            ['email' => 'sidihcamara1945@gmail.com'],
            [
                'name' => 'Sidi Camara',
                'password' => Hash::make('sidihcamara'),
            ]
        );

        $this->call(TemplateSeeder::class);
    }
}

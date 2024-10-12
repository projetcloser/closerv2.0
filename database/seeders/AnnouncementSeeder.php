<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 5; $i++) {
            Announcement::create([
                'object' => $faker->sentence,
                'body' => $faker->paragraph,
                'attachment' => $faker->filePath("tmp/file.pdf"),
                'author' => $faker->userName
            ]);
        }
    }
}

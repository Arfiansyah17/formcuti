<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('leaves')->insert([
            [
                'full_name' => 'John Doe',
                'duration' => 14, // dalam hari
                'reason' => 'Vacation',
                'letter_date' => '2024-08-07',
                'signature1' => 'path/to/signature1.jpg',
                'signature2' => 'path/to/signature2.jpg'
            ],
            // Data lainnya
        ]);
    }
}    
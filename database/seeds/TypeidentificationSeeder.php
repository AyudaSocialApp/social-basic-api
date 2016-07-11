<?php

use Illuminate\Database\Seeder;
use App\Models\Typeidentification;

class TypeidentificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('typeidentifications')->delete();
        Typeidentification::create(['name' => 'CÉDULA']);
        Typeidentification::create(['name' => 'CÉDULA DE EXTRANJERÍA ']);
        Typeidentification::create(['name' => 'PASAPORTE']);
        Typeidentification::create(['name' => 'NIT']);
    }
}

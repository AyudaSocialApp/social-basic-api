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
        Typeidentification::create(['id'=>1, 'name' => 'CÉDULA']);
        Typeidentification::create(['id'=>2, 'name' => 'CÉDULA DE EXTRANJERÍA ']);
        Typeidentification::create(['id'=>3, 'name' => 'PASAPORTE']);
        Typeidentification::create(['id'=>4, 'name' => 'NIT']);
    }
}

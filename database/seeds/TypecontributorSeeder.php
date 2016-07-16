<?php

use Illuminate\Database\Seeder;
use App\Models\Typecontributor;

class TypecontributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('typecontributors')->delete();
        Typecontributor::create(['id'=>1, 'name' => 'Particular']);
        Typecontributor::create(['id'=>2, 'name' => 'Familia']);
        Typecontributor::create(['id'=>3, 'name' => 'Empresa']);
    }
}

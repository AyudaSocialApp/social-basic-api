<?php

use Illuminate\Database\Seeder;
use App\Models\Typehelp;

class TypeHelpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('typehelps')->delete();
        Typehelp::create(['id'=>1, 'name' => 'Mercado']);
        Typehelp::create(['id'=>2, 'name' => 'Ropa']);
    }
}

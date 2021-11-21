<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currencies;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = array_map('str_getcsv', file(__DIR__.'\currencies.csv'));
        $header = array_shift($rows);
        $csv = array();
        foreach ($rows as $row) {
            $csv[] = array_combine($header, $row);
        }
        Currencies::insert($csv);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Bustype;

class BusTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bustype = new Bustype;
        $bustype
		   	->setTranslation('name', 'en', 'VIP Express')
		   	->setTranslation('name', 'mm', 'အဆင့်မြင့်ကားကြီး');
		$bustype->manufacturer = "Romany Berger";
		$bustype->save();

		$bustype = new Bustype;
        $bustype
        	->setTranslation('name', 'en', 'Express')
		   	->setTranslation('name', 'mm', 'ရိုးရိုးကား');
		$bustype->manufacturer = "Serenity Power";
		$bustype->save();

		$bustype = new Bustype;
        $bustype
		   	->setTranslation('name', 'en', 'Hilux')
		   	->setTranslation('name', 'mm', 'ကားငယ်');
		$bustype->manufacturer = "Toyota";
		$bustype->save();
    }
}

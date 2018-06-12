<?php

use App\Utils\Keys\common\ApplicationKeys;
use App\Utils\Keys\common\StatusKeys;
use Illuminate\Database\Seeder;

class StoreTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $personalData = [
            ['id' => 3, 'name' => '', 'last_name' => '', 'company_name' => 'Refacciones para motos lopez'],
        ];

        $locationData = [
            ['id' => 3, 'address' => 'Calle 17 No. 101-A 20 y 22', 'postal_code' => '', 'city' => 'Dzidzantun Yucatán', 'phone' => '', 'cell_phone' => '', 'email' => '']
        ];

        $store = [
            ['id' => ApplicationKeys::STORE_ID, 'status_id' => StatusKeys::STATUS_ACTIVE, 'personal_data_id' => 3, 'location_data_id' => 3]
        ];

        DB::table('personal_data')->insert($personalData);

        DB::table('location_data')->insert($locationData);

        DB::table('store')->insert($store);
    }
}

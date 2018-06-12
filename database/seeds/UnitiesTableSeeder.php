<?php

use App\Utils\Keys\common\StatusKeys;
use Illuminate\Database\Seeder;
use App\Utils\Keys\common\ApplicationKeys;

class UnitiesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $unitites = [
            ['id' => ApplicationKeys::UNITY_PRODUCT, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => 'Pza / Unidad'],
            ['id' => ApplicationKeys::BULK_PRODUCT, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => 'A Granel']
        ];

        DB::table('unities')->insert($unitites);
    }
}

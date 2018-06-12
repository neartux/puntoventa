<?php

use App\Utils\Keys\common\ApplicationKeys;
use App\Utils\Keys\common\StatusKeys;
use App\Utils\Keys\user\UserKeys;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $personalData = [
            ['id' => 2, 'name' => 'Publico en general', 'last_name' => '', 'company_name' => ''],
        ];

        $locationData = [
            ['id' => 2, 'address' => 'Merida', 'cell_phone' => '9999', 'email' => 'client@hotmail.com']
        ];

        $client = [
            ['id' => ApplicationKeys::CLIENT_GENERAL_PUBLIC, 'status_id' => StatusKeys::STATUS_ACTIVE, 'personal_data_id' => 2, 'location_data_id' => 2]
        ];

        DB::table('personal_data')->insert($personalData);

        DB::table('location_data')->insert($locationData);

        DB::table('clients')->insert($client);

    }
}

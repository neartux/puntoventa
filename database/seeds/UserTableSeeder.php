<?php

use App\Utils\Keys\common\StatusKeys;
use App\Utils\Keys\store\StoreKeys;
use App\Utils\Keys\user\UserKeys;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $personalData = [
            ['id' => 1, 'name' => 'Admin', 'last_name' => ''],
        ];

        $locationData = [
            ['id' => 1, 'address' => 'Merida', 'postal_code' => '97000', 'city' => 'Merida', 'phone' => '9993599516', 'cell_phone' => '9993599516', 'email' => UserKeys::EMAIL_ROOT_USER]
        ];

        $user = [
            ['id' => UserKeys::USER_ROOT_ID, 'status_id' => StatusKeys::STATUS_ACTIVE, 'personal_data_id' => 1, 'location_data_id' => 1, 'user_name' => UserKeys::USER_ROOT, 'password' => bcrypt(UserKeys::PASSWORD_USER_ROOT)]
        ];

        DB::table('personal_data')->insert($personalData);

        DB::table('location_data')->insert($locationData);

        DB::table('users')->insert($user);

        $pDU = [
            ['id' => 4, 'name' => 'Felipe', 'last_name' => 'Lopez'],
        ];

        $lDU = [
            ['id' => 4, 'address' => 'Merida', 'cell_phone' => '9911108191', 'email' => 'flopez@hotmail.com']
        ];

        $userS = [
            ['status_id' => StatusKeys::STATUS_ACTIVE, 'personal_data_id' => 4, 'location_data_id' => 4, 'user_name' => 'f.lopez', 'password' => bcrypt('flopez@2018')]
        ];

        DB::table('personal_data')->insert($pDU);

        DB::table('location_data')->insert($lDU);

        DB::table('users')->insert($userS);


    }

}

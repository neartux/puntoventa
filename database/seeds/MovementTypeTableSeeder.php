<?php

use App\Utils\Keys\common\ApplicationKeys;
use App\Utils\Keys\common\StatusKeys;
use Illuminate\Database\Seeder;

class MovementTypeTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $entrada = [
            ['id' => ApplicationKeys::MOVEMENT_TYPE_ENTRADA, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => 'Entrada']
        ];

        $salida = [
            ['id' => ApplicationKeys::MOVEMENT_TYPE_SALIDA, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => 'Salida']
        ];

        DB::table('movement_types')->insert($entrada);

        DB::table('movement_types')->insert($salida);
    }
}

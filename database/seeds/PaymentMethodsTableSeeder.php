<?php

use App\Utils\Keys\common\ApplicationKeys;
use App\Utils\Keys\common\StatusKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $methodChash = [
            ['id' => ApplicationKeys::PAYMENT_METHOD_CASH, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => 'Efectivo', 'abbreviation' => 'C']
        ];

        DB::table('payment_methods')->insert($methodChash);

    }
}

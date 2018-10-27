<?php

use App\Utils\Keys\common\ApplicationKeys;
use App\Utils\Keys\common\StatusKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReasonWithdrawalCajaTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $reason = [
            ['id' => ApplicationKeys::REASON_WITHDRAWAL_SALE_CANCELLATION, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => 'Cancelacion de venta'],
            ['id' => ApplicationKeys::REASON_WITHDRAWAL_PAYMENT_PROVIDER, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => 'Pago a Proveedor'],
            ['id' => ApplicationKeys::REASON_WITHDRAWAL_PAYMENT_NOTE, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => 'Pago de Nota'],
            ['id' => ApplicationKeys::REASON_WITHDRAWAL_OTHER, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => 'Otro'],
        ];

        DB::table('reason_withdrawal_caja')->insert($reason);
    }
}

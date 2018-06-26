<?php

use App\Utils\Keys\common\ApplicationKeys;
use App\Utils\Keys\common\StatusKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdjustmentReasonTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $adjustment_sale = [
            ['id' => ApplicationKeys::ADJUSTMENT_REASON_BY_SALE, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => 'Ajuste por venta', 'abbreviation' => 'AV']
        ];

        $adjustment_cancellation = [
            ['id' => ApplicationKeys::ADJUSTMENT_REASON_BY_SALE_CANCELLATION, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => 'Ajuste por cancelación de venta', 'abbreviation' => 'ACV']
        ];

        $AEP = [
            ['id' => ApplicationKeys::ADJUSTMENT_REASON_BY_PRODUCT_ENTRY, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => 'Entrada de producto', 'abbreviation' => 'AEP', 'sign' => '+']
        ];

        $ASP = [
            ['id' => ApplicationKeys::ADJUSTMENT_REASON_BY_PRODUCT_OUTPUT, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => 'Salida de producto', 'abbreviation' => 'ASP', 'sign' => '-']
        ];

        $APD = [
            ['id' => ApplicationKeys::ADJUSTMENT_REASON_BY_DAMAGED_PRODUCT, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => 'Producto Dañado', 'abbreviation' => 'APD', 'sign' => '-']
        ];

        DB::table('adjustment_reasons')->insert($adjustment_sale);
        DB::table('adjustment_reasons')->insert($adjustment_cancellation);
        DB::table('adjustment_reasons')->insert($AEP);
        DB::table('adjustment_reasons')->insert($ASP);
        DB::table('adjustment_reasons')->insert($APD);
    }
}

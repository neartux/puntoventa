<?php

use App\Utils\Keys\common\ApplicationKeys;
use Illuminate\Database\Seeder;

class PrintingFormatTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $printingF = [
            ['id' => ApplicationKeys::PRINTING_FORMAT_TICKET, 'name' => 'Impresión ticket', 'comments' => 'En partes electricas no hay cambios ni devoluciones'],
        ];

        $printingC = [
            ['id' => 1, 'printing_format_id' => ApplicationKeys::PRINTING_FORMAT_TICKET, 'header_x' => 20, 'header_y' => -38,
             'header_size' => 10, 'logo_x' => 10, 'logo_y' => 12, 'logo_size' => 66,
             'folio_x' => 15, 'folio_y' => 10, 'folio_size' => 10, 'date_x' => 225, 'date_y' => -10, 'date_size' => 10,
             'body_x' => 2, 'body_y' => 10, 'body_size' => 10, 'footer_x' => 10, 'footer_y' => 0, 'footer_size' => 10],
        ];

        DB::table('printing_formats')->insert($printingF);
        DB::table('printing_formats_configurations')->insert($printingC);
    }
}

<?php

use App\Utils\Keys\common\ApplicationKeys;
use App\Utils\Keys\common\StatusKeys;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DeparmentTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $deparment = [
            ['id' => ApplicationKeys::DEPARMENT_NA, 'status_id' => StatusKeys::STATUS_ACTIVE, 'description' => '- Sin Departamento -'],
        ];

        DB::table('deparments')->insert($deparment);

        // Si existe el archivo procede a hacer la exportacion de productos
        if(file_exists('/home/ricardo/Downloads/excel.xlsx')) {
            try {
                // Obtiene y lee el excel
                Excel::load('/home/ricardo/Downloads/excel.xls', function($reader) {
                    // Getting all results
                    $results = $reader->get();
                    $deparmentId = ApplicationKeys::DEPARMENT_NA;
                    $statusId = StatusKeys::STATUS_ACTIVE;
                    $unitId = ApplicationKeys::UNITY_PRODUCT;
                    // Itera cada fila de la hoja de excel
                    foreach ($results as $row) {
                        $codigo = $row['codigo'];
                        $description = $row['descripcion'];
                        $precio_costo = str_replace("$", "", $row['precio_costo']);
                        $precio_venta = str_replace("$", "", $row['precio_venta']);
                        $precio_mayoreo = str_replace("$", "", $row['precio_mayoreo']);
                        $inventario = $row['inventario'];
                        $invt_minimo = $row['inv._minimo'];

                        $product = [
                            ['status_id' => $statusId, 'unit_id' => $unitId, 'deparment_id' => $deparmentId, 'code' => preg_replace('/\s+/', '', $codigo),
                                'description' => trim($description), 'purchase_price' => floatval($precio_costo),
                                'sale_price' => floatval($precio_venta), 'wholesale_price' => floatval($precio_mayoreo),
                                'created_at' => \Carbon\Carbon::now(), 'current_stock' => $inventario, 'minimum_stock' => $invt_minimo],
                        ];

                        DB::table('products')->insert($product);
                    }

                });
            } catch (\Exception $e){
                echo $e->getMessage() ."\n";
            }
        } else {
            echo "File not found, product export not work \n";
        }
    }
}

<?php
/**
 * User: ricardo
 * Date: 4/04/18
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\PrintingFormats;
use App\Models\PrintingFormatsConfiguration;
use App\Repository\user\UserInterface;
use App\Utils\Keys\common\ApplicationKeys;
use Illuminate\Http\Request;

class ConfigurationController extends Controller {

    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserInterface $user) {
        $this->middleware('auth');
        $this->user = $user;
    }

    public function configurationTicket() {
        return view('admin.configuration.ticket');
    }

    public function findStore() {
        return response()->json($this->user->findStore());
    }

    public function findPrintingTicketById($formatId) {
        return response()->json($this->user->findPrintingTicketById($formatId));
    }

    public function saveConfiguration(Request $request) {
        try {
            $logo_x = $request->input('logo_x');
            $logo_y = $request->input('logo_y');
            $logo_size = $request->input('logo_size');

            $header_x = $request->input('header_x');
            $header_y = $request->input('header_y');
            $header_size = $request->input('header_size');

            $folio_x = $request->input('folio_x');
            $folio_y = $request->input('folio_y');
            $folio_size = $request->input('folio_size');

            $date_x = $request->input('date_x');
            $date_y = $request->input('date_y');
            $date_size = $request->input('date_size');

            $body_x = $request->input('body_x');
            $body_y = $request->input('body_y');
            $body_size = $request->input('body_size');

            $footer_x = $request->input('footer_x');
            $footer_y = $request->input('footer_y');
            $footer_size = $request->input('footer_size');

            $comments = $request->input('comments');

            // TODO cambiar key en un futuro
            $format = PrintingFormats::find(ApplicationKeys::PRINTING_FORMAT_TICKET);

            $format->comments = $comments;
            $format->save();
            // TODO cambiar key en un futuro
            $configuration = PrintingFormatsConfiguration::find(ApplicationKeys::PRINTING_FORMAT_TICKET);

            $configuration->logo_x = $logo_x;
            $configuration->logo_y = $logo_y;
            $configuration->logo_size = $logo_size;

            $configuration->header_x = $header_x;
            $configuration->header_y = $header_y;
            $configuration->header_size = $header_size;

            $configuration->folio_x = $folio_x;
            $configuration->folio_y = $folio_y;
            $configuration->folio_size = $folio_size;

            $configuration->date_x = $date_x;
            $configuration->date_y = $date_y;
            $configuration->date_size = $date_size;

            $configuration->body_x = $body_x;
            $configuration->body_y = $body_y;
            $configuration->body_size = $body_size;

            $configuration->footer_x = $footer_x;
            $configuration->footer_y = $footer_y;
            $configuration->footer_size = $footer_size;

            $configuration->save();

            return response()->json(array("error" => false, "message" => "Se ha guardado la configuración correctament"));
        } catch (\Exception $e){
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

    public function downloadBackupDataBase() {
        $this->EXPORT_TABLES();
    }

    private function EXPORT_TABLES() {
        set_time_limit(3000);
        $queryTables = DB::select('SHOW TABLES');
        foreach ($queryTables as $key => $value) {
            $target_tables[] = $value->Tables_in_puntoventadb;
        }

        $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `puntoventadb`\r\n--\r\n\r\n\r\n";

        foreach ($target_tables as $table) {

            if ($table == 'adjustment_reasons' || $table == 'adjustments' || $table == 'clients' || $table == 'deparments' || $table == 'general_parameters' || $table == 'location_data' || $table == 'movements_caja' || $table == 'password_resets' || $table == 'permissions' || $table == 'personal_data' || $table == 'products' || $table == 'promotions' || $table == 'roles' || $table == 'sale_details' || $table == 'sales' || $table == 'store' || $table == 'users') {
            //if ($table == 'adjustment_reasons' || $table == 'adjustments' || $table == 'clients' || $table == 'deparments') {
                if (empty($table)) {
                    continue;
                }

                $result = DB::select('SELECT * FROM `' . $table . '`');
                $fields_amount = 0;
                foreach ($result as $item) {
                    foreach ($item as $column){
                        $fields_amount += 1;
                    }
                    break;
                }
                $rows_num = count($result);

                $TableMLine = DB::select('SHOW CREATE TABLE ' . $table);
                foreach ($TableMLine as $row) {
                    $value1 = (array)$row;
                    $content .= "\n\n" . $value1['Create Table'] . ";\n\n";
                    break;
                }

                for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
                    foreach ($result as $key => $value) {
                        if ($st_counter % 100 == 0 || $st_counter == 0) {
                            $content .= "\nINSERT INTO " . $table . " VALUES";
                        }
                        $content .= "\n(";
                        $fila = (array)$value;
                        $newRow = [];
                        foreach ($fila as $item) {
                            $newRow[] = str_replace("\n", "\\n", addslashes($item));
                        }

                        for ($j = 0; $j < $fields_amount; $j++) {
                            if (isset($newRow)) {
                                $content .= '"' . $newRow[$j] . '"';
                            } else {
                                $content .= '""';
                            }
                            if ($j < ($fields_amount - 1)) {
                                $content .= ',';
                            }
                        }
                        $content .= ")";

                        //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                        if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
                            $content .= ";";
                        } else {
                            $content .= ",";
                        }
                        $st_counter = $st_counter + 1;


                    }
                }
            }


        }


        $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";

        $backup_name = "puntoventadb_" . date('H-i-s') . "_" . date('d-m-Y') . ".sql";

        ob_get_clean();
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
        echo $content;
        exit;

    }

}
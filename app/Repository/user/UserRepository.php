<?php
/**
 * User: ricardo
 * Date: 3/04/18
 */

namespace App\Repository\user;


use App\User;
use App\Utils\Keys\common\StatusKeys;
use App\Utils\Keys\user\UserKeys;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface {

    private $user;

    /**
     * UserRepository constructor.
     * @param $user
     */
    public function __construct(User $user) {
        $this->user = $user;
    }


    public function updatePassword($userId, $password) {
        $user = $this->user->findById($userId);
        $user->password = bcrypt($password);
        $user->save();
    }

    public function findAllUsers() {
        return DB::select("SELECT users.id,users.user_name,personal_data.name,personal_data.last_name
          FROM users
          INNER JOIN personal_data ON users.personal_data_id = personal_data.id
          WHERE users.status_id = ".StatusKeys::STATUS_ACTIVE."
          AND users.id != ".UserKeys::USER_ROOT_ID);
    }

    public function findStore() {
        return DB::select("SELECT personal_data.company_name,location_data.address,location_data.city
        FROM store
        INNER JOIN personal_data ON store.personal_data_id = personal_data.id
        INNER JOIN location_data ON store.location_data_id = location_data.id");
    }

    public function findPrintingTicketById($printingFormatId) {
        return DB::select("SELECT *
        FROM printing_formats
        INNER JOIN printing_formats_configurations ON printing_formats.id = printing_formats_configurations.printing_format_id
        WHERE printing_formats.id = ".$printingFormatId);
    }
}
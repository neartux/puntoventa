<?php
/**
 * User: ricardo
 * Date: 3/04/18
 */

namespace App\Repository\user;


use App\Models\LocationData;
use App\Models\PersonalData;
use App\User;
use App\Utils\Keys\common\ApplicationKeys;
use App\Utils\Keys\common\NumberKeys;
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
        // Valida que exista el usuario
        if (! $user) {
            throw new \Exception("No existe el usuario");
        }
        $user->password = bcrypt($password);
        $user->updated_at = \Carbon\Carbon::now();
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

    public function existUserName($id, $userName) {
        return DB::selectOne('SELECT count(*) > '.NumberKeys::NUMBER_ZERO.' exist FROM users WHERE id != '.$id.' AND status_id = '.StatusKeys::STATUS_ACTIVE.' AND UPPER(user_name) = \''.$userName.'\'')->exist;
    }

    public function saveUser($userData) {
        $location_data = new LocationData();
        $location_data->address = $userData['address'];
        $location_data->phone = $userData['phone'];
        $location_data->cell_phone = $userData['cell_phone'];
        $location_data->email = $userData['email'];

        $location_data->save();

        $personal_data = new PersonalData();

        $personal_data->name = $userData['name'];
        $personal_data->last_name = $userData['last_name'];

        $personal_data->save();

        $user_ = new User();
        $user_->status_id = StatusKeys::STATUS_ACTIVE;
        $user_->personal_data_id = $personal_data->id;
        $user_->location_data_id = $location_data->id;

        $user_->user_name = $userData['user_name'];
        $user_->password = bcrypt($userData['password']);
        $user_->created_at = \Carbon\Carbon::now();

        $user_->save();

        $roles = [UserKeys::ROLE_USER_CAJERO];
        // Agregar role de cajero
        $this->addRolesToUser($user_->id, $roles);
    }

    public function updateUser($userData) {
        $user = $this->user->findById($userData['id']);
        if (!$user) {
            throw new \Exception("El usuario no se encontro");
        }
        $user->locationData->address = $userData['address'];
        $user->locationData->phone = $userData['phone'];
        $user->locationData->cell_phone = $userData['cell_phone'];
        $user->locationData->email = $userData['email'];

        $user->personalData->name = $userData['name'];
        $user->personalData->last_name = $userData['last_name'];

        $user->push();
    }

    public function deleteUser($id) {
        $user = $this->user->findById($id);
        if (!$user) {
            throw new \Exception("El usuario no se encontro");
        }
        $user->status_id = StatusKeys::STATUS_INACTIVE;

        $user->save();
    }

    public function findRolesNoAdmin() {
        return DB::select("select * from roles where id not in (".UserKeys::ROLE_USER_ROOT.",".UserKeys::ROLE_USER_ADMIN.")");
    }

    public function addRolesToUser($userId, $roles) {
        if (count($roles) > NumberKeys::NUMBER_ZERO) {
            // Elimina los roles de usuario
            $this->deleteRolesByUser($userId);
            // Add roles
            foreach ($roles as $role) {
                DB::insert('insert into role_user (user_id, role_id) values (?, ?)', [$userId, $role]);
            }
        }
    }

    private function deleteRolesByUser($userId) {
        DB::table('role_user')->where('user_id', $userId)->delete();
    }
}
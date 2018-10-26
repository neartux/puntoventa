<?php
/**
 * User: ricardo
 * Date: 10/25/18
 * Time: 09:44
 */

namespace App\Http\Controllers;


use App\Repository\user\UserInterface;
use App\Utils\Keys\common\NumberKeys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller {

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

    public function viewChangePassword() {
        return view('admin.configuration.password');
    }

    public function changePassword(Request $request) {
        $currentPassword = $request->input('current_password');
        $password = $request->input('password');
        $passwordConfirmation = $request->input('password_confirmation');
        // Validate old password
        if (!Hash::check($currentPassword, Auth::user()->password)) {
            return response()->json(array("error" => true, "message" => "La contraseña actual no es correcta"));
        }
        // Validate length
        if (strlen($password) < NumberKeys::NUMBER_SIX || strlen($passwordConfirmation) < NumberKeys::NUMBER_SIX) {
            return response()->json(array("error" => true, "message" => "La contraseña debe tener minimo 6 caracteres"));
        }
        // Validate match
        if ($password != $passwordConfirmation) {
            return response()->json(array("error" => true, "message" => "La contraseñas y la confirmación no coinciden"));
        }
        // Validate current password an new, no the same
        if (Hash::check($password, Auth::user()->password)) {
            return response()->json(array("error" => true, "message" => "La contraseña nueva no puede ser igual a la actual"));
        }
        $this->user->updatePassword(Auth::user()->id, $password);
        return response()->json(array("error" => false, "message" => "Se ha actualizado la contraseña correctamente"));
    }

    public function existUserName($id, $userName) {
        return response()->json(array("exist" => $this->user->existUserName($id, $userName)));
    }

    public function findUsers() {
        $users = $this->user->findAllUsers();
        return response()->json($users);
    }

    public function findRolesNoAdmin() {
        $roles = $this->user->findRolesNoAdmin();
        return response()->json($roles);
    }

    public function save(Request $request){
        try {
            $usrName = $request->input('user_name');
            $password = $request->input('password');
            $passwordConfirmation = $request->input('password_confirmation');
            // valida nombre usuario no sea invalido
            if ($this->user->existUserName(NumberKeys::NUMBER_ZERO, $usrName)) {
                return response()->json(array("error" => true, "message" => "El nombre de usuario ya no esta disponible"));
            }
            // Validate length
            if (strlen($password) < NumberKeys::NUMBER_SIX || strlen($passwordConfirmation) < NumberKeys::NUMBER_SIX) {
                return response()->json(array("error" => true, "message" => "La contraseña debe tener minimo 6 caracteres"));
            }
            // Validate match
            if ($password != $passwordConfirmation) {
                return response()->json(array("error" => true, "message" => "La contraseña y la confirmación no coinciden"));
            }

            $this->user->saveUser($request->all());
            return response()->json(array("error" => false, "message" => "El usuario se ha creado"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

    public function update(Request $request) {
        try {
            $this->user->updateUser($request->all());
            return response()->json(array("error" => false, "message" => "El usuario se ha actualizado"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

    public function delete(Request $request){
        try {
            $this->user->deleteUser($request->input('id'));
            return response()->json(array("error" => false, "message" => "Usuario eliminado"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

    public function changePasswordUser(Request $request) {
        $userId = $request->input('id');
        $password = $request->input('password');
        $passwordConfirmation = $request->input('password_confirmation');
        // Validate length
        if (strlen($password) < NumberKeys::NUMBER_SIX || strlen($passwordConfirmation) < NumberKeys::NUMBER_SIX) {
            return response()->json(array("error" => true, "message" => "La contraseña debe tener minimo 6 caracteres"));
        }
        // Validate match
        if ($password != $passwordConfirmation) {
            return response()->json(array("error" => true, "message" => "La contraseñas y la confirmación no coinciden"));
        }
        $this->user->updatePassword($userId, $password);
        return response()->json(array("error" => false, "message" => "Se ha actualizado la contraseña correctamente"));
    }

    public function addRolesToUser(Request $request) {
        try {
            $userId = $request->input('id');
            $roles = $request->input('roles');
            $this->user->addRolesToUser($userId, $roles);
            return response()->json(array("error" => false, "message" => "Se ha actualizado la contraseña correctamente"));
        } catch (\Exception $e) {
            return response()->json(array("error" => true, "message" => $e->getMessage()));
        }
    }

}
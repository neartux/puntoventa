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
            return response()->json(array("error" => true, "message" => "Las contraseñas no coinciden"));
        }
        // Validate current password an new, no the same
        if (Hash::check($password, Auth::user()->password)) {
            return response()->json(array("error" => true, "message" => "La contraseña nueva no puede ser igual a la actual"));
        }
        $this->user->updatePassword(Auth::user()->id, $password);
        return response()->json(array("error" => false, "message" => "Se ha actualizado la contraseña correctamente"));
    }

}
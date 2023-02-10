<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Helpers\ResponseGenerator;
use App\Mail\RecoverPassword;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


use function PHPUnit\Framework\isEmpty;


class UserController extends Controller 
{
    public function register(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        $user = new User();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:20'],
            'email' => ['required','email'],
            'password' => ['required', Password::min(8)->mixedCase()->numbers()],
            'rol' => ['required', Rule::in(['particular','professional','admin'])],
        ],
        [
            'name' => [
                'required' => 'El nombre es obligatorio.',
                'max' => 'El nombre es muy largo.',
            ],
            'email' => [
                'required' => 'El email es obligatorio.',
                'email' => 'Formato de email inválido.',
            ],
            'password' => [
                'required' => 'La contraseña es obligatoria.',
                'min' => 'La contraseña debe ser mínimo de 8 cifras',
                'mixedCase' => 'La contraseña debe tener mínimo una letra minúscula y una mayúscula',
                'numbers' => 'La contraseña debe tener mínimo un número',
            ],
            'password_confirm' => [
                'required' => 'La confirmación de contraseña es obligatoria',
                'same:password' => 'Las contraseñas no coinciden',
            ],
            'rol' => [
                'required' => 'El rol es obligatorio',
            ],
        ]);

        if($validator->fails()){
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'Fallo error');
        }else{
            $user->name = $datos->name;
            $user->email = $datos->email;
            $user->password = Hash::make($datos->password);
            $user->rol = $datos->rol;

            $userResponse = [$user->id, $user->name];

            try{
                $user->save();
                return ResponseGenerator::generateResponse(200, $userResponse, 'Usuario gurdado correctamente');
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'Fallo al guardar');
            }
        }
    }
    
    public function login(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        try{
            $user = User::where('name', 'like', $datos->name)->firstOrFail();
        }catch(\Exception $e){
            return ResponseGenerator::generateResponse(400, '', 'No se ha encontrado ningún usuario con ese nombre.');
        }
        if(Hash::check($datos->password, $user->password)){
            $token = $user->createToken('user');
            $fullUser = [$user, $token->plainTextToken];
            return ResponseGenerator::generateResponse(200, $fullUser, 'Usuario válido');
        }else{
            return ResponseGenerator::generateResponse(400, '', 'La contraseña es incorrecta.');
        }

    }



    public function recoverPassword(Request $request){
        $json = $request->getContent();
        $datos = json_decode($json);

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if($validator->fails()){
            return ResponseGenerator::generateResponse(400, $validator->errors()->all(), 'ALGO FUE MAL');
        }else{
            try{
                $user = User::where('email', 'like', $datos->email)->firstOrFail();
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'EMAIL INVALIDO');
            }

            $str=rand();
            $newPassword = md5($str);
            $hashPassword = Hash::make($newPassword);

            $user->password = $hashPassword;

            try{
                $user->save();
                return ResponseGenerator::generateResponse(200, $newPassword, 'Esta es tu nueva contraseña');
            }catch(\Exception $e){
                return ResponseGenerator::generateResponse(400, '', 'ERROR AL GUARDAR');
            }
        }
        
    }
}

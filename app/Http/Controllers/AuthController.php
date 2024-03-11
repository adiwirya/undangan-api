<?php

namespace App\Http\Controllers;
use Validator;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController 
{
   
    public function __construct() {}

    protected function createToken($user) {
        $payload = [
            'iss'               => 'UndanganAPI',
            'sub'               => $user->id,
            'iat'               => time(), 
            'exp'               => time() + 7*24*60*60,
            'email'             => $user->email,
            'namalengkap'       => $user->name,
            'fgaktif'           => $user->flag_aktif,
			'role'           	=> $user->role,
        ];
        
        return JWT::encode($payload, 'BCG5fI4rbuypVmRcKfpDeGPT7ZCYy1ny');
    } 

    public function authenticate(Request $r) {
        $this->validate($r, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        // Find the user
        $user = User::where('email', $r->email)->first();
		
        if (!$user) {
            return response()->json([
                'error' => 'Email Tidak Terdaftar'
            ], 400);
        }
		
		if (Hash::check($r->input('password'), $user->password)) {
			return response()->json([
				'token' => $this->createToken($user)
			], 200);
		}

        // Bad Request response
        return response()->json([
            'error' => 'Password Salah'
        ], 400);
    }
}

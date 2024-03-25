<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_User extends Model
{	
    public static function createUser($email,$password,$name){
        
         $q =  DB::table('users')->insert([
                'email' => $email,
                'password' => $password,
                'name' => $name,
                'flag_aktif' => 'Y',
                'role' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $q;
    }
    
    public static function changePassword($email, $password){

        $q = DB::table('users')
            ->where('email', $email)
            ->update([
                'password' => $password,
                'updated_at' => date('Y-m-d H:i:s')
        ]);

        return $q;
    }

   
}
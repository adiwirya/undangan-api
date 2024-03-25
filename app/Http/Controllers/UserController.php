<?php

namespace App\Http\Controllers;

use \stdClass;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Hash;
use App\Models\M_User;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Log;

class UserController extends Controller
{
      /**
   * Create a new controller instance.
   *
   * @return void
   */
	public function __construct(){}

   public function createUser(Request $r)
	{	
        
		$email 		= $r->email;
		$password 	= $r->password;
		$name 	    = $r->name;
        $password 	= Hash::make($password);
        $data       = M_User::createUser($email, $password, $name);
        return  response()->json("User Created");
	}

       public function changePassword(Request $r)
	{	
		$email 		= $r->email;
		$password 	= $r->password;
        $password 	= Hash::make($password);
		$data       = M_User::changePassword($email, $password);
		return  response()->json("Password Changed");
	}
}
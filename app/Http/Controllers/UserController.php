<?php

namespace App\Http\Controllers;

use \stdClass;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Hash;
use App\Models\M_User;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Log;
use DB;

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

	public function getVersionAPK()  {   
        $get_version    = '1.0.0';

        return response()->json($get_version);
    }

	public function setPassword(Request $r)
	{	
		$data = $r->json()->all();
		Log::info("data : ", $data);
		DB::beginTransaction();
				$password	 = $data["password"];
				$password = collect($password);

				foreach ($password->chunk(10) as $dtitemList) {

				$cases = [];
				$ids = [];
				$params = [];
					foreach ($dtitemList as $dt3) {
						$dt3['PASSWORD'] = Hash::make($dt3['PASSWORD']);
						$cases[] = "WHEN email = '{$dt3['ID']}' THEN  ? ";
						$params[] = "'{$dt3['PASSWORD']}'";
						$params[] = "'{$dt3['AKTIF']}'";
						$ids[] = "'{$dt3['ID']}'" ;
						
					}
					
					$ids = implode(',', $ids);
					$cases = implode(' ', $cases);
					
					
				try {		
				if (!empty($cases)) {
					\DB::update("UPDATE users SET password = CASE {$cases} END, flag_aktif = CASE {$cases} END WHERE email IN ({$ids}) ", $params);
				}
					
				
					DB::commit();
					Log::info("1 : ", $params);
					$response["success"] 	= 1;
					$response["status"]		= "";
				} catch (\Exception $e) {
					Log::info("0 : ", $params);
					$response["success"] 	= 0;
					$response["status"]		= "[{$e->getMessage()}]";
				}

			}
			return $response;
	}
}


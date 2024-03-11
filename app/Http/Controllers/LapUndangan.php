<?php

namespace App\Http\Controllers;

use \stdClass;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Hash;
use App\Models\M_lapundangan;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class LapUndangan extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
	public function __construct(){}

    public function get_zona_hadir(Request $r)
	{
		$vuser 	    = $r->auth->sub;
        $stshadir 	= $r->stshadir;
        $tglhadir 	= $r->tglhadir;

		$get_zona_hadir 	    = M_lapundangan::get_zona_hadir($stshadir,$tglhadir);
		$get_zona_hadir_array   = array();
		foreach ($get_zona_hadir as $get_zona_hadir_row) {
			$get_zona_hadir_array[] = $get_zona_hadir_row;
		}

		$result = array(
			'DATA_ZONA' => $get_zona_hadir_array
		);

		return $result;
    }

    public function get_dtl_hadir(Request $r)
	{
        $vuser 		= $r->auth->sub;
        $stshadir 	= $r->stshadir;
        $tglhadir 	= $r->tglhadir;
        $vzona 	    = $r->vzona;

		$get_dtl_hadir 		    = M_lapundangan::get_dtl_hadir($stshadir,$tglhadir,$vzona);
		$get_dtl_hadir_array    = array();
		foreach ($get_dtl_hadir as $get_dtl_hadir_row) {
			$get_dtl_hadir_array[] = $get_dtl_hadir_row;
		}

		$result = array(
			'DATA_HADIR' => $get_dtl_hadir_array
		);

		return $result;
    }
    
    public function get_zona_blmhadir(Request $r)
	{
		$vuser 	    = $r->auth->sub;
        $stshadir 	= $r->stshadir;
        $tglhadir 	= $r->tglhadir;

		$get_zona_blmhadir 	        = M_lapundangan::get_zona_blmhadir($stshadir,$tglhadir);
		$get_zona_blmhadir_array    = array();
		foreach ($get_zona_blmhadir as $get_zona_blmhadir_row) {
			$get_zona_blmhadir_array[] = $get_zona_blmhadir_row;
		}

		$result = array(
			'DATA_ZONA' => $get_zona_blmhadir_array
		);

		return $result;
    }
    
    public function get_dtl_blmhadir(Request $r)
	{
        $vuser 		= $r->auth->sub;
        $stshadir 	= $r->stshadir;
        $tglhadir 	= $r->tglhadir;
        $vzona 	    = $r->vzona;

		$get_dtl_undangan 		= M_lapundangan::get_dtl_blmhadir($stshadir,$tglhadir,$vzona);
		$get_dtl_undangan_array = array();
		foreach ($get_dtl_undangan as $get_dtl_undangan_row) {
			$get_dtl_undangan_array[] = $get_dtl_undangan_row;
		}

		$result = array(
			'DATA_BELUMHADIR' => $get_dtl_undangan_array
		);

		return $result;
    }
    
    public function get_daftar_hadir(Request $r)
	{
		$debug 		= [];
		$tmpObjh 	= $this->get_zona_hadir($r);
		$tempHadir 	= $this->get_dtl_hadir($r);

		$r2 = clone $r;

		foreach($tmpObjh["DATA_ZONA"] as &$a) {
			$a = (array)$a;
			
			$tempHadir2 = (array)clone (object)$tempHadir;

            $r2->vzona = $a["KODE_WARNA"];

			$a["DATA_HADIR"] = $this->get_dtl_hadir($r2)["DATA_HADIR"];			
		}

		return response()->json($tmpObjh)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    public function get_daftar_belum(Request $r)
	{
		$debug 			= [];
		$tmpObjb 		= $this->get_zona_blmhadir($r);
		$tempBlmHadir	= $this->get_dtl_blmhadir($r);

		$r2 = clone $r;

		foreach($tmpObjb["DATA_ZONA"] as &$b) {
			$b = (array)$b;
			
			$tempBlmHadir2 = (array)clone (object)$tempBlmHadir;

            $r2->vzona = $b["KODE_WARNA"];

			$b["DATA_BELUMHADIR"] = $this->get_dtl_blmhadir($r2)["DATA_BELUMHADIR"];			
		}

		return response()->json($tmpObjb)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }
    
    public function get_rekap_undangan(Request $r)
	{
        $vuser 		= $r->auth->sub;
        $stshadir 	= $r->stshadir;
        $tglhadir 	= $r->tglhadir;

		$get_rekap_undangan         = M_lapundangan::get_rekap_undangan($stshadir,$tglhadir);

	    return response()->json($get_rekap_undangan)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }
    

}
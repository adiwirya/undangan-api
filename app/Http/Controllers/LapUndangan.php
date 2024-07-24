<?php

namespace App\Http\Controllers;

use \stdClass;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Hash;
use App\Models\M_lapundangan;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Log;

class LapUndangan extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
	public function __construct(){}

	public function getJmlUndangan(Request $r)
	{	
		$vuser = $r->auth->sub;

		$kategori 	= $r->kategori;
		$periode 	= $r->periode;

		$getJmlUndangan 	= M_lapundangan::getJmlUndangan($kategori,$periode);
		
		return response()->json($getJmlUndangan);
	}

    public function get_zona_hadir(Request $r)
	{
		$vuser 	    = $r->auth->sub;
        $tglhadir 	= $r->tglhadir;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;

		$get_zona_hadir 	    = M_lapundangan::get_zona_hadir($tglhadir,$kategori,$periode);
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
        $tglhadir 	= $r->tglhadir;
        $vzona 	    = $r->vzona;
        $kategori   = $r->kategori;
		$periode 	= $r->periode;

		$get_dtl_hadir 		    = M_lapundangan::get_dtl_hadir($tglhadir,$vzona,$kategori,$periode);
		$get_dtl_hadir_array    = array();
		foreach ($get_dtl_hadir as $get_dtl_hadir_row) {
			$get_dtl_hadir_array[] = $get_dtl_hadir_row;
		}

		$result = array(
			'DETAIL' => $get_dtl_hadir_array
		);

		return $result;
    }
    
    public function get_zona_blmhadir(Request $r)
	{
		$vuser 	    = $r->auth->sub;
        $tglhadir 	= $r->tglhadir;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;


		$get_zona_blmhadir 	        = M_lapundangan::get_zona_blmhadir($tglhadir,$kategori,$periode);
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
        $tglhadir 	= $r->tglhadir;
        $vzona 	    = $r->vzona;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;

		$get_dtl_undangan 		= M_lapundangan::get_dtl_blmhadir($tglhadir,$vzona,$kategori,$periode);
		$get_dtl_undangan_array = array();
		foreach ($get_dtl_undangan as $get_dtl_undangan_row) {
			$get_dtl_undangan_array[] = $get_dtl_undangan_row;
		}

		$result = array(
			'DETAIL' => $get_dtl_undangan_array
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

            $r2->vzona = $a["KODE_WARNA"] ;

			$a["DETAIL"] = $this->get_dtl_hadir($r2)["DETAIL"];			
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
			$b["DETAIL"] = $this->get_dtl_blmhadir($r2)["DETAIL"];			
		}

		return response()->json($tmpObjb)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }
    
    public function get_rekap_undangan(Request $r)
	{
        $vuser 		= $r->auth->sub;
        $tglhadir 	= $r->tglhadir;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;

		$get_rekap_undangan         = M_lapundangan::get_rekap_undangan($tglhadir,$kategori,$periode);

	    return response()->json($get_rekap_undangan)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

	 public function get_daftar_melebihi(Request $r)
	{
		$debug 			= [];
		$tmpObjb 		= $this->get_zona_melebihi($r);
		$tempMelebihi	= $this->get_dtl_melebihi($r);

		$r2 = clone $r;

		foreach($tmpObjb["DATA_ZONA"] as &$b) {
			$b = (array)$b;
			
			$tempMelebihi2 = (array)clone (object)$tempMelebihi;

            $r2->vzona = $b["KODE_WARNA"];

			$b["DETAIL"] = $this->get_dtl_melebihi($r2)["DETAIL"];			
		}

		return response()->json($tmpObjb)->setEncodingOptions(JSON_NUMERIC_CHECK);
		
    }

	public function get_zona_melebihi(Request $r){
		$vuser 	    = $r->auth->sub;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;


		$get_zona_melebihi         = M_lapundangan::get_zona_melebihi($kategori,$periode);
		$get_zona_melebihi_array    = array();
		foreach ($get_zona_melebihi as $get_zona_melebihi_row) {
			$get_zona_melebihi_array[] = $get_zona_melebihi_row;
		}

		$result = array(
			'DATA_ZONA' => $get_zona_melebihi_array
		);

		return $result;
	}

	public function get_dtl_melebihi(Request $r){
		$vuser 		= $r->auth->sub;
        $tglhadir 	= $r->tglhadir;
        $vzona 	    = $r->vzona;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;
		
		$get_dtl_undangan 		= M_lapundangan::get_dtl_melebihi($kategori,$vzona,$periode);
		
		$get_dtl_undangan_array = array();
		foreach ($get_dtl_undangan as $get_dtl_undangan_row) {
			$get_dtl_undangan_array[] = $get_dtl_undangan_row;
		}

		$result = array(
			'DETAIL' => $get_dtl_undangan_array
		);

		return $result;
	}
	 public function get_daftar_tambahan(Request $r)
	{
		$debug 			= [];
		$tmpObjb 		= $this->get_zona_tambahan($r);
		$temptambahan	= $this->get_dtl_tambahan($r);

		$r2 = clone $r;

		foreach($tmpObjb["DATA_ZONA"] as &$b) {
			$b = (array)$b;
			$temptambahan2 = (array)clone (object)$temptambahan;
			
            $r2->vzona = $b["KODE_WARNA"];
			
			$b["DETAIL"] = $this->get_dtl_tambahan($r2)["DETAIL"];			
		}

		return response()->json($tmpObjb)->setEncodingOptions(JSON_NUMERIC_CHECK);
		
    }

	public function get_zona_tambahan(Request $r){
		$vuser 	    = $r->auth->sub;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;

		$get_zona_tambahan         = M_lapundangan::get_zona_tambahan($kategori,$periode);
		$get_zona_tambahan_array    = array();
		foreach ($get_zona_tambahan as $get_zona_tambahan_row) {
			$get_zona_tambahan_array[] = $get_zona_tambahan_row;
		}

		$result = array(
			'DATA_ZONA' => $get_zona_tambahan_array
		);

		return $result;
	}

	public function get_dtl_tambahan(Request $r){
		$vuser 		= $r->auth->sub;
        $tglhadir 	= $r->tglhadir;
        $vzona 	    = $r->vzona;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;

		$get_dtl_undangan 		= M_lapundangan::get_dtl_tambahan($kategori,$vzona,$periode);
		$get_dtl_undangan_array = array();
		foreach ($get_dtl_undangan as $get_dtl_undangan_row) {
			$get_dtl_undangan_array[] = $get_dtl_undangan_row;
		}

		$result = array(
			'DETAIL' => $get_dtl_undangan_array
		);

		return $result;
	}
	 public function get_daftar_kurang(Request $r)
	{
		$debug 			= [];
		$tmpObjb 		= $this->get_zona_kurang($r);
		$tempkurang	= $this->get_dtl_kurang($r);

		$r2 = clone $r;

		foreach($tmpObjb["DATA_ZONA"] as &$b) {
			$b = (array)$b;
			
			$tempkurang2 = (array)clone (object)$tempkurang;

            $r2->vzona = $b["KODE_WARNA"];

			$b["DETAIL"] = $this->get_dtl_kurang($r2)["DETAIL"];			
		}

		return response()->json($tmpObjb)->setEncodingOptions(JSON_NUMERIC_CHECK);
		
    }

	public function get_zona_kurang(Request $r){
		$vuser 	    = $r->auth->sub;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;


		$get_zona_kurang         = M_lapundangan::get_zona_kurang($kategori,$periode);
		$get_zona_kurang_array    = array();
		foreach ($get_zona_kurang as $get_zona_kurang_row) {
			$get_zona_kurang_array[] = $get_zona_kurang_row;
		}

		$result = array(
			'DATA_ZONA' => $get_zona_kurang_array
		);

		return $result;
	}

	public function get_dtl_kurang(Request $r){
		$vuser 		= $r->auth->sub;
        $tglhadir 	= $r->tglhadir;
        $vzona 	    = $r->vzona;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;

		$get_dtl_undangan 		= M_lapundangan::get_dtl_kurang($kategori,$vzona,$periode);
		$get_dtl_undangan_array = array();
		foreach ($get_dtl_undangan as $get_dtl_undangan_row) {
			$get_dtl_undangan_array[] = $get_dtl_undangan_row;
		}

		$result = array(
			'DETAIL' => $get_dtl_undangan_array
		);

		return $result;
	}
	 public function get_daftar_tidak_hadir(Request $r)
	{
		$debug 			= [];
		$tmpObjb 		= $this->get_zona_tidak_hadir($r);
		$temptidak_hadir	= $this->get_dtl_tidak_hadir($r);

		$r2 = clone $r;

		foreach($tmpObjb["DATA_ZONA"] as &$b) {
			$b = (array)$b;
			
			$temptidak_hadir2 = (array)clone (object)$temptidak_hadir;

            $r2->vzona = $b["KODE_WARNA"];

			$b["DETAIL"] = $this->get_dtl_tidak_hadir($r2)["DETAIL"];			
		}

		return response()->json($tmpObjb)->setEncodingOptions(JSON_NUMERIC_CHECK);
		
    }

	public function get_zona_tidak_hadir(Request $r){
		$vuser 	    = $r->auth->sub;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;

		$get_zona_tidak_hadir         = M_lapundangan::get_zona_tidak_hadir($kategori,$periode);
		$get_zona_tidak_hadir_array    = array();
		foreach ($get_zona_tidak_hadir as $get_zona_tidak_hadir_row) {
			$get_zona_tidak_hadir_array[] = $get_zona_tidak_hadir_row;
		}

		$result = array(
			'DATA_ZONA' => $get_zona_tidak_hadir_array
		);

		return $result;
	}

	public function get_dtl_tidak_hadir(Request $r){
		$vuser 		= $r->auth->sub;
        $tglhadir 	= $r->tglhadir;
        $vzona 	    = $r->vzona;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;

		$get_dtl_undangan 		= M_lapundangan::get_dtl_tidak_hadir($kategori,$vzona,$periode);
		$get_dtl_undangan_array = array();
		foreach ($get_dtl_undangan as $get_dtl_undangan_row) {
			$get_dtl_undangan_array[] = $get_dtl_undangan_row;
		}

		$result = array(
			'DETAIL' => $get_dtl_undangan_array
		);

		return $result;
	}


	public function get_total_rekap(Request $r)
	{
		$vuser 		= $r->auth->sub;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;
		
		$get_total_rekap         = M_lapundangan::get_total_rekap($kategori,$periode);

	    return response()->json($get_total_rekap)->setEncodingOptions(JSON_NUMERIC_CHECK);

	}

	 

}
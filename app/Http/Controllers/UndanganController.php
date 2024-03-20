<?php

namespace App\Http\Controllers;

use \stdClass;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Hash;
use App\Models\M_undangan;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class UndanganController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
	public function __construct(){}

	public function getDisplayUndangan(Request $r)
	{	
		$vuser 		= $r->auth->sub;
		//$no_barcode = $r->no_barcode;
		$kategori 	= $r->kategori;
		$noreg 		= $r->noreg;

		$getDisplayUndangan 	= M_undangan::getDisplayUndangan($kategori, $noreg);
		// $data = array(
		// 	'results' => $getDisplayUndangan);
		// echo json_encode($data);
		return response()->json($getDisplayUndangan);
	}

	public function getDataUndangan(Request $r)
	{	
		$vuser = $r->auth->sub;
		$kategori 	= $r->kategori;

		$getDataUndangan 	= M_undangan::getDataUndangan($kategori);
		
		return response()->json($getDataUndangan);
	}

	public function getTitipan(Request $r)
	{	
		$vuser = $r->auth->sub;
		$kategori 	= $r->kategori;

		$getDataTitipan 	= M_undangan::getTitipan($kategori);
		
		return response()->json($getDataTitipan);
	}


	public function simpanData(Request $r)
	{
		$vuser 		= $r->auth->sub;
		//$no_barcode = $r->no_barcode;
		$kategori 	= $r->kategori;
		$noreg 		= $r->noreg;
		$jml 		= $r->jml;
		$vege		= $r->jmlvege;
		//$vege2		= $r->vege2;
		// $jml		= $r->jml;
		$flgangpao	= $r->angpao;
		//$hadir2		= $r->hadir2;
		// $fgrapid	= $r->fgrapid;
		// $ktp1		= $r->ktp1;
		$souvenir	= $r->souvenir;
		$celengan	= $r->celengan;
		date_default_timezone_set('Asia/Jakarta');
		$tgl		= date('Y-m-d H:i:s');
		
		// $simpan1 = M_Undangan::submit($vuser,$kategori,1,$noreg,$vege1,$hadir1,$tgl,$jml);
		// $simpan2 = M_Undangan::submit($vuser,$kategori,2,$noreg,$vege2,$hadir2,$tgl);
		
		// return response()->json([$simpan1, $simpan2]);
		$simpan = M_Undangan::submit($vuser,$kategori,$noreg,$vege,$jml,$tgl, $flgangpao, $souvenir, $celengan);
		return response()->json($simpan);
	}
	
	public function updateSouvenir(Request $r)
	{
		$vuser 		= $r->auth->sub;
		$kategori 	= $r->kategori;
		$noreg 		= $r->noreg;
		date_default_timezone_set('Asia/Jakarta');
		$tgl		= date('Y-m-d H:i:s');
		
		// $simpan1 = M_Undangan::submit($vuser,$kategori,1,$noreg,$vege1,$hadir1,$tgl,$jml);
		// $simpan2 = M_Undangan::submit($vuser,$kategori,2,$noreg,$vege2,$hadir2,$tgl);
		
		// return response()->json([$simpan1, $simpan2]);
		$simpan = M_Undangan::update_souvenir($vuser,$kategori,$noreg,$tgl);
		return response()->json($simpan);
	}

	public function updateTitipan(Request $r)
	{
		$vuser 		= $r->auth->sub;
		$kategori 	= $r->kategori;
		$noreg 		= $r->noreg;
		date_default_timezone_set('Asia/Jakarta');
		$tgl		= date('Y-m-d H:i:s');

		$titipan = M_Undangan::update_titipan($vuser,$kategori,$noreg,$tgl);
		return response()->json($titipan);
	}


	public function getParkir(Request $r)
	{	

		$getParkir 	= M_undangan::getParkir();
		
		return response()->json($getParkir);
	}

	public function saveUndanganTambahan(Request $r)
	{	
		$vuser 			= $r->auth->sub;
		$periode 	 	= $r->periode;
		$kategori	 	= $r->kategori;
		$zona		 	= $r->zona;
		$nama	 	 	= $r->nama;
		$jml_undangan 	= $r->jml;
		$lokasi_parkir 	= $r->parkir;
		$email      	= $r->email;
		$hp         	= $r->hp;
		$perusahaan 	= $r->perusahaan;
		$souvenir 	    = $r->souvenir;
		
		

		$saveUndanganTambahan = M_undangan::saveUndanganTambahan($vuser, $periode, $kategori, $zona, $nama, $jml_undangan, $lokasi_parkir, $email, $hp, $perusahaan, $souvenir);
		
		return response()->json($saveUndanganTambahan);
	}

	public function getListKategori(Request $r)
	{	
		$vuser = $r->auth->sub;

		$getListKategori 	= M_undangan::getListKategori();
		
		return response()->json($getListKategori);
	}
	
	public function getListZona(Request $r)
	{	
		$vuser = $r->auth->sub;

		$getListZona 	= M_undangan::getListZona();
		
		return response()->json($getListZona);
	}
	
	
}
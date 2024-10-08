<?php

namespace App\Http\Controllers;

use \stdClass;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Hash;
use App\Models\M_undangan;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Log;
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
		$periode 	= $r->periode;
		

		// $getDisplayUndangan 	= M_undangan::getDisplayUndangan($kategori, $noreg);
		$getDisplayUndangan 	= M_undangan::getDisplayUndangan($kategori, $noreg, $periode);
		// $data = array(
		// 	'results' => $getDisplayUndangan);
		// echo json_encode($data);
		return response()->json($getDisplayUndangan);
	}

	public function getBarcodeNama(Request $r)
	{	
		$vuser 		= $r->auth->sub;
		//$no_barcode = $r->no_barcode;
		$kategori 	= $r->kategori;
		$nama 		= $r->nama;
		$periode 	= $r->periode;

		$getBarcodeNama 	= M_undangan::getBarcodeNama($kategori, $nama, $periode);
		// $data = array(
		// 	'results' => $getBarcodeNama);
		// echo json_encode($data);
		return response()->json($getBarcodeNama);
	}

	public function getDataUndangan(Request $r)
	{	
		$vuser = $r->auth->sub;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;

		$getDataUndangan 	= M_undangan::getDataUndangan($kategori, $periode);
		
		return response()->json($getDataUndangan);
	}

	public function getTitipan(Request $r)
	{	
		$vuser = $r->auth->sub;
		$kategori 	= $r->kategori;
		$periode 	= $r->periode;

		$getDataTitipan 	= M_undangan::getTitipan($kategori, $periode);
		
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
		$ketopt1	= $r->ketopt1;
		date_default_timezone_set('Asia/Jakarta');
		$tgl		= date('Y-m-d H:i:s');

		// return response()->json([$simpan1, $simpan2]);
		$simpan = M_Undangan::submit($vuser,$kategori,$noreg,$vege,$jml,$tgl, $flgangpao, $souvenir, $ketopt1);
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
		Log::info('Log data: '.$r);
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
		$ketopt1 	    = $r->ketopt1;
		$zonaDtl 	    = $r->zonaDtl;
	
		$saveUndanganTambahan = M_undangan::saveUndanganTambahan($vuser, $periode, $kategori, $zona, $nama, $jml_undangan, $lokasi_parkir, $email, $hp, $perusahaan, $souvenir, $ketopt1, $zonaDtl);
		
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

		$getListZona = M_undangan::getListZona();
		
		return response()->json($getListZona);
	}
	
		public function getListZonaDtl(Request $r)
	{	
		$vuser = $r->auth->sub;

		$getListZonaDtl = M_undangan::getListZonaDtl();
		
		return response()->json($getListZonaDtl);
	}

	public function getListPerusahaan(Request $r)
	{	
		$vuser = $r->auth->sub;

		$getListPerusahaan = M_undangan::getListPerusahaan();
		
		return response()->json($getListPerusahaan);
	}
}
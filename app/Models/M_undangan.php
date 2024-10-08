<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
// use DB;

class M_undangan extends Model
{	
	// public static function getDisplayUndangan($kategori,$no_barcode)
	public static function getDisplayUndangan($kategori,$no_barcode,$periode)
	{
		$q = DB::table('REGISTER_TAMU AS A')
		->leftJoin('AGEN_HDR AS B', 'A.PERUSAHAAN', '=', 'B.NO_AGEN')
		->select(
			DB::RAW("LTRIM(RTRIM(A.NO_REGISTER)) AS NO_BARCODE"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(UPPER(A.KATEGORI))),'-') AS KATEGORI"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(UPPER(A.NAMA))),'-') AS NAMA"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') AS ZONA"), 
			DB::RAW("ISNULL(A.SEAT,0) AS JML_UNDANGAN_AWAL"), 
			DB::RAW("ISNULL(A.JUMLAH,0) AS JML_UNDANGAN_UPDATE"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.HADIR)),'-') AS HADIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_RAPID)),'Y') AS FLAG_RAPID"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KTP_1)),'') AS KTP_1"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KTP_2)),'') AS KTP_2"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.LOKASI_PARKIR)),'-') AS LOKASI_PARKIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KATEGORI_UND)),'-') AS KATEGORI_UND"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.VEGETARIAN)),'-') AS VEGETARIAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.NO_URUT)),'-') AS NO_URUT"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.JML_KONFIRMASI_HADIR)),'-') AS JML_KONFIRMASI_HADIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.JML_VEGETARIAN)),'0') AS JML_VEGETARIAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_ANGPAO)),'-') AS FLAG_ANGPAO"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_TITIP_ANGPAO)),'-') AS FLAG_TITIP_ANGPAO"),
			DB::RAW("ISNULL(LTRIM(RTRIM(B.NAMA_AGEN)),'-') AS PERUSAHAAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(LEN(A.PERUSAHAAN))),0) AS LEN_PERUSAHAAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.NO_KURSI)),'-') AS NO_MEJA"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_KIRIM)),'-') AS FLAG_KIRIM"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_OPT1)),'-') AS FLAG_PRINT"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.TAMBAH_GOODIEBAG)),'0') AS SOUVENIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.STATUS_TEMPLATE)),'-') AS STATUS_TEMPLATE"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KET_OPT1)),'-') AS KET_OPT1"),
			DB::RAW("(Select 
					CASE 
						-- Jika semua KODE_WARNA_OPTION sampai KODE_WARNA_OPTION5 kosong (NULL),
						-- kita menggunakan nilai default '-'.
						WHEN COALESCE(KODE_WARNA_OPTION, KODE_WARNA_OPTION2, KODE_WARNA_OPTION3, KODE_WARNA_OPTION4, KODE_WARNA_OPTION5) IS NULL THEN
							'-'
						ELSE
							-- Jika ada setidaknya satu nilai yang tidak kosong, kita akan melakukan
							-- penggabungan dengan pemisah '-' seperti biasa.
							ISNULL(RTRIM(KODE_WARNA_OPTION),'') + 
							CASE 
								WHEN KODE_WARNA_OPTION2 IS NOT NULL THEN
									' - ' + RTRIM(KODE_WARNA_OPTION2)
								ELSE 
									''
							END +
							CASE 
								WHEN KODE_WARNA_OPTION3 IS NOT NULL THEN
									' - ' + RTRIM(KODE_WARNA_OPTION3)
								ELSE 
									''
							END +
							CASE 
								WHEN KODE_WARNA_OPTION4 IS NOT NULL THEN
									' - ' + RTRIM(KODE_WARNA_OPTION4)
								ELSE 
									''
							END +
							CASE 
								WHEN KODE_WARNA_OPTION5 IS NOT NULL THEN
									' - ' + RTRIM(KODE_WARNA_OPTION5)
								ELSE 
									''
							END
					END) AS KODE_WARNA_CONCAT
				")
		)
		

		->where('A.KATEGORI', $kategori)
		->where('A.PERIODE', $periode)
		->where('A.NO_REGISTER', $no_barcode)
		->limit(1)
		->get();
				
		return $q;
	}

	public static function getBarcodeNama($kategori,$nama,$periode)
	{
		$q = DB::table('REGISTER_TAMU AS A')
		->leftJoin('AGEN_HDR AS B', 'A.PERUSAHAAN', '=', 'B.NO_AGEN')
		->select(
			DB::RAW("LTRIM(RTRIM(A.NO_REGISTER)) AS NO_BARCODE"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(UPPER(A.KATEGORI))),'-') AS KATEGORI"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(UPPER(A.NAMA))),'-') AS NAMA"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') AS ZONA"), 
			DB::RAW("ISNULL(A.SEAT,0) AS JML_UNDANGAN_AWAL"), 
			DB::RAW("ISNULL(A.JUMLAH,0) AS JML_UNDANGAN_UPDATE"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.HADIR)),'-') AS HADIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_RAPID)),'Y') AS FLAG_RAPID"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KTP_1)),'') AS KTP_1"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KTP_2)),'') AS KTP_2"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.LOKASI_PARKIR)),'-') AS LOKASI_PARKIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KATEGORI_UND)),'-') AS KATEGORI_UND"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.VEGETARIAN)),'-') AS VEGETARIAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.NO_URUT)),'-') AS NO_URUT"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.JML_KONFIRMASI_HADIR)),'-') AS JML_KONFIRMASI_HADIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.JML_VEGETARIAN)),'0') AS JML_VEGETARIAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_ANGPAO)),'-') AS FLAG_ANGPAO"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_TITIP_ANGPAO)),'-') AS FLAG_TITIP_ANGPAO"),
			DB::RAW("ISNULL(LTRIM(RTRIM(B.NAMA_AGEN)),'-') AS PERUSAHAAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(LEN(A.PERUSAHAAN))),0) AS LEN_PERUSAHAAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.NO_KURSI)),'-') AS NO_MEJA"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_KIRIM)),'-') AS FLAG_KIRIM"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_OPT1)),'-') AS FLAG_PRINT"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.TAMBAH_GOODIEBAG)),'0') AS SOUVENIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.STATUS_TEMPLATE)),'-') AS STATUS_TEMPLATE"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KET_OPT1)),'-') AS KET_OPT1"),
			DB::RAW("(Select 
					CASE 
						-- Jika semua KODE_WARNA_OPTION sampai KODE_WARNA_OPTION5 kosong (NULL),
						-- kita menggunakan nilai default '-'.
						WHEN COALESCE(KODE_WARNA_OPTION, KODE_WARNA_OPTION2, KODE_WARNA_OPTION3, KODE_WARNA_OPTION4, KODE_WARNA_OPTION5) IS NULL THEN
							'-'
						ELSE
							-- Jika ada setidaknya satu nilai yang tidak kosong, kita akan melakukan
							-- penggabungan dengan pemisah '-' seperti biasa.
							ISNULL(RTRIM(KODE_WARNA_OPTION),'') + 
							CASE 
								WHEN KODE_WARNA_OPTION2 IS NOT NULL THEN
									' - ' + RTRIM(KODE_WARNA_OPTION2)
								ELSE 
									''
							END +
							CASE 
								WHEN KODE_WARNA_OPTION3 IS NOT NULL THEN
									' - ' + RTRIM(KODE_WARNA_OPTION3)
								ELSE 
									''
							END +
							CASE 
								WHEN KODE_WARNA_OPTION4 IS NOT NULL THEN
									' - ' + RTRIM(KODE_WARNA_OPTION4)
								ELSE 
									''
							END +
							CASE 
								WHEN KODE_WARNA_OPTION5 IS NOT NULL THEN
									' - ' + RTRIM(KODE_WARNA_OPTION5)
								ELSE 
									''
							END
					END) AS KODE_WARNA_CONCAT
				")
		)
		

		->where('A.KATEGORI', $kategori)
		->where('A.NAMA', $nama)
		->where('A.PERIODE', $periode)
		->limit(1)
		->get();
				
		return $q;
	}

	public static function getDataUndangan($kategori,$periode)
	{
		$q = DB::select("
		SELECT
		LTRIM(RTRIM(A.NO_REGISTER)) AS NO_BARCODE ,
		ISNULL(LTRIM(RTRIM(UPPER(A.KATEGORI))),'-') AS KATEGORI ,
		ISNULL(LTRIM(RTRIM(UPPER(A.NAMA))),'-') AS NAMA ,
		ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') AS ZONA ,
		ISNULL(A.SEAT,0) AS JML_UNDANGAN_AWAL ,
		ISNULL(A.JUMLAH,0) AS JML_UNDANGAN_UPDATE,
		ISNULL(LTRIM(RTRIM(A.HADIR)),'-') AS HADIR,
		ISNULL(LTRIM(RTRIM(A.FLAG_RAPID)),'Y') AS FLAG_RAPID,
		ISNULL(LTRIM(RTRIM(A.KTP_1)),'') AS KTP_1,
		ISNULL(LTRIM(RTRIM(A.KTP_2)),'') AS KTP_2,
		ISNULL(LTRIM(RTRIM(A.LOKASI_PARKIR)),'-') AS LOKASI_PARKIR,
		ISNULL(LTRIM(RTRIM(A.KATEGORI_UND)),'-') AS KATEGORI_UND,
		ISNULL(LTRIM(RTRIM(A.VEGETARIAN)),'-') AS VEGETARIAN,
		ISNULL(LTRIM(RTRIM(A.NO_URUT)),'-') AS NO_URUT,
		ISNULL(LTRIM(RTRIM(A.JML_KONFIRMASI_HADIR)),'-') AS JML_KONFIRMASI_HADIR,
		ISNULL(LTRIM(RTRIM(A.JML_VEGETARIAN)),'0') AS JML_VEGETARIAN,
		ISNULL(LTRIM(RTRIM(A.FLAG_ANGPAO)),'-') AS FLAG_ANGPAO,
		ISNULL(LTRIM(RTRIM(A.FLAG_TITIP_ANGPAO)),'-') AS FLAG_TITIP_ANGPAO,
		ISNULL(LTRIM(RTRIM(B.NAMA_AGEN)),'-') AS PERUSAHAAN,
		ISNULL(LTRIM(RTRIM(LEN(A.PERUSAHAAN))),0) AS LEN_PERUSAHAAN,
		ISNULL(LTRIM(RTRIM(A.NO_KURSI)),'-') AS NO_MEJA,
		ISNULL(LTRIM(RTRIM(A.FLAG_KIRIM)),'-') AS FLAG_KIRIM,
		ISNULL(LTRIM(RTRIM(A.FLAG_OPT1)),'-') AS FLAG_PRINT,
		ISNULL(LTRIM(RTRIM(A.TAMBAH_GOODIEBAG)),'0') AS SOUVENIR,
		ISNULL(LTRIM(RTRIM(A.STATUS_TEMPLATE)),'-') AS STATUS_TEMPLATE,
		ISNULL(LTRIM(RTRIM(A.HP)),'-') AS HP,
		ISNULL(LTRIM(RTRIM(A.KET_OPT1)),'-') AS KET_OPT1,
		(SELECT	CASE 
				-- Jika semua KODE_WARNA_OPTION sampai KODE_WARNA_OPTION5 kosong (NULL),
				-- kita menggunakan nilai default '-'.
				WHEN COALESCE(KODE_WARNA_OPTION, KODE_WARNA_OPTION2, KODE_WARNA_OPTION3, KODE_WARNA_OPTION4, KODE_WARNA_OPTION5) IS NULL THEN
					'-'
				ELSE
					-- Jika ada setidaknya satu nilai yang tidak kosong, kita akan melakukan
					-- penggabungan dengan pemisah '-' seperti biasa.
					ISNULL(RTRIM(KODE_WARNA_OPTION),'') + 
					CASE 
						WHEN KODE_WARNA_OPTION2 IS NOT NULL THEN
							' - ' + RTRIM(KODE_WARNA_OPTION2)
						ELSE 
							''
					END +
					CASE 
						WHEN KODE_WARNA_OPTION3 IS NOT NULL THEN
							' - ' + RTRIM(KODE_WARNA_OPTION3)
						ELSE 
							''
					END +
					CASE 
						WHEN KODE_WARNA_OPTION4 IS NOT NULL THEN
							' - ' + RTRIM(KODE_WARNA_OPTION4)
						ELSE 
							''
					END +
					CASE 
						WHEN KODE_WARNA_OPTION5 IS NOT NULL THEN
							' - ' + RTRIM(KODE_WARNA_OPTION5)
						ELSE 
							''
					END
	END) AS KODE_WARNA_CONCAT
	FROM REGISTER_TAMU AS A
	LEFT JOIN AGEN_HDR B
	ON A.PERUSAHAAN = B.NO_AGEN
	WHERE A.KATEGORI  = '".$kategori."'
	AND A.PERIODE   = '".$periode."'
	ORDER BY A.NAMA");
				
		return $q;
	}


	public static function getTitipan($kategori,$periode)
	{
		$q = DB::table('REGISTER_TAMU AS A')
		->leftJoin('AGEN_HDR B', 'A.PERUSAHAAN', '=', 'B.NO_AGEN')
		->select(
			DB::RAW("LTRIM(RTRIM(A.NO_REGISTER)) AS NO_BARCODE"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(UPPER(A.KATEGORI))),'-') AS KATEGORI"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(UPPER(A.NAMA))),'-') AS NAMA"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') AS ZONA"), 
			DB::RAW("ISNULL(A.SEAT,0) AS JML_UNDANGAN_AWAL"), 
			DB::RAW("ISNULL(A.JUMLAH,0) AS JML_UNDANGAN_UPDATE"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.HADIR)),'-') AS HADIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_RAPID)),'Y') AS FLAG_RAPID"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KTP_1)),'') AS KTP_1"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KTP_2)),'') AS KTP_2"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.LOKASI_PARKIR)),'-') AS LOKASI_PARKIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KATEGORI_UND)),'-') AS KATEGORI_UND"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.VEGETARIAN)),'-') AS VEGETARIAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.NO_URUT)),'-') AS NO_URUT"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.JML_KONFIRMASI_HADIR)),'-') AS JML_KONFIRMASI_HADIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.JML_VEGETARIAN)),'0') AS JML_VEGETARIAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_ANGPAO)),'-') AS FLAG_ANGPAO"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_TITIP_ANGPAO)),'-') AS FLAG_TITIP_ANGPAO"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.PERUSAHAAN)),'-') AS PERUSAHAAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(LEN(A.PERUSAHAAN))),0) AS LEN_PERUSAHAAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.NO_KURSI)),'-') AS NO_MEJA"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_KIRIM)),'-') AS FLAG_KIRIM"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.TAMBAH_GOODIEBAG)),'0') AS SOUVENIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.STATUS_TEMPLATE)),'-') AS STATUS_TEMPLATE"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KET_OPT1)),'-') AS KET_OPT1"),
			DB::RAW("(Select 
					CASE 
						-- Jika semua KODE_WARNA_OPTION sampai KODE_WARNA_OPTION5 kosong (NULL),
						-- kita menggunakan nilai default '-'.
						WHEN COALESCE(KODE_WARNA_OPTION, KODE_WARNA_OPTION2, KODE_WARNA_OPTION3, KODE_WARNA_OPTION4, KODE_WARNA_OPTION5) IS NULL THEN
							'-'
						ELSE
							-- Jika ada setidaknya satu nilai yang tidak kosong, kita akan melakukan
							-- penggabungan dengan pemisah '-' seperti biasa.
							ISNULL(RTRIM(KODE_WARNA_OPTION),'') + 
							CASE 
								WHEN KODE_WARNA_OPTION2 IS NOT NULL THEN
									' - ' + RTRIM(KODE_WARNA_OPTION2)
								ELSE 
									''
							END +
							CASE 
								WHEN KODE_WARNA_OPTION3 IS NOT NULL THEN
									' - ' + RTRIM(KODE_WARNA_OPTION3)
								ELSE 
									''
							END +
							CASE 
								WHEN KODE_WARNA_OPTION4 IS NOT NULL THEN
									' - ' + RTRIM(KODE_WARNA_OPTION4)
								ELSE 
									''
							END +
							CASE 
								WHEN KODE_WARNA_OPTION5 IS NOT NULL THEN
									' - ' + RTRIM(KODE_WARNA_OPTION5)
								ELSE 
									''
							END
					END) AS KODE_WARNA_CONCAT
				")
		)

		
		// ->where('A.KATEGORI', '=', 'PAKAIANKOE')
		//->where('A.KATEGORI', '=', 'GANTARI')
		// ->where('A.KATEGORI', '=', 'TRUNK')
		->where('A.KATEGORI', '=', $kategori)
		->where('A.PERIODE', $periode)
		->whereNull('A.HADIR') 
		// ->where('A.KATEGORI_UND', '=', 'Summarecon')
		->orderby('A.NAMA')
		->get();
				
		return $q;
	}

	//public static function submit($vuser,$kategori,$nourut,$noreg,$vege,$hadir,$tgl,$jml = null)
	public static function submit($vuser,$kategori,$noreg,$vege,$jml =1,$tgl,$flgangpao,$souvenir, $ketopt1)
	{
		
		$data = [
			// 'JUMLAH'		=> $jml,
			'HADIR'			=> 'Y',
			// 'JML_VEGETARIAN_ACARA'	=> $vege,
			'JUMLAH'			=> $jml,
			// 'FLAG_RAPID'	=> $fgrapid,
			//'KTP_1'			=> $ktp1,
			//'KTP_2'			=> $ktp2,
			'JAM_DATANG'	=> $tgl,
			'USER_UPDATE'	=> $vuser,
			'TGL_UPDATE'	=> $tgl,
			'FLAG_ANGPAO'	=> $flgangpao,	
			'TAMBAH_GOODIEBAG'	=> $souvenir,	
			'KET_OPT1'	=> $ketopt1	
		];
		//if ($jml != null) $data['JUMLAH'] = $jml;

		$q = DB::table('REGISTER_TAMU')
		->where('NO_REGISTER', '=', $noreg)
		->where('KATEGORI', '=', $kategori)
		->update($data);

		return $q;
	}
	
	public static function update_souvenir($vuser, $kategori, $noreg, $tgl)
	{
		$data = [
			// 'JUMLAH'		=> $jml,
			'FLAG_GOODYBAG'	=> 'Y',
			'USER_UPDATE'	=> $vuser,
			'TGL_UPDATE'	=> $tgl,
		];
		//if ($jml != null) $data['JUMLAH'] = $jml;

		$q = DB::table('REGISTER_TAMU')
		->where('NO_REGISTER', '=', $noreg)
		->where('KATEGORI', '=', $kategori)
		//->where('NO_URUT', '=', $nourut)
		->update($data);

		return $q;
	}

	public static function update_titipan($vuser, $kategori, $noreg, $tgl)
	{
		$data = [
			// 'JUMLAH'		=> $jml,
			'FLAG_GOODYBAG'		=> 'Y',
			'FLAG_TITIP_ANGPAO'	=> 'Y',
			'FLAG_ANGPAO'	=> 'Y',
			'USER_UPDATE'	=> $vuser,
			'TGL_UPDATE'	=> $tgl,
		];
		//if ($jml != null) $data['JUMLAH'] = $jml;

		$q = DB::table('REGISTER_TAMU')
		->where('NO_REGISTER', '=', $noreg)
		->where('KATEGORI', '=', $kategori)
		//->where('NO_URUT', '=', $nourut)
		->update($data);

		return $q;
	}


	 public static function getParkir()
    {

        $q = DB::SELECT("
		        SELECT  ISNULL(LTRIM(RTRIM(A.ID_PARKIR)),'-') AS ID_PARKIR,
		                ISNULL(LTRIM(RTRIM(A.NM_PARKIR)),'-') AS NM_PARKIR
		        FROM MST_LOKASI_PARKIR A
		        WHERE A.FLAG_PARKIR='Y'
	    	");
              
        return $q;
    }

    public static function saveUndanganTambahan($vuser, $periode, $kategori, $zona, $nama, $jml_undangan,$lokasi_parkir, $email, $hp, $perusahaan, $souvenir, $ketopt1, $zonaDtl)
    {    
        $sql = "EXEC SQII_INPUT_UNDANGAN_TAMBAHAN ";
        $sql.= "'".$vuser."',";
        $sql.= "'".$periode."',";
        $sql.= "'".$kategori."',";
        $sql.= "'".$zona."',";
        $sql.= "'".$nama."',";
        $sql.= "'".$jml_undangan."',";
        $sql.= "'".$lokasi_parkir."',";
        $sql.= "'".$email."',";
        $sql.= "'".$hp."',";
        $sql.= "'".$perusahaan."',";
        $sql.= "'".$souvenir."',";
        $sql.= "'".$ketopt1."',";
        $sql.= "'".$zonaDtl."'";
		
        $q = DB::connection('UNDANGAN')
        ->select($sql); 

        return $q;
    }

	public static function getListKategori()
	{
		$q = DB::table('KATEGORI AS A')
		->select(
			DB::RAW("LTRIM(RTRIM(A.KATEGORI)) AS KATEGORI"), 
			DB::RAW("LTRIM(RTRIM(A.NM_KATEGORI)) AS NM_KATEGORI"),
			DB::RAW("LTRIM(RTRIM(A.PERIODE)) AS PERIODE"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FN_ZONA)),'N') AS FN_ZONA"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FN_MEJA)),'N') AS FN_MEJA"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FN_SOUVENIR)),'N') AS FN_SOUVENIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FN_ANGPAO)),'N') AS FN_ANGPAO"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FN_VEGETARIAN)),'N') AS FN_VEGETARIAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FN_PRINT_MEJA)),'N') AS FN_PRINT_MEJA"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FN_CELENGAN)),'N') AS FN_CELENGAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.ID_GRUP_EVENT)),'0') AS ID_GRUP_EVENT"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.NM_GRUP_EVENT)),'-') AS NM_GRUP_EVENT"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FN_JML_HADIR)),'N') AS FN_JML_HADIR")
		)
		->where('A.FLAG_AKTIF', '=', 'A')
		->orderBy('A.PERIODE', 'ASC')
		->get();
				
		return $q;
	}
	
		
	public static function getListZona()
	{
		$q = DB::table('TBL_ZONA')
		->select(
			DB::RAW("ISNULL(LTRIM(RTRIM(ZONA)),'-') AS ZONA")
		)
		->where('FLAG_AKTIF', '=', 'A')
		->get();
				
		return $q;
	}
	
	public static function getListZonaDtl()
	{
		$q = DB::table('TBL_ZONA_DTL')
		->select(
			DB::RAW("ISNULL(LTRIM(RTRIM(ZONA_OPTION)),'-') AS ZONA")
		)
		->where('FLAG_AKTIF', '=', 'A')	
		->get();
				
		return $q;
	}

	public static function getListPerusahaan()
	{
		$q = DB::table('AGEN_HDR')
		->select(
			DB::RAW("ISNULL(LTRIM(RTRIM(NO_AGEN)),'-') AS KODE_PERUSAHAAN"),
			DB::RAW("ISNULL(LTRIM(RTRIM(NAMA_AGEN)),'-') AS NAMA_PERUSAHAAN")
		)
		->orderby('NAMA_PERUSAHAAN')
		->get();
				
		return $q;
	}
}

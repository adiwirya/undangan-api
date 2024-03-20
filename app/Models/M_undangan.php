<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
// use DB;

class M_undangan extends Model
{	
	public static function getDisplayUndangan($kategori,$no_barcode)
	{
		$q = DB::table('REGISTER_TAMU AS A')
		->select(
			DB::RAW("LTRIM(RTRIM(A.NO_REGISTER)) AS NO_BARCODE"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(UPPER(A.KATEGORI))),'-') AS KATEGORI"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(UPPER(A.NAMA))),'-') AS NAMA"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') AS ZONA"), 
			DB::RAW("ISNULL(A.SEAT,0) AS JML_UNDANGAN_AWAL"), 
			DB::RAW("ISNULL(A.JUMLAH,0) AS JML_UNDANGAN_UPDATE"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.HADIR)),'N') AS HADIR"),
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
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_OPT1)),'-') AS FLAG_PRINT"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.TAMBAH_GOODIEBAG)),'0') AS SOUVENIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.STATUS_TEMPLATE)),'-') AS STATUS_TEMPLATE"),
			DB::RAW("ISNULL(RTRIM(KODE_WARNA_OPTION),'-') + 
						CASE WHEN KODE_WARNA_OPTION2 IS NOT NULL THEN		
		 					+ ' - ' + RTRIM(KODE_WARNA_OPTION2)
						ELSE
							CASE WHEN KODE_WARNA_OPTION3 IS NOT NULL THEN
								+ ' - ' + RTRIM(KODE_WARNA_OPTION3)
							ELSE ''
							END 
						END KODE_WARNA_CONCAT")
		)
		

		->where('A.KATEGORI', $kategori)
		->where('A.NO_REGISTER', $no_barcode)
		->get();
				
		return $q;
	}

	public static function getDataUndangan($kategori)
	{
		$q = DB::table('REGISTER_TAMU AS A')
		->select(
			DB::RAW("LTRIM(RTRIM(A.NO_REGISTER)) AS NO_BARCODE"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(UPPER(A.KATEGORI))),'-') AS KATEGORI"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(UPPER(A.NAMA))),'-') AS NAMA"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') AS ZONA"), 
			DB::RAW("ISNULL(A.SEAT,0) AS JML_UNDANGAN_AWAL"), 
			DB::RAW("ISNULL(A.JUMLAH,0) AS JML_UNDANGAN_UPDATE"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.HADIR)),'N') AS HADIR"),
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
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FLAG_OPT1)),'-') AS FLAG_PRINT"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.TAMBAH_GOODIEBAG)),'0') AS SOUVENIR"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.STATUS_TEMPLATE)),'-') AS STATUS_TEMPLATE"),
			DB::RAW("ISNULL(RTRIM(KODE_WARNA_OPTION),'-') + 
						CASE WHEN KODE_WARNA_OPTION2 IS NOT NULL THEN		
		 					+ ' - ' + RTRIM(KODE_WARNA_OPTION2)
						ELSE
							CASE WHEN KODE_WARNA_OPTION3 IS NOT NULL THEN
								+ ' - ' + RTRIM(KODE_WARNA_OPTION3)
							ELSE ''
							END 
						END KODE_WARNA_CONCAT")
		)

		
		// ->where('A.KATEGORI', '=', 'PAKAIANKOE')
		//->where('A.KATEGORI', '=', 'GANTARI')
		// ->where('A.KATEGORI', '=', 'TRUNK')
		->where('A.KATEGORI', '=', $kategori)
		// ->where('A.KODE_WARNA', '<>', '')
		// ->where('A.KATEGORI_UND', '=', 'Summarecon')
		->orderby('A.NAMA')
		->get();
				
		return $q;
	}


	public static function getTitipan($kategori)
	{
		$q = DB::table('REGISTER_TAMU AS A')
		->select(
			DB::RAW("LTRIM(RTRIM(A.NO_REGISTER)) AS NO_BARCODE"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(UPPER(A.KATEGORI))),'-') AS KATEGORI"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(UPPER(A.NAMA))),'-') AS NAMA"), 
			DB::RAW("ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') AS ZONA"), 
			DB::RAW("ISNULL(A.SEAT,0) AS JML_UNDANGAN_AWAL"), 
			DB::RAW("ISNULL(A.JUMLAH,0) AS JML_UNDANGAN_UPDATE"),
			DB::RAW("ISNULL(LTRIM(RTRIM(A.HADIR)),'N') AS HADIR"),
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
			DB::RAW("ISNULL(RTRIM(KODE_WARNA_OPTION),'-') + 
						CASE WHEN KODE_WARNA_OPTION2 IS NOT NULL THEN		
		 					+ ' - ' + RTRIM(KODE_WARNA_OPTION2)
						ELSE
							CASE WHEN KODE_WARNA_OPTION3 IS NOT NULL THEN
								+ ' - ' + RTRIM(KODE_WARNA_OPTION3)
							ELSE ''
							END 
						END KODE_WARNA_CONCAT")
		)

		
		// ->where('A.KATEGORI', '=', 'PAKAIANKOE')
		//->where('A.KATEGORI', '=', 'GANTARI')
		// ->where('A.KATEGORI', '=', 'TRUNK')
		->where('A.KATEGORI', '=', $kategori)
		->whereNull('A.HADIR') 
		// ->where('A.KATEGORI_UND', '=', 'Summarecon')
		->orderby('A.NAMA')
		->get();
				
		return $q;
	}

	//public static function submit($vuser,$kategori,$nourut,$noreg,$vege,$hadir,$tgl,$jml = null)
	public static function submit($vuser,$kategori,$noreg,$vege,$jml,$tgl,$flgangpao,$souvenir)
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
			'TAMBAH_GOODIEBAG'	=> $souvenir	
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

    public static function saveUndanganTambahan($vuser, $periode, $kategori, $zona, $nama, $jml_undangan,$lokasi_parkir, $email, $hp, $perusahaan, $souvenir)
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
        $sql.= "'".$souvenir."'";
		
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
			DB::RAW("ISNULL(LTRIM(RTRIM(A.FN_JML_HADIR)),'N') AS FN_JML_HADIR")
		)
		->where('A.FLAG_AKTIF', '=', 'A')
		->orderBy('A.PERIODE', 'ASC')
		->get();
				
		return $q;
	}
	
	public static function getListZona()
	{
		$q = DB::table('TBL_ZONA AS A')
		->select(
			DB::RAW("ISNULL(LTRIM(RTRIM(A.ZONA)),'Z') AS ZONA")
		)
		->where('A.FLAG_AKTIF', '=', 'A')
		->get();
				
		return $q;
	}

	public static function getJmlUndangan($kategori)
	{
		$q = DB::SELECT("
		(SELECT COUNT(NO_REGISTER) AS JUMLAH, COALESCE(SUM(JML_KONFIRMASI_HADIR),0) PAX
		FROM Register_Tamu where kategori= '".$kategori."'
		AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0) ----TOTAL UNDANGAN
			UNION ALL
		(SELECT COUNT(B.NO_REGISTER) AS JUMLAH, ISNULL(SUM(B.JUMLAH),0) AS PAX
		FROM Register_Tamu B
		WHERE HADIR = 'Y' and kategori= '".$kategori."'
		AND (
				ISNULL(JML_KONFIRMASI_HADIR,0) > 0
			  OR ( ISNULL(JML_KONFIRMASI_HADIR,0) >= 0) AND USER_ENTRY IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
			)
		) ----TOTAL HADIR 	
			UNION ALL
		(SELECT COUNT(B.NO_REGISTER) AS JUMLAH, ISNULL(SUM(B.JML_KONFIRMASI_HADIR),0) AS PAX
		FROM Register_Tamu B
		WHERE ISNULL(HADIR,'') = '' and kategori= '".$kategori."'
		AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0) ----BELUM HADIR
			UNION ALL
		(SELECT COUNT(B.NO_REGISTER) AS JUMLAH, ISNULL(SUM(B.JML_KONFIRMASI_HADIR),0) AS PAX
		FROM Register_Tamu B
		WHERE HADIR = 'N' and kategori= '".$kategori."'
		AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0)  ----KONFIRM TDK HADIR 
			UNION ALL 
		(SELECT COUNT(B.NO_REGISTER) AS JUMLAH, ISNULL(SUM(ABS(B.JML_KONFIRMASI_HADIR - B.JUMLAH)),0) AS PAX
		FROM Register_Tamu B WHERE 1=1
	AND KATEGORI = '".$kategori."'
	AND (B.JML_KONFIRMASI_HADIR - B.JUMLAH) < 0) --- MELEBIHI JUMLAH PAX
		UNION ALL 
		(SELECT COUNT(B.NO_REGISTER) AS JUMLAH, ISNULL(SUM(ABS(B.JML_KONFIRMASI_HADIR - B.JUMLAH)),0) AS PAX
		FROM Register_Tamu B WHERE 1=1
	AND KATEGORI = '".$kategori."'
	AND (B.JML_KONFIRMASI_HADIR - B.JUMLAH) > 0) --- KURANG JUMLAH PAX
	    	");
				
		return $q;
	}
}

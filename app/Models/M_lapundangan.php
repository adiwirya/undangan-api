<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_lapundangan extends Model
{	
    public static function get_zona_hadir($tglhadir,$kategori)
	{  
		$q = DB::select("
			SELECT
                ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') KODE_WARNA,
                TOTAL = 
                (
                    SELECT
                        SUM_HADIR = ISNULL(SUM(XA.JUMLAH),0)
                    FROM REGISTER_TAMU XA
                    WHERE 1=1			

                        AND XA.KATEGORI                              = '".$kategori."'
                        AND ISNULL(LTRIM(RTRIM(XA.NAMA)),'')		!= ''
                        AND ISNULL(LTRIM(RTRIM(XA.KODE_WARNA)),'-')	!= ''
                      --  AND CONVERT(VARCHAR(10),XA.JAM_DATANG,126)	 = '".$tglhadir."'
                        AND LTRIM(RTRIM(XA.HADIR))					 = 'Y'
                        AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0
						AND USER_ENTRY NOT IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
                )
            FROM REGISTER_TAMU A
            WHERE 1=1

                AND A.KATEGORI                               =  '".$kategori."'
                AND ISNULL(LTRIM(RTRIM(A.NAMA)),'')         != ''
                AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')   != ''
               -- AND CONVERT(VARCHAR(10),A.JAM_DATANG,126)    = '".$tglhadir."' 
                AND LTRIM(RTRIM(A.HADIR))                    = 'Y'
                AND ISNULL(JML_KONFIRMASI_HADIR,0) >= 0
            GROUP BY
                ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')
		
            
        ");
        
        return $q;
    }

    public static function  get_dtl_hadir($tglhadir,$vzona,$kategori)
	{
        $q = DB::select("
            
			SELECT 
                ROW_NUMBER() OVER(PARTITION BY ISNULL(LTRIM(RTRIM(V_HADIR.KODE_WARNA)),'-') ORDER BY LTRIM(RTRIM(V_HADIR.NAMA)) ASC ) AS NOMOR,
                V_HADIR.NAMA,
                V_HADIR.JML_UNDANGAN,
                V_HADIR.JAM_HADIR
            FROM 
            (
                SELECT
                    ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') KODE_WARNA,
                    ISNULL(LTRIM(RTRIM(A.NAMA)),'-') AS NAMA,
                    ISNULL(A.JUMLAH,0) AS JML_UNDANGAN,
                    CONVERT(VARCHAR(5), ISNULL(A.JAM_DATANG,'00:00'), 108) JAM_HADIR
                FROM REGISTER_TAMU AS A
                WHERE 1=1
                    
                    AND A.KATEGORI                               = '".$kategori."'
                    AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')				 = '".$vzona."'
                    AND ISNULL(LTRIM(RTRIM(A.NAMA)),'')			!= ''
                    AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')	!= ''
                 --   AND CONVERT(VARCHAR(10),A.JAM_DATANG,126)	 = '".$tglhadir."' 
                    AND LTRIM(RTRIM(A.HADIR))					 = 'Y'
                    AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0
					AND USER_ENTRY NOT IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
            ) V_HADIR
            WHERE 1=1
                
                
        ");

        return $q;
    }

    public static function get_zona_blmhadir($tglhadir,$kategori)
	{  
		$q = DB::select("
				
		SELECT
                ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') KODE_WARNA,
                TOTAL = 
                (
                    SELECT 
                        SUM_BLMHADIR = ISNULL(SUM(XA.JML_KONFIRMASI_HADIR),0)
                    FROM REGISTER_TAMU XA
                    WHERE 1=1			 
                        AND XA.KATEGORI                              = '".$kategori."'           
                        AND ISNULL(LTRIM(RTRIM(XA.NAMA)),'')		!= ''
                        AND ISNULL(LTRIM(RTRIM(XA.KODE_WARNA)),'-')	!= ''
                        AND LTRIM(RTRIM(XA.HADIR)) IS NULL
                        AND ISNULL(XA.JUMLAH,0)						 = 0
                        AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0
                )
            FROM REGISTER_TAMU A
            WHERE 1=1                  
                AND A.KATEGORI                              = '".$kategori."'       
                AND ISNULL(LTRIM(RTRIM(A.NAMA)),'')			!= ''
                AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')	!= ''
                AND LTRIM(RTRIM(A.HADIR)) IS NULL
                AND ISNULL(A.JUMLAH,0)						 = 0
                AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0
            GROUP BY
                ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')
        ");
        
        return $q;
    }

    public static function  get_dtl_blmhadir($tglhadir,$vzona,$kategori)
	{
		$q = DB::select("
			SELECT 
				ROW_NUMBER() OVER(PARTITION BY ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') ORDER BY LTRIM(RTRIM(A.NAMA)) ASC ) AS NOMOR,
				ISNULL(LTRIM(RTRIM(A.NAMA)),'-') AS NAMA,
				ISNULL(A.JML_KONFIRMASI_HADIR,0) AS JML_UNDANGAN,
				CONVERT(VARCHAR(5), ISNULL(A.JAM_DATANG,'00:00'), 108) JAM_HADIR
			FROM REGISTER_TAMU AS A
			WHERE 1=1
				AND A.KATEGORI                              = '".$kategori."'              
				AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')              = '".$vzona."'
				AND ISNULL(LTRIM(RTRIM(A.NAMA)),'')			!= ''
				AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')	!= ''
				AND LTRIM(RTRIM(A.HADIR)) IS NULL
				AND ISNULL(A.JUMLAH,0)	= 0
				AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0
		
		");

		return $q;
    }

    public static function  get_rekap_undangan($tglhadir,$kategori)
	{    
        $q = DB::select("
			SELECT	
                ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') AS KODE_WARNA,
                JML_HADIR_HIJAU = (
                    SELECT 
                        SUM_HADIR = ISNULL(SUM(B.JUMLAH),0)
                    FROM REGISTER_TAMU B
                    WHERE 1=1
                     
                        AND B.KATEGORI                              = '".$kategori."'
                        AND ISNULL(LTRIM(RTRIM(B.KODE_WARNA)),'-')				= ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')
                        AND LTRIM(RTRIM(B.HADIR))					= 'Y'
                        AND ISNULL(LTRIM(RTRIM(B.NAMA)),'')			!= ''
                        AND ISNULL(LTRIM(RTRIM(B.KODE_WARNA)),'-')	!= ''
                        AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0
                ),
                JML_BLMHADIR = (
                    SELECT 
                        SUM_BLMHADIR = ISNULL(SUM(C.SEAT),0)
                    FROM REGISTER_TAMU C
                    WHERE 1=1
                      
                        AND C.KATEGORI                               = '".$kategori."'
                        AND ISNULL(LTRIM(RTRIM(C.KODE_WARNA)),'-') = ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')
                        AND ISNULL(C.JUMLAH,0)						 = 0
                        AND LTRIM(RTRIM(C.HADIR))					IS NULL
                        AND ISNULL(LTRIM(RTRIM(C.NAMA)),'')			!= ''
                        AND ISNULL(LTRIM(RTRIM(C.KODE_WARNA)),'-')	!= ''
                        AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0
                ) 
            FROM REGISTER_TAMU A
            WHERE 1=1
                
                AND A.KATEGORI                              = '".$kategori."'
                AND LTRIM(RTRIM(A.HADIR))					= 'Y'
                AND ISNULL(LTRIM(RTRIM(A.NAMA)),'')			!= ''
                AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')	!= ''
                AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0
            GROUP BY
                 ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')
		
  
        ");

        return $q;
    }

    public static function get_zona_melebihi($kategori){
         $q = DB::select("
             SELECT
              ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') KODE_WARNA,
                TOTAL = 
                (
                    SELECT 
                        ISNULL(SUM(ABS(XA.JML_KONFIRMASI_HADIR - XA.JUMLAH)),0)
                    FROM REGISTER_TAMU XA
                    WHERE 1=1			   
                        AND XA.KATEGORI                              = '".$kategori."'             
                        AND ISNULL(LTRIM(RTRIM(XA.NAMA)),'')		!= ''
                        AND ISNULL(LTRIM(RTRIM(XA.KODE_WARNA)),'-')	!= ''
                        AND LTRIM(RTRIM(XA.HADIR))   ='Y'
                        AND (XA.JML_KONFIRMASI_HADIR - XA.JUMLAH) < 0	
						AND USER_ENTRY NOT IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
                )
            FROM REGISTER_TAMU A
            WHERE 1=1                    
                AND A.KATEGORI                              = '".$kategori."'          
                AND ISNULL(LTRIM(RTRIM(A.NAMA)),'')			!= ''
                AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')	!= ''
                AND LTRIM(RTRIM(A.HADIR))   ='Y'
                AND (A.JML_KONFIRMASI_HADIR - A.JUMLAH) < 0
            GROUP BY
                ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')
        ");

         return $q;
    }

	public static function get_dtl_melebihi($kategori,$vzona){
        $q = DB::select("
        SELECT ROW_NUMBER() OVER(PARTITION BY ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') ORDER BY LTRIM(RTRIM(A.NAMA)) ASC ) AS NOMOR,
				ISNULL(LTRIM(RTRIM(A.NAMA)),'-') AS NAMA,
				ISNULL(ABS(A.JML_KONFIRMASI_HADIR - A.JUMLAH),0) AS JML_UNDANGAN,
				CONVERT(VARCHAR(5), ISNULL(A.JAM_DATANG,'00:00'), 108) JAM_HADIR
            FROM Register_Tamu A
            WHERE KATEGORI = '".$kategori."'   
            AND ISNULL(LTRIM(RTRIM(KODE_WARNA)),'-')	= '".$vzona."'
            AND NO_REGISTER IN 

            (SELECT B.NO_REGISTER 
		    FROM Register_Tamu B WHERE 1=1
	        AND KATEGORI = '".$kategori."'  
            AND ISNULL(LTRIM(RTRIM(KODE_WARNA)),'-')	= '".$vzona."'
	        AND (B.JML_KONFIRMASI_HADIR - B.JUMLAH) < 0)
            AND USER_ENTRY NOT IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
        ");

         return $q;

    }

    public static function get_zona_kurang($kategori){
         $q = DB::select("
            SELECT
              ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') KODE_WARNA,
                TOTAL = 
                (
                    SELECT 
                        ISNULL(SUM(ABS(XA.JML_KONFIRMASI_HADIR - XA.JUMLAH)),0)
                    FROM REGISTER_TAMU XA
                    WHERE 1=1			   
                        AND XA.KATEGORI                              = '".$kategori."'          
                        AND ISNULL(LTRIM(RTRIM(XA.NAMA)),'')		!= ''
                        AND ISNULL(LTRIM(RTRIM(XA.KODE_WARNA)),'-')	!= ''
                        AND LTRIM(RTRIM(XA.HADIR))   ='Y'
                        AND (XA.JML_KONFIRMASI_HADIR - XA.JUMLAH) > 0	
						AND USER_ENTRY NOT IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
                )
            FROM REGISTER_TAMU A
            WHERE 1=1                    
                AND A.KATEGORI                              = '".$kategori."'        
                AND ISNULL(LTRIM(RTRIM(A.NAMA)),'')			!= ''
                AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')	!= ''
                AND LTRIM(RTRIM(A.HADIR))   ='Y'
                AND (A.JML_KONFIRMASI_HADIR - A.JUMLAH) > 0
            GROUP BY
                ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')
        
        ");

         return $q;
    }

	public static function get_dtl_kurang($kategori,$vzona){
        $q = DB::select("
        SELECT ROW_NUMBER() OVER(PARTITION BY ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') ORDER BY LTRIM(RTRIM(A.NAMA)) ASC ) AS NOMOR,
				ISNULL(LTRIM(RTRIM(A.NAMA)),'-') AS NAMA,
				ISNULL(ABS(A.JML_KONFIRMASI_HADIR - A.JUMLAH),0) AS JML_UNDANGAN,
				CONVERT(VARCHAR(5), ISNULL(A.JAM_DATANG,'00:00'), 108) JAM_HADIR
            FROM Register_Tamu A
            WHERE KATEGORI = '".$kategori."'   
            AND ISNULL(LTRIM(RTRIM(KODE_WARNA)),'-')	= '".$vzona."'
            AND NO_REGISTER IN 

            (SELECT B.NO_REGISTER 
		    FROM Register_Tamu B WHERE 1=1
	        AND KATEGORI = '".$kategori."'   
            AND ISNULL(LTRIM(RTRIM(KODE_WARNA)),'-')	= '".$vzona."'
	        AND (B.JML_KONFIRMASI_HADIR - B.JUMLAH) > 0)
			AND USER_ENTRY NOT IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
        ");

         return $q;

    }
    public static function get_zona_tambahan($kategori){
         $q = DB::select("
            SELECT
              ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') KODE_WARNA,
                TOTAL = 
                (
                    SELECT 
                        ISNULL(SUM(XA.JUMLAH),0)
                    FROM REGISTER_TAMU XA
                    WHERE 1=1			   
                        AND XA.KATEGORI                              = '".$kategori."'         
                        AND ISNULL(LTRIM(RTRIM(XA.NAMA)),'')		!= ''
                        AND ISNULL(LTRIM(RTRIM(XA.KODE_WARNA)),'-')	!= ''
                        AND LTRIM(RTRIM(XA.HADIR))   ='Y'	
						AND USER_ENTRY IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
                )
            FROM REGISTER_TAMU A
            WHERE 1=1                    
                AND A.KATEGORI                              = '".$kategori."'       
                AND ISNULL(LTRIM(RTRIM(A.NAMA)),'')			!= ''
                AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')	!= ''
                AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')	!= ''
                AND LTRIM(RTRIM(A.HADIR))   ='Y'
				AND USER_ENTRY IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
            GROUP BY
                ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')
        ");

         return $q;
    }

	public static function get_dtl_tambahan($kategori,$vzona){
        $q = DB::select("
        SELECT ROW_NUMBER() OVER(PARTITION BY ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') ORDER BY LTRIM(RTRIM(A.NAMA)) ASC ) AS NOMOR,
				ISNULL(LTRIM(RTRIM(A.NAMA)),'-') AS NAMA,
				ISNULL(A.JUMLAH,0) AS JML_UNDANGAN,
				CONVERT(VARCHAR(5), ISNULL(A.JAM_DATANG,'00:00'), 108) JAM_HADIR
            FROM Register_Tamu A
            WHERE KATEGORI = '".$kategori."'    
            AND ISNULL(LTRIM(RTRIM(KODE_WARNA)),'-')	= '".$vzona."'
            AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')	!= ''
            AND NO_REGISTER IN 

            (
			SELECT B.NO_REGISTER 
		    FROM Register_Tamu B WHERE 1=1
	        AND KATEGORI = '".$kategori."'   
            AND ISNULL(LTRIM(RTRIM(KODE_WARNA)),'-')	= '".$vzona."'
            AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')	!= ''
			AND USER_ENTRY IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
			)
        
        ");

         return $q;

    }

    public static function get_zona_tidak_hadir($kategori){
         $q = DB::select("
            SELECT
                ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') KODE_WARNA,
                TOTAL = 
                (
                    SELECT
                        SUM_HADIR = ISNULL(COUNT(XA.NO_REGISTER),0)
                    FROM REGISTER_TAMU XA
                    WHERE 1=1			

                        AND XA.KATEGORI                              = 'OPENING2'
                        AND ISNULL(LTRIM(RTRIM(XA.NAMA)),'')		!= ''
                        AND ISNULL(LTRIM(RTRIM(XA.KODE_WARNA)),'-')	!= ''
                        AND LTRIM(RTRIM(XA.HADIR))					 = 'N'
                        AND ISNULL(JML_KONFIRMASI_HADIR,0) = 0
						AND USER_ENTRY NOT IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
                )
            FROM REGISTER_TAMU A
            WHERE 1=1

                AND A.KATEGORI                               =  '".$kategori."' 
                AND ISNULL(LTRIM(RTRIM(A.NAMA)),'')         != ''
                AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')   != ''
                AND LTRIM(RTRIM(A.HADIR))                    = 'N'
				AND ISNULL(JML_KONFIRMASI_HADIR,0) = 0
            GROUP BY
                ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')
        
        ");

         return $q;
    }

	public static function get_dtl_tidak_hadir($kategori,$vzona){
        $q = DB::select("
        SELECT 
                ROW_NUMBER() OVER(PARTITION BY ISNULL(LTRIM(RTRIM(V_HADIR.KODE_WARNA)),'-') ORDER BY LTRIM(RTRIM(V_HADIR.NAMA)) ASC ) AS NOMOR,
                V_HADIR.NAMA,
                V_HADIR.JML_UNDANGAN,
                V_HADIR.JAM_HADIR
            FROM 
            (
                SELECT
                    ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-') KODE_WARNA,
                    ISNULL(LTRIM(RTRIM(A.NAMA)),'-') AS NAMA,
                    ISNULL(A.JUMLAH,0) AS JML_UNDANGAN,
                    CONVERT(VARCHAR(5), ISNULL(A.JAM_DATANG,'00:00'), 108) JAM_HADIR
                FROM REGISTER_TAMU AS A
                WHERE 1=1
                    
                    AND A.KATEGORI                               = '".$kategori."' 
                    AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')				 = '".$vzona."' 
                    AND ISNULL(LTRIM(RTRIM(A.NAMA)),'')			!= ''
                    AND ISNULL(LTRIM(RTRIM(A.KODE_WARNA)),'-')	!= ''
                    AND LTRIM(RTRIM(A.HADIR))					 = 'N'
                    AND ISNULL(JML_KONFIRMASI_HADIR,0) = 0
					AND USER_ENTRY NOT IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
            ) V_HADIR
            WHERE 1=1
        ");

         return $q;

    }

    public static function  get_total_rekap($kategori){
		 $q = DB::select("
                    
        SELECT 'Total Undangan' AS NAMA,  COUNT(NO_REGISTER) AS JUMLAH
        from REGISTER_TAMU
        where KATEGORI = '".$kategori."' --TOTAL UNDANGAN
        UNION ALL
        SELECT 'Total Hadir' AS NAMA,  COUNT(NO_REGISTER) AS JUMLAH
        FROM REGISTER_TAMU
        WHERE KATEGORI = '".$kategori."' 
        AND HADIR ='Y' -- HADIR
        AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0
        UNION ALL 
        SELECT 'Total Belum Hadir' AS NAMA,  COUNT(NO_REGISTER) AS JUMLAH
        FROM REGISTER_TAMU
        WHERE KATEGORI = '".$kategori."'
        AND ISNULL(HADIR,'') = '' --BLM HADIR
        AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0
        UNION ALL 
        SELECT 'Total Tambahan' AS NAMA,  COUNT(NO_REGISTER) AS JUMLAH
        FROM REGISTER_TAMU
        WHERE KATEGORI = '".$kategori."'
        AND HADIR ='Y' -- HADIR
        AND ISNULL(JML_KONFIRMASI_HADIR,0) >= 0
        AND USER_ENTRY IN  (SELECT CAST(ID AS VARCHAR(50)) FROM users) -- TOTAL TAMBAHAN
        UNION ALL
        Select 'Total Souvenir' AS NAMA, ISNULL(SUM(TAMBAH_GOODIEBAG),0) AS JUMLAH
        from REGISTER_TAMU
        where KATEGORI = '".$kategori."' --TOTAL SOUVENIR

		 ");

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
        AND USER_ENTRY NOT IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
		AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0
			
		) ----TOTAL HADIR 	
		UNION ALL
		(SELECT COUNT(B.NO_REGISTER) AS JUMLAH, ISNULL(SUM(B.JUMLAH),0) AS PAX
		FROM Register_Tamu B
		WHERE HADIR = 'Y' and kategori= '".$kategori."'
		AND ( ISNULL(JML_KONFIRMASI_HADIR,0) >= 0) AND USER_ENTRY IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
			
		) ----TOTAL TAMBAHAN 
			UNION ALL
		(SELECT COUNT(B.NO_REGISTER) AS JUMLAH, ISNULL(SUM(B.JML_KONFIRMASI_HADIR),0) AS PAX
		FROM Register_Tamu B
		WHERE ISNULL(HADIR,'') = '' and kategori= '".$kategori."'
		AND ISNULL(JML_KONFIRMASI_HADIR,0) > 0) ----BELUM HADIR
			UNION ALL
		(SELECT COUNT(B.NO_REGISTER) AS JUMLAH, ISNULL(SUM(B.JML_KONFIRMASI_HADIR),0) AS PAX
		FROM Register_Tamu B
		WHERE HADIR = 'N' and kategori= '".$kategori."'
		AND ISNULL(JML_KONFIRMASI_HADIR,0) = 0)  ----KONFIRM TDK HADIR 
			UNION ALL 
		(SELECT COUNT(B.NO_REGISTER) AS JUMLAH, ISNULL(SUM(ABS(B.JML_KONFIRMASI_HADIR - B.JUMLAH)),0) AS PAX
		FROM Register_Tamu B WHERE 1=1
	AND KATEGORI = '".$kategori."'
    AND USER_ENTRY NOT IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
	AND (B.JML_KONFIRMASI_HADIR - B.JUMLAH) < 0)
     --- MELEBIHI JUMLAH PAX
		UNION ALL 
		(SELECT COUNT(B.NO_REGISTER) AS JUMLAH, ISNULL(SUM(ABS(B.JML_KONFIRMASI_HADIR - B.JUMLAH)),0) AS PAX
		FROM Register_Tamu B WHERE 1=1
	AND KATEGORI = '".$kategori."'
    AND USER_ENTRY NOT IN (SELECT CAST(ID AS VARCHAR(50)) FROM users)
	AND (B.JML_KONFIRMASI_HADIR - B.JUMLAH) > 0) --- KURANG JUMLAH PAX
	    	");
				
		return $q;
	}
    
}

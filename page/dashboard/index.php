  
<div class="tile-area no-padding">
    
<?php
        $loadinfo  = "SELECT * FROM akademik_info ORDER BY info_id DESC limit 1";
        $queryinfo = mysqli_query($koneksi,$loadinfo);
        $info = mysqli_fetch_array($queryinfo);
        ?>
<marquee direction="left" scrollamount="5" align="center"><mark><b><?php echo $info['isi_info'] ?><b></mark></marquee>
    <div class="tile-container ">
        <a href="<?= $_url ?>tutorial">
        	<div class="tile-wide bg-crimson fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-youtube"></span>
                    </div>
                    <span class="tile-label">TUTORIAL</span>
        	</div>
        </a>
        <a target="_BLANK" href="<?= $_url ?>ulearning">
        	<div class="tile-wide bg-blue fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-power"></span>
                    </div>
                    <span class="tile-label">ULEARNING</span>
        	</div>
        </a>
        <a href="<?= $_url ?>pmb_undaris">
        	<div class="tile-wide bg-maroon fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-rocket"></span>
                    </div>
                    <span class="tile-label">PELOPOR UNDARIS</span>
        	</div>
        </a>
    <?php
        $mhs = mysqli_query($koneksi,"SELECT angkatan_id, semester,id_sks,kpt FROM student_mahasiswa WHERE nim='$_username'");
        $dis = mysqli_fetch_array($mhs);
        $ang = $dis['angkatan_id'];
        $sks = $dis['id_sks'];
        $kpt = $dis['kpt'];
        $sem = $dis['semester'];
        if ($ang <= 20 && $sks==2 && $kpt==0){
            $loadbyr = mysqli_query($koneksi,"SELECT * FROM bayar_sks WHERE nim='$_username' AND semester='$sem'");
            $cek = mysqli_num_rows($loadbyr);
            if ($cek > 0){
            $status = mysqli_fetch_array($loadbyr);
            if ($status['status']!=1){
                echo "<script>window.alert('Silahkan Melunasi Biaya SKS Konversi di BAUK!!')
		    window.location.href='{$_url}krs-konversi/bayar/19610084'</script>";
            }
        }
        }
        ?>
    <?php if ($_access == 'admin'): ?>
        <a href="<?= $_url ?>mahasiswa">
        <?php
        $loadmhs  = "SELECT * FROM student_mahasiswa";
        $querymhs = mysqli_query($koneksi,$loadmhs);
        $count = mysqli_num_rows($querymhs);
        ?>
        	<div class="tile-wide bg-indigo fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-users"><?php echo $count ?></span>
                    </div>
                    <span class="tile-label">MAHASISWA</span>
        	</div>
        </a>
        <a href="<?= $_url ?>cek_tagihan/briva">
            <div class="tile-wide bg-lightRed fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-money"></span>
                    </div>
                    <span class="tile-label">CEK SPP BRIVA</span>
            </div>
        </a>
        <a href="<?= $_url ?>laporan_krs">
        	<div class="tile-wide bg-emerald fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">LAPORAN KRS MAHASISWA</span>
        	</div>
        </a>
        <a href="<?= $_url ?>krs-susulan">
        	<div class="tile-wide bg-blue fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">KRS SUSULAN</span>
        	</div>
        </a>
        <a href="<?= $_url ?>khs_fakultas">
        	<div class="tile-wide bg-lightRed fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-calendar"></span>
                    </div>
                    <span class="tile-label">KHS MAHASISWA</span>
        	</div>
        </a>
        <a href="<?= $_url ?>transkrip_fakultas">
            <div class="tile-wide bg-yellow fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-school"></span>
                    </div>
                    <span class="tile-label">TRANSKRIP</span>

            </div>
        </a>
        <a href="<?= $_url ?>dosen">
        	<div class="tile-wide bg-lightRed fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-users"></span>
                    </div>
                    <span class="tile-label">DOSEN</span>
        	</div>
        </a>
        <a href="<?= $_url ?>dosen/add_dosen_junior">
        	<div class="tile bg-blue fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-users"></span>
                    </div>
                    <span class="tile-label">SET DOSEN PEMBANTU</span>
        	</div>
        </a>
        <a href="<?= $_url ?>absen_dosen">
            <div class="tile-wide bg-cobalt fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-users"></span>
                    </div>
                    <span class="tile-label">PRESENSI DOSEN</span>
            </div>
        </a>
        <a href="<?= $_url ?>matakuliah">
        	<div class="tile-wide bg-emerald fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">MATAKULIAH</span>
        	</div>
        </a>
        <a href="<?= $_url ?>program-studi">
        	<div class="tile-wide bg-darkRed fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-school"></span>
                    </div>
                    <span class="tile-label">PROGRAM STUDI</span>
        	</div>
        </a>
        <a href="<?= $_url ?>konversi_nilai">
            <div class="tile-wide bg-darkBlue fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-school"></span>
                    </div>
                    <span class="tile-label">KONVERSI NILAI</span>
            </div>
        </a>
        <a href="<?= $_url ?>user">
        	<div class="tile bg-magenta fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-users"></span>
                    </div>
                    <span class="tile-label">USERS</span>
        	</div>
        </a>
        <a href="<?= $_url ?>jadwal">
        	<div class="tile-wide bg-lightBlue fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-calendar"></span>
                    </div>
                    <span class="tile-label">JADWAL</span>
        	</div>
        </a>
        <a href="<?= $_url ?>info/add">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">INFORMASI</span>
        	</div>
        </a>
    <?php endif; ?>
    <?php if ($_access == 'yayasan'): ?>
        <a href="<?= $_url ?>mahasiswa">
        <?php 
        $loadmhs  = "SELECT * FROM student_mahasiswa";
        $querymhs = mysqli_query($koneksi,$loadmhs);
        $count = mysqli_num_rows($querymhs);
        ?>
        	<div class="tile-wide bg-yellow fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-users"><?php echo $count ?></span>
                    </div>
                    <span class="tile-label">MAHASISWA</span>
        	</div>
        </a>
        <a href="<?= $_url ?>absen_dosen">
            <div class="tile-wide bg-cobalt fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-users"></span>
                    </div>
                    <span class="tile-label">PRESENSI DOSEN</span>
            </div>
        </a>
        <a href="<?= $_url ?>report">
        	<div class="tile-wide bg-lightBlue fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">LAPORAN BIAYA KULIAH SEMESTER</span>
        	</div>
        </a>
        <a href="<?= $_url ?>report/bulanan">
        	<div class="tile-wide bg-lightRed fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">LAPORAN ANGSURAN BIAYA KULIAH BULANAN</span>
        	</div>
        </a>
        <a href="<?= $_url ?>report/konversi-bulanan">
        	<div class="tile-wide bg-lightGreen fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">LAPORAN ANGSURAN BIAYA KULIAH MAHASISWA KONVERSI BULANAN</span>
        	</div>
        </a>
        <a href="<?= $_url ?>report/kpt">
        	<div class="tile-wide bg-lightBlue fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">LAPORAN BIAYA KULIAH KPT</span>
        	</div>
        </a>
    <?php endif; ?>
    <?php if ($_access == 'keuangan'): ?>
       <a target="_BLANK" href="download?filename=MODUL-ADMIN-KEUANGAN.pdf">
            <div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-key"></span>
                    </div>
                    <span class="tile-label">DOWNLOAD MODUL</span>
            </div>
        </a>
        <a href="<?= $_url ?>briva">
            <div class="tile-wide bg-lightGreen fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-money"></span>
                    </div>
                    <span class="tile-label">BRIVA</span>
            </div>
        </a>
        <a href="<?= $_url ?>bayar_kpt">
            <div class="tile-wide bg-darkMagenta fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-money"></span>
                    </div>
                    <span class="tile-label">KPT</span>
            </div>
        </a>
         <a href="<?= $_url ?>cek_tagihan/briva">
            <div class="tile-wide bg-lightRed fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-money"></span>
                    </div>
                    <span class="tile-label">CEK SPP BRIVA</span>
            </div>
        </a>
        <a href="<?= $_url ?>mahasiswa">
        <?php 
        $loadmhs  = "SELECT * FROM student_mahasiswa";
        $querymhs = mysqli_query($koneksi,$loadmhs);
        $count = mysqli_num_rows($querymhs);
        ?>
        	<div class="tile-wide bg-magenta fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-users"><?php echo $count ?></span>
                    </div>
                    <span class="tile-label">MAHASISWA</span>
        	</div>
        </a>
        <a href="<?= $_url ?>sks-peternakan">
            <div class="tile-wide bg-darkRed fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-school"></span>
                    </div>
                    <span class="tile-label">PEMBAYARAN SKS (PETERNAKAN)</span>
            </div>
        </a>
        <a href="<?= $_url ?>angsuran">
            <div class="tile bg-yellow fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">ANGSURAN MAHASISWA</span>
            </div>
        </a>
        <a href="<?= $_url ?>keuangan">
            <div class="tile-wide bg-yellow fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-pencil"></span>
                    </div>
                    <span class="tile-label">PEMBAYARAN SEMESTER MAHASISWA</span>
            </div>
        </a>
        <a href="<?= $_url ?>angsuran/biaya_angsuran">
            <div class="tile bg-lightRed fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">SET ANGSURAN FAKULTAS</span>
            </div>
        </a>
        <a href="<?= $_url ?>keuangan_sks">
            <div class="tile-wide bg-darkRed fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">PEMBAYARAN SKS (KONVERSI)</span>
            </div>
        </a>
        <a href="<?= $_url ?>konversi_bulanan">
            <div class="tile-wide bg-cobalt fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">PEMBAYARAN KONVERSI BULANAN</span>
            </div>
        </a>
        <a href="<?= $_url ?>report">
        	<div class="tile-wide bg-lightBlue fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">LAPORAN BIAYA KULIAH SEMESTER</span>
        	</div>
        </a>
        <a href="<?= $_url ?>report/bulanan">
        	<div class="tile-wide bg-orange fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">LAPORAN ANGSURAN BIAYA KULIAH BULANAN</span>
        	</div>
        </a>
        <a href="<?= $_url ?>report/konversi-bulanan">
        	<div class="tile-wide bg-lightGreen fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">LAPORAN ANGSURAN BIAYA KULIAH MAHASISWA KONVERSI BULANAN</span>
        	</div>
        </a>
        <a href="<?= $_url ?>report/kpt">
        	<div class="tile bg-lightBlue fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">LAPORAN BIAYA KULIAH KPT</span>
        	</div>
        </a>
    <?php endif; ?>
    <?php if ($_access == 'kpt'): ?>
        <a href="<?= $_url ?>angsuran_kpt">
        	<div class="tile-wide bg-crimson fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-school"></span>
                    </div>
                    <span class="tile-label">BAYAR BULANAN</span>
        	</div>
        </a>
        <a href="<?= $_url ?>report/kpt">
        	<div class="tile-wide bg-lightBlue fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">LAPORAN BIAYA KULIAH KPT</span>
        	</div>
        </a>
        <a href="<?= $_url ?>angsuran_kpt/change-password">
        	<div class="tile-wide bg-magenta fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-key"></span>
                    </div>
                    <span class="tile-label">CHANGE PASSWORD</span>
        	</div>
        </a>
    <?php endif; ?>
    <?php if ($_access == 'dosen'): ?>
        <a href="<?= $_url ?>dosen/view/<?= $_username ?>">
        	<div class="tile-wide bg-crimson fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-user"></span>
                    </div>
                    <span class="tile-label">PROFIL DOSEN</span>
        	</div>
        </a>
        <a target="_BLANK" href="download?filename=ALUR-SIAKAD-DOSEN.pdf">
            <div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-key"></span>
                    </div>
                    <span class="tile-label">DOWNLOAD MODUL</span>
            </div>
        </a>
        <a href="<?= $_url ?>dosen/list">
        	<div class="tile-wide bg-lightRed fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-calendar"></span>
                    </div>
                    <span class="tile-label">JADWAL MENGAJAR <br> & INPUT NILAI</span>
        	</div>
        </a>
        <a href="<?= $_url ?>jadwal_pengawas/view">
        	<div class="tile-wide bg-darkBlue fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-calendar"></span>
                    </div>
                    <span class="tile-label">JADWAL PENGAWAS</span>
        	</div>
        </a>
        <a href="<?= $_url ?>presensi_mahasiswa">
            <div class="tile-wide bg-orange fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-school"></span>
                    </div>
                    <span class="tile-label">PRESENSI MAHASISWA</span>

            </div>
        </a>
        <a href="<?= $_url ?>dosen/acc-krs">
            <div class="tile-wide bg-lightBlue fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-school"></span>
                    </div>
                    <span class="tile-label">KRS Wali Mahasiswa</span>
            </div>
        </a>
        <a href="<?= $_url ?>dosen/lihatnilai">
        	<div class="tile-wide bg-lightRed fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">LIHAT NILAI</span>
        	</div>
        </a>
        <a href="<?= $_url ?>persentase">
        	<div class="tile-wide bg-green fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">SET PERSENTASE</span>
        	</div>
        </a>
        <a href="<?= $_url ?>dosen/change-password">
        	<div class="tile-wide bg-magenta fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-key"></span>
                    </div>
                    <span class="tile-label">CHANGE PASSWORD</span>
        	</div>
        </a>
     
    <?php endif; ?>
    <?php if ($_access == 'mhs'): ?>
    <?php
    echo "<script>window.alert('MAAF HALAMAN TIDAK BISA DIAKSSES')
		    window.location.href='mt.php'</script>";
		    ?>
		    <?php
		    endif;
		    ?>
     <?php if ($_access == 'mahasiswa'): ?>
    <?php $cek = mysqli_query($koneksi,"SELECT * FROM student_mahasiswa WHERE nim='$_username'"); 
          $dis = mysqli_fetch_array($cek);
          $angkatan = $dis['angkatan_id'];
          $semester = $dis['semester'];
          $email = $dis['email'];
          $kpt = $dis['kpt'];
          $angkatan = $dis['angkatan_id'];
          $beasiswa = $dis['beasiswa'];
        
          
          $ver = mysqli_query($koneksi,"SELECT * FROM email_verifikasi WHERE nim='$_username'");
          $status = mysqli_fetch_array($ver);
          if(mysqli_num_rows($ver) == 0){
               echo "<script type='text/javascript'>alert('Silahkan verifikasi alamat email anda!!');
                    setTimeout(function(){ 
                        window.location.href='https://siakad.undaris.ac.id/input-email.php'; 
                    }, 2000);</script>";
          }else{
          if($status['status']==0){
              echo "<script type='text/javascript'>alert('Silahkan verifikasi alamat email anda!!');
                    setTimeout(function(){ 
                        window.location.href='https://siakad.undaris.ac.id/input-email.php'; 
                    }, 2000);</script>";
          }
          }
    ?>
    
        <a target="_BLANK" href="https://chat.whatsapp.com/LqvM3BAjK588An9ZXafy5s">
        	<div class="tile-wide bg-green fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-whatsapp"></span>
                    </div>
                    <span class="tile-label">INFO SIAKAD</span>
        	</div>
        </a>
        <a href="<?= $_url ?>mahasiswa/view/<?= $_username ?>">
        	<div class="tile-wide bg-crimson fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-user"></span>
                    </div>
                    <span class="tile-label">PROFIL MAHASISWA</span>
        	</div>
        </a>
        <a target="_BLANK" href="download?filename=ALUR-KRS-MAHASISWA.pdf">
            <div class="tile-wide bg-yellow fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-key"></span>
                    </div>
                    <span class="tile-label">DOWNLOAD MODUL</span>
            </div>
        </a>
        <?php
        if ($angkatan > 16 AND $kpt!=1 AND $beasiswa!=1):
        ?>
        <a href="<?= $_url ?>transaksi">
        	<div class="tile-wide bg-lightGreen fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-money"></span>
                    </div>
                    <span class="tile-label">TRANSAKSI</span>
        	</div>
        </a>
        <?php
        endif;
        ?>
        <?php
        $loadpakis = mysqli_query($koneksi,"SELECT * FROM nim_briva WHERE nim='$_username'");
        $pakis = mysqli_num_rows($loadpakis);
        if($pakis > 0):
            ?>
            <a href="<?= $_url ?>transaksi">
        	<div class="tile-wide bg-lightGreen fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-money"></span>
                    </div>
                    <span class="tile-label">TRANSAKSI</span>
        	</div>
        </a>
        <?php
        endif;
        ?>
        <?php
        // $loadmhs  = "SELECT * FROM akademik_info";
        // $querymhs = mysqli_query($koneksi,$loadmhs);
        // $count = mysqli_num_rows($querymhs);
        ?>
        <!--<a href="<?= $_url ?>info/view/<?= $_username ?> ">-->
        <!--	<div class="tile-wide bg-darkBlue fg-white" data-role="tile">-->
        <!--			<div class="tile-content iconic">-->
        <!--            <span class="icon mif-books"><b><?php echo $count ?></b></span>-->
        <!--            </div>-->
        <!--            <span class="tile-label">INFO UMUM</span>-->
        <!--	</div>-->
        <!--</a>-->
        <a href="<?= $_url ?>mahasiswa/list/<?= $_username ?>">
        	<div class="tile-wide bg-cobalt fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-calendar"></span>
                    </div>
                    <span class="tile-label">JADWAL KULIAH</span>
        	</div>
        </a>
                <?php
        
    $sql1   = "SELECT jk.*, akrs.jadwal_id FROM jadwal_kuliah as jk, akademik_krs as akrs
               WHERE jk.jadwal_id=akrs.jadwal_id AND akrs.nim='$_username'";
	$query1 = mysqli_query($koneksi, $sql1);
	$countt = mysqli_num_rows($query1);
?>
        <a href="<?= $_url ?>jadwal_uas/view">
        	<div class="tile-wide bg-lightRed fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-calendar"><?php echo $countt ?></span>
                    </div>
                    <span class="tile-label">JADWAL UAS</span>
        	</div>
        </a>
<?php
        $loadcicilan = mysqli_query($koneksi,"SELECT semester,id_sks,status_angsur,kpt,beasiswa,konsentrasi_id,angkatan_id FROM student_mahasiswa WHERE nim='$_username'");
        $cicilan = mysqli_fetch_array($loadcicilan); 
        if ($cicilan['id_sks']=='1' AND $cicilan['status_angsur']=='0' 
        AND $cicilan['beasiswa']=='0' AND $cicilan['kpt']=='0' 
        AND $cicilan['konsentrasi_id']!=25 ):
        ?>
        <a href="<?= $_url ?>krs/view/<?= $_username ?>">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-download"></span>
                    </div>
                    <span class="tile-label">KRS</span>
        	</div>
        </a>
        <?php
        elseif ($cicilan['konsentrasi_id']=='25'):
        ?>
        <a href="<?= $_url ?>krs-magister/view/<?= $_username ?>">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-download"></span>
                    </div>
                    <span class="tile-label">KRS MAGISTER</span>
        	</div>
        </a>
        <?php
    	elseif ($cicilan['id_sks']=='2' && $cicilan['status_angsur']=='0'):
        ?>
        <a href="<?= $_url ?>krs-konversi/view/<?= $_username ?>">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-download"></span>
                    </div>
                    <span class="tile-label">KRS KONVERSI</span>
        	</div>
        </a>
        <?php
    	elseif ($cicilan['kpt']=='1' && $cicilan['id_sks']=='2' && $cicilan['status_angsur']=='0' && $cicilan['beasiswa']=='0'):
        ?>
        <a href="<?= $_url ?>krs-kpt-konversi/view/<?= $_username ?>">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-download"></span>
                    </div>
                    <span class="tile-label">KRS KPT KONVERSI</span>
        	</div>
        </a>
        <?php
    	elseif ($cicilan['angkatan_id']<= '20' && $cicilan['status_angsur']=='1' && $cicilan['id_sks']=='2'):
        ?>
        <a href="<?= $_url ?>krs-kerjasama-konversi/view/<?= $_username ?>">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-download"></span>
                    </div>
                    <span class="tile-label">KRS BULANAN KONVERSI</span>
        	</div>
        </a>
        <?php
        elseif ($cicilan['angkatan_id']<= '20' && $cicilan['status_angsur']=='1' && $cicilan['beasiswa']=='0' && $cicilan['kpt']=='0'):
        ?>
        <a href="<?= $_url ?>krs-cicilan/view/<?= $_username ?>">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-download"></span>
                    </div>
                    <span class="tile-label">KRS METODE CICILAN</span>
        	</div>
        </a>
         <?php
        elseif ($cicilan['angkatan_id'] >= '21' && $cicilan['status_angsur']=='1' && $cicilan['id_sks']=='2'):
        ?>
        <a href="<?= $_url ?>krs-konversi-briva/view/<?= $_username ?>">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-download"></span>
                    </div>
                    <span class="tile-label">KRS KONVERSI BRIVA</span>
        	</div>
        </a>
        <?php
        elseif ($cicilan['kpt']=='1'):
        ?>
        <a href="<?= $_url ?>krs-kpt/view/<?= $_username ?>">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-download"></span>
                    </div>
                    <span class="tile-label">KRS via KPT</span>
        	</div>
        </a>
        <?php
        elseif ($cicilan['beasiswa']=='1'):
        ?>
        <a href="<?= $_url ?>krs-beasiswa/view/<?= $_username ?>">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-download"></span>
                    </div>
                    <span class="tile-label">KRS Mahasiswa</span>
        	</div>
        </a>
        <?php
        elseif ($cicilan['angkatan_id'] = 21 && $cicilan['status_angsur']=='1'):
        ?>
        <a href="<?= $_url ?>krs-briva/view/<?= $_username ?>">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-download"></span>
                    </div>
                    <span class="tile-label">KRS BRIVA</span>
        	</div>
        </a>
        <?php
        elseif ($cicilan['angkatan_id'] = 23 && $cicilan['status_angsur']=='1'):
        ?>
        <a href="<?= $_url ?>krs-briva/view/<?= $_username ?>">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-download"></span>
                    </div>
                    <span class="tile-label">KRS BRIVA</span>
        	</div>
        </a>
        <?php
        elseif ($cicilan['angkatan_id'] = 24 && $cicilan['status_angsur']=='1'):
        ?>
        <a href="<?= $_url ?>krs-briva/view/<?= $_username ?>">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-download"></span>
                    </div>
                    <span class="tile-label">KRS BRIVA</span>
        	</div>
        </a>
       
        <?php
    	endif;
        ?>
        <a href="<?= $_url ?>krs-mbkm">
        	<div class="tile-wide bg-blue fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-clipboard"></span>
                    </div>
                    <span class="tile-label">KRS MBKM</span>
        	</div>
        </a>
        <a href="<?= $_url ?>transkrip/view/<?= $_username ?>">
            <div class="tile-wide bg-darkBlue fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-school"></span>
                    </div>
                    <span class="tile-label">TRANSKRIP</span>

            </div>
        </a>
        <a href="<?= $_url ?>khs/view/<?= $_username ?>">
        	<div class="tile-wide bg-green fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-school"></span>
                    </div>
                    <span class="tile-label">KHS</span>
        	</div>
        </a>
        <!--<a href="<?= $_url ?>pengajuan-skripsi ">-->
        <!--    <div class="tile-wide bg-lightBlue fg-white" data-role="tile">-->
        <!--            <div class="tile-content iconic">-->
        <!--            <span class="icon mif-books"></span>-->
        <!--            </div>-->
        <!--            <span class="tile-label">AJUKAN JUDUL SKRIPSI/TA</span>-->
        <!--    </div>-->
        <!--</a>-->
        <a href="<?= $_url ?>perpustakaan ">
            <div class="tile-wide bg-lightBlue fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">PERPUSTAKAAN</span>
            </div>
        </a>
        <a href="<?= $_url ?>mahasiswa/change-password">
        	<div class="tile-wide bg-magenta fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-key"></span>
                    </div>
                    <span class="tile-label">CHANGE PASSWORD</span>
        	</div>
        </a>
    <?php endif; ?>
    <?php if ($_access == 'fakultas'): ?>
       <a href="<?= $_url ?>mahasiswa">
        <?php 
        $loadmhs  = "SELECT sm.* FROM student_mahasiswa as sm, akademik_konsentrasi as ak WHERE sm.konsentrasi_id=ak.konsentrasi_id and ak.nama_konsentrasi='$_username'";
        $querymhs = mysqli_query($koneksi,$loadmhs);
        $count = mysqli_num_rows($querymhs);
        ?>
        	<div class="tile-wide bg-darkRed fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-users"><?php echo $count ?></span>
                    </div>
                    <span class="tile-label">MAHASISWA</span>
        	</div>
        </a>
        <a href="<?= $_url ?>cek_tagihan/briva">
            <div class="tile-wide bg-lightRed fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-money"></span>
                    </div>
                    <span class="tile-label">CEK SPP BRIVA</span>
            </div>
        </a>
        <a href="<?= $_url ?>nilai_fakultas">
        	<div class="tile-wide bg-lightRed fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-users"></span>
                    </div>
                    <span class="tile-label">DAFTAR DOSEN & NILAI</span>
        	</div>
        </a>
        <a href="<?= $_url ?>konversi_nilai">
            <div class="tile-wide bg-darkBlue fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-school"></span>
                    </div>
                    <span class="tile-label">KONVERSI NILAI</span>
            </div>
        </a>
        <a href="<?= $_url ?>absen_dosen">
            <div class="tile-wide bg-cobalt fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-users"></span>
                    </div>
                    <span class="tile-label">PRESENSI DOSEN</span>
            </div>
        </a>
        <a href="<?= $_url ?>presensi_mahasiswa">
            <div class="tile-wide bg-orange fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-school"></span>
                    </div>
                    <span class="tile-label">PRESENSI MAHASISWA</span>

            </div>
        </a>
        <a href="<?= $_url ?>matakuliah">
        	<div class="tile-wide bg-emerald fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">MATAKULIAH</span>
        	</div>
        </a>
        <a href="<?= $_url ?>krs_fakultas">
        	<div class="tile-wide bg-yellow fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-calendar"></span>
                    </div>
                    <span class="tile-label">KRS MAHASISWA</span>
        	</div>
        </a>
        <a href="<?= $_url ?>khs_fakultas">
        	<div class="tile-wide bg-lightRed fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-calendar"></span>
                    </div>
                    <span class="tile-label">KHS MAHASISWA</span>
        	</div>
        </a>
        <a href="<?= $_url ?>laporan_krs">
        	<div class="tile-wide bg-emerald fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">LAPORAN KRS MAHASISWA</span>
        	</div>
        </a>
        <a href="<?= $_url ?>fakultas/jadwal">
        	<div class="tile-wide bg-lightBlue fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-calendar"></span>
                    </div>
                    <span class="tile-label">JADWAL</span>
        	</div>
        </a>
        <a href="<?= $_url ?>jadwal_uas">
        	<div class="tile-wide bg-darkRed fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-calendar"></span>
                    </div>
                    <span class="tile-label">JADWAL UAS</span>
        	</div>
        </a>
        <a href="<?= $_url ?>transkrip_fakultas">
            <div class="tile-wide bg-cobalt fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-school"></span>
                    </div>
                    <span class="tile-label">TRANSKRIP</span>

            </div>
        </a>
        <a href="<?= $_url ?>info/view">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">INFORMASI</span>
        	</div>
        </a>
        <a href="<?= $_url ?>fakultas/change-password">
            <div class="tile-wide bg-magenta fg-white" data-role="tile">
                    <div class="tile-content iconic">
                    <span class="icon mif-key"></span>
                    </div>
                    <span class="tile-label">CHANGE PASSWORD</span>
            </div>
        </a>
    <?php endif; ?>
    
</div>
    </div>
    <script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = 'siakad-undaris';
    
    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function () {
        var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = '//' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
    }());
</script>
<script id="dsq-count-scr" src="//siakad-undaris.disqus.com/count.js" async></script>
</div>


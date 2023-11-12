<?php
// starting session
session_start();

// set session
    $_access = isset($_SESSION['access']) ? $_SESSION['access'] : '';
    $_username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    $_name = isset($_SESSION['name']) ? $_SESSION['name'] : '';

// configuration conection with format 'host','username','password','dbname'
    $koneksi = mysqli_connect('localhost','root','','siakad');
    $koneksipmb = mysqli_connect('localhost','root','','pmb');
    $_tahun_ajaran = 20151;

// configuration access rule who can access page
    $_rules = array(
	'dashboard/index' => array('admin','mahasiswa','dosen','fakultas','keuangan','yayasan','kpt'),
	'pmb_undaris/index' => array('admin','mahasiswa','dosen','fakultas','keuangan','yayasan','kpt'),
	//tutorial
	'tutorial/index' => array('mahasiswa','dosen','admin','fakultas'),
	//briva
	'briva/index' => array('admin','keuangan'),
	'briva/monitoring' => array('admin','keuangan'),
	'briva/monitoring-nim' => array('admin','keuangan'),
	'briva/laporan' => array('admin','keuangan'),
	//briva
	'bayar_kpt/index' => array('admin','keuangan'),
	'bayar_kpt/monitoring' => array('admin','keuangan'),
	'bayar_kpt/monitoring-nim' => array('admin','keuangan'),
	'bayar_kpt/laporan' => array('admin','keuangan'),
	//email
	'email/index' => array('mahasiswa'),
	'email/verifikasi' => array('mahasiswa'),
	// absen dosen
	'absen_dosen/index' => array('admin','fakultas','dosen'),
	'absen_dosen/absen' => array('admin','fakultas','dosen'),
	// absensi
	'absensi/index' => array('admin','fakultas','dosen'),
	// route angsuran bulanan
	'angsuran/index' => array('admin','keuangan'),
	'angsuran/approved' => array('admin','keuangan'),
	'angsuran/bayar_angsuran' => array('admin','keuangan'),
	'angsuran/biaya_angsuran' => array('admin','keuangan'),
	'angsuran/delete' => array('admin','keuangan'),
	'angsuran/setting' => array('admin','keuangan'),
	'angsuran/bayar' => array('admin','keuangan'),
	// route peringatan
	'peringatan_angsuran/index' => array('admin','keuangan'),
	'peringatan_angsuran/edit' => array('admin','keuangan'),
	// route angsuran konversi
	'angsuran_konversi_blank/index' => array('admin','keuangan'),
	'angsuran_konversi_blank/approved' => array('admin','keuangan'),
	'angsuran_konversi_blank/bayar_angsuran' => array('admin','keuangan'),
	'angsuran_konversi_blank/biaya_angsuran' => array('admin','keuangan'),
	'angsuran_konversi_blank/delete' => array('admin','keuangan'),
	'angsuran_konversi_blank/setting' => array('admin','keuangan'),
	'angsuran_konversi_blank/bayar' => array('admin','keuangan'),
	// angsuran kpt
	'angsuran_kpt/index' => array('kpt'),
	'angsuran_kpt/approved' => array('kpt'),
	'angsuran_kpt/bayar_angsuran' => array('kpt'),
	'angsuran_kpt/biaya_angsuran' => array('kpt'),
	'angsuran_kpt/delete' => array('kpt'),
	'angsuran_kpt/setting' => array('kpt'),
	'angsuran_kpt/bayar' => array('kpt'),
	// route dosen
	'dosen/absen' => array('admin','dosen','fakultas'),
	'dosen/absensi' => array('admin','dosen','fakultas'),
	'dosen/add' => array('admin','fakultas'),
	'dosen/cetak-nilai' => array('admin','fakultas','dosen'),
	'dosen/form-penilaian' => array('admin','fakultas','dosen'),
	'dosen/index' => array('admin'),
	'dosen/view' => array('admin','dosen','fakultas'),
	'dosen/edit' => array('admin','dosen'),
	'dosen/delete' => array('admin'),
	'dosen/add-mahasiswa' => array('admin'),
	'dosen/delete-mahasiswa' => array('admin'),
	'dosen/add-prodi' => array('admin'),
	'dosen/delete-prodi' => array('admin'),
	'dosen/add_dosen_junior' => array('admin'),
	'dosen/lihatnilai' => array('dosen','fakultas'),
	'dosen/cetak-absen' => array('admin','dosen'),
	'dosen/list_absen' => array('admin','dosen'),
	'dosen/list' => array('admin','dosen','fakultas'),
	'dosen/inputnilai' => array('admin','dosen','fakultas'),
	'dosen/acc-krs' => array('fakultas','dosen'),
	'dosen/krs-mhs' => array('fakultas','dosen'),
	'dosen/approve' => array('fakultas','dosen'),
	'dosen/disapprove' => array('fakultas','dosen'),
	'dosen/publish-all' => array('fakultas','dosen'),
	'dosen/publish-khs' => array('fakultas','dosen'),
	'dosen/unpublish' => array('fakultas','dosen'),
	// keuangan sks konversi
	'keuangan_sks' => array('admin','keuangan'),
	'keuangan_sks/approved' => array('admin','keuangan'),
	'keuangan_sks/bayar' => array('admin','keuangan'),
	// keuangan
	'keuangan/index' => array('admin','keuangan'),
	'keuangan/struk' => array('admin','keuangan'),
	'keuangan/cetak' => array('admin','keuangan'),
	'keuangan/delete' => array('admin','keuangan'),
	// route konversi
	'konversi_nilai/index' => array('admin','fakultas'),
	'konversi_nilai/input' => array('admin','fakultas'),
	'konversi_nilai/view' => array('admin','fakultas'),
	// route konversi bulanan
	'konversi_bulanan' => array('admin','keuangan'),
	'konversi_bulanan/biaya_angsuran' => array('admin','keuangan'),
	'konversi_bulanan/bayar_angsuran' => array('admin','keuangan'),
	'konversi_bulanan/delete' => array('admin','keuangan'),
	// route mahasiswa
	'mahasiswa/index' => array('admin','yayasan','fakultas','keuangan'),
	'mahasiswa/add' => array('admin'),
	'mahasiswa/view' => array('admin','mahasiswa','dosen','fakultas','yayasan','keuangan'),
	'mahasiswa/edit' => array('admin','mahasiswa'),
	'mahasiswa/delete' => array('admin'),
	'mahasiswa/wali' => array('dosen'),
	'mahasiswa/export-mahasiswa' => array('admin'),
	'mahasiswa/editstatus' => array('admin'),
	'mahasiswa/status' => array('admin','fakultas'),
	// route mahasiswa
	'mhs_fakultas/index' => array('fakultas'),
	'mhs_fakultas/add' => array('fakultas'),
	'mhs_fakultas/view' => array('fakultas'),
	'mhs_fakultas/edit' => array('fakultas'),
	'mhs_fakultas/delete' => array('fakultas'),
	'mhs_fakultas/wali' => array('fakultas'),
	'mhs_fakultas/export-mahasiswa' => array('fakultas'),
	// nilai fakultas
	'nilai_fakultas/index' => array('fakultas'),
	'nilai_fakultas/makul_dosen' => array('fakultas'),
	'nilai_fakultas/lihat_nilai' => array('fakultas'),
	// krs susulan
	'krs-susulan/index' => array('admin'),
	'krs-susulan/setting' => array('admin'),
	'krs-susulan/add-krs' => array('admin'),
	// route krs
	'krs/index' => array('dosen','admin','fakultas'),
	'krs/view' => array('dosen','mahasiswa','admin','fakultas'),
	'krs/add-krs' => array('dosen','mahasiswa','admin','fakultas'),
	'krs/approve' => array('admin','fakultas'),
	'krs/disapprove' => array('admin','fakultas'),
	'krs/krs-mhs' => array('admin','fakultas'),
	'krs/delete' => array('dosen','mahasiswa','admin','fakultas'),
    'krs/laporan' => array('dosen','mahasiswa','admin','fakultas'),
    // route krs briva
	'krs-briva/index' => array('dosen','admin','fakultas'),
	'krs-briva/view' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-briva/add-krs' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-briva/approve' => array('admin','fakultas'),
	'krs-briva/disapprove' => array('admin','fakultas'),
	'krs-briva/krs-mhs' => array('admin','fakultas'),
	'krs-briva/delete' => array('dosen','mahasiswa','admin','fakultas'),
    'krs-briva/laporan' => array('dosen','mahasiswa','admin','fakultas'),
    // route krs briva
	'krs-konversi-briva/index' => array('dosen','admin','fakultas'),
	'krs-konversi-briva/view' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-konversi-briva/add-krs' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-konversi-briva/approve' => array('admin','fakultas'),
	'krs-konversi-briva/disapprove' => array('admin','fakultas'),
	'krs-konversi-briva/krs-mhs' => array('admin','fakultas'),
	'krs-konversi-briva/delete' => array('dosen','mahasiswa','admin','fakultas'),
    'krs-konversi-briva/laporan' => array('dosen','mahasiswa','admin','fakultas'),
    // route krs briva
	'krs-mbkm/index' => array('dosen','admin','fakultas','mahasiswa'),
	'krs-mbkm/view' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-mbkm/add-krs' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-mbkm/approve' => array('admin','fakultas'),
	'krs-mbkm/disapprove' => array('admin','fakultas'),
	'krs-mbkm/krs-mhs' => array('admin','fakultas'),
	'krs-mbkm/delete' => array('dosen','mahasiswa','admin','fakultas'),
    'krs-mbkm/laporan' => array('dosen','mahasiswa','admin','fakultas'),
    // route krs peternakan
	'krs-peternakan/index' => array('dosen','admin','fakultas'),
	'krs-peternakan/view' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-peternakan/add-krs' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-peternakan/approve' => array('admin','fakultas'),
	'krs-peternakan/disapprove' => array('admin','fakultas'),
	'krs-peternakan/krs-mhs' => array('admin','fakultas'),
	'krs-peternakan/delete' => array('dosen','mahasiswa','admin','fakultas'),
    'krs-peternakan/laporan' => array('dosen','mahasiswa','admin','fakultas'),
    //route konversi
    'krs-konversi/bayar' => array('admin','fakultas','mahasiswa'),
    'krs-konversi/index' => array('mahasiswa'),
    'krs-konversi/pilih-makul' => array('mahasiswa'),
	'krs-konversi/view' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-konversi/add-krs' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-konversi/approve' => array('admin','fakultas'),
	'krs-konversi/disapprove' => array('admin','fakultas'),
	'krs-konversi/krs-mhs' => array('admin','fakultas'),
	'krs-konversi/delete' => array('dosen','mahasiswa','admin','fakultas'),
    'krs-konversi/laporan' => array('dosen','mahasiswa','admin','fakultas'),
    //route kpt konversi
    'krs-kpt-konversi/bayar' => array('admin','fakultas','mahasiswa'),
    'krs-kpt-konversi/index' => array('dosen','admin','fakultas'),
	'krs-kpt-konversi/view' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-kpt-konversi/add-krs' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-kpt-konversi/approve' => array('admin','fakultas'),
	'krs-kpt-konversi/disapprove' => array('admin','fakultas'),
	'krs-kpt-konversi/krs-mhs' => array('admin','fakultas'),
	'krs-kpt-konversi/delete' => array('dosen','mahasiswa','admin','fakultas'),
    'krs-kpt-konversi/laporan' => array('dosen','mahasiswa','admin','fakultas'),
    //route kpt konversi
    'krs-kerjasama-konversi/bayar' => array('admin','fakultas','mahasiswa'),
    'krs-kerjasama-konversi/index' => array('dosen','admin','fakultas'),
	'krs-kerjasama-konversi/view' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-kerjasama-konversi/add-krs' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-kerjasama-konversi/approve' => array('admin','fakultas'),
	'krs-kerjasama-konversi/disapprove' => array('admin','fakultas'),
	'krs-kerjasama-konversi/krs-mhs' => array('admin','fakultas'),
	'krs-kerjasama-konversi/delete' => array('dosen','mahasiswa','admin','fakultas'),
    'krs-kerjasama-konversi/laporan' => array('dosen','mahasiswa','admin','fakultas'),
        //route kpt
    'krs-beasiswa/bayar' => array('admin','fakultas','mahasiswa'),
    'krs-beasiswa/index' => array('dosen','admin','fakultas'),
	'krs-beasiswa/view' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-beasiswa/add-krs' => array('dosen','mahasiswa','admin','fakultas'),
	'krs-beasiswa/approve' => array('admin','fakultas'),
	'krs-beasiswa/disapprove' => array('admin','fakultas'),
	'krs-beasiswa/krs-mhs' => array('admin','fakultas'),
	'krs-beasiswa/delete' => array('dosen','mahasiswa','admin','fakultas'),
    'krs-beasiswa/laporan' => array('dosen','mahasiswa','admin','fakultas'),
    // laporan krs
    'laporan_krs/index' => array('admin','fakultas'),
    // route khs
	'khs/index' => array('dosen','admin','fakultas'),
	'khs/view' => array('dosen','mahasiswa','admin','fakultas'),
	'khs/add' => array('dosen','mahasiswa','admin'),
	'khs/approve' => array('dosen','admin','fakultas'),
	'khs/delete' => array('dosen','mahasiswa','admin'),
    'khs/laporan' => array('dosen','mahasiswa','admin'),
    'khs_fakultas/index' => array('fakultas','admin'),
    
    //route chat
    'chat/index'=> array('dosen','mahasiswa','admin'),
    //route absensi
    'absensi/index' => array('dosen','admin'),
	// route matakuliah
	'matakuliah/index' => array('admin','fakultas'),
	'matakuliah/edit' => array('admin','fakultas'),
	'matakuliah/add' => array('admin','fakultas'),
	'matakuliah/delete' => array('admin','fakultas'),
	'matakuliah/add-dosen' => array('admin'),
	'matakuliah/delete-dosen' => array('admin'),
    // ROUTE PERPUS
    'perpustakaan/index'=> array('mahasiswa'),
    // route info
	'info/add' => array('admin','fakultas'),
	'info/view' => array('mahasiswa','admin'),
	// route persentas
	'persentase' => array('dosen'),
	// route Program studi
	'program-studi/index' => array('admin','fakultas'),
	'program-studi/edit' => array('admin','fakultas'),
	'program-studi/add' => array('admin','fakultas'),
	'program-studi/delete' => array('admin','fakultas'),
	// info
	'info/add' => array('admin','fakultas'),
	'info/view' => array('dosen','mahasiswa','admin','fakultas'),
	// route jadwal
	'jadwal/index' => array('admin','fakultas'),
	'jadwal/edit' => array('admin','fakultas'),
	'jadwal/delete()' => array('admin','fakultas'),
    // jadwal uas
    'jadwal_uas/index' => array('fakultas'),
    'jadwal_uas/edit' => array('fakultas'),
    'jadwal_uas/delete' => array('fakultas'),
    'jadwal_uas/cetak-presensi' => array('fakultas'),
    'jadwal_uas/view' => array('mahasiswa'),
	// route transkrip
	'transkrip/view' => array('dosen','mahasiswa','admin'),
	'transkrip/laporan' => array('dosen','mahasiswa','admin'),
	// route user
	'user/index' => array('admin'),
	'user/add' => array('admin'),
	'user/edit' => array('admin'),
	'user/delete' => array('admin'),
	'user/synchronize' => array('admin'),
	'user/change-password' => array('admin','dosen','mahasiswa','fakultas'),
	// route chat
	'chat' => array('admin','mahasiswa','dosen','fakultas'),
	// route absen dosen
	'absen_dosen/index' => array('fakultas','dosen','admin','yayasan'),
	'absen_dosen/absen' => array('fakultas','dosen','admin'),
	// presensi mahasiswa
	'presensi_mahasiswa/index' => array('fakultas','dosen','admin'),
	'presensi_mahasiswa/absensi' => array('fakultas','dosen','admin'),
	'presensi_mahasiswa/rekap_absen' => array('fakultas','dosen','admin'),
	'presensi_mahasiswa/cetak-gasal' => array('fakultas','dosen','admin'),
	'presensi_mahasiswa/cetak-genap' => array('fakultas','dosen','admin'),
	'presensi_mahasiswa/cetak-uts' => array('fakultas','dosen','admin'),
	'presensi_mahasiswa/cetak-uas' => array('fakultas','dosen','admin'),
	// route fakultas
	'fakultas/mahasiswa/index' => array('fakultas'),
	'fakultas/mahasiswa/add' => array('fakultas'),
	'fakultas/mahasiswa/view' => array('fakultas'),
	'fakultas/mahasiswa/edit' => array('fakultas'),
	'fakultas/mahasiswa/delete' => array('fakultas'),
	'fakultas/mahasiswa/wali' => array('fakultas'),
	'fakultas/mahasiswa/export-mahasiswa' => array('fakultas'),
	'fakultas/jadwal' => array('fakultas'),
	'fakultas/edit' => array('fakultas'),
	'fakultas/delete' => array('fakultas'),
	'fakultas/view-nilai' => array('fakultas'),
	'fakultas/cetak-nilai' => array('fakultas'),
	'fakultas/jadwal-uas' => array('fakultas'),
	'fakultas/list' => array('fakultas'),
	// route report
	'report/index' => array('admin','yayasan','keuangan'),
	'report/bulanan' => array('admin','yayasan','keuangan'),
	'report/konversi-bulanan' => array('admin','yayasan','keuangan'),
	'report/konversi' => array('admin','yayasan','keuangan'),
	'report/cetak-bulanan' => array('admin','yayasan','keuangan'),
	'report/cetak-konversi-bulanan' => array('admin','yayasan','keuangan'),
	'report/cetak' => array('admin','yayasan','keuangan'),
	'report/cetak/kpt' => array('admin','yayasan','keuangan','kpt'),
	//seting tagihan
	'tagihan/index' => array('admin','keuangan'),
	'tagihan/atur-tagihan' => array('admin','keuangan'),
	'tagihan/simpan' => array('admin','keuangan'),
	//transaksi BRI
	'transaksi/index' => array('mahasiswa','keuangan'),
	'transaksi/proses' => array('mahasiswa'),
	'transaksi/refresh' => array('mahasiswa'),
	'transaksi/invoice' => array('mahasiswa'),
	'transaksi/delete' => array('mahasiswa','keuangan'),
	'transaksi/invoice-pembayaran' => array('mahasiswa'),
	'transaksi/konfirmasi' => array('mahasiswa'),
	'transaksi/prarilis' => array('mahasiswa'),
	// cek tagihan
	'cek_tagihan/index' => array('admin','keuangan'),
	'cek_tagihan/briva' => array('admin','keuangan','fakultas'),
	'cek_tagihan/insert' => array('admin','keuangan'),
	'cek_tagihan/send-mail' => array('admin','keuangan'),
	'cek_tagihan/surat-bulanan' => array('admin','keuangan'),
	'cek_tagihan/surat' => array('admin','keuangan'),
	// route sign
	'sign/in' => array(''),
	'sign/out' => array('','mahasiswa','fakultas','dosen','admin','keuangan','kpt','yayasan'),
);

$_url = str_replace('/index.php', '/', $_SERVER['PHP_SELF']);
$_route = explode($_url, explode("?", $_SERVER['REQUEST_URI'])[0], 2)[1];
date_default_timezone_set('Asia/Jakarta');
?>
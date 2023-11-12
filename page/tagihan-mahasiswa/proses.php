
<?php
    $tgl_skrg       = date("Ymd");
    // $tgl_exp        = date('Ymd', strtotime('+6 days', strtotime($tgl_skrg)));
    $today          = date("Y-m-d");
    $tambah         = date('Y-m-d', strtotime('+6 days', strtotime($today)));
    $exp            = date("H:m:s");
    $today_id       = date("Ym");
    $sql            = "SELECT * FROM student_mahasiswa WHERE nim='$_username'";
    $x              = mysqli_query($koneksi, $sql);
    $view           = mysqli_fetch_array($x);
    $nim            = $view['nim'];
    $nama           = $view['nama'];
    $angkatan       = $view['angkatan_id'];
    $konsentrasi    = $view['konsentrasi_id'];
    $status         = $view['status_angsur'];
	$sql1           = "SELECT * FROM tagihan_mahasiswa WHERE id_tagihan='$_id'";
	$query1         = mysqli_query($koneksi, $sql1);
    $item = mysqli_fetch_array($query1);
    $jenis_bayar = $item['jenis_bayar'];
    
	// cari id transaksi terakhir yang berawalan tanggal hari ini
	$que = "SELECT max(custCode) as maxCode FROM proses_transaksi";
    $hasil = mysqli_query($koneksi,$que);
    $dt  = mysqli_fetch_array($hasil);
    $lastNoTransaksi = $dt['maxCode'];
	
	// baca nomor urut transaksi dari id transaksi terakhir 
	$lastNoUrut = (int)substr($lastNoTransaksi, 6, 4); 
	
	// nomor urut ditambah 1
    $nextNoUrut = $lastNoUrut + 1;
     
    // membuat format nomor transaksi berikutnya
    $nextNoTransaksi = $today_id.sprintf('%04s', $nextNoUrut);
?>
<h1>
<a href="<?= $_url ?>transaksi" class="nav-button transform"><span></span></a>
PROSES TAGIHAN-MU
</h1>

<?php
    $load       = mysqli_query($koneksi,"SELECT * FROM proses_transaksi WHERE nim='$_username' AND id_tagihan='$_id'");
    $cek        = mysqli_num_rows($load);
        if($cek > 0){
            echo "<script>window.alert('TRANSAKSI SUDAH ADA!')
		    window.location.href='{$_url}transaksi'</script>";
        }
?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
           <h3>Proses Tagihan</h3>
           <form Method="POST">
           <div class="table-responsive">
            <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <tr>
                   <td>Jenis Bayar</td><td>:</td><td>Pembayaran <b>
                <?php 
			    $select=mysqli_query($koneksi,"SELECT * FROM kode_tagihan WHERE kode_bayar='$jenis_bayar'");
			    $view = mysqli_fetch_array($select);
			    echo $view['keterangan']; ?> Semester <?= $item['semester']; ?></b></td>
                </tr>
                <tr>
                   <td>Nominal</td><td>:</td><td><?= rupiah($item['jumlah']); ?></td>
                </tr>
                <tr>
                <td>Jatuh Tempo</td><td>:</td><td><?= tgl_indo($item['batas_bayar']); ?></td>
                </tr>
            </table>
            <input type="hidden" name="nim" value="<?= $nim ?>" readonly>
            <input type="hidden" name="nama" value="<?= $nama ?>" readonly>
            <input type="hidden" name="brivaNo" value="77777" readonly>
            <input type="hidden" name="custCode" value="<?= $_username ?><?= $jenis_bayar ?>" readonly>
            <input type="hidden" name="id_tagihan" value="<?= $item['id_tagihan']; ?>" readonly>
            <input type="hidden" name="amount" value="<?= $item['jumlah']; ?>" readonly>
            <input type="hidden" name="keterangan" value="<?= $view['keterangan']; ?> Semester <?= $item['semester']; ?>" readonly>
            <input type="hidden" name="expiredDate" value="<?= $tambah ?> <?= $exp; ?>" readonly>
            <input type="hidden" name="tanggal_bayar" value="<?= $tgl_skrg; ?>" readonly>
            <input type="hidden" name="status" value="n" readonly>
            <!--
            
            -->
            <button type="submit" name="submit" class="button success">Proses</button>
           </div>
           </form>
        </div>
    </div>
</div>

<?php
	
if (isset($_POST['submit'])) {
$nim        	= $_POST['nim'];
$nama       	= $_POST['nama'];
$brivaNo   		= $_POST['brivaNo'];
$custCode		= $_POST['custCode'];
$id_tagihan 	= $_POST['id_tagihan'];
$expiredDate	= $_POST['expiredDate'];
$status			= $_POST['status'];
$tanggal_bayar	= $_POST['tanggal_bayar'];
$keterangan		= $_POST['keterangan'];
$amount 		= $_POST['amount'];

            $cmd = mysqli_query($koneksi,"SELECT * FROM proses_transaksi WHERE custCode='$custCode' AND del_endpoint='0'");
            $cek = mysqli_num_rows($cmd);
            if($cek > 0){   
            echo "<script>$.Notify({
    		    caption: 'Failed',
    		    content: 'CustCode Sudah Terpakai, Silahkan coba lagi!!',
    		    type: 'alert'
    		});
    		setTimeout(function(){ window.location.href='{$_url}tagihan-mahasiswa'; }, 2000);
    		</script>";
            }else{
        	$sql = "INSERT INTO proses_transaksi SET nim='$nim', nama='$nama',
        	brivaNo='$brivaNo',custCode='$custCode',id_tagihan='$id_tagihan',expiredDate='$expiredDate',status_bayar='$status',tanggal_bayar='$tanggal_bayar'";
        	$queque = mysqli_query($koneksi, $sql);
    
        	if ($queque) {
        		echo "<script>$.Notify({
        		    caption: 'Success',
        		    content: 'Data Transaksi Berhasil Ditambah',
            		type: 'success'
        		});
         		setTimeout(function(){ window.location.href='{$_url}tagihan-mahasiswa'; }, 2000);
        		</script>";
        	} else {
        		echo "<script>$.Notify({
        		    caption: 'Failed',
        		    content: 'Data Gagal Ditambah',
        		    type: 'alert'
        		});</script>";
        	}
        }
    }
?>
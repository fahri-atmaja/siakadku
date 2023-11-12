
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
		    window.location.href='{$_url}sandbox'</script>";
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
// $client_id = "4y0fz9VFU5LLAbJKRGgPXeMUhLaddYSX";
// $secret_id= "Ttama2OL82xpdvvY";

/* Generate Token */
function BRIVAgenerateToken($client_id, $secret_id) {
    $url ="https://sandbox.partner.api.bri.co.id/oauth/client_credential/accesstoken?grant_type=client_credentials";
    $data = "client_id=".$client_id."&client_secret=".$secret_id;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
    
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $json = json_decode($result, true);
    $accesstoken = $json['access_token'];

    return $accesstoken;
}

/* Generate signature */
function BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret) {
    $payloads = "path=$path&verb=$verb&token=Bearer $token&timestamp=$timestamp&body=$payload";
    $signPayload = hash_hmac('sha256', $payloads, $secret, true);
    return base64_encode($signPayload);
}


    $client_id = "hEXMUhwvUpHfZsEqXOBH1FrOlYq540nA";
    $secret_id= "4eq4F3RpePRLhk7c";
    $timestamp = gmdate("Y-m-d\TH:i:s.000\Z");
    $secret = $secret_id;
    $token = BRIVAgenerateToken($client_id, $secret_id);

    $institutionCode = "J104408";
    
    $datas = array(
        'institutionCode' => $institutionCode ,
        'brivaNo' => $brivaNo,
        'custCode' => $custCode,
        'nama' => $nama,
        'amount' => $amount,
        'keterangan' => $keterangan,
        'expiredDate' => $expiredDate
    );
    $payload = json_encode($datas, true);
    $path = "/v1/briva";
    $verb = "POST";
    $base64sign = BRIVAgenerateSignature($path, $verb, $token, $timestamp, $payload, $secret);

    $request_headers = array(
        "Content-Type:"."application/json",
        "Authorization:Bearer " . $token,
        "BRI-Timestamp:" . $timestamp,
        "BRI-Signature:" . $base64sign,
    );

    $urlPost ="https://sandbox.partner.api.bri.co.id/v1/briva";
    $chPost = curl_init();
    curl_setopt($chPost, CURLOPT_URL, $urlPost);
    curl_setopt($chPost, CURLOPT_HTTPHEADER, $request_headers);
    curl_setopt($chPost, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($chPost, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($chPost, CURLINFO_HEADER_OUT, true);
    curl_setopt($chPost, CURLOPT_RETURNTRANSFER, true);

    $resultPost = curl_exec($chPost);
    $httpCodePost = curl_getinfo($chPost, CURLINFO_HTTP_CODE);
    curl_close($chPost);

    // echo "Response Post : ".$resultPost;
    $json = json_decode($resultPost, true);
    // return json_decode($resultPost, true);


// BrivaUpdate($brivaNo, $custCode, $nama, $amount, $keterangan, $expiredDate);
// $result = file_get_contents($resultPost);
// $json = json_decode($result, true);
$error = $json['errDesc'];
$statusJSON = $json['status'];
// echo "ERROR ->". $error;
// echo "STATUS ->". $status;

if($statusJSON===false){
        echo "<script>
alert('$error');
exit();
</script>";
        }



// if (empty($brivaNo)){
//         echo "<script>$.Notify({
// 		    caption: 'Failed',
// 		    content: 'Briva No Tidak Boleh Kosong!!',
// 		    type: 'alert'
// 		});
// 		</script>";
//     }
//     elseif(empty($custCode)){
//         echo "<script>$.Notify({
// 		    caption: 'Failed',
// 		    content: 'Customer Code Tidak Boleh Kosong!!',
// 		    type: 'alert'
// 		});
// 		</script>";
        
//     }elseif(empty($institutionCode)){
//         echo "<script>$.Notify({
// 		    caption: 'Failed',
// 		    content: 'Institution code Tidak Boleh Kosong!!',
// 		    type: 'alert'
// 		});
// 		</script>";
//     }elseif($json[0]['status']=='false'){
//         echo "<script>$.Notify({
// 		    caption: 'Failed',
// 		    content: '$json[0]['errDesc']',
// 		    type: 'alert'
// 		});
// 		</script>";
//     }
    
    
    
        else{
            $cmd = mysqli_query($koneksi,"SELECT * FROM proses_transaksi WHERE custCode='$custCode' AND del_endpoint='0'");
            $cek = mysqli_num_rows($cmd);
            if($cek > 0){   
            echo "<script>$.Notify({
    		    caption: 'Failed',
    		    content: 'CustCode Sudah Terpakai, Silahkan coba lagi!!',
    		    type: 'alert'
    		});
    		setTimeout(function(){ window.location.href='{$_url}sandbox'; }, 2000);
    		</script>";
            }else{
        	$sql = "INSERT INTO proses_transaksi SET nim='$nim', nama='$nama',
        	brivaNo='$brivaNo',custCode='$custCode',id_tagihan='$id_tagihan',expiredDate='$expiredDate',status_bayar='$status',tanggal_bayar='$tanggal_bayar',amount='$amount'";
        	$queque = mysqli_query($koneksi, $sql);
    
        	if ($queque) {
        		echo "<script>$.Notify({
        		    caption: 'Success',
        		    content: 'Data Transaksi Berhasil Ditambah',
            		type: 'success'
        		});
         		setTimeout(function(){ window.location.href='{$_url}sandbox'; }, 2000);
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
}
?>
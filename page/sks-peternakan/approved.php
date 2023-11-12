<?php
$cekdulu = mysqli_num_rows(mysqli_query($koneksi,"SELECT * from bayar_sks_peternakan where biaya_id = '$_id' and status='1'"));
if ($cekdulu > 0){
		echo "<script>window.alert('MAAF MAHASISWA SUDAH BAYAR SILAHKAN CETAK BUKTI BAYAR')
    window.location.href='{$_url}keuangan_sks'</script>";
	}else{

date_default_timezone_set("Asia/Jakarta");
$tanggal = date('Y-m-d H:i:s');
$query = mysqli_query($koneksi, "UPDATE bayar_sks_peternakan SET status='1', tanggal_bayar='$tanggal' WHERE biaya_id='$_id'");
if ($query) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Pembayaran Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}sks-peternakan'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Pembayaran Gagal Ditambah',
		    type: 'alert'
		});
		setTimeout(function(){ window.location.href='{$_url}sks-peternakan'; }, 2000);
		</script>";
	}
}
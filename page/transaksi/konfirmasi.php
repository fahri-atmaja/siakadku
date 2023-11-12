<?php
$loadbpd = mysqli_query($koneksi,"SELECT * FROM bpd_jateng WHERE nim='$_username' AND kode_bayar='01' AND status='n'");
$view = mysqli_fetch_array($loadbpd);
?>
<h1>KONFIRMASI</h1>
<h3>Konfirmasi pembayaran SPI anda yang telah terbayar adalah <?= rupiah($view['jumlah_bayar']); ?> ?</h3>
<a href="<?= $_url ?>transaksi/konfirmasi/yes" class="button primary">Benar</a> <a href="<?= $_url ?>transaksi/konfirmasi/no" class="button danger">Tidak</a>

<?php

if ($_id == 'yes') {

        $update = mysqli_query($koneksi,"UPDATE bpd_jateng SET status='y' WHERE nim='$_username' AND kode_bayar='01' AND status='n'");
        if($update){
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data anda berhasi di update!',
			type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}transaksi'; }, 2000);
		</script>";
        }
} elseif ($_id == 'no') {
        $update = mysqli_query($koneksi,"UPDATE bpd_jateng SET status='x' WHERE nim='$_username' AND kode_bayar='01' AND status='n'");
        if($update){
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Silahkan Konfirmasi Ke BAUK!',
			type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}transaksi'; }, 2000);
		</script>";
        }
}
?>
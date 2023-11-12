<?php
// if ($_access!='admin'){
//     echo "<script>window.alert('MAAF HALAMAN TIDAK BISA DIAKSSES')
// 		    window.location.href='{$_url}'</script>";
// }
?>
<div class="container-fluid">
<div class="row">
    <div class="col-md-8">
        <h3>Tagihan Mahasiswa</h3>
        <a href="<?= $_url ?>daftar-tagihan/reguler"><label>1. Tagihan Mahasiswa Reguler</label></a><br>
        <a href="<?= $_url ?>daftar-tagihan/konversi"><label>2. Tagihan Mahasiswa Konversi</label></a><br>
        <a href="<?= $_url ?>daftar-tagihan/reguler-bulanan"><label>3. Tagihan Mahasiswa Reguler Bulanan</label></a><br>
        <a href="<?= $_url ?>daftar-tagihan/konversi-bulanan"><label>4. Tagihan Mahasiswa Konversi Bulanan</label></a>
    </div>
</div>
</div>
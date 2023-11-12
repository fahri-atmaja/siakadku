<div class="grid">
    <div class="container-fluid">
        <div class="row">
            <div class="form-group">
            <h3>Masukan Kode Verifikasi Email Anda!</h3>
            <form method="POST">
            <input name="kode" id="kode" value="">
            </div>
            <div class="form-group">
            <button type="submit" class="button primary">Verifikasi</button>
            </form>
            </div>
        </div>
    </div>
</div
<?php
if(isset($_POST['kode'])){
    $ass = mysqli_query($koneksi,"SELECT * FROM email_verifikasi WHERE nim='$_username'");
    if(mysqli_num_rows($ass) > 0){
        $real = mysqli_fetch_array($ass);
        $kode = $_POST['kode'];
        $code = $real['code'];
        if($kode===$code){
            $update = mysqli_query($koneksi,"UPDATE email_verifikasi SET status=1 WHERE nim='$_username'");
            if($update){
                echo "<script>$.Notify({
    		    caption: 'Success',
    		    content: 'Email Berhasil Diverifikasi',
        		type: 'success'
        		});
        		setTimeout(function(){ window.location.href='{$_url}'; }, 2000);
        		</script>";
            }else{
                echo "<script>$.Notify({
    		    caption: 'Failed',
    		    content: 'Email Gagal Diverifikasi',
    		    type: 'alert'
        		});</script>";
            }
        }else{
            echo "<script>window.alert('Kode Salah.. Silahkan Cek Inbox Email Anda..!')</script>";
        }
    }else{
        echo "<script>window.alert('Email anda belum terdaftar! Silahkan verifikasi email anda.')
		    window.location.href='{$_url}email'</script>";
    }
}
?>
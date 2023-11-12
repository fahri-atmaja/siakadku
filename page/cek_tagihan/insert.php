
<?php
$postnim = $_GET['nim'];
$postsemester = $_GET['semester'];
$jenis = $_GET['id_sks'];
$jmlsks = $_GET['jumlah_sks'];
$bayar_sks = $jmlsks*95000;
$cek = mysqli_query($koneksi,"SELECT * FROM bayar_sks WHERE nim='$postnim' AND semester='$postsemester'");
$row = mysqli_num_rows($cek);
if ($row > 0){
    echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Sudah Ada',
		    type: 'alert'
		});
		setTimeout(function(){ window.location.href='{$_url}cek_tagihan?nim=$postnim'; }, 2000);
		</script>";
}else{
$sqlsks 		 = "INSERT INTO bayar_sks SET nim='$postnim', semester='$postsemester', id_sks='$jenis', jumlah_sks='$jmlsks', jumlah_bayar='$bayar_sks'";
	$queque 	 = mysqli_query($koneksi, $sqlsks);
	if ($queque) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Bayar SKS Berhasil Ditambah',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}cek_tagihan?nim=$postnim'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Bayar SKS Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
}
?>
<style type="text/css">
.loader {
  border-top: 16px solid blue;
  border-right: 16px solid green;
  border-bottom: 16px solid red;
  border-left: 16px solid pink;
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<div class="loader"></div>
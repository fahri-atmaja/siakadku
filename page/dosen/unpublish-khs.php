<?php
// if ($_params[1] == 0)
// {
// 	echo "<script>window.alert('KRS Belum Disetujui')
//     window.location.href='{$_url}dosen/list'</script>";
// }elseif ($_params[1] == 1){
$query = mysqli_query($koneksi, "UPDATE akademik_khs SET confirm='2' WHERE krs_id='$_id'");
if($query)
{
	echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data KHS Berhasil di Unpublish',
    		type: 'success'
		});
		window.location=history.go(-1);
		</script>";
}
// }
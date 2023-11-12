<?php
$cek = mysqli_query($koneksi,"Select akademik_krs.*,akademik_khs.confirm, akademik_khs.kehadiran, akademik_khs.tugas, 
	        akademik_khs.praktik, akademik_khs.mutu, akademik_khs.mutu2, akademik_khs.nilai_akhir, 
	        akademik_khs.grade, student_mahasiswa.nama, akademik_konsentrasi.nama_konsentrasi FROM akademik_krs
			LEFT JOIN akademik_khs ON akademik_krs.krs_id=akademik_khs.krs_id
			LEFT JOIN student_mahasiswa ON student_mahasiswa.nim=akademik_krs.nim
			LEFT JOIN akademik_konsentrasi ON akademik_konsentrasi.konsentrasi_id=student_mahasiswa.konsentrasi_id
			WHERE akademik_krs.jadwal_id='$_id' 
			order by akademik_krs.nim asc");
?>
<form method="POST" target="#">
    <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">NIM</th>
      <th scope="col">NAMA</th>
      <th scope="col">NILAI AKHIR</th>
      <th scope="col">GRADE</th>
    </tr>
  </thead>
  <tbody>
<?php
if (mysqli_num_rows($cek) > 0):
			while($field = mysqli_fetch_array($cek)):
			    ?>
<?php
if ($field['accept']==0){
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'KRS mahasiswa ada yang belum disetujui!!',
		    type: 'alert'
		});
		window.location='{$_url}dosen/form-penilaian/$_id';
		</script>";
}
?>
    
    		<tr>
    			<td>
    				<input type="hidden" name="krs[]" value="<?= $field["krs_id"] ?>">
    			</td>
    			<td><?= $field['nim'] ?></td>
			    <td><?= $field['nama'] ?></td>
    			<td>
    			    <label><?= $field["nilai_akhir"] ?></label>
    			</td>
    			<td><?= $field['grade'] ?></td>
    		</tr>
    

<?php
endwhile;
		else:
		echo	"Data tidak ditemukan";
		endif;
?>

    	</tbody>
</table>
<div class="container">
    <div class="cold-md-6">
        <h2>Anda akan mempublish semua nilai??</h2>
<button type="submit" name="submit" class="button primary">Yaa</button>
</div></div>
</form>
<?php
if (isset($_POST['krs'])){
$krs = $_POST['krs'];
$jumlah_dipilih = count($krs);
 
for($x=0;$x<$jumlah_dipilih;$x++){
	 $query = mysqli_query($koneksi, "UPDATE akademik_khs SET confirm='1' WHERE krs_id=('$krs[$x]')");
 if($query)
 {
 	echo "<script>$.Notify({
 		    caption: 'Success',
 		    content: 'Data KHS Berhasil di publish',
     		type: 'success'
 		});
 		window.location='{$_url}dosen/form-penilaian/$_id';
 		</script>";
 }else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data KHS Gagal Ubah',
		    type: 'alert'
		});</script>";
	}
}
}
 ?>
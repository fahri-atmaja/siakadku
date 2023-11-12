<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 1px;
	}
</style>

<h1>
<a href="<?= $_url ?>tagihan" class="nav-button transform"><span></span></a>
Atur Tagihan
</h1>


<?php
$angkatan       = $_POST['angkatan_id'];
$konsentrasi	= $_POST['konsentrasi_id'];
$status			= $_POST['status'];

if (empty($angkatan)){
    echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Invalid',
		    type: 'alert'
		});
		setTimeout(function(){ window.location.href='{$_url}tagihan'; }, 2000);
		</script>";
}

$load_angkatan = mysqli_query($koneksi,"SELECT * FROM student_angkatan WHERE angkatan_id='$angkatan'");
$la = mysqli_fetch_array($load_angkatan);
$load_konsentrasi = mysqli_query($koneksi,"SELECT * FROM akademik_konsentrasi WHERE konsentrasi_id='$konsentrasi'");
$lk = mysqli_fetch_array($load_konsentrasi);
?>

<h3>Angkatan : <?= $la['keterangan']; ?></h3>
<h3>Konsentrasi : <?= $lk['nama_konsentrasi']; ?></h3>
<h3>Status : <?php 
if ($status==1){
    echo "Bulanan";
}else{
    echo "Standard";
}
?>
</h3>
  
  <form method="post" action="simpan">
    <!-- Buat tombol untuk menabah form data -->
    <button type="button" id="btn-tambah-form">Tambah Data Form</button>
    <button type="button" id="btn-reset-form">Reset Form</button><br><br>
    
    <b>Data ke 1 :</b>
    <input type="hidden" name="angkatan" value="<?= $angkatan ?>" readonly>
    <input type="hidden" name="konsentrasi" value="<?= $konsentrasi ?>" readonly>
    <input type="hidden" name="status" value="<?= $status ?>" readonly>
    <table>
      <tr>
        <td>Kode Pembayaran</td>
        <td><input type="text" name="jenis_bayar[]" required></td>
        <!--<td><select name="jenis_bayar[]" id="jenis_bayar" required></select></td>-->
      </tr>
      <tr>
        <td>Semester</td>
        <td><input type="number" name="semester[]" required></td>
      </tr>
      <tr>
        <td>Nominal</td>
        <td><input type="number" name="jumlah[]" required></td>
      </tr>
      <tr>
        <td>Jatuh Tempo</td>
        <td><input type="date" name="batas_bayar[]" required></td>
      </tr>
    </table>
    <br><br>
    <div id="insert-form"></div>
    
    <hr>
    <input type="submit" class="button primary" value="Simpan">
  </form>
  
  <!-- Kita buat textbox untuk menampung jumlah data form -->
  <input type="hidden" id="jumlah-form" value="1">

<?php
	$sql1 ="SELECT * FROM tagihan_mahasiswa 
	        WHERE angkatan_id='$angkatan' AND konsentrasi_id='$konsentrasi' AND status='$status' ORDER BY tagihan_mahasiswa.semester ASC";
	$query1 = mysqli_query($koneksi, $sql1);
	
?>
<div class="container"> 
<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Jenis Bayar</th>
			<th>Semester/Angsuran</th>
			<th>Nominal Biaya</th>
			<th>Jatuh Tempo</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>

	<?php
		$no=1;
		if (mysqli_num_rows($query1) > 0):
			while($field1 = mysqli_fetch_array($query1)):
	?>
		<tr>
			<td><?= $no++ ?></td>
			<td><?php $jenis = $field1['jenis_bayar'];
			          $load = mysqli_query($koneksi,"SELECT * FROM kode_tagihan WHERE kode_bayar='$jenis'");
			          $cek = mysqli_num_rows($load);
			          if($cek > 0){
			          $view = mysqli_fetch_array($load);
			          echo $view['keterangan'];
			          }else{
			          echo "Kode Tidak Terdaftar";
			          }
			     ?></td>
			     <td><?= $field1['semester'] ?></td>
			<td><?= rupiah($field1['jumlah']) ?></td>
			<td><?= tgl_indo($field1['batas_bayar']) ?></td>
			<td>
				<div class="inline-block">
				    <li><a href="<?= $_url ?>tagihan/list/<?= $field1['id_tagihan'] ?>"><span class="mif-list"></span> List</a></li>
				    <!--<li><a href="<?= $_url ?>tagihan/delete/<?= $field1['id_tagihan'] ?>"><span class="mif-cross"></span> Delete</a></li>-->
				  <!--  <button class="button mini-button dropdown-toggle">Aksi</button>-->
				  <!--  <ul class="split-content d-menu" data-role="dropdown">-->
						<!--<li><a href="<?= $_url ?>tagihan/delete/<?= $field1['id_tagihan'] ?>"><span class="mif-cross"></span> Delete</a></li>-->
						<!--<li><a href="<?= $_url ?>jadwal/edit/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-pencil"></span> Edit</a></li>-->
						<!--<li><a href="<?= $_url ?>dosen/list_absensi/<?= $field1['jadwal_id'] ?>/<?= urlencode($field1['nama_makul']) ?>"><span class="mif-pencil"></span> List Absen</a></li>-->
					
				</div>
			</td>
		</tr>
	<?php
			endwhile;
		else:
	?>
		<tr>
			<td colspan="4">
			Data tidak ditemukan
			</td>
		</tr>
	<?php
		endif;
	?>
		
	</tbody>
</table>
</div>

<!-- skrip form -->  
  <script>
  $(document).ready(function(){ // Ketika halaman sudah diload dan siap
    $("#btn-tambah-form").click(function(){ // Ketika tombol Tambah Data Form di klik
      var jumlah = parseInt($("#jumlah-form").val()); // Ambil jumlah data form pada textbox jumlah-form
      var nextform = jumlah + 1; // Tambah 1 untuk jumlah form nya
      
      // Kita akan menambahkan form dengan menggunakan append
      // pada sebuah tag div yg kita beri id insert-form
      $("#insert-form").append("<b>Data ke " + nextform + " :</b>" +
        "<table>" +
        "<tr>" +
        "<td>Kode Pembayaran</td>" +
        "<td><input type='text' name='jenis_bayar[]' required></td>" +
        "</tr>" +
        "<tr>" +
        "<td>Semester</td>" +
        "<td><input type='number' name='semester[]' required></td>" +
        "</tr>" +
        "<td>Nominal</td>" +
        "<td><input type='number' name='jumlah[]' required></td>" +
        "</tr>" +
        "<tr>" +
        "<td>Jatuh Tempo</td>" +
        "<td><input type='date' name='batas_bayar[]' required></td>" +
        "</tr>" +
        "</table>" +
        "<br><br>");
      
      $("#jumlah-form").val(nextform); // Ubah value textbox jumlah-form dengan variabel nextform
    });
    
    // Buat fungsi untuk mereset form ke semula
    $("#btn-reset-form").click(function(){
      $("#insert-form").html(""); // Kita kosongkan isi dari div insert-form
      $("#jumlah-form").val("1"); // Ubah kembali value jumlah form menjadi 1
    });
  });
  
//   $(document).ready(function(){
//       	$.ajax({
//             type: 'POST',
//           	url: "../select.php",
//           	cache: false, 
//           	success: function(msg){
//               $("#jenis_bayar").html(msg);
//             }
//         });
//      });
  </script>
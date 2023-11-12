<div class="container-fluid">
<h1><a href="<?= $_url ?>konversi_nilai" class="nav-button transform"><span></span></a>Input Nilai Konversi</h1>
<script src="../js/jquery-2.1.3.min.js" type="text/javascript"></script>

  <form method="post">
    <!-- Buat tombol untuk menabah form data -->
    <div class="form-group">
        <label>NIM</label><br>
        <select name="nim">
            <option value="">-- Pilih Mahasiswa --</option>
                        <?php
                        if($_access=='admin'){
                        $load =mysqli_query($koneksi,"SELECT * FROM student_mahasiswa WHERE id_sks=2 ORDER BY nim ASC");
                        while ($row= mysqli_fetch_array($load)) {
				        echo '<option name="jadwal_id" value="' . $row['nim'] . '">
				        NIM:' . $row['nim'] . '- Nama: ' . $row['nama'] . '</option>';
                        }
                        }elseif($_access=='fakultas'){
                        $kon = mysqli_query($koneksi,"SELECT * FROM akademik_konsentrasi WHERE nama_konsentrasi='$_username'");
                        $sentra = mysqli_fetch_array($kon);
                        $fakultas = $sentra['konsentrasi_id'];
                        $load = mysqli_query($koneksi,"SELECT * FROM student_mahasiswa WHERE id_sks=2 AND konsentrasi_id='$fakultas' ORDER BY nim ASC");
                        while ($row= mysqli_fetch_array($load)) {
				        echo '<option name="jadwal_id" value="' . $row['nim'] . '">
				        NIM:' . $row['nim'] . '- Nama: ' . $row['nama'] . '</option>';
                        }
                        }
                        ?>
        </select>
    </div>
    <button type="button" id="btn-tambah-form">Tambah Data Form</button>
    <button type="button" id="btn-reset-form">Reset Form</button><br><br>
    
    <b>Data ke 1 :</b>
    <table>
        <tr>
        <td>Kode Matakuliah</td>
        <td><input type="text" name="kode_mapel[]" required></td>
      </tr>
      <tr>
        <td>Matakuliah</td>
        <td><input type="text" name="mapel[]" required></td>
      </tr>
      <tr>
        <td>Mutu</td>
        <td><input type="number" name="na[]" step="0.01" required></td>
      </tr>
      <tr>
        <td>Bobot</td>
        <td><input type="number" name="bobot[]" step="0.01" required></td>
      </tr>
      <tr>
        <td>Grade</td>
        <td><input type="text" name="grade[]" required></td>
      </tr>
      <tr>
        <td>Sks</td>
        <td><input type="text" name="sks[]" required></td>
      </tr>
    </table>
    <br><br>
    <div id="insert-form"></div>
    
  <input type="hidden" name="jumlah" id="jumlah-form" value="1" readonly>
    <hr>
    <input type="submit" name="submit" class="button primary" value="Simpan">
  </form>
  
  <!-- Kita buat textbox untuk menampung jumlah data form -->
  </div>
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
        "<td>Kode Matakuliah</td>" +
        "<td><input type='text' name='kode_mapel[]' required></td>" +
        "</tr>" +
        "<tr>" +
        "<td>Matakuliah</td>" +
        "<td><input type='text' name='mapel[]' required></td>" +
        "</tr>" +
        "<tr>" +
        "<td>Mutu</td>" +
        "<td><input type='number' name='na[]' required></td>" +
        "</tr>" +
        "<tr>" +
        "<td>Bobot</td>" +
        "<td><input type='number' name='bobot[]' step='0.01' required></td>" +
        "</tr>" +
        "<tr>" +
        "<td>Grade</td>" +
        "<td><input type='text' name='grade[]' required></td>" +
        "</tr>" +
        "<td>Sks</td>" +
        "<td><input type='text' name='sks[]' required></td>" +
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
  </script>

  <?php
if (isset($_POST['submit'])) {
$nim = $_POST['nim'];
$jumlah = $_POST['jumlah'];
$kode_mapel = $_POST['kode_mapel'];
$mapel = $_POST['mapel'];
$na = $_POST['na']; 
$bobot = $_POST['bobot'];
$grade = $_POST['grade'];
$sks = $_POST['sks']; 
for($i=0;$i<$jumlah;$i++){
$sql = mysqli_query($koneksi,"INSERT INTO nilai_konversi(nim,kode_mapel,mapel,nilai,bobot,grade,sks) VALUES('$nim','$kode_mapel[$i]','$mapel[$i]','$na[$i]','$bobot[$i]','$grade[$i]','$sks[$i]')");
if($sql){
		header("location:index");
	} else {
		echo "<script>alert('Data gagal disimpan');</script>";
	}
}
}
?>
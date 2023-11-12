<?php
// proses perpus
$konperpus = mysqli_connect('localhost','smilefoo_und','m-U(77a;E#RH','smilefoo_slims');
// mengecek koneksi
// if (!$konperpus) {
//     die("Koneksi gagal: " . mysqli_connect_error());
// }
// echo "Koneksi berhasil";
// mysqli_close($konperpus);
if(isset($_POST['submit'])){
    $member_id = $_POST['member_id'];
    $member_name = $_POST['member_name'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $member_type_id = $_POST['member_type_id'];
    $member_address = $_POST['member_address'];
    $member_mail_address = $_POST['member_mail_address'];
    $member_email = $_POST['member_email'];
    $postal_code = $_POST['postal_code'];
    $inst_name = $_POST['inst_name'];
    $member_phone = $_POST['member_phone'];
    $member_since_date = $_POST['member_since_date'];
    $expire_date = $_POST['expire_date'];
    $is_pending = $_POST['is_pending'];
    $mpasswd = $_POST['mpasswd'];
    $input_date = $_POST['input_date'];
    $last_update = $_POST['last_update'];
    
        $insert = mysqli_query($konperpus,"INSERT INTO member (member_id, member_name, gender, birth_date, member_type_id, 
                member_address, member_mail_address, member_email, postal_code, inst_name, member_phone, member_since_date, expire_date,
                is_pending, mpasswd, input_date, last_update) VALUES ('$member_id', '$member_name', '$gender', '$birth_date', '$member_type_id', 
                '$member_address', '$member_mail_address', '$member_email', '$postal_code', '$inst_name', '$member_phone', '$member_since_date', '$expire_date',
                '$is_pending', '$mpasswd', '$input_date', '$last_update')");
        if ($insert) {
		echo "<script>$.Notify({
		    caption: 'Success',
		    content: 'Data Perpustakaan Sukses',
    		type: 'success'
		});
		setTimeout(function(){ window.location.href='{$_url}perpustakaan'; }, 2000);
		</script>";
	} else {
		echo "<script>$.Notify({
		    caption: 'Failed',
		    content: 'Data Gagal Ditambah',
		    type: 'alert'
		});</script>";
	}
    
}

// proses siakad
$loadmhs = mysqli_query($koneksi,"SELECT * FROM student_mahasiswa WHERE nim='$_username'");
$data = mysqli_fetch_array($loadmhs);
$tanggal = date('Y-m-d');
$tahun = date('Y');
$bulan = date('m-d');
$exp = $tahun + 4;
// echo $exp."-".$bulan;
?>
<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
PERPUSTAKAAN
</h1>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
            $load = mysqli_query($konperpus,"SELECT * FROM member WHERE member_id='$_username'");
            if(mysqli_num_rows($load) > 0){
                $view = mysqli_fetch_array($load);
            ?>
            <h3>Informasi Anggota Perpustakaan</h3>
            <hr>
            <table border='0'>
                <tr>
                    <td>ID Anggota</td><td>:&nbsp; &nbsp; </td><td><b><?= $view['member_id']; ?></b></td>
                </tr>
                <tr>
                    <td>Nama Member</td><td>: &nbsp; &nbsp; </td><td><b><?= $view['member_name']; ?></b></td>
                </tr>
                <tr>
                    <td>Kata Sandi Default</td><td>: &nbsp; &nbsp; </td><td><b>undaris2022</b></td>
                </tr>
            </table>
            <span>Silahkan ubah password anda dengan login ke <a href="https://perpustakaan.undaris.ac.id?p=member" target="_blank">SIM PERPUS</a></span>
            <hr>
            <h3>Informasi Peminjaman Buku Perpustakaan</h3>
            <hr>
            <?php
            $loan = mysqli_query($konperpus,"SELECT loan.item_code, loan.is_return, biblio.title FROM loan 
                                            LEFT JOIN item ON item.item_code=loan.item_code
                                            LEFT JOIN biblio ON biblio.biblio_id=item.biblio_id
                                            WHERE loan.member_id='$_username'");
            ?>
            <div class="table-responsive">
            <table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
              width="100%">
            	<thead>
                <tr>
                    <td>No.</td>
                    <td>Kode Eksemplar</td>
                    <td>Judul</td>
                    <td>Status</td>
                </tr>
                </thead>
                <tbody>
            <?php
            $no = 1;
            while($vi = mysqli_fetch_array($loan)){
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $vi['item_code']; ?></td>
                    <td><?= $vi['title']; ?></td>
                    <td><?php if($vi['is_return']!=1){ echo "<b>Belum Kembali</b>"; }else{ echo "<i>Sudah Kembali</i>"; } ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
            </table>
            </div>
            <?php
            }else{
                ?>
            <h3>DAFTAR ANGGOTA PERPUSTAKAAN</h3>
            <br>
            <label>Klik Daftar</label>
            <form method="POST">
            <input type="hidden" name="member_id" value="<?= $data['nim']; ?>">
            <input type="hidden" name="member_name" value="<?= $data['nama']; ?>">
            <input type="hidden" name="gender" value="<?= $data['gender']; ?>">
            <input type="hidden" name="birth_date" value="<?= $data['tanggal_lahir']; ?>">
            <input type="hidden" name="member_type_id" value="1">
            <input type="hidden" name="member_address" value="<?= $data['alamat']; ?>">
            <input type="hidden" name="member_mail_address" value="<?= $data['alamat']; ?>">
            <input type="hidden" name="member_email" value="<?= $data['email']; ?>">
            <input type="hidden" name="postal_code" value="0">
            <input type="hidden" name="inst_name" value="UPT PERPUSTAKAAN UNDARIS">
            <input type="hidden" name="member_phone" value="<?= $data['no_hp_ortu'] ?>">
            <input type="hidden" name="member_since_date" value="<?= $tanggal; ?>">
            <input type="hidden" name="member_register_date" value="<?= $tanggal; ?>">
            <input type="hidden" name="expire_date" value="<?= $exp.'-'.$bulan; ?>">
            <input type="hidden" name="is_pending" value="0">
            <input type="hidden" name="mpasswd" value="$2y$10$R.A1u2Jv5hj5iBi0/KYkqu8FhQyqKdGtRegSDW2Kwb4xBX0ldipeK">
            <input type="hidden" name="input_date" value="<?= $tanggal; ?>">
            <input type="hidden" name="last_update" value="<?= $tanggal; ?>">
            <button type="submit" name="submit" class="button success">DAFTAR SLIMS PERPUSTAKAAN UNDARIS</button>
            </form>
            <?php
            }
            ?>
        </div>
    </div>
</div>
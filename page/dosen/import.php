<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
	if ($_access == 'fakultas' && $_id != $_username) {
		header("location:{$_url}");
	}
	if ($_access == 'dosen' && $_id != $_username) {
		header("location:{$_url}");
	}
?>
<a href="<?= $_url ?>dosen" class="nav-button transform"><span></span></a>
Dosen
<br/><br/>

<form method="post" enctype="multipart/form-data" action="aksi_upload">
	Pilih File: 
	<input name="dosen" type="file" required="required"> 
	<br>
	<input name="upload" type="submit" value="Import">
</form>
 
<br/><br/>
 
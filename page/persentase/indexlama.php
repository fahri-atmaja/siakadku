<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>
<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 1px;
	}
</style>

<h1>
<a href="<?= $_url ?><?= in_array($_access, array('admin','dosen')) ? 'dashboard' : '' ?>" class="nav-button transform"><span></span></a>
Input Nilai
</h1>
<table class="table striped hovered border bordered">
<div class="row cells2">
<div class="cell">
	<?php 
		$load ="select * from setpersentase where nip='$_username'";
		$qqq = mysqli_query($koneksi,$load);
		$row = mysqli_fetch_array($qqq);
		$a = $row['kehadiran'];
		$b = $row['tugas'];
		$c = $row['uts'];
		$d = $row['uas'];
		$kehadiran = $a / 100;
		$tugas 	   = $b / 100;
		$uts 		= $c / 100;
		$uas 		= $d /100;

	?>
	<h2>PERSENTASE NILAI</h2>
	<br>
	<label>KEHADIRAN</label>
</div>
<div class="cell">
	<input type="form-control" name="kehadiran1" id="kehadiran1" value="<?php echo $kehadiran?>0" readonly>
</div>
<div class="cell">
	<label>TUGAS</label>
</div>
<div class="cell">
	<input type="form-control" name="tugas1" id="tugas1" value="<?php echo $tugas?>0" readonly>
</div>
<div class="cell">
	<label>UTS</label>
</div>
<div class="cell">
	<input type="form-control" name="uts1" id="uts1" value="<?php echo $uts?>0" readonly>
</div>
<div class="cell">
	<label>UAS</label>
</div>
<div class="cell">
	<input type="form-control" name="uas1" id="uas1" value="<?php echo $uas?>0" readonly>
</div>
<div class="cell">
	<a href="persentase/set-persentase"><button>Setting Persentase Awal</button></a>
	<a href="persentase/update-persentase"><button>Update Persentase</button></a>
</div>
</div>
</table>
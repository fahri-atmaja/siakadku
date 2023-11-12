<?php
	if ($_access == 'mahasiswa' && $_id != $_username) {
		header("location:{$_url}krs/view/{$_username}");
	}
?>

<style type="text/css">
	.input-control {
		border: 1px solid #d9d9d9;
		padding: 10px;
	}
</style>

<h1>
<a href="<?= $_url ?>" class="nav-button transform"><span></span></a>
INFO UMUM
</h1>
<?php 
function youtube($url){
	$link=str_replace('http://www.youtube.com/watch?v=', '', $url);
	$link=str_replace('https://www.youtube.com/watch?v=', '', $link);
	$data='<object width="600" height="300" data="http://www.youtube.com/v/'.$link.'" type="application/x-shockwave-flash">
	<param name="src" value="http://www.youtube.com/v/'.$link.'" />
	</object>';
	return $data;
}
 
?>
<center>
<?php
		echo youtube("https://www.youtube.com/watch?v=PXjtdzSeoh8");
?>
</center>
<?php
$sql = "SELECT * from akademik_info ORDER BY info_id DESC";
$query = mysqli_query($koneksi, $sql);
	$no=1;
?>

	<table class="table striped hovered border bordered">
	<thead>
		<tr>
			<th>JUDUL INFO</th>
			<th>ISI INFO</th>
			<th>TANGGAL INFO</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if (mysqli_num_rows($query) > 0):
			while($field = mysqli_fetch_array($query)):
	?>
		<tr>
				<td><?= $field['judul_info'] ?> </td>
				<td><?= $field['isi_info'] ?> </td>
				<td><?= $field['tanggal_info'] ?> </td>
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
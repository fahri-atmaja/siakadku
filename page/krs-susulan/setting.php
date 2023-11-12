<?php
$_id = $nim;
$tahun = mysqli_query($koneksi,"SELECT * FROM akademik_tahun_akademik");
?>
<form method="GET">
    <label>Pilih tahun akademik</label>
    <select name="tahun" value="" class="form-control">
        <?php
        while($array = mysqli_fetch_array($tahun)){
            echo "<option name='tahun' value='". $array[tahun_akademik_id] ."'>". $array[keterangan] ."</option>";
        }
        ?>
    </select>
    <label>Semester Susulan</label>
    <select name="semester" value="" class="form-control">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
    </select>
    <hr>
    <button type="submit" name="submit" class="form-control">Generate</button>
</form>
<?php
if($_GET['tahun']){
    $akademik = $_GET['tahun'];
    $sem = $_GET['semester'];
    ?>
<a href="<?= $_url ?>krs-susulan/add-krs?nim=<?= $_params[0] ?>&tahun=<?= $akademik ?>&sem=<?= $sem ?>"><button class="btn btn-primary">Lanjutkan</button></a>    
<?php    
}
?>
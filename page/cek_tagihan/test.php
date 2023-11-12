<?php
$test = mysqli_query($koneksi,"SELECT * FROM `angsuran_konversi_bayar` WHERE nim=19610011");

?>
<table border='1px'>
    <tr>
        <td>nim</td>
        <td>bayar</td>
        <td>angsuran</td>
        <td>tanggal</td>
    </tr>
    <?php while ($tam = mysqli_fetch_array($test)): ?>
    <tr>
        <td><?= $tam['nim'] ?></td>
        <td><?= $tam['bayar'] ?></td>
        <td><?= $tam['angsuran'] ?></td>
        <td><?= $tam['tanggal'] ?></td>
    </tr>
    <?php
    endwhile;
    ?>
</table>
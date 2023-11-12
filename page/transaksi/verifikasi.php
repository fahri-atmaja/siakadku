<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/4.0.3/sweetalert2.min.css">
  <link rel="stylesheet" type="text/css" href="app.css">
  <script src="https://cdn.jsdelivr.net/sweetalert2/4.0.3/sweetalert2.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.js"></script>
<div class="ui container">
<?php
$custCode = $_id;
$load = mysqli_query($koneksi,"SELECT * FROM proses_transaksi WHERE nim='$_username' AND custCode='$custCode'");
$view = mysqli_fetch_array($load);
if (empty($custCode)){
    echo "<script>window.alert('ERROR!')
		    window.location.href='{$_url}transaksi'</script>";
}
?>


    <div class="ui segment">

      <h2 class="ui header dividing">Informasi Virtual Account</h2>
      <div class="ui icon message">
        <i class="wait icon"></i>
          <div class="header">Pastikan anda mentransfer dana sebelum masa berlaku habis dan dengan nominal yang tepat</div>
      </div>

      <table class="ui collapsing table celled selectable teal">
        <tbody>
          <tr>
            <td><div class="ui ribbon label teal">Nomor Virtual Account</div></td>
            <td><?= $view['brivaNo']; ?><?= $view['custCode']; ?></td>
          </tr>
          <tr>
            <td><div class="ui ribbon label teal">Bank</div></td>
            <td>BRI</td>
          </tr>
          <tr>
            <td><div class="ui ribbon label teal">Nominal</div></td>
            <td><?= rupiah($view['amount']); ?></td>
          </tr>
          <tr>
            <td><div class="ui ribbon label teal">Nama Penerima</div></td>
            <td>BRIVA <?= $view['nama']; ?> </td>
          </tr>
          <!--<tr>-->
          <!--  <td><div class="ui ribbon label teal">Nomor Order</div></td>-->
          <!--  <td>Invoice-1234</td>-->
          <!--</tr>-->
          <tr>
            <td><div class="ui ribbon label teal">Masa Berlaku</div></td>
            <td>
                <?php 
                $tgl = substr($view['expiredDate'],0,10);
                $waktu = substr($view['expiredDate'],10);
                echo tgl_indo($tgl)." ".$waktu;
                ?>
            </td>
          </tr>
        </tbody>
      </table>
    <form method="POST" action="<?=$_url?>transaksi/refresh/<?= $view['custCode']; ?>">
        <td>Tanggal Bayar</td><td>:</td><td><input type="date" name="tanggal" value="" required></td>
        <hr>
        <td><button type="submit" name="refresh" class="btn btn-primary" id="submit">Refresh</button></td>
    </form>
    </div> <!-- .segment -->

  </div> <!-- .container -->
    <script type="text/javascript" src="<?= $_url ?>js/sweet.js"></script>

<textarea id="printing-css" style="display:none;">.no-print{display:none}</textarea>
<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
<script type="text/javascript">
function printDiv(elementId) {
 var a = document.getElementById('printing-css').value;
 var b = document.getElementById(elementId).innerHTML;
 window.frames["print_frame"].document.title = document.title;
 window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
 window.frames["print_frame"].window.focus();
 window.frames["print_frame"].window.print();
}
</script>

</body>
</html>
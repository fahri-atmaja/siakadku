
    <div class="ui buttons no-print">
      <button class="ui button" onclick="window.history.go(-1);"><i class="arrow left icon"></i> Back</button>
      <div class="or"></div>
      <a href="javascript:printDiv('cetak');"><button class="ui positive button"><i class="print icon"></i> Print</button></a>
    </div>
<div id="cetak">
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

      <h2 class="ui header dividing">Bayar Melalui</h2>
      <div class="ui three cards stackable">

        <div class="ui card">
          <div class="content">
            <div class="header ui dividing">ATM</div>
            <div class="meta">
              <div class="group">Panduan Bayar</div>
            </div>
            <div class="description">
              
              <div class="ui ordered list">
                <div class="item">Input kartu <div class="ui label">ATM</div> dan <div class="ui label">PIN</div> Anda</div>
                <div class="item">Pilih Menu <div class="ui label">Transaksi Lain</div></div>
                <div class="item">Pilih Menu <div class="ui label">Pembayaran</div></div>
                <div class="item">Pilih Menu <div class="ui label">Lain-lain</div></div>
                <div class="item">Pilih Menu <div class="ui label">BRIVA</div></div>
                <div class="item">Masukkan <div class="ui label">Nomor Virtual Account</div>, misal. <div class="ui label">88788XXXXXXXXXXX</div></div>
                <div class="item">Pilih <div class="ui label">Ya</div></div>
                <div class="item">Ambil <div class="ui label">bukti bayar</div> anda</div>
                <div class="item">Selesai</div>
              </div> <!-- .list -->

            </div> <!-- .description -->
          </div> <!-- .content -->
        </div> <!-- .card -->

        <div class="ui card">
          <div class="content">
            <div class="header ui dividing">Mobile Banking</div>
            <div class="meta">
              <div class="group">Panduan Bayar</div>
            </div>
            <div class="description">
              
              <div class="ui ordered list">
                <div class="item">Login <div class="ui label">BRI Mobile</div></div>
                <div class="item">Pilih <div class="ui label">Mobile Banking BRI</div></div>
                <div class="item">Pilih Menu <div class="ui label">Pembayaran</div></div>
                <div class="item">Pilih Menu <div class="ui label">BRIVA</div></div>
                <div class="item">Masukkan <div class="ui label">Nomor Virtual Account</div>, misal. <div class="ui label">88788XXXXXXXXXXX</div></div>
                <div class="item">Masukkan Nominal misal. <div class="ui label">10000</div></div>
                <div class="item">Klik <div class="ui label">Kirim</div></div>
                <div class="item">Masukkan <div class="ui label">PIN Mobile</div></div>
                <div class="item">Klik <div class="ui label">Kirim</div></div>
                <div class="item"><div class="ui label">Bukti bayar</div> akan dikirim melalui sms</div>
                <div class="item">Selesai</div>
              </div> <!-- .list -->

            </div> <!-- .description -->
          </div> <!-- .content -->
        </div> <!-- .card -->

        <div class="ui card">
          <div class="content">
            <div class="header ui dividing">Internet Banking</div>
            <div class="meta">
              <div class="group">Panduan Bayar</div>
            </div>
            <div class="description">
              
              <div class="ui ordered list">
                <div class="item">Login <div class="ui label">Internet Banking</div></div>
                <div class="item">Pilih <div class="ui label">Pembayaran</div></div>
                <div class="item">Pilih <div class="ui label">BRIVA</div></div>
                <div class="item">Masukkan <div class="ui label">Nomor Virtual Account</div>, misal. <div class="ui label">88788XXXXXXXXXXX</div></div>
                <div class="item">Klik <div class="ui label">Kirim</div></div>
                <div class="item">Masukkan <div class="ui label">Password</div></div>
                <div class="item">Masukkan <div class="ui label">mToken</div></div>
                <div class="item">Klik <div class="ui label">Kirim</div></div>
                <div class="item"><div class="ui label">Bukti bayar</div> akan ditampilkan</div>
                <div class="item">Selesai</div>
              </div> <!-- .list -->

            </div> <!-- .description -->
          </div> <!-- .content -->
        </div> <!-- .card -->

      </div> <!-- .stackable -->

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
</div>

</body>
</html>
<div class="page-tools">
            <div class="action-buttons">
                <a class="btn bg-white btn-light mx-1px text-95" href="javascript:printDiv('cetak');" data-title="Print">
                    <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                    Print
                </a>
                <!--<a class="btn bg-white btn-light mx-1px text-95" href="#" data-title="PDF">-->
                <!--    <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>-->
                <!--    Export-->
                <!--</a>-->
            </div>
        </div>

<?php
$load = mysqli_query($koneksi,"SELECT * FROM proses_transaksi WHERE id_bayar='$_id' AND nim='$_username'");
$view = mysqli_fetch_array($load);
$cek  = mysqli_num_rows($load);
if (empty($cek)){
    echo "<script>window.alert('ERROR!')
		    window.location.href='{$_url}transaksi'</script>";
}
$load2 = mysqli_query($koneksi,"SELECT * FROM student_mahasiswa WHERE nim='$_username'");
$view2 = mysqli_fetch_array($load2);

$tanggal = substr($view['tanggal_bayar'],6);
$bulan = substr($view['tanggal_bayar'],4,2);
$tahun = substr($view['tanggal_bayar'],0,4);
?>
<div id="cetak">
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<div class="page-content container">
    <div class="page-header text-blue-d2">
        <!--<h1 class="page-title text-secondary-d1">-->
        <!--    ID-->
        <!--    <small class="page-info">-->
        <!--        <i class="fa fa-angle-double-right text-80"></i>-->
        <!--        Virtual Account : <?= $view['brivaNo']?><?= $view['custCode']; ?>-->
        <!--    </small>-->
        <!--</h1>-->

        
    </div>

    <div class="container px-0">
        <div class="row mt-4">
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center text-150">
                            <img src="https://siakad.undaris.ac.id/assets/img/logo/logo.png" width="4%">
                            <span class="text-default-d3">UNDARIS</span>
                        </div>
                    </div>
                </div>
                <!-- .row -->

                <hr class="row brc-default-l1 mx-n1 mb-4" />

                <div class="row">
                    <div class="col-sm-6">
                        <div>
                            <span class="text-sm text-grey-m2 align-middle">To:</span>
                            <span class="text-600 text-110 text-blue align-middle"><?= $view['nama']; ?></span>
                        </div>
                        <div class="text-grey-m2">
                            <div class="my-1">
                                <?= $view2['alamat']; ?>
                            </div>
                            <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600"><?= $view2['no_hp_ortu']; ?></b></div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                        <hr class="d-sm-none" />
                        <div class="text-grey-m2">
                            <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                Invoice
                            </div>

                            <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Virtual Account:</span> <?= $view['brivaNo']?><?= $view['custCode']; ?></div>

                            <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Issue Date:</span><?= $tanggal ?>-<?= $bulan ?>-<?= $tahun ?></div>

                            <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Status:</span> <span class="badge badge-warning badge-pill px-25">PAID</span></div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
<?php

    $proses = mysqli_query($koneksi,"SELECT proses_transaksi.id_bayar, proses_transaksi.brivaNo, proses_transaksi.custCode, proses_transaksi.status_bayar, tagihan_mahasiswa.* FROM proses_transaksi
                                        LEFT JOIN tagihan_mahasiswa ON tagihan_mahasiswa.id_tagihan=proses_transaksi.id_tagihan
                                        WHERE nim='$_username' AND id_bayar='$_id' ORDER BY id_tagihan ASC");

?>
                <div class="mt-4">
                    <div class="row text-600 text-white bgc-default-tp1 py-25">
                        <div class="d-none d-sm-block col-1">#</div>
                        <div class="col-9 col-sm-5">Description</div>
                        <div class="col-2">Amount</div>
                    </div>
	<?php
		$no=1;
		if (mysqli_num_rows($proses) > 0):
			while($field = mysqli_fetch_array($proses)):
	?>
                    <div class="text-95 text-secondary-d3">
                        <div class="row mb-2 mb-sm-0 py-25">
                            <div class="d-none d-sm-block col-1"><?= $no++ ?></div>
                            <div class="col-9 col-sm-5">
                            <?php
                			    $jenis_bayar = $field['jenis_bayar'];
                			    $select=mysqli_query($koneksi,"SELECT * FROM kode_tagihan WHERE kode_bayar='$jenis_bayar'");
                			    $view = mysqli_fetch_array($select);
                			    echo $view['keterangan'];?>
            			    </div>
                            <div class="col-2 text-secondary-d2"><?= rupiah($field['jumlah']); ?></div>
                        </div>
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
                    <div class="row border-b-2 brc-default-l2"></div>

                    <!-- or use a table instead -->
                    <!--
            <div class="table-responsive">
                <table class="table table-striped table-borderless border-0 border-b-2 brc-default-l1">
                    <thead class="bg-none bgc-default-tp1">
                        <tr class="text-white">
                            <th class="opacity-2">#</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th width="140">Amount</th>
                        </tr>
                    </thead>

                    <tbody class="text-95 text-secondary-d3">
                        <tr></tr>
                        <tr>
                            <td>1</td>
                            <td>Domain registration</td>
                            <td>2</td>
                            <td class="text-95">$10</td>
                            <td class="text-secondary-d2">$20</td>
                        </tr> 
                    </tbody>
                </table>
            </div>
            -->

                    <!--<div class="row mt-3">-->
                    <!--    <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">-->
                    <!--        Extra note such as company or payment information...-->
                    <!--    </div>-->

                    <!--    <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">-->
                    <!--        <div class="row my-2">-->
                    <!--            <div class="col-7 text-right">-->
                    <!--                SubTotal-->
                    <!--            </div>-->
                    <!--            <div class="col-5">-->
                    <!--                <span class="text-120 text-secondary-d1">$2,250</span>-->
                    <!--            </div>-->
                    <!--        </div>-->

                    <!--        <div class="row my-2">-->
                    <!--            <div class="col-7 text-right">-->
                    <!--                Tax (10%)-->
                    <!--            </div>-->
                    <!--            <div class="col-5">-->
                    <!--                <span class="text-110 text-secondary-d1">$225</span>-->
                    <!--            </div>-->
                    <!--        </div>-->

                    <!--        <div class="row my-2 align-items-center bgc-primary-l3 p-2">-->
                    <!--            <div class="col-7 text-right">-->
                    <!--                Total Amount-->
                    <!--            </div>-->
                    <!--            <div class="col-5">-->
                    <!--                <span class="text-150 text-success-d3 opacity-2">$2,475</span>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->

                    <hr />

                        <div>
                            <span class="text-secondary-d1 text-105">Thank you for your business</span>
                            <!--<a href="#" class="btn btn-info btn-bold px-4 float-right mt-3 mt-lg-0">Pay Now</a>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
body{
    margin-top:20px;
    color: #484b51;
}
.text-secondary-d1 {
    color: #728299!important;
}
.page-header {
    margin: 0 0 1rem;
    padding-bottom: 1rem;
    padding-top: .5rem;
    border-bottom: 1px dotted #e2e2e2;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -ms-flex-align: center;
    align-items: center;
}
.page-title {
    padding: 0;
    margin: 0;
    font-size: 1.75rem;
    font-weight: 300;
}
.brc-default-l1 {
    border-color: #dce9f0!important;
}

.ml-n1, .mx-n1 {
    margin-left: -.25rem!important;
}
.mr-n1, .mx-n1 {
    margin-right: -.25rem!important;
}
.mb-4, .my-4 {
    margin-bottom: 1.5rem!important;
}

hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0,0,0,.1);
}

.text-grey-m2 {
    color: #888a8d!important;
}

.text-success-m2 {
    color: #86bd68!important;
}

.font-bolder, .text-600 {
    font-weight: 600!important;
}

.text-110 {
    font-size: 110%!important;
}
.text-blue {
    color: #478fcc!important;
}
.pb-25, .py-25 {
    padding-bottom: .75rem!important;
}

.pt-25, .py-25 {
    padding-top: .75rem!important;
}
.bgc-default-tp1 {
    background-color: rgba(121,169,197,.92)!important;
}
.bgc-default-l4, .bgc-h-default-l4:hover {
    background-color: #f3f8fa!important;
}
.page-header .page-tools {
    -ms-flex-item-align: end;
    align-self: flex-end;
}

.btn-light {
    color: #757984;
    background-color: #f5f6f9;
    border-color: #dddfe4;
}
.w-2 {
    width: 1rem;
}

.text-120 {
    font-size: 120%!important;
}
.text-primary-m1 {
    color: #4087d4!important;
}

.text-danger-m1 {
    color: #dd4949!important;
}
.text-blue-m2 {
    color: #68a3d5!important;
}
.text-150 {
    font-size: 150%!important;
}
.text-60 {
    font-size: 60%!important;
}
.text-grey-m1 {
    color: #7b7d81!important;
}
.align-bottom {
    vertical-align: bottom!important;
}

</style>
</div>
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
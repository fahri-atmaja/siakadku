
<div class="col-md-4 col-md-offset-4 col-sm-5 col-xs-12" text-align:center;"> 
	<div class="text-center">
             <img src="assets/img/logo/logo_awal.png" class="img" alt="logo siakad">
           </div>
    </div>
   
<div class="tile-area no-padding">
    <div class="tile-container ">

    <?php if ($_access == 'fakultas'): ?>
         <a href="<?= $_url ?>fakultas/mahasiswa">
        	<div class="tile-large bg-indigo fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-users"></span>
                    </div>
                    <span class="tile-label">MAHASISWA</span>
        	</div>
        </a>
        <a href="<?= $_url ?>fakultas/dosen">
        	<div class="tile-wide bg-lightRed fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-users"></span>
                    </div>
                    <span class="tile-label">DOSEN</span>
        	</div>
        </a>
        <!--
        <a href="<?= $_url ?>fakultas/dosen/add_dosen_junior">
        	<div class="tile bg-blue fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-users"></span>
                    </div>
                    <span class="tile-label">SET DOSEN JUNIOR</span>
        	</div>
        </a>
    -->
        <a href="<?= $_url ?>fakultas/matakuliah">
        	<div class="tile-wide bg-emerald fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">MATAKULIAH</span>
        	</div>
        </a>
        <a href="<?= $_url ?>krs">
        	<div class="tile-wide bg-yellow fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-calendar"></span>
                    </div>
                    <span class="tile-label">KRS MAHASISWA</span>
        	</div>
        </a>
        <a href="<?= $_url ?>user">
        	<div class="tile bg-magenta fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-users"></span>
                    </div>
                    <span class="tile-label">USERS</span>
        	</div>
        </a>
        <a href="<?= $_url ?>fakultas/jadwal">
        	<div class="tile-wide bg-lightBlue fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-calendar"></span>
                    </div>
                    <span class="tile-label">JADWAL</span>
        	</div>
        </a>
        <a href="<?= $_url ?>fakultas/info/add">
        	<div class="tile-wide bg-lime fg-white" data-role="tile">
        			<div class="tile-content iconic">
                    <span class="icon mif-books"></span>
                    </div>
                    <span class="tile-label">INFORMASI</span>
        	</div>
        </a>

<span class="icon mif-key"><button type="button" class="btn" onclick="openForm()">Open Chat</button></span>
<div class="form-popup" id="myForm"> 
 <div class="form-group" style="overflow-y: scroll; height:400px;">  

<!--	<style type="text/css">
 		table{
   overflow-y:scroll;
   height:100px;
   display:block;
}
 	</style> -->
	<table border="0" cellspacing="0" cellpadding="0" style="margin: 0; width: 100%;">
		
			<?php
			//*koneksi ke database*//
			$Open = mysql_connect("localhost","root","");
				if (!$Open){
					die ("MySQL E !<br>");
				}
			$Koneksi = mysql_select_db("akademik-php");
				if (!$Koneksi){
					die ("DBase E !");
				}
			$Tampil="SELECT * FROM chat ORDER BY waktu DESC LIMIT 99;";
			$query = mysql_query($Tampil);
			while (	$hasil = mysql_fetch_array ($query)) {
				$komen = stripslashes ($hasil['komen']);
				$waktu = stripslashes ($hasil['waktu']);
				$nama = stripslashes ($hasil['nama']);	
			?>	
			<style type="text/css">
				#atas {
					
					margin-top: 1px;
					margin-right: 1px;
					margin-bottom: 2px;
					margin-left: 0px;
					padding-bottom: 1px;
					color: #FFA500;
				}
				#pesan {
					padding-right: 1px;
					padding-left: 0px;
					margin-bottom: 2px;
					color: #080808;
					border-bottom-width: 1px;
					border-bottom-style: ridge;
					border-bottom-color: #CCC;
				}
				.waktu {
					float: right;
					color: #871214;
					font-family: Arial;
					font-size: 9px;
				}
			</style>
			<?php
			echo"
				<div id='atas'>$hasil[nama]<span class='waktu'>$hasil[waktu]</span></div>
				<div id='pesan'>$hasil[komen]</div>
			";
			}
			?>
		
	</table>  
<br>
</div>
<div class="form-group" style="background-color: white;">
	<form method="POST" name="chat" action="#" enctype="application/x-www-form-urlencoded"><p>Post your chat:</p><input type="hidden" placeholder=" Nama Anda" name="nama" 
		value="<?php echo $_name ?>" maxlength="20" style="width: 95%;"></input><br><br><p>Email</p><input type="text" placeholder=" Alamat email Anda" name="email" maxlength="30" style="width: 95%;"></input><br><br><p>Chat</p><textarea placeholder=" Obrolan Anda" name="komen" rows="2" cols="40" maxlength="120" style="width: 95%;"></textarea><br><br><input type="checkbox" name="cek" value="cek" class="art-button"> Confirm you are NOT a spammer</input><br><br><input class="btn cancel" type="submit" name="submit" value="Send" class="art-button"></input>&nbsp;<input type="reset" name="reset" value="Clear" class="art-button"></input><button type="button" onclick="closeForm()">Close</button>
	<?php
		if (isset($_POST['submit'])) {
		$nama	= $_POST['nama'];
		$email	= $_POST['email'];
		$komen	= $_POST['komen'];
		$waktu	= date ("Y-m-d, H:i a");
		$cek	= $_POST['cek'];
		if ($_POST['nama']=='Admin') { //validasi kata admin
	?>
		<script language="JavaScript">
			alert('Anda bukan Admin !');
				document.location='<?= $_url ?>';
		</script>
	<?php
		mysql_close($Open);
	}
		if (empty($_POST['nama'])|| empty($_POST['email']) || empty($_POST['komen'])) { //validasi data
	?>
		<script language="JavaScript">
			alert('Data yang Anda masukan tidak lengkap !');
				document.location='<?= $_url ?>';
			</script>
	<?php
	}
		if (empty($_POST['cek'])) { //validasi data
	?>
		<script language="JavaScript">
			alert('Please Checklist - Confirm you are NOT a spammer !');
				document.location='<?= $_url ?>';
		</script>
	<?php
	}
	else {
		$input_chat = "INSERT INTO chat (nama, email, komen, waktu, cek) VALUES ('$nama', '$email', '$komen', '$waktu', '$cek')";
		$query_input =mysql_query($input_chat);
		if ($query_input) {
	?>
		<script language="JavaScript">
			document.location='<?= $_url ?>';
			document.getElementById("myForm").style.display = "block";
			
		</script>
	<?php
	}
	else{
		echo'Dbase E';
	}
	}
	}
	mysql_close($Open);
	?>
	</form>
</div>
</div>

    <?php endif; ?>
    </div>
</div>


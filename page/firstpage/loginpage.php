<!DOCTYPE html>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>

  <meta name=”description” content="Sistem informasi akademik STIE PErtiba adalah suatu sistem yang dibangun untuk mengelola data-data akademik kampus sehingga memberikan kemudahan kepada mahasiswa, dosen, hingga administrasi akademik kampus secara online.">
  <style>
    body { height: auto; background-color: #ECF0F5; }
    .lockscreen-itme { padding: 10px; }
    .lockscreen-item a > img {
      border-radius: 10px; border:2.2px solid #cecece;
      margin-bottom: 15px;
    }
     a.btn-social { font-family: 'Arial Narrow'; }
    a.btn-social > i { color: #EBB906; border-color:white; }
/*     a.btn-social { background: #222A7B; color: white;  } */
    .box-warning { border-color: #444; }
    .lockscreen-footer { font-family: 'Arial'; font-size:12px; color:gray; }
    .box { background: <?php echo ($this->agent->is_mobile()) ? '#222A7B' : '#222A7B'; ?>; border-radius: 7px; border-color: ; }
  </style>
   <div class="container">
      <div class="row">
         <div class="col-md-4 col-md-offset-4 col-sm-5 col-xs-12" style="margin-top: 20%; text-align:center;">
           <div class="text-center">
             <img src="<?php echo base_url("assets/img/logo_login-2.png"); ?>" class="img" alt="logo siakad stie pertiba">
           </div>
            <div class="box" style="margin-top: 20px; border-color:#F8C301;">
               <div class="box-body">
                  <div class="col-md-12 col-xs-12">
                     <a href="../sign/in" class="btn btn-block btn-social btn-default btn-flat btn-lg">
                        <i class="ion ion-ios-people" style="font-size:27px;"></i> Mahasiswa
                     </a>
                     <a href="../sign_dosen/in" class="btn btn-block btn-social btn-default btn-flat btn-lg">
                        <i class="ion ion-person-stalker" style="font-size:24px;"></i> Dosen
                     </a>
                     <div class="" style="margin-top:5px;"></div>
                     <a href="../sign_admin/in" class="btn btn-block btn-social btn-default btn-flat btn-lg">
                        <i class="fa fa-university" style="font-size:22px;"></i> Bag.  Akademik
                     </a>  
                  </div>
               </div>
            </div>
            <div class="lockscreen-footer text-center">
               <small>Hak Cipta &copy; 2016 - <?php echo date('Y'); ?> <a href="">IT Division</a> STIE Pertiba Pangkalpinang. <br> All rights reserved.<small>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- /.container -->
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="assets/bootstrap/bootstrap.min.js"></script>


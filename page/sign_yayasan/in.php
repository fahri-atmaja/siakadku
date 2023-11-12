    <style>
        .login-form {
            width: 400px;
            height: 300px;
            top: 50%;
            left: 50%;
            margin-left: -200px;
            background-color: #ffffff;
            -webkit-transform: scale(.8);
            transform: scale(.8);
        }
    </style>
    <?php
    $username = '';
    $password = '';
    if (isset($_POST['submit'])) {
        extract($_POST);

        $sql = "SELECT * FROM user_yayasan WHERE username='{$username}' AND password=md5('{$password}')";

        $query = mysqli_query($koneksi, $sql);

        if (mysqli_num_rows($query) == 1) {
            $field = mysqli_fetch_array($query);
            $_SESSION['access'] = $field['status'];
            $_SESSION['username'] = $field['username'];
            $_SESSION['name'] = $field['nama'];
            echo "<script>$.Notify({
                caption: 'Login Success',
                content: 'Anda berhasil Login',
                type: 'success'
            });
            setTimeout(function(){ window.location.href='{$_url}'; }, 2000);
            </script>";
        } else {
            echo "<script>$.Notify({
                caption: 'Login Failed',
                content: 'Periksa Username dan Password anda!!',
                type: 'alert'
            });</script>";
        }
    }
    ?>
<div class="col-md-4 col-md-offset-4 col-sm-5 col-xs-12" text-align:center;">   
            <div class="text-center">
             <img src="../assets/img/logo/logo_awal.png" class="img" alt="logo siakad">
           </div>
           <br>
<!-- <div class="login-form padding20 block-shadow">
    
    <form method="post">
        <h1 class="text-light">Login</h1>
        <hr class="thin"/>
        <br />
        <div class="input-control text full-size" data-role="input">
            <label for="user_login">Username:</label>
            <input type="text" name="username" id="username" value="<?= $username ?>">
            <button class="button helper-button clear"><span class="mif-cross"></span></button>
        </div>
        <br />
        <br />
        <div class="input-control password full-size" data-role="input">
            <label for="user_password">Password:</label>
            <input type="password" name="password" id="password" value="<?= $password ?>">
            <button class="button helper-button reveal"><span class="mif-looks"></span></button>
        </div>
        <br />
        <br />
        <div class="form-actions">
            <button type="submit" name="submit" class="button primary">Login</button>
            <button type="button" class="button link">Cancel</button>
        </div>
    </form>
</div> -->
 <form method="post">
    <h1 class="text-dark">Login Pengurus Yayasan</h1>
        <hr class="thin"/>
        <br />
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Enter Username">
    <small id="emailHelp" class="form-text text-muted">isikan username anda</small>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
  </div>
  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  <button type="button" class="button link">Cancel</button>
 </form>
</div>
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
    if (isset($_POST['submit'])) {
        $username = addslashes($_POST['username']);
        $password = addslashes($_POST['password']);
        $sql = "SELECT * FROM app_users WHERE username='{$username}' AND password=md5('{$password}')";

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
<div class="col-md-4 col-md-offset-4 col-sm-5 col-xs-12">   
            <div class="text-center">
             <img src="../assets/img/logo/logo_awal.png" class="img" alt="logo siakad">
           </div>
           <br>
 <form method="post">
    <h1 class="text-dark">Login Admin Sistem</h1>
        <hr class="thin"/>
        <br />
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name="username" pattern="[a-zA-Z0-9!@#$%^*_|]{6,25}" onKeyDown="limitText(this,11);" 
onKeyUp="limitText(this,15);" aria-describedby="emailHelp" placeholder="Enter Username">
    <small id="emailHelp" class="form-text text-muted">isikan username anda</small>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password" pattern="[a-zA-Z0-9!@#$%^*_|]{6,25}" onKeyDown="limitText(this,15);" 
onKeyUp="limitText(this,15);">
  </div>
  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  <button type="button" class="button link">Cancel</button>
 </form>
</div>
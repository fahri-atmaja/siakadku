

    <!-- Metro 4 -->


    <div class="login-box">
        <form class="bg-white p-4"
              action="javascript:"
              data-role="validator"
              data-clear-invalid="2000"
              data-on-error-form="invalidForm"
        >
            <img src="https://siakad.undaris.ac.id/assets/img/undaris-min.png" class="place-right mt-4-minus mr-6-minus">
            <h1 class="mb-0">Login</h1>
            <div class="text-muted mb-4">Sign in to start your session</div>
            <div class="form-group">
                <a href="<?= $_url ?>sign/in"><button class="image-button w-100 mt-1 bg-cyan fg-white" type="button">
                    <span class="ion ion-ios-people"></span>
                    <span class="caption">Mahasiswa</span>
                </button></a>
                <a href="<?= $_url ?>sign_dosen/in"><button class="image-button w-100 mt-1 bg-emerald fg-white" type="button">
                    <span class="ion ion-person-stalker"></span>
                    <span class="caption">Dosen</span>
                </button></a>
                <a href="<?= $_url ?>sign_admin/in"><button class="image-button w-100 mt-1 bg-crimson fg-white" type="button">
                    <span class="fa fa-university"></span>
                    <span class="caption">Bag. Akademik</span>
                </button></a>
                <a href="<?= $_url ?>sign_fakultas/in"><button class="image-button w-100 mt-1 bg-blue fg-white" type="button">
                    <span class="ion-android-contacts"></span>
                    <span class="caption">Bag. Fakultas</span>
                </button></a>
            </div>
            <!--<div class="form-group border-top bd-default pt-2">-->
            <!--    <a href="#" class="d-block">If error, please contact support!</a>-->
            <!--    <a href="#" class="d-block">Click here.</a>-->
            <!--</div>-->
        </form>
    </div>


    <script src="vendors/jquery/jquery-3.4.1.min.js"></script>
    <script src="vendors/metro4/js/metro.min.js"></script>
    <script>
        function invalidForm(){
            var form  = $(this);
            form.addClass("ani-ring");
            setTimeout(function(){
                form.removeClass("ani-ring");
            }, 1000);
        }
    </script>
<?php 
session_start();

$heading = " Login"; 
$_SESSION['redirect_url'] = isset($_GET['redirect']) ? urldecode($_GET['redirect']) : '';
// echo $_SESSION['redirect_url'];
?>
<?php include 'views/components/header.php'; ?>
  <body>
    
   
   <!-- navbar component start -->
    <?php include 'views/components/navbar.php'; ?>
    <!-- navbar component end -->

  
    <section class="" style="margin-bottom: 10rem;">
      <div class="container py-5 ">
        <div class="row d-flex justify-content-center align-items-center" style="margin-top: 5rem;">
          <div class="col col-xl-10">
            <div class="card shadow rounded overflow-hidden" style="border-radius: 1rem; margin-top: 3rem;">
              <div class="row g-0">
                <div class="col-md-6 col-lg-5 d-none d-md-block bg-dark text-white">
                  <div class="content-left" style="padding: 3.5rem;">
                      <div class="mini-header" style="font-size: 20px;">Welcome to</div>
                      <div class="header" style="white-space: normal;" ><h1 style="font-weight: bold; color: #fff;"><?php echo $system_name; ?></h1></div>
                      <div class="line" style="padding: 1px; background-color: #fff; margin-top: 2rem; margin-bottom: 1rem; width: 5rem;"></div>
                      <div class="info">Discover Ideal Studio Rentals for Students Across Malaysia</div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                  <div class="card-body p-4 p-lg-5 text-black" style="padding: 6rem 7rem !important;">
    
                    <form action="<?php echo $base_url ?>/submit-login" method="post">
    
                      <!-- <div class="d-flex align-items-center mb-3 pb-1">
                        <img class="h1 fw-bold mb-0" src="img/logo.png" style="height: 10rem;">
                      </div> -->
    
                      <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Login to your account</h5>

                      <div class="form-outline" style="margin-bottom: 1rem;" data-mdb-input-init>
                          <input name="email" type="text" id="form12" class="form-control" style="height: 2.5rem;" required />
                          <label class="form-label" for="form12">Email</label>
                      </div>

                      <div class="form-outline" data-mdb-input-init>
                          <input type="password" name="password" id="form12" class="form-control" style="height: 2.5rem;" required />
                          <label class="form-label" for="form12">Password</label>
                      </div>

                      <p class="mb-5 pb-lg-2" style="color: #393f81; margin-bottom: 0 !important; margin-top: 3.5rem !important; display: flex; justify-content: center;">Click for register account <a href="<?php echo $base_url ?>/signup" style="color: blue; text-decoration: underline; padding-left: 0.5rem;">Register</a></p>

                      <div class="pt-1 mb-4">
                          <input style="border-radius: 30px !important; width: 100%;" class="btn btn-primary rounded-pill text-white btn-lg btn-block bg-dark" type="submit" value="Login" name="login"></input>
                      </div>
    
                      <!-- <a class="small text-muted" href="#!">Forgot password?</a> -->
                      
                    </form>
    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End your project here-->
    <?php include 'views/components/footer.php'; ?>

    <!-- MDB -->
    <script type="text/javascript" src="js/mdb.umd.min.js"></script>
    <!-- Custom scripts -->
    <script type="text/javascript"></script>
  </body>
</html>

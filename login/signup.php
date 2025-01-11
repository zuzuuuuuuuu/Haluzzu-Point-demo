<?php $heading = " Signup"; ?>

<?php include 'views/components/header.php'; ?>

<body>


  <!-- navbar component start -->
  <?php include 'views/components/navbar.php'; ?>
  <!-- navbar component end -->

  <section class="" style="background-color: #faf9fb; ">
    <div class="container py-5 ">
      <div class="row d-flex justify-content-center align-items-center" style="margin-top: 5rem;">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem; margin-top: 3rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block bg-dark text-white">
                <div class="content-left" style="padding: 3.5rem;">
                  <div class="mini-header" style="font-size: 18px;">Register for</div>
                  <div class="header">
                    <h1 style="font-weight: bold; color: #fff;"><?php echo $system_name; ?></h1>
                  </div>
                  <div class="line" style="padding: 1px; background-color: #fff; margin-top: 2rem; margin-bottom: 1rem; width: 5rem;"></div>
                  <div class="info">Discover Ideal Studio Rentals for Students Across Malaysia.</div>
                </div>
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black" style="padding: 6rem 7rem !important;">

                  <form method="post" action="<?php echo $base_url ?>/submit-register">

                    <div class=" align-items-center mb-3 pb-1" style="margin-bottom: 1.5rem !important;">
                      <!-- <i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i> -->
                      <span class="h1 fw-bold mb-0" style="">Register your account</span>
                      <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; font-size: 13px; margin-top: 1rem !important;">Please fill in all field</h5>
                    </div>

                    <div class="form-outline" style="margin-bottom: 1rem;" data-mdb-input-init>
                      <label class="form-label" for="form12">Name*</label>
                      <input name="name" type="text" id="form12" class="form-control" style="height: 2.5rem;" required />
                    </div>
                    <div class="form-outline" style="margin-bottom: 1rem;" data-mdb-input-init>
                      <label class="form-label" for="form12">Phone*</label>
                      <input name="phone" type="text" id="form12" class="form-control" style="height: 2.5rem;" required />
                    </div>
                    <div class="form-outline" style="margin-bottom: 1rem;" data-mdb-input-init>
                      <label class="form-label" for="form12">Student Number*</label>
                      <input name="student_no" type="text" id="form12" class="form-control" style="height: 2.5rem;" required />
                    </div>
                    <div class="form-outline" style="margin-bottom: 1rem;" data-mdb-input-init>
                      <label class="form-label" for="form12">Campus*</label>
                      <input name="campus" type="text" id="form12" class="form-control" style="height: 2.5rem;" required />
                    </div>
                    <div class="form-outline" style="margin-bottom: 1rem;">
                      <label class="form-label" for="state">State*</label>
                      <select name="state" id="state" class="form-control" style="height: 2.5rem;" required>
                        <option value="" disabled selected>Select your state</option>
                        <option value="Johor">Johor</option>
                        <option value="Kedah">Kedah</option>
                        <option value="Kelantan">Kelantan</option>
                        <option value="Melaka">Melaka</option>
                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                        <option value="Pahang">Pahang</option>
                        <option value="Penang">Penang</option>
                        <option value="Perak">Perak</option>
                        <option value="Perlis">Perlis</option>
                        <option value="Sabah">Sabah</option>
                        <option value="Sarawak">Sarawak</option>
                        <option value="Selangor">Selangor</option>
                        <option value="Terengganu">Terengganu</option>
                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                        <option value="Labuan">Labuan</option>
                        <option value="Putrajaya">Putrajaya</option>
                      </select>
                    </div>
                    <div class="form-outline" style="margin-bottom: 1rem;" data-mdb-input-init>
                      <label class="form-label" for="form12">Email*</label>
                      <input name="email" type="gmail" id="form12" class="form-control" style="height: 2.5rem;" required />
                    </div>
                    <div class="form-outline" data-mdb-input-init>
                      <label class="form-label" for="form12">Password*</label>
                      <input name="password" type="password" id="form12" class="form-control" style="height: 2.5rem;" required />
                    </div>

                    <p class="mb-5 pb-lg-2" style="color: #393f81; margin-bottom: 0 !important; margin-top: 3.5rem !important; display: flex; justify-content: center;">Already have a account? <a href="<?php echo $base_url ?>/log-in" style="color: blue; text-decoration: underline; padding-left: 0.5rem;">Login here</a></p>

                    <div class="pt-1 mb-4">
                      <input style="border-radius: 30px !important; width: 100%;" class="btn btn-primary rounded-pill text-white btn-lg btn-block bg-dark" type="submit" value="Signup" name="signup"></input>
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
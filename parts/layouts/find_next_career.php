<?php get_header(); ?>


<section class="careers-section py-5">
  <div class="container-fluid">
    <div class="row">

      <!-- LEFT SIDEBAR -->
      <div class="col-lg-3 col-md-4 mb-4">
        <h1 class="font-medium fw-bold mb-2 pb-1">Find the next career</h1>
        <div class="left-search-col bg-light-blue-100 p-3 px-xl-4 py-xl-5 rounded">


          <!-- Search Box -->
          <div class="search-box p-3">
            <label class="form-label fw-semibold heading pb-2">Search Careers</label>
            <div class="input-group gap-3">
              <input type="text" class="form-control" placeholder="Nurse, Server, etc">
              <button class="btn btn-primary search-btn">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
            </div>
          </div>
          <div class="or-divider">OR</div>

          <!-- Filters -->
          <div class="filters p-3">
            <h6 class="fw-bold mb-3 heading">Filter Careers<img src="<?php echo get_template_directory_uri(); ?>/assets/images/filter.svg" class="ps-2" alt="filter-icon">
</h6>

            <p class="filter-title mb-2 fw-semibold">Company Location</p>
            <div class="form-check py-3 d-flex align-items-center"><input class="form-check-input me-2" type="checkbox" id="Allentown"><label class="form-check-label">Allentown</label></div>
            <div class="form-check py-3 d-flex align-items-center"><input class="form-check-input me-2" type="checkbox"><label class="form-check-label">Bethlehem</label></div>
            <div class="form-check py-3 d-flex align-items-center"><input class="form-check-input me-2" type="checkbox"><label class="form-check-label">Forks of Easton</label></div>
            <div class="form-check py-3 d-flex align-items-center"><input class="form-check-input me-2" type="checkbox"><label class="form-check-label">Frederick</label></div>
            <div class="form-check py-3 d-flex align-items-center"><input class="form-check-input me-2" type="checkbox"><label class="form-check-label">Hershey</label></div>
            <div class="form-check py-3 d-flex align-items-center"><input class="form-check-input me-2" type="checkbox"><label class="form-check-label">Mechanicsburg</label></div>
            <div class="form-check py-3 d-flex align-items-center"><input class="form-check-input me-2" type="checkbox"><label class="form-check-label">Wyomissing</label></div>
            <div class="form-check py-3 d-flex align-items-center"><input class="form-check-input me-2" type="checkbox"><label class="form-check-label">York-South</label></div>
            <div class="form-check py-3 d-flex align-items-center"><input class="form-check-input me-2" type="checkbox"><label class="form-check-label">York-West</label></div>


            <p class="filter-title mb-2 fw-semibold">Job Category</p>
            <div class="form-check py-3 d-flex align-items-center"><input class="form-check-input me-2" type="checkbox"><label class="form-check-label">Dining</label></div>
            <div class="form-check py-3 d-flex align-items-center"><input class="form-check-input me-2" type="checkbox"><label class="form-check-label">Personal Care</label></div>
            <div class="form-check py-3 d-flex align-items-center"><input class="form-check-input me-2" type="checkbox"><label class="form-check-label">Admin Nursing</label></div>
            <div class="form-check py-3 d-flex align-items-center"><input class="form-check-input me-2" type="checkbox"><label class="form-check-label">Housekeeping</label></div>
            <div class="form-check py-3 d-flex align-items-center"><input class="form-check-input me-2" type="checkbox"><label class="form-check-label">Comm Life - Dynam Living</label></div>
          </div>

          <a class="text-blue">Load All career Categories</a>


        </div>

        <!-- <div> -->
        <div class="career-alert-box rounded mt-4">
          <h6 class="fw-semibold mb-1 text-capitalize">Country Meadows career Alerts</h6>
          <p class="mb-3">Receive career alerts in your inbox!</p>
          <button class="btn subscribe-btn d-flex align-items-center gap-2 fw-bold text-capitalize">
            Subscribe
            <i class="fa-regular fa-envelope"></i>
          </button>
        </div>


        <!-- </div> -->
      </div>

      <!-- RIGHT CONTENT -->
      <div class="col-lg-9 col-md-8">

        <div class="row g-4">

          <!-- career Card -->
          <div class="col-lg-4 col-md-6">
            <div class="career-card  bg-white p-4 h-100 rounded ">
              <a href="" class="text-pink">
                <h5 class="career-title text-pink fw-bold mb-2">Server</h5>
              </a>

              <div class="d-flex align-items-center gap-2 text-muted mb-2">
                <i class="fa-regular fa-clock text-purple"></i>
                <h6 class="mb-0 fw-normal">Part Time</h6>
                <i class="fa-regular fa-location-dot ms-2 text-purple"></i>
                <h6 class="mb-0 fw-normal"> Hershey</h6>
              </div>

              <h6 class="posted-date mb-0 fw-normal text-light-gray">Posted on October 16, 2025</h6>
              <hr>

              <p class="career-description">
                Pay starts at $14.00/hour, with the opportunity to earn more based on experience.
                A Server plays a key role in our residents’ dining experience.
              </p>

              <a href="#" class="view-more fw-medium">View More</a>
            </div>
          </div>
           <div class="col-lg-4 col-md-6">
            <div class="career-card  bg-white p-4 h-100 rounded">
              <a href="" class="text-pink">
                <h5 class="career-title text-pink fw-bold">Server</h5>
              </a>

              <div class="d-flex align-items-center gap-2 text-muted mb-2">
                <i class="fa-regular fa-clock text-purple"></i>
                <h6 class="mb-0 fw-normal">Part Time</h6>
                <i class="fa-regular fa-location-dot ms-2 text-purple"></i>
                <h6 class="mb-0 fw-normal"> Hershey</h6>
              </div>

              <h6 class="posted-date mb-0 fw-normal text-light-gray">Posted on October 16, 2025</h6>
              <hr>

              <p class="career-description">
                Pay starts at $14.00/hour, with the opportunity to earn more based on experience.
                A Server plays a key role in our residents’ dining experience.
              </p>

              <a href="#" class="view-more fw-medium">View More</a>
            </div>
          </div>
           <div class="col-lg-4 col-md-6">
            <div class="career-card  bg-white p-4 h-100 rounded">
              <a href="" class="text-pink">
                <h5 class="career-title text-pink fw-bold">Server</h5>
              </a>

              <div class="d-flex align-items-center gap-2 text-muted mb-2">
                <i class="fa-regular fa-clock text-purple"></i>
                <h6 class="mb-0 fw-normal">Part Time</h6>
                <i class="fa-regular fa-location-dot ms-2 text-purple"></i>
                <h6 class="mb-0 fw-normal"> Hershey</h6>
              </div>

              <h6 class="posted-date mb-0 fw-normal text-light-gray">Posted on October 16, 2025</h6>
              <hr>

              <p class="career-description">
                Pay starts at $14.00/hour, with the opportunity to earn more based on experience.
                A Server plays a key role in our residents’ dining experience.
              </p>

              <a href="#" class="view-more fw-medium">View More</a>
            </div>
          </div>
           <div class="col-lg-4 col-md-6">
            <div class="career-card  bg-white p-4 h-100 rounded">
              <a href="" class="text-pink">
                <h5 class="career-title text-pink fw-bold">Server</h5>
              </a>

              <div class="d-flex align-items-center gap-2 text-muted mb-2">
                <i class="fa-regular fa-clock text-purple"></i>
                <h6 class="mb-0 fw-normal">Part Time</h6>
                <i class="fa-regular fa-location-dot ms-2 text-purple"></i>
                <h6 class="mb-0 fw-normal"> Hershey</h6>
              </div>

              <h6 class="posted-date mb-0 fw-normal text-light-gray">Posted on October 16, 2025</h6>
              <hr>

              <p class="career-description">
                Pay starts at $14.00/hour, with the opportunity to earn more based on experience.
                A Server plays a key role in our residents’ dining experience.
              </p>

              <a href="#" class="view-more fw-medium">View More</a>
            </div>
          </div>
           <div class="col-lg-4 col-md-6">
            <div class="career-card  bg-white p-4 h-100 rounded">
              <a href="" class="text-pink">
                <h5 class="career-title text-pink fw-bold">Server</h5>
              </a>

              <div class="d-flex align-items-center gap-2 text-muted mb-2">
                <i class="fa-regular fa-clock text-purple"></i>
                <h6 class="mb-0 fw-normal">Part Time</h6>
                <i class="fa-regular fa-location-dot ms-2 text-purple"></i>
                <h6 class="mb-0 fw-normal"> Hershey</h6>
              </div>

              <h6 class="posted-date mb-0 fw-normal text-light-gray">Posted on October 16, 2025</h6>
              <hr>

              <p class="career-description">
                Pay starts at $14.00/hour, with the opportunity to earn more based on experience.
                A Server plays a key role in our residents’ dining experience.
              </p>

              <a href="#" class="view-more fw-medium">View More</a>
            </div>
          </div>

           <div class="col-lg-4 col-md-6">
            <div class="career-card  bg-white p-4 h-100 rounded">
              <a href="" class="text-pink">
                <h5 class="career-title text-pink fw-bold">Server</h5>
              </a>

              <div class="d-flex align-items-center gap-2 text-muted mb-2">
                <i class="fa-regular fa-clock text-purple"></i>
                <h6 class="mb-0 fw-normal">Part Time</h6>
                <i class="fa-regular fa-location-dot ms-2 text-purple"></i>
                <h6 class="mb-0 fw-normal"> Hershey</h6>
              </div>

              <h6 class="posted-date mb-0 fw-normal text-light-gray">Posted on October 16, 2025</h6>
              <hr>

              <p class="career-description">
                Pay starts at $14.00/hour, with the opportunity to earn more based on experience.
                A Server plays a key role in our residents’ dining experience.
              </p>

              <a href="#" class="view-more fw-medium">View More</a>
            </div>
          </div>

           <div class="col-lg-4 col-md-6">
            <div class="career-card  bg-white p-4 h-100 rounded">
              <a href="" class="text-pink">
                <h5 class="career-title text-pink fw-bold">Server</h5>
              </a>

              <div class="d-flex align-items-center gap-2 text-muted mb-2">
                <i class="fa-regular fa-clock text-purple"></i>
                <h6 class="mb-0 fw-normal">Part Time</h6>
                <i class="fa-regular fa-location-dot ms-2 text-purple"></i>
                <h6 class="mb-0 fw-normal"> Hershey</h6>
              </div>

              <h6 class="posted-date mb-0 fw-normal text-light-gray">Posted on October 16, 2025</h6>
              <hr>

              <p class="career-description">
                Pay starts at $14.00/hour, with the opportunity to earn more based on experience.
                A Server plays a key role in our residents’ dining experience.
              </p>

              <a href="#" class="view-more fw-medium">View More</a>
            </div>
          </div>

           <div class="col-lg-4 col-md-6">
            <div class="career-card  bg-white p-4 h-100 rounded">
              <a href="" class="text-pink">
                <h5 class="career-title text-pink fw-bold">Server</h5>
              </a>

              <div class="d-flex align-items-center gap-2 text-muted mb-2">
                <i class="fa-regular fa-clock text-purple"></i>
                <h6 class="mb-0 fw-normal">Part Time</h6>
                <i class="fa-regular fa-location-dot ms-2 text-purple"></i>
                <h6 class="mb-0 fw-normal"> Hershey</h6>
              </div>

              <h6 class="posted-date mb-0 fw-normal text-light-gray">Posted on October 16, 2025</h6>
              <hr>

              <p class="career-description">
                Pay starts at $14.00/hour, with the opportunity to earn more based on experience.
                A Server plays a key role in our residents’ dining experience.
              </p>

              <a href="#" class="view-more fw-medium">View More</a>
            </div>
          </div>

           <div class="col-lg-4 col-md-6">
            <div class="career-card  bg-white p-4 h-100 rounded">
              <a href="" class="text-pink">
                <h5 class="career-title text-pink fw-bold">Server</h5>
              </a>

              <div class="d-flex align-items-center gap-2 text-muted mb-2">
                <i class="fa-regular fa-clock text-purple"></i>
                <h6 class="mb-0 fw-normal">Part Time</h6>
                <i class="fa-regular fa-location-dot ms-2 text-purple"></i>
                <h6 class="mb-0 fw-normal"> Hershey</h6>
              </div>

              <h6 class="posted-date mb-0 fw-normal text-light-gray">Posted on October 16, 2025</h6>
              <hr>

              <p class="career-description">
                Pay starts at $14.00/hour, with the opportunity to earn more based on experience.
                A Server plays a key role in our residents’ dining experience.
              </p>

              <a href="#" class="view-more fw-medium">View More</a>
            </div>
          </div>

         
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper text-center mt-5 bg-light-gray-100">
           <ul class="pagination justify-content-center gap-4  mb-0">
              <li class="page-item active text-decoration-none"><a class="page-link" href="#">1</a></li>
              <li class="page-item text-decoration-none"><a href="#" class="text-decoration-none">2</a></li>
              <li class="page-item text-decoration-none"><a href="#" class="text-decoration-none">3</a></li>
            </ul>
        </div>

      </div>

    </div>
  </div>
</section>
















<?php get_footer(); ?>
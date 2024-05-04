<?php
require_once('../layouts/header.php');
?>
<!-- Content -->
<style>
    /* Custom styles for the bordered image */
    .custom-border {
      border: 3px solid gray; /* Set the border width and color */
      
    }
  </style>

<div class=" flex-grow-1 ">
<div class="card-body pb-0 px-0 px-md-4">
              <h3 class="card-title text-primary">Welcome <?= $username ?>!<img data-v-2495b3ee="" srcset="https://img.icons8.com/?size=80&amp;id=XhCDqjapCbBj&amp;format=png 1x, https://img.icons8.com/?size=160&amp;id=XhCDqjapCbBj&amp;format=png 2x" width="35" height="35" alt="Bouquet icon"></h3>
              <!-- <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a> -->
              
            </div>
            <img src="<?= asset('assets/img/avatars/13.png') ?>" width="1500" height="1500" alt="library image" class="img-fluid custom-border">
              </div>

            

        
    
    
    <!-- <div class="col-lg-4 col-md-4 order-1">
      <div class="row">
        <div class="col-lg-6 col-md-12 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="<?= asset('assets/img/icons/unicons/chart-success.png') ?>" alt="chart success" class="rounded" />
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                  </div>
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Profit</span>
              <h3 class="card-title mb-2">$12,628</h3>
              <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="card-title d-flex align-items-start justify-content-between">
                <div class="avatar flex-shrink-0">
                  <img src="<?= asset('assets/img/icons/unicons/wallet-info.png') ?>" alt="Credit Card" class="rounded" />
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                  </div>
                </div>
              </div>
              <span>Sales</span>
              <h3 class="card-title text-nowrap mb-1">$4,679</h3>
              <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
            </div>
          </div>
        </div>
      </div>
    </div> -->
  </div>
</div>
<!-- / Content -->

<?php
require_once('../layouts/footer.php');
?>
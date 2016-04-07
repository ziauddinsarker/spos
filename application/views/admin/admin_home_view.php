        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <?php
            $group = $this->ion_auth->get_users_groups()->row()->name;
          ?>
            <div class="row">
                <?php
                if($group == 'admin') { ?>
                    <h1>Welcome Admin</h1>
                <?php }elseif($group == 'sales'){ ?>
                    <h2>Welcome to  <?php $user = $this->ion_auth->user()->row(); echo $user->first_name; //Get First Name and Use as a Store Name?></h2>

                <?php } ?>

            </div>
                <div class="row">

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <a href="<?php base_url()?>inventory/invoice">
                            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                            <div class="info-box-content">

                                <span class="info-box-text">Invoice</span>
                                  <span class="info-box-number">
                                      <?php
                                      //echo $total_invoice_today;
                                      ?>
                                  </span>

                            </div><!-- /.info-box-content -->
                        </a>
                    </div><!-- /.info-box -->
                </div><!-- /.col -->

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <a href="<?php base_url() ?>inventory/index">
                            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                            <div class="info-box-content">

                                <span class="info-box-text">Inventory</span>
                                  <span class="info-box-number">

                                      <?php
                                      //echo $total_rows;
                                      ?>

                                  </span>

                            </div><!-- /.info-box-content -->
                        </a>
                    </div><!-- /.info-box -->
                </div><!-- /.col -->

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <a href="<?php base_url() ?>inventory/get_daily_product_summary">
                            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                            <div class="info-box-content">

                                <span class="info-box-text">Summary</span>
                                  <span class="info-box-number">

                                      <?php
                                      //echo $total_rows;
                                      ?>

                                  </span>

                            </div><!-- /.info-box-content -->
                        </a>
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
        </div>


        </section><!-- /.content -->
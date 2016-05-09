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
					<?php /*
                    <h2>Sells Graph</h2>

                    <div id="searchVolume"></div>

                    <div id="tooltip" class="hidden">
                        <p class="heading"><span id="keyword">word</span></p>
                        <p class="heading">Total Sell</p>
                        <p class="indent"><span id="volVal">5</span></p>
                        <p class="heading">CPC</p>
                        <p class="indent">$<span id="cpcVal">5</span></p>
                    </div>
                    <button id="change">Switch Global</button> */
				?>


                <?php }elseif($group == 'sales'){ ?>
                    <h2>Welcome to  <?php $user = $this->ion_auth->user()->row(); echo $user->first_name; //Get First Name and Use as a Store Name?></h2>



            </div>
                <div class="row">

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <a href="<?php base_url()?>inventory/all_invoice">
                            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                            <div class="info-box-content">

                                <span class="info-box-text">Total Invoice</span>
                                  <span class="info-box-number">
                                      <?php
                                      echo $total_rows;
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

                                <span class="info-box-text">Products In Inventory</span>
                                  <span class="info-box-number">

                                      <?php foreach($all_inventory as $inv){ ?>
                                      <?php //echo $inv->Inventory;?>

                                          <?php
                                          $inventory = $inv->Inventory;
                                          if(($inventory == "0") || ($inventory == NULL)){
                                              echo "0 ";
                                          }else {
                                              echo $inventory;
                                          }
                                          ?>




                                      <?php }  ?>

                                  </span>

                            </div><!-- /.info-box-content -->
                        </a>
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
<?php /*
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <a href="<?php base_url() ?>inventory/get_daily_product_summary">
                            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                            <div class="info-box-content">

                                <span class="info-box-text">Today Sell</span>
                                  <span class="info-box-number">

                                       <?php foreach($daily_total_sell as $daily_total){ ?>
                                           <?php
                                           $sell = $daily_total->daily_total_sell;
                                           if(($sell == "0") || ($sell == NULL)){
                                               echo "0 ";
                                           }else {
                                               echo $daily_total->daily_total_sell;
                                           }
                                           echo "TK";
                                           ?>
                                       <?php }  ?>

                                  </span>

                            </div><!-- /.info-box-content -->
                        </a>
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
				
				*/ ?>
        </div>
        <?php } ?>

        </section><!-- /.content -->
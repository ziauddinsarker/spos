<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content">
<div class="row">
    <div class="col-md-8 col-sm-16 col-xs-18">
        <a class="btn btn-default" href="<?=  base_url()?>store/all_stores">All Store</a>
        <div>
            <h1 class="page-header">Add Stores</h1>
        </div>


        <?php if(validation_errors()) { ?>
            <div class="alert alert-warning">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>


        <?php if($this->session->flashdata('store')) { ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('store'); ?>
            </div>
        <?php } ?>


        <form  role="form" action="<?=  base_url()?>store/save_to_stores" method="post">

            <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="control-label col-xs-2">Store Name</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control full" name="store-name" placeholder="Store Name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="fabric" class="control-label col-xs-2">Address</label>
                    <div class="col-xs-10">
                        <input type="text" class="form-control full" name="store-address" placeholder="Store Address">
                    </div>
                </div>


                    <input type="submit" class="btn btn-primary" name="save" value="Save Store">
            </div>
                <div class="col-md-4"></div>
        </form>
    </div>
    </div>
</div>
</section>


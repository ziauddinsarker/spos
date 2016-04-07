<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="content">
<div class="row">
    <div class="col-md-8 col-sm-16 col-xs-18">
        <a class="btn btn-default" href="<?=  base_url()?>store/all_stores">All Sales Persons</a>
        <div>
            <h1 class="page-header">Add Sales Person</h1>
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


        <form  role="form" action="<?=  base_url()?>store/save_to_sales_person" method="post">

            <div class="row">
                <div class="col-md-12">

                    <div class="form-group">
                        <label for="fabric" class="control-label col-xs-2">Assigned Store</label>
                        <div class="col-xs-10">
                            <?php
                            $attributes = 'class="form-control" id="form-fabric"';
                            echo form_dropdown('store-name',$store,set_value('store-name'),$attributes);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fabric" class="control-label col-xs-2">Assigned User</label>
                        <div class="col-xs-10">
                            <?php
                            $attributes = 'class="form-control" id="form-user"';
                            echo form_dropdown('user-name',$users,set_value('user-name'),$attributes);
                            ?>
                        </div>
                    </div>


                    <input type="submit" class="btn btn-primary" name="save" value="Save Sales Person">
            </div>
                <div class="col-md-4"></div>
        </form>
    </div>
    </div>
</div>
</section>


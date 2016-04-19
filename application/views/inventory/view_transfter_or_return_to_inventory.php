 <!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-md-4 col-sm-8 col-xs-18">
        <a class="btn btn-default" href="<?php base_url() ?>index">View All T/R Product</a>
        <div>
            <h1 class="page-header">Transfer or Return</h1>
        </div>

        <?php if(validation_errors()) { ?>
            <div class="alert alert-warning">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>


        <?php if($this->session->flashdata('item')) { ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('item'); ?>
            </div>
        <?php } ?>

        <form  role="form" action="<?=  base_url()?>inventory/save_products_to_inventory" method="post">

            <div class="row">
                <div class="form-group">
                    <label for="date" class="control-label col-xs-4">Challan / Invoice:</label>
                    <div class="col-xs-8">
                        <input type="text" name="chalan-or-inv-no"  class="form-control" placeholder="Challan/Invoice" required="required">
                    </div>
                </div>

                <div class="form-group">
                    <label for="date" class="control-label col-xs-4">Transfer/Received:</label>
                    <div class="col-xs-8">
                        <input type="text" name="transfer-or-received" class="form-control" placeholder="Transfer / Received" required="required">
                    </div>
                </div>
            </div>
<br>
            <!-- Multiple Prdouct Update in the inventory-->
            <table class="table table-bordered table-hover invtable">
                <thead>
                    <th>No</th>
                    <th colspan="4">Product Code</th>
                    <th>Quantity</th>
                    <th>Transfer To / Received From</th>
                </thead>
                <tbody class="detail-inventory">
                    <tr>
                        <td class="no">1</td>
                        <td colspan="4"><input type="text" class="form-control productcode-inventory autocomplete_inventory_product" data-type="productcode-inventory" id='productcode-inventory_1' name="productcode-inventory[]" required="required"></td>
                        <input type="hidden" class="form-control" data-type="productcodeid-inventory" id='productcodeid-inventory_1' name="productcodeid-inventory[]" required="required">
                        <td><input type="text" class="form-control quantity-inventory" data-type="quantityinventory" id='quantity-inventory_1' name="quantity-inventory[]" required="required"></td>
                        <td><input type="text" class="form-control quantity-inventory" data-type="quantityinventory" id='quantity-inventory_1' name="quantity-inventory[]" required="required"></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <input type="submit" class="btn btn-primary" name="save" value="Save">
        </form>

</div>
</section><!-- /.content -->

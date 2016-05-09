 <!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-md-4 col-sm-8 col-xs-18">
        
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

        <form  role="form" action="<?=  base_url()?>inventory/save_product_transfer_or_received_at_inventory" method="post">

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
                        <select name="transfer-or-received" class="form-control">
                            <option value="Transfer">Transfer</option>
                            <option value="Received">Received</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="date" class="control-label col-xs-4">T / R From:</label>
                    <div class="col-xs-8">
                        <input type="text" class="form-control transfer-or-received-inventory" id='from-transfer-or-received-inventory' name="from-transfer-or-received-inventory" required="required">
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
                </thead>
                <tbody class="detail-inventory">
                    <tr>
                        <td class="no">1</td>
                        <td colspan="4"><input type="text" class="form-control productcode-transfer-or-received-inventory autocomplete_inventory_product" data-type="productcode-transfer-or-received-inventory" id='productcode-transfer-or-received-inventory_1' name="productcode-transfer-or-received-inventory" required="required"></td>
                        <input type="hidden" class="form-control" data-type="productcodeid-transfer-or-received-inventory" id='productcodeid-inventory_1' name="productcodeid-inventory" required="required">
                        <td><input type="text" class="form-control quantity-transfer-or-received-inventory"id='quantity-transfer-or-received-inventory' name="quantity-transfer-or-received-inventory" required="required"></td>

                    </tr>
                </tbody>
            </table>
            <br>
            <input type="hidden" name="storeid" value="<?php $user = $this->ion_auth->user()->row(); echo $user->id;?>">
            <input type="submit" class="btn btn-primary" name="save" value="Save">
        </form>

</div>
</section><!-- /.content -->

<section class="content">
<div class="row">
    <div class="col-md-8 col-sm-16 col-xs-18">
    <div>
        <h1 class="page-header">All Inventory</h1>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <th>No.</th>
            <th>Product ID</th>
            <th>Quantity Sold</th>
            <th>Quantity Left</th>
            <th>Action</th>
        </thead>
        <tbody class="inventory">
        <?php $i = 1;?>
        <?php foreach($allinventorys as $inventory){ ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $inventory->product_code;?></td>
                <td><?php echo $inventory->product_sold ;?></td>
                <td><?php echo $inventory->product_left ;?></td>
                <td><a class="btn btn-default" href="<?php base_url();?>get_single_product_inventory_summary_admin/<?php echo $inventory->product_code ;?>">View</a></td>
            </tr>
        <?php }  ?>
        </tbody>
    </table>
</div>
</div>

</section><!-- /.content -->
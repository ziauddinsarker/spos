<section class="content">
<div class="row">
<div class="col-md-8 col-sm-16 col-xs-18">
    <div>
        <h1>All Invoice</h1>
    </div>
    <?php
    $user = $this->ion_auth->user()->row();
    if($user->username == 'admin'){
        ?>
        <div class="form-group">
            <label for="location" class="control-label col-xs-2">Booking Code</label>
            <div class="col-xs-10">
                <input type="text" name="booking-code" class="form-control" placeholder="Booking Code">
            </div>
        </div>

    <h3>Total Invoice: <?php echo $count_invoice; ?></h3>
    <form class="form-inline" role="form" action="<?=  base_url()?>inventory/gettotalreport" method="post">
        <input class="btn btn-default" type="submit" value="Get Report">
    </form>
	<form class="form-inline" role="form" action="<?=  base_url()?>inventory/gettotalverbosereport" method="post">
        <input class="btn btn-default" type="submit" value="Get Verbose Report">
    </form>

    <?php } 	?>
    <table class="table table-bordered table-hover">
        <thead>
            <th>SI No.</th>
            <th>Date</th>
            <th>Invoice No.</th>
            <th>Customer Name</th>
            <th>Product Quantity</th>
            <th>Subtotal</th>
            <th>Discount</th>
            <th>Total</th>
            <th>Sold By</th>
            <th></th>
        </thead>
        <tbody class="inventory">
        <?php $i = 1;?>
        <?php foreach($invoices as $inv){ ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $inv->date;?></td>
                <td><?php echo $inv->invoice_no;?></td>
                <td><?php echo $inv->customer_name;?></td>
                <td><?php echo $inv->quantity ;?></td>
                <td><?php echo $inv->subtotal ;?></td>
                <td><?php echo $inv->totalDiscount ;?></td>
                <td><?php echo $inv->total ;?></td>
                <td><?php echo $inv->first_name ;?></td>
				<td><a class="btn btn-default" href="<?php base_url();?>print_later_from_invoice_data/<?php echo $inv->customer_id ;?>">Print</a></td>
                <!--
                <td><a class="btn btn-default" href="<?php // base_url();?>edit_product/<?php //echo $inv->customer_id ;?>">Edit</a>  <a class="btn btn-default" href="<?php //base_url();?>delete_product/<?php //echo $inv->customer_id ;?>">Delete</a></td>
                -->
            </tr>
        <?php }  ?>
        </tbody>
    </table>
    <?php echo $this->pagination->create_links(); ?>
</div>
</div>

</section>

<section class="content">
<div class="row">
<div class="col-md-8 col-sm-16 col-xs-18">
    <div><h1 class="page-header">Single Product Summary</h1></div>
    <table class="table table-bordered table-hover">
        <thead>
            <th>SI No.</th>
            <th>Product Code.</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Discount</th>
            <th>Total</th>
            <th>Store Name</th>
        </thead>
        <tbody class="inventory">
        <?php $i = 1;?>
        <?php foreach($single_summary as $daily){ ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $daily->product_code;?></td>
                <td><?php echo $daily->totalquantity ;?></td>
                <td><?php echo $daily->subtotal ;?></td>
                <td><?php echo $daily->discount ;?></td>
                <td><?php echo $daily->total ;?></td>
                <td><?php echo $daily->username ;?></td>
             </tr>
        <?php }  ?>
        </tbody>
    </table>
</div>
</div>

</section>

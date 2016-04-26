
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
             
        <!-- Default to the left -->
        <strong>Copyright &copy; 2016 <a href="#">SIMURA.</a></strong> All rights reserved.
      </footer>

    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4-->
    <script src="<?php echo base_url("assets/plugins/jQuery/jQuery-2.1.4.min.js")?>"></script>


    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url("assets/js/bootstrap.min.js")?> "></script>
     <script src="<?php echo site_url(); ?>assets/Bootstrap-3-Typeahead-master/bootstrap3-typeahead.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url("assets/dist/js/app.min.js")?> "></script>
      <!--
      <script src="<?php //echo base_url('assets/js/angular.min.js'); ?>"></script>
      <script src="<?php //echo base_url('assets/js/typeahead.bundle.js'); ?>"></script>-->

      <script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
      <script src="<?php echo base_url('assets/js/d3.min.js'); ?>"></script>
      <script src="<?php echo base_url('assets/js/bootstrap-sortable.js'); ?>"></script>
      <script src="<?php echo base_url('assets/js/moment.min.js'); ?>"></script>
      <script src="<?php echo base_url('assets/js/dropzone.js'); ?>"></script>
      <script src="<?php echo base_url('assets/js/html2canvas.js'); ?>"></script>



      <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
	  
	  <script>
	   
		 /**
           * Get Product code and price from inventory and show in the invoice. If there is no product in the inventory then can't make any invoice.
           * Autocomplete field when trying to write product code.
           */
          $(document).on('focus','.autocomplete_txt',function(){
              type = $(this).data('type');

              if(type =='productcodeid' )autoTypeNo=0;
              if(type =='productcode' )autoTypeNo=1;
              if(type =='price' )autoTypeNo=2;

              $(".autocomplete_txt").autocomplete({
                  source: "<?php echo base_url(); ?>index.php/inventory/show_product_from_inventory_in_invoice",
              minLength: 0,
                  dataType: 'json',
                  change: function(event, ui) {
                      id_arr = $(this).attr('id');
                      id = id_arr.split("_");
                      elementId = id[id.length-1];

                      $('#productcodeid_'+elementId).val(ui.item ? ui.item.id : "");
                  if (ui.item) {
                      $('#productcode_'+elementId).val(ui.item.value);
                      $('#price_'+elementId).val(ui.item.price);
                  }
              },

              select: function(event, ui) {
                  id_arr = $(this).attr('id');
                  id = id_arr.split("_");
                  elementId = id[id.length-1];
                  $('#productcodeid_'+elementId).val(ui.item ? ui.item.id : "");
                  $('#productcode_'+elementId).val(ui.item.value);
                  $('#price_'+elementId).val(ui.item.price);
              }
          });
          });
	  </script>
	  <script type="text/javascript">
          /**
           * Get Product code from all products and show in the invoice.
           * If there is no product in the inventory then can't make any invoice.
           * Autocomplete field when trying to write product code.
           */
          $(document).on('focus','.autocomplete_inventory_product',function(){
              type = $(this).data('type');

              if(type =='productcodeid-inventory' )autoTypeNo=0;
              if(type =='productcode-inventory' )autoTypeNo=1;

              $(".autocomplete_inventory_product").autocomplete({
                  source: "<?php echo base_url(); ?>index.php/inventory/show_product_from_products_in_inventory",
                  minLength: 0,
                  dataType: 'json',
                  change: function(event, ui) {
                      id_arr = $(this).attr('id');
                      id = id_arr.split("_");
                      elementId = id[id.length-1];

                      $('#productcodeid-inventory_'+elementId).val(ui.item ? ui.item.id : "");
                  if (ui.item) {
                      $('#productcode-inventory_'+elementId).val(ui.item.value);
                  }
              },

              select: function(event, ui) {
                  id_arr = $(this).attr('id');
                  id = id_arr.split("_");
                  elementId = id[id.length-1];
                  $('#productcodeid-inventory_'+elementId).val(ui.item ? ui.item.id : "");
                  $('#productcode-inventory_'+elementId).val(ui.item.value);
              }
          });
          });


      </script>
	  
	  
	<script>
          var j=$('.detail-inventory tr').length+1;

          $(".addmore-inventory").on('click',function(){
              count=$('.detail-inventory tr').length + 1;
              var data="<tr><td><span id='snum"+j+"'>"+count+".</span></td>";
              data+="<td colspan='4'><input type='text' class='form-control productcode-inventory autocomplete_inventory_product' data-type='productcode-inventory' id='productcode-inventory_"+j+"' name='productcode-inventory[]' required='required'></td>";
              data+="<input type='hidden' class='form-control' data-type='productcodeid-inventory' id='productcodeid-inventory_"+j+"' name='productcodeid-inventory[]' required='required'>";
              data+="<td><input type='text' class='form-control quantity-inventory' data-type='quantityinventory' id='quantity-inventory_"+j+"' name='quantity-inventory[]' required='required'></td>";
              data+="<td><a href='#' class='btn btn-primary remove'><i class='fa fa-times'></i></a></td></tr>";
              $('table').append(data);
              row = j ;
              j++;

          });

      </script>
	  <script>
          /**
           * Site : http:www.smarttutorials.net
           * @author muni
           */
          $(".delete").on('click', function() {
              $('.case:checkbox:checked').parents("tr").remove();
              $('.check_all').prop("checked", false);
              check();
          });


          var i=$('.detail tr').length+1;

          $(".addmore").on('click',function(){
              count=$('.detail tr').length + 1;
              var data="<tr><td><span id='snum"+i+"'>"+count+".</span></td>";
              data+="<td colspan='4'><input type='text' class='form-control productcode autocomplete_txt' data-type='productcode' id='productcode_"+i+"' name='productcode[]' required='required'></td>";
              data+="<input type='hidden' class='form-control' data-type='productcodeid' id='productcodeid_"+i+"' name='productcodeid[]' required='required'>";
              data+="<td><input type='text' class='form-control quantity' data-type='quantity' id='quantity_"+i+"' name='quantity[]' required='required'></td>";
              data+="<td><input type='text' class='form-control price autocomplete_txt' data-type='price' id='price_"+i+"' name='price[]' required='required'></td>";
              data+="<td><input type='text' class='form-control discount-amount' data-type='discountamount' id='discountamount_"+i+"' name='discountamount[]'></td>";
              data+="<td><input type='text' class='form-control discount' data-type='discount' id='discount_"+i+"' name='discount[]'></td>";
              data+="<td><input type='text' class='form-control amount' data-type='amount' id='amount_"+i+"' name='amount[]' readonly='readonly'></td>";
              data+="<td><a href='#' class='btn btn-primary remove'><i class='fa fa-times'></i></a> </td></tr>";
              $('table').append(data);
              row = i ;
              i++;
          });


          function select_all() {
              $('input[class=case]:checkbox').each(function(){
                  if($('input[class=check_all]:checkbox:checked').length == 0){
                      $(this).prop("checked", false);
                  } else {
                      $(this).prop("checked", true);
                  }
              });
          }

          function check(){
              obj=$('table tr').find('span');
              $.each( obj, function( key, value ) {
                  id=value.id;
                  $('#'+id).html(key+1);
              });
          }

      </script>




     <script>
        window.setTimeout(function() {
            $("#success_message").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 2000);
     </script>
	  
	 <script type="text/javascript">
        $(document).ready(function(){

            $('.detail').delegate('.quantity,.price,.discount,.discount-amount,.deliverycharge,.inword','keyup',function(){
                var tr = $(this).parent().parent();
                var qty = tr.find('.quantity').val();
                var price = tr.find('.price').val();
                var amt = qty * price;
				
				pquantity = tr.find('.quantity').val();

                //Discount Amount  if needed
                var discamount = tr.find('.discount-amount').val();
                var percent = tr.find('.discount').val();
                //console.log(discamount);
                if(discamount > 0){
                    var disc = (discamount/(qty * price))*100;
                    tr.find('.discount').val((disc).toFixed(2));
                }

               var amt = qty * price;
                tr.find('.amount').val(amt);

                subtotal();
                discount();
                //deliverycharge();

                //delchg = $(".deliverycharge").val();

                //console.log(delchg);

                //var delivecharge = tr.find('.deliverycharge').val();
                deliverychrg = $(".deliverycharge").val()-0;


                var total = (gsubtotal - gdiscount + deliverychrg);
                $('.total').html(total);
                $('.inWord').html(inWords(gsubtotal - gdiscount + deliverychrg));

                deliverycharge();

                var inw = inWords(gsubtotal - gdiscount);
                console.log(inw);
                //("#inword").txt(inw);
                //tr.find('.inword').val(inw);
                document.getElementById("inword").value = inw;
            });


            $('body').delegate('.remove','click',function(){
                $(this).parent().parent().remove();
            });

        });
        /**
         *
         *
         *
        */

        function deliverycharge(){
            $(".deliverycharge").keyup(function() {
                deliverychrg = +$(".deliverycharge").val();

                subtotal();
                discount();

                var total = (gsubtotal - gdiscount + deliverychrg);
                $('.total').html(total);
                $('.inWord').html(inWords(gsubtotal - gdiscount));


            });
        }
        /*
            var t = 0;
            $('.deliverycharge').each(function (i,e) {
                var amt = $(this).val()-0;
                t += amt;
            });

            deliverychare = t;
            }
*/





        /**
         * Total Amount
         */
        function subtotal(){
            var t = 0;
            $('.amount').each(function (i,e) {
                var amt = $(this).val()-0;
                t += amt;
            });

            gsubtotal = t;

            $('.inWord').html(inWords(t));
            $('.subtotal').html(t);
        }

        /**
         * Total Amount
         */
        function discount(){
            var t = 0;
            $('.discount-amount').each(function (i,e) {
                var disc = $(this).val()- 0;
                t += disc;
            });

            gdiscount = t;

            $('.discount').html(t);
        }

        var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
        var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

        function inWords (num) {
            if ((num = num.toString()).length > 9) return 'overflow';
            n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
            if (!n) return;
            var str = '';
            str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
            str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
            str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
            str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
            str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
            return str;
        }
    </script>

  </body>
</html>

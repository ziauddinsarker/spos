
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

                var inw = inWords(gsubtotal - gdiscount + deliverychrg);
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

      <script>
          var margin = {top: 25, right: 75, bottom: 85, left: 85},
              w = 600 - margin.left - margin.right,
              h = 350 - margin.top - margin.bottom;
          var padding = 10;

          var colors =	[["Local", "#377EB8"],
              ["Global", "#4DAF4A"]];

          var dataset = //"http://localhost/spos/inventory/show_sold_amount_by_date_in_json"

              [
              {"date": "2016-05-03", "global": 40000, "local": 73000, "cpc": "14.11"},
              {"date": "2016-05-04", "global": 165000, "local": 160000, "cpc": "12.53" }
          ];


          var xScale = d3.scale.ordinal()
              .domain(d3.range(dataset.length))
              .rangeRoundBands([0, w], 0.05);
          // ternary operator to determine if global or local has a larger scale
          var yScale = d3.scale.linear()
              .domain([0, d3.max(dataset, function(d) { return (d.local > d.global) ? d.local : d.global;})])
              .range([h, 0]);
          var xAxis = d3.svg.axis()
              .scale(xScale)
              .tickFormat(function(d) { return dataset[d].date; })
              .orient("bottom");
          var yAxis = d3.svg.axis()
              .scale(yScale)
              .orient("left")
              .ticks(5);

          var commaFormat = d3.format(',');

          //SVG element
          var svg = d3.select("#searchVolume")
              .append("svg")
              .attr("width", w + margin.left + margin.right)
              .attr("height", h + margin.top + margin.bottom)
              .append("g")
              .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

          // Graph Bars
          var sets = svg.selectAll(".set")
              .data(dataset)
              .enter()
              .append("g")
              .attr("class","set")
              .attr("transform",function(d,i){
                  return "translate(" + xScale(i) + ",0)";
              })	;

          sets.append("rect")
              .attr("class","local")
              .attr("width", xScale.rangeBand()/2)
              .attr("y", function(d) {
                  return yScale(d.local);
              })
              .attr("x", xScale.rangeBand()/2)
              .attr("height", function(d){
                  return h - yScale(d.local);
              })
              .attr("fill", colors[0][1])
              .on("mouseover", function(d,i) {
                  //Get this bar's x/y values, then augment for the tooltip
                  var xPosition = parseFloat(xScale(i) + xScale.rangeBand() );
                  var yPosition = h / 2;
                  //Update Tooltip Position & value
                  d3.select("#tooltip")
                      .style("left", xPosition + "px")
                      .style("top", yPosition + "px")
                      .select("#cpcVal")
                      .text(d.cpc);
                  d3.select("#tooltip")
                      .select("#volVal")
                      .text(commaFormat(d.local));
                  d3.select("#tooltip")
                      .select("#keyword")
                      .style("color", colors[1][1])
                      .text(d.date);
                  d3.select("#tooltip").classed("hidden", false);
              })
              .on("mouseout", function() {
                  //Remove the tooltip
                  d3.select("#tooltip").classed("hidden", true);
              })
          ;

          sets.append("rect")
              .attr("class","global")
              .attr("width", xScale.rangeBand()/2)
              .attr("y", function(d) {
                  return yScale(d.global);
              })
              .attr("height", function(d){
                  return h - yScale(d.global);
              })
              .attr("fill", colors[1][1])
              .on("mouseover", function(d,i) {
                  //Get this bar's x/y values, then augment for the tooltip
                  var xPosition = parseFloat(xScale(i) + xScale.rangeBand() );
                  var yPosition = h / 2;
                  //Update Tooltip Position & value
                  d3.select("#tooltip")
                      .style("left", xPosition + "px")
                      .style("top", yPosition + "px")
                      .select("#cpcVal")
                      .text(d.cpc);
                  d3.select("#tooltip")
                      .select("#volVal")
                      .text(commaFormat(d.global));
                  d3.select("#tooltip")
                      .select("#keyword")
                      .style("color", colors[1][1])
                      .text(d.date);
                  d3.select("#tooltip").classed("hidden", false);
              })
              .on("mouseout", function() {
                  //Remove the tooltip
                  d3.select("#tooltip").classed("hidden", true);
              })
          ;

          // Labels
          sets.append("text")
              .attr("class", "local")
              .attr("width", xScale.rangeBand()/2)
              .attr("y", function(d) {
                  return yScale(d.local);
              })
              .attr("dy", 10)
              .attr("dx", (xScale.rangeBand()/1.60) )
//	.attr("text-anchor", "middle")
              .attr("font-family", "sans-serif")
              .attr("font-size", "8px")
              .attr("fill", "white")
              .text(function(d) {
                  return commaFormat(d.local);
              });

          sets.append("text")
              .attr("class", "global")
              .attr("y", function(d) {
                  return yScale(d.global);
              })
              .attr("dy", 10)
              .attr("dx",(xScale.rangeBand() / 4) - 10)
//	.attr("text-anchor", "middle")
              .attr("font-family", "sans-serif")
              .attr("font-size", "8px")
              .attr("fill", "white")
              .text(function(d) {
                  return commaFormat(d.global);
              });

          // xAxis
          svg.append("g") // Add the X Axis
              .attr("class", "x axis")
              .attr("transform", "translate(0," + (h) + ")")
              .call(xAxis)
              .selectAll("text")
              .style("text-anchor", "end")
              .attr("dx", "-.8em")
              .attr("dy", ".15em")
              .attr("transform", function(d) {
                  return "rotate(-25)";
              })
          ;
          // yAxis
          svg.append("g")
              .attr("class", "y axis")
              .attr("transform", "translate(0 ,0)")
              .call(yAxis)
          ;
          // xAxis label
          svg.append("text")
              .attr("transform", "translate(" + (w / 2) + " ," + (h + margin.bottom - 5) +")")
              .style("text-anchor", "middle")
              .text("Sales By Date");
          //yAxis label
          svg.append("text")
              .attr("transform", "rotate(-90)")
              .attr("y", 0 - margin.left)
              .attr("x", 0 - (h / 2))
              .attr("dy", "1em")
              .style("text-anchor", "middle")
              .text("Volume in TK");

          // Title
          svg.append("text")
              .attr("x", (w / 2))
              .attr("y", 0 - (margin.top / 2))
              .attr("text-anchor", "middle")
              .style("font-size", "16px")
              .style("text-decoration", "underline")
              .text("Total Sell");

          // add legend
          var legend = svg.append("g")
                  .attr("class", "legend")
//		.attr("x", w - 65)
//		.attr("y", 50)
//		.attr("height", 100)
//		.attr("width", 100)
                  .attr("transform", "translate(70,10)")
              ;
          var legendRect = legend.selectAll('rect').data(colors);

          legendRect.enter()
              .append("rect")
              .attr("x", w - 65)
//	.attr("y", 0)										// use this to flip horizontal
              .attr("width", 10)
              .attr("height", 10)
              .attr("y", function(d, i) {
                  return i * 20;
              })
//	.attr("x", function(d, i){return w - 65 - i * 70}) // use this to flip horizontal
              .style("fill", function(d) {
                  return d[1];
              });

          var legendText = legend.selectAll('text').data(colors);

          legendText.enter()
              .append("text")
              .attr("x", w - 52)
              .attr("y", function(d, i) {
                  return i * 20 + 9;
              })
              .text(function(d) {
                  return d[0];
              });

          function updateBars()
          {
              svg.selectAll(".local").remove();
              svg.selectAll(".global").transition().duration(500).attr("width", xScale.rangeBand());
          }
          d3.select("#change").on("click", updateBars);
        </script>

  </body>
</html>

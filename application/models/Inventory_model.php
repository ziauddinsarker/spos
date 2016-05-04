<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_model extends CI_Model
{
        function __construct()
        {
            // Call the Model constructor
            parent::__construct();
            $this->load->library('fpdf_gen');
        }

    function get_all_products(){
        $this->db->select('tbl_product.id,tbl_product_name.product_name,tbl_product.product_code,tbl_product_color.product_color,tbl_product_fabric.product_fabric_name,tbl_product.product_price,tbl_product_category.product_category_name');
        $this->db->select('tbl_product.id as product_id');
        $this->db->from('tbl_product');
        $this->db->join('tbl_product_name','tbl_product.product_name = tbl_product_name.id');
        $this->db->join('tbl_product_color','tbl_product.product_color = tbl_product_color.id');
        $this->db->join('tbl_product_fabric','tbl_product.product_fabric = tbl_product_fabric.id');
        $this->db->join('tbl_product_category','tbl_product.product_category = tbl_product_category.id');
        $query = $this->db->get();
        return $query->result();
    }

    function get_all_p(){
        $this->db->select('tbl_product.id,tbl_product_name.product_name,tbl_product.product_code,tbl_product.product_price');
        $this->db->select('tbl_product.id as product_id');
        $this->db->from('tbl_product');
        $this->db->join('tbl_product_name','tbl_product.product_name = tbl_product_name.id');
        $this->db->join('tbl_product_color','tbl_product.product_color = tbl_product_color.id');
        $this->db->join('tbl_product_fabric','tbl_product.product_fabric = tbl_product_fabric.id');
        $this->db->join('tbl_product_category','tbl_product.product_category = tbl_product_category.id');
        $query = $this->db->get();
        return $query->result();
    }

    /*******************Products*********************/
         function all_products()
        {
            $this->db->select('tbl_product.id as product_id,tbl_product_name.product_name,tbl_product.product_code,tbl_product_color.product_color,tbl_product_fabric.product_fabric_name,tbl_product.product_price,tbl_product_category.product_category_name');
            $this->db->from('tbl_product');
            $this->db->join('tbl_product_name','tbl_product.product_name = tbl_product_name.id');
            $this->db->join('tbl_product_color','tbl_product.product_color = tbl_product_color.id');
            $this->db->join('tbl_product_fabric','tbl_product.product_fabric = tbl_product_fabric.id');
            $this->db->join('tbl_product_category','tbl_product.product_category = tbl_product_category.id');
			$this->db->order_by('product_code','ASC');
            $query = $this->db->get();
            return $query->result();
        }

        function edit_product($product_id) {
            $this->db->join('tbl_product_category','tbl_product.product_category = tbl_product_category.id');
            $data = $this->db->get_where('tbl_product', array('tbl_product.id' => $product_id))->row();
            return $data;
        }


        function update_product($product_id) {
            $product_update_data = array(
                'product_name' => $this->input->post('name'),
                'product_code' => $this->input->post('code'),
                'product_fabric' => $this->input->post('fabric'),
                'product_color' => $this->input->post('color'),
                'product_price' => $this->input->post('price'),
                'product_category' => $this->input->post('category'),
            );

            $this->db->where('id', $product_id);
            $this->db->update('tbl_product', $product_update_data);

        }

        function delete_product($product_id)
        {
            $this->db->where('id',$product_id);
            $this->db->delete('tbl_product');
        }

        /**
         * @return array
         */
        function get_product_name()
        {
            $this->db->select('id,product_name');
            $this->db->from('tbl_product_name');
            $this->db->order_by('product_name', 'ASC');
            $query = $this->db->get();
            $result = $query->result();

            //array to store department id & department name
            $product_name_id = array('');
            $product_name = array('-SELECT-');

            for ($i = 0; $i < count($result); $i++) {
                array_push($product_name_id, $result[$i]->id);
                array_push($product_name, $result[$i]->product_name);
            }
            return $doc_specility_result = array_combine($product_name_id, $product_name);
        }

		
		 /**
     * @param $keyword
     * @return mixed
     */
    function get_product_from_inventory($keyword, $user_id ){
        $this->db->select('tbl_product.id,tbl_product.product_code,tbl_product.product_price');
        $this->db->from('tbl_inventory');
        $this->db->join('tbl_product','tbl_inventory.product_id = tbl_product.id');
        $this->db->where('store',$user_id);
        $this->db->like('product_code',$keyword,'after');
        $this->db->order_by('product_code', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * @param $keyword
     * @return mixed
     */
    function get_sold_amount_by_date(){
        $this->db->select('tbl_orderdetail.date,
                            tbl_product.product_code,
                            tbl_product.product_price,
                            Sum(tbl_orderdetail.quantity) AS totalquantity,
                            Sum(tbl_orderdetail.amount) AS subtotal,
                            Sum(tbl_orderdetail.discount_amount) AS discount,
                            (SUM(amount)-sum(discount_amount)) AS total');
        $this->db->from('tbl_customer');
        $this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
        $this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
        $this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
        $this->db->group_by('tbl_orderdetail.date');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     *
     */
    function get_product_from_all_products($keyword){
        $this->db->select('tbl_product.id,tbl_product.product_code');
        $this->db->from('tbl_product');
        $this->db->like('product_code',$keyword,'after');
        $query = $this->db->get();
        return $query->result();
    }

		
        /**
         * @return array
         */
      /*  function get_product_code()
        {
            $this->db->select('id,product_code');
            $this->db->from('tbl_product_code');
            $this->db->order_by('product_code', 'ASC');
            $query = $this->db->get();
            $result = $query->result();

            //array to store department id & department name
            $code_id = array('');
            $code_name = array('-SELECT-');

            for ($i = 0; $i < count($result); $i++) {
                array_push($code_id, $result[$i]->id);
                array_push($code_name, $result[$i]->product_code);
            }
            return $doc_specility_result = array_combine($code_id, $code_name);
        }
*/
        /**
         * @return array
         */
        function get_product_color()
        {
            $this->db->select('id,product_color');
            $this->db->from('tbl_product_color');
            $this->db->order_by('product_color', 'ASC');
            $query = $this->db->get();
            $result = $query->result();

            //array to store department id & department name
            $color_id = array('');
            $color_name = array('-SELECT-');

            for ($i = 0; $i < count($result); $i++) {
                array_push($color_id, $result[$i]->id);
                array_push($color_name, $result[$i]->product_color);
            }
            return $doc_specility_result = array_combine($color_id, $color_name);
        }

        function get_product_fabric()
        {
            $this->db->select('id,product_fabric_name');
            $this->db->from('tbl_product_fabric');
            $this->db->order_by('product_fabric_name', 'ASC');
            $query = $this->db->get();
            $result = $query->result();

            //array to store department id & department name
            $fabric_id = array('');
            $fabric_name = array('-SELECT-');

            for ($i = 0; $i < count($result); $i++) {
                array_push($fabric_id, $result[$i]->id);
                array_push($fabric_name, $result[$i]->product_fabric_name);
            }
            return $doc_specility_result = array_combine($fabric_id, $fabric_name);
        }

        function get_product_category()
        {
            $this->db->select('id,product_category_name');
            $this->db->from('tbl_product_category');
            $this->db->order_by('product_category_name', 'ASC');
            $query = $this->db->get();
            $result = $query->result();

            //array to store department id & department name
            $category_id = array('');
            $category_name = array('-SELECT-');

            for ($i = 0; $i < count($result); $i++) {
                array_push($category_id, $result[$i]->id);
                array_push($category_name, $result[$i]->product_category_name);
            }
            return $doc_specility_result = array_combine($category_id, $category_name);
        }
    /*******************Category*********************/
         function get_all_categories()
        {
            $this->db->select('*');
            $this->db->from('tbl_product_category');
            $query = $this->db->get();
            return $query->result();
        }


        function edit_category($category_id) {
            $data = $this->db->get_where('tbl_product_category', array('id' => $category_id))->row();
            return $data;
        }


        function update_category($category_id) {
            $category_update_data = array(
                'product_category_name' => $this->input->post('category'),
            );
            $this->db->where('id', $category_id);
            $this->db->update('tbl_product_category', $category_update_data);
        }

        function delete_category($category_id)
        {
            $this->db->where('id',$category_id);
            $this->db->delete('tbl_product_category');
        }


    /*******************Product Name*********************/
         function get_all_product_name()
        {
            $this->db->select('*');
            $this->db->from('tbl_product_name');
            $query = $this->db->get();
            return $query->result();
        }


        function edit_product_name($product_name_id) {
            $data = $this->db->get_where('tbl_product_name', array('id' => $product_name_id))->row();
            return $data;
        }


        function update_product_name($product_name_id) {
            $category_update_data = array(
                'product_name' => $this->input->post('product-name'),
            );
            $this->db->where('id', $product_name_id);
            $this->db->update('tbl_product_name', $category_update_data);
        }

        function delete_product_name($product_name_id)
        {
            $this->db->where('id',$product_name_id);
            $this->db->delete('tbl_product_name');
        }

    /*******************Product Code*********************/
         function get_all_product_code()
        {
            $this->db->select('*');
            $this->db->from('tbl_product_code');
            $query = $this->db->get();
            return $query->result();
        }


        function edit_product_code($product_code_id) {
            $data = $this->db->get_where('tbl_product_code', array('id' => $product_code_id))->row();
            return $data;
        }


        function update_product_code($product_code_id) {
            $category_update_data = array(
                'product_code' => $this->input->post('product-code'),
            );
            $this->db->where('id', $product_code_id);
            $this->db->update('tbl_product_code', $category_update_data);
        }

        function delete_product_code($product_code_id)
        {
            $this->db->where('id',$product_code_id);
            $this->db->delete('tbl_product_code');
        }

    /*******************Product Color*********************/
         function get_all_product_color()
        {
            $this->db->select('*');
            $this->db->from('tbl_product_color');
            $query = $this->db->get();
            return $query->result();
        }


        function edit_product_color($product_color_id) {
            $data = $this->db->get_where('tbl_product_color', array('id' => $product_color_id))->row();
            return $data;
        }


        function update_product_color($product_color_id) {
            $category_update_data = array(
                'product_color' => $this->input->post('product-color'),
            );
            $this->db->where('id', $product_color_id);
            $this->db->update('tbl_product_color', $category_update_data);
        }

        function delete_product_color($product_color_id)
        {
            $this->db->where('id',$product_color_id);
            $this->db->delete('tbl_product_color');
        }

    /*******************Product Fabric*********************/
         function get_all_product_fabric()
        {
            $this->db->select('*');
            $this->db->from('tbl_product_fabric');
            $query = $this->db->get();
            return $query->result();
        }


        function edit_product_fabric($product_fabric_id) {
            $data = $this->db->get_where('tbl_product_fabric', array('id' => $product_fabric_id))->row();
            return $data;
        }


        function update_product_fabric($product_fabric_id) {
            $category_update_data = array(
                'product_fabric_name' => $this->input->post('product-fabric'),
            );
            $this->db->where('id', $product_fabric_id);
            $this->db->update('tbl_product_fabric', $category_update_data);
        }

        function delete_product_fabric($product_fabric_id)
        {
            $this->db->where('id',$product_fabric_id);
            $this->db->delete('tbl_product_fabric');
        }


    /*******************Product Fabric*********************/
        function get_all_invoice($offset, $limit,$user_id)
        {
            $this->db->select('*');
            $this->db->select('SUM(quantity)as quantity ,SUM(amount) as subtotal,sum(discount_amount) as totalDiscount,delivery_charge,((SUM(amount)-sum(discount_amount)) + delivery_charge) as total');
            $this->db->from('tbl_customer');
            $this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
            $this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
            $this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
            $this->db->join('users','users.id = tbl_customer.sell_by');
            $this->db->where('sell_by',$user_id);
            $this->db->group_by('customer_id');
            $this->db->order_by('invoice_no','DESC');
			
            $this->db->limit($offset, $limit);
            $query = $this->db->get();
            return $query->result();
        }

    function get_all_invoice_for_admin($offset, $limit)
        {
            $this->db->select('*');
            $this->db->select('SUM(quantity)as quantity ,SUM(amount) as subtotal,sum(discount_amount) as totalDiscount,(SUM(amount)-sum(discount_amount)) as total');
            $this->db->from('tbl_customer');
            $this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
            $this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
            $this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
            $this->db->join('users','users.id = tbl_customer.sell_by');
            $this->db->group_by('customer_id');
            $this->db->order_by('invoice_no','DESC');

            $this->db->limit($offset, $limit);
            $query = $this->db->get();
            return $query->result();
        }

        /**
         * @param $offset
         * @param $limit
         * @param $date
         * @return mixed
         *
         * Get all invoice by date
         */
		function get_all_invoice_by_date($offset, $limit, $date )
        {
            if(!isset($date)) {
                $date = date("Y-m-d");
            }else{
                $date = $date;
            }

            $this->db->select('*');
            $this->db->select('SUM(quantity)as quantity ,SUM(amount) as subtotal,sum(discount_amount) as totalDiscount,(SUM(amount)-sum(discount_amount)) as total');
            $this->db->from('tbl_customer');
            $this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
            $this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
            $this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
            $this->db->join('tbl_sells_person','tbl_sells_person.id = tbl_customer.sell_by');
            $this->db->group_by('customer_id');
            $this->db->where('date',$date);
            $this->db->order_by('invoice_no','DESC');
            $this->db->limit($offset, $limit);
            $query = $this->db->get();
            return $query->result();
        }

    /**
     * @param string $date
     * @return mixed
     *
     *Get total in csv by date
     */
	function gettotalCSVByDate($date = '')
        {
            if(!isset($date)) {
                $date = date("Y-m-d");
            }else{
                $date = $date;
            }

            $sql = "SELECT
                    date as Date,tbl_orderdetail.invoice_no as Invoice_Number,tbl_customer.customer_name as Customer_Name,tbl_customer.customer_phone as Customer_Phone,SUM(quantity)as Quantity ,
                    SUM(amount) as Subtotal,
					sum(discount_amount) as Discount,
					(sum(amount) - sum(discount_amount)) as Total,
					tbl_sells_person.sells_person_name as Sold_By
                    FROM
                    tbl_customer
                    INNER JOIN tbl_order ON tbl_order.customer_id = tbl_customer.id
                    INNER JOIN tbl_orderdetail ON tbl_order.order_id = tbl_orderdetail.id
                    INNER JOIN tbl_product ON tbl_product.id = tbl_orderdetail.product_code
                    INNER JOIN tbl_sells_person ON tbl_sells_person.id = tbl_customer.sell_by
                    WHERE
						tbl_orderdetail.date = '" . $date ."'
                    GROUP BY
                    customer_id";
            return $this->db->query($sql);
        }

        function count_all_invoice($store_id)
        {
            $this->db->select('*');
            //$this->db->select('SUM(quantity)as quantity ,SUM(amount) as subtotal,sum(discount_amount) as totalDiscount,(SUM(amount)-sum(discount_amount)) as total');
            //$this->db->from('tbl_customer');
            $this->db->from('tbl_order');
           // $this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
            //$this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
            //$this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
           // $this->db->group_by('tbl_order.customer_id');
            //$this->db->where('sell_by',$store_id);
            $this->db->where('tbl_order.store_id',$store_id);
            $this->db->group_by('tbl_order.customer_id');
            //$this->db->group_by('store_id');
            //$norow = $this->db->count_all('tbl_customer');
            //$norow = $this->db->count_all_results();;
           $query = $this->db->get();
            $rowcount = $query->num_rows();
            //return $norow;
            return $rowcount;
        }

        function count_all_inventory($store_id)
        {
            $this->db->select('tbl_inventory.store,SUM(product_left) as Inventory');
            $this->db->from('tbl_inventory');
            $this->db->where('tbl_inventory.store',$store_id);
            $query = $this->db->get();
            return $query->result();
        }

        function count_all_invoice_for_admin()
        {
            $this->db->select('*');
           $this->db->from('tbl_customer');
            $this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
            $this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
            $this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
            $this->db->group_by('customer_id');
            $norow = $this->db->count_all('tbl_customer');
            // $query = $this->db->get();
            return $norow;
        }

        function count_all_outlet_invoice($store_id)
        {
            $this->db->select('*');
            //$this->db->select('SUM(quantity)as quantity ,SUM(amount) as subtotal,sum(discount_amount) as totalDiscount,(SUM(amount)-sum(discount_amount)) as total');
            $this->db->from('tbl_customer');
            $this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
            $this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
            $this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
            $this->db->where('store_id',$store_id);
            $this->db->group_by('customer_id');
            //$query = $this->db->get();
            //$norow = $this->db->count_all_results();
           // $query = $this->db->get();


            $query = $this->db->get();
            $rowcount = $query->num_rows();

            return $rowcount;
        }
		
        function count_total_sell_today($user_id)
        {
            $today = date('Y-m-d');
            $this->db->select('store_id,date,(SUM(amount)-SUM(discount_amount)) as daily_total_sell');
            $this->db->from('tbl_orderdetail');
            $this->db->join('tbl_order','tbl_order.order_id = tbl_orderdetail.id');
            $this->db->where('date',$today);
            $this->db->where('store_id',$user_id);
            $this->db->limit(1);
            $query = $this->db->get();
            return $query->result();
        }

    function count_all_sell_today()
        {
            $today = date('Y-m-d');
            $this->db->select('date,(SUM(amount)-sum(discount_amount)) as total_sell_today');
            $this->db->from('tbl_customer');
            $this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
            $this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
            $this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
            $this->db->where('date',$today);
            $this->db->limit(1);
            $query = $this->db->get();
            return $query->result();
        }


		function count_sold_by_seller()
        {
            $this->db->select('users.id as userid,users.first_name, COUNT(users.first_name) as total_no_of_sell');
             $this->db->from('tbl_customer');
            $this->db->join('users','users.id = tbl_customer.sell_by');
            $this->db->group_by('users.first_name');
            //$total_count = $this->db->count_all('total_no_of_sell');
            //return $total_count;
			$query = $this->db->get();
            return $query->result();
        }  

		function count_sold_amount_by_seller()
        {
            $this->db->select('users.first_name AS Seller,Sum(tbl_orderdetail.quantity) as Quantity,Sum(tbl_orderdetail.amount) AS TotalAmount');
             $this->db->from('tbl_order');
            $this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
            $this->db->join('tbl_customer','tbl_order.customer_id = tbl_customer.id');
            $this->db->join('users','users.id = tbl_customer.sell_by');
            $this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
            $this->db->group_by('users.first_name');
            $this->db->order_by('totalAmount','DESC');
			$query = $this->db->get();
            return $query->result();
        }
		
		function count_daily_invoice()
        {
			$todaydate = date('Y-m-d');
            $this->db->select('*');
			$this->db->from('tbl_customer');
            $this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
            $this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
            $this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
			$this->db->where('date',$todaydate);
            $this->db->group_by('customer_code');			
            $norow = $this->db->count_all('tbl_customer');
           // $query = $this->db->get();
            return $norow;
        }

        function get_daily_summary( $date = null)
        {
            if(!isset($date)) {
                $date = date("y-m-d");
            }else{
                $date = $date;
            }
            $this->db->select('*');
            $this->db->select('tbl_orderdetail.date,
                                tbl_product.product_code,
                                sum(tbl_orderdetail.quantity) as totalquantity,
                                tbl_orderdetail.price,
                                ((tbl_orderdetail.price * COUNT(tbl_product.product_code))*sum(tbl_orderdetail.quantity)) as  subtotal,
                                SUM(discount_amount) as discount,                                
								((tbl_orderdetail.price * COUNT(tbl_product.product_code)*sum(tbl_orderdetail.quantity))- SUM(discount_amount)) as total');              				
            $this->db->from('tbl_orderdetail');
            $this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
            $this->db->group_by('tbl_product.product_code');
            $this->db->where('date',$date);
            $query = $this->db->get();
            return $query->result();
        }

        function get_left_product_on_inventory($product_id = NULL, $store_id){
            $this->db->select('store,product_id,product_left,product_sold');
            $this->db->from('tbl_inventory');
            $this->db->where('store',$store_id);
            $this->db->where('product_id',$product_id);
            $query = $this->db->get();
            return $query->result();
        }





		
		function get_daily_product_summary($date = null,$user_id)
        {
			 if(!isset($date)) {
                $date = date("Y-m-d");
            }else{
                $date = $date;
            }
            $this->db->select('*');
            $this->db->select('tbl_orderdetail.date,
                                tbl_product.product_code,
                                tbl_orderdetail.price,
                                Sum(tbl_orderdetail.quantity) AS totalquantity,
                                Sum(tbl_orderdetail.amount) AS subtotal,
                                Sum(tbl_orderdetail.discount_amount) AS discount,
                                (SUM(amount)-sum(discount_amount)) AS total,
                                sell_by'
                );
            $this->db->from('tbl_customer');
            $this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
            $this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
            $this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
            $this->db->group_by('tbl_product.product_code');
            $this->db->where('sell_by',$user_id);
			$this->db->where('date',$date);
            $query = $this->db->get();
            return $query->result();
        }
		
		function get_all_daily_product_summary_admin()
        {
            $this->db->select('*');
            $this->db->select('tbl_orderdetail.date,
                                tbl_product.product_code,
                                tbl_orderdetail.price,
                                Sum(tbl_orderdetail.quantity) AS totalquantity,
                                Sum(tbl_orderdetail.amount) AS subtotal,
                                Sum(tbl_orderdetail.discount_amount) AS discount,
                                (SUM(amount)-sum(discount_amount)) AS total');
            $this->db->from('tbl_customer');
            $this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
            $this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
            $this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
            $this->db->group_by('tbl_product.product_code');
            $query = $this->db->get();
            return $query->result();
        }

        function get_single_product_summary_admin($product_code)
        {
            $this->db->select('*');
            $this->db->select('tbl_orderdetail.date,
                                tbl_product.product_code,
                                tbl_orderdetail.price,
                                Sum(tbl_orderdetail.quantity) AS totalquantity,
                                Sum(tbl_orderdetail.amount) AS subtotal,
                                Sum(tbl_orderdetail.discount_amount) AS discount,
                                (SUM(amount)-sum(discount_amount)) AS total,
                                tbl_order.store_id');
            $this->db->from('tbl_customer');
            $this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
            $this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
            $this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
            $this->db->join('users','users.id = tbl_order.store_id');
            $this->db->where('tbl_product.product_code', $product_code);
            $this->db->group_by('tbl_order.store_id');
            $query = $this->db->get();
            return $query->result();
        }

        function get_daily_summary_report($date = null){
            if(!isset($date)) {
                $date = date("y-m-d");
            }else{
                $date = $date;
            }
            $this->db->select('*');
            $this->db->select('tbl_orderdetail.date,
                                tbl_product.product_code,
                                sum(tbl_orderdetail.quantity) as totalquantity,
                                tbl_orderdetail.price,
                                ((tbl_orderdetail.price * COUNT(tbl_product.product_code))*sum(tbl_orderdetail.quantity)) as  subtotal,
                                (SUM(discount_amount)*sum(tbl_orderdetail.quantity)) as discount,
                                ((tbl_orderdetail.price * COUNT(tbl_product.product_code) - (SUM(discount_amount)))*sum(tbl_orderdetail.quantity)) as  total');
            //$this->db->from('tbl_orderdetail');
            $this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
            $this->db->group_by('tbl_product.product_code');
            $this->db->where('date',$date);
            $query = $this->db->get('tbl_orderdetail');
            return $query;
        }

        /**
         * @param string $date
         * @return mixed
         * Get CSV for daily summary
         */
        function getDailyCSV($date = '') {
            if(!isset($date)) {
                $date = date("y-m-d");
            }else{
                $date = $date;
            }

            $sql = "SELECT
						tbl_orderdetail.date,
						tbl_product.product_code,
						 tbl_orderdetail.price,
						sum(tbl_orderdetail.quantity) as totalquantity,                    
						Sum(tbl_orderdetail.amount) AS subtotal,
						Sum(tbl_orderdetail.discount_amount) AS discount,
						(SUM(amount)-sum(discount_amount)) AS total                   
                    FROM
                        tbl_orderdetail
                    INNER JOIN tbl_product ON tbl_product.id = tbl_orderdetail.product_code
                    WHERE
						tbl_orderdetail.date = '" . $date ."'
                    GROUP BY
						tbl_orderdetail.product_code";

            return $this->db->query($sql);
        } 
		
		
			
		

        /**
         * @return mixed
         * get All invoice in CSV format
         */
        function gettotalCSV($user_id)
        {
            $sql = "SELECT
                    tbl_orderdetail.date AS Date,
                    tbl_orderdetail.invoice_no AS Invoice_Number,
                    tbl_customer.customer_name AS Customer_Name,
                    tbl_customer.customer_phone AS Customer_Phone,
                    Sum(tbl_orderdetail.quantity) AS Quantity,
                    Sum(tbl_orderdetail.amount) AS Subtotal,
                    Sum(tbl_orderdetail.discount_amount) AS Discount,
                    (sum(amount) - sum(discount_amount)) AS Total
                    FROM
                    tbl_customer
                    INNER JOIN tbl_order ON tbl_order.customer_id = tbl_customer.id
                    INNER JOIN tbl_orderdetail ON tbl_order.order_id = tbl_orderdetail.id
                    INNER JOIN tbl_product ON tbl_product.id = tbl_orderdetail.product_code
                    INNER JOIN users ON tbl_customer.sell_by = users.id
                    WHERE users.id = $user_id
                    GROUP BY
                        customer_id
                    ";
            return $this->db->query($sql);
        }

		
		/**
         * @return mixed
         * get All invoice in CSV format
         */
        function gettotalverboseCSV($user_id)
        {
            $sql = "SELECT
                    tbl_orderdetail.date as Date,
                    tbl_orderdetail.invoice_no as Invoice_No,
                    tbl_customer.customer_name as Customer_Name,
                    tbl_customer.customer_phone as Customer_Phone,
                    tbl_customer.customer_email as Customer_Email,
                    tbl_product.product_code as Product_Code,
                    tbl_orderdetail.quantity as Quantity,
                    tbl_orderdetail.price as Price,
                    (tbl_orderdetail.price * tbl_orderdetail.quantity) as Subtotal,
                    tbl_orderdetail.discount_amount as Discount_Amount,
                    tbl_orderdetail.discount as Discount_Percentage,
                    ((tbl_orderdetail.price * tbl_orderdetail.quantity) - (tbl_orderdetail.discount_amount)) as Total_Amount,
                    tbl_orderdetail.created_at
                    FROM
                    tbl_customer
                    INNER JOIN tbl_order ON tbl_order.customer_id = tbl_customer.id
                    INNER JOIN tbl_orderdetail ON tbl_order.order_id = tbl_orderdetail.id
                    INNER JOIN tbl_product ON tbl_product.id = tbl_orderdetail.product_code
                    INNER JOIN users ON tbl_customer.sell_by = users.id
                    WHERE users.id = $user_id
                    ORDER BY invoice_no ASC";
            return $this->db->query($sql);
        }
		
		     //$this->db->select('SUM(quantity)as quantity ,SUM(amount) as subtotal,(sum(discount_amount)*sum(quantity)) as totalDiscount,(SUM(amount)-(sum(discount_amount)*sum(quantity))) as total');


        function edit_invoice($product_fabric_id) {
            $data = $this->db->get_where('tbl_product_fabric', array('id' => $product_fabric_id))->row();
            return $data;
        }


        function update_invoice($product_fabric_id) {
            $category_update_data = array(
                'product_fabric_name' => $this->input->post('product-fabric'),
            );
            $this->db->where('id', $product_fabric_id);
            $this->db->update('tbl_product_fabric', $category_update_data);
        }

        function delete_invoice($product_fabric_id)
        {
            $this->db->where('id',$product_fabric_id);
            $this->db->delete('tbl_product_fabric');
        }


        /***************Inventory**************************/
        /**
         * @return mixed
         */
        function get_inventory($store_id = NULL)
        {
            $this->db->select('*');
            $this->db->from('tbl_inventory');
            $this->db->join('tbl_product','tbl_inventory.product_id = tbl_product.id');
            $this->db->join('tbl_product_name','tbl_product.product_name = tbl_product_name.id');
            $this->db->where('store',$store_id);
            $query = $this->db->get();
            return $query->result();
        }

        function product_left($product_id)
        {
            $this->db->select('product_id');
            $data =  $this->db->get_where('tbl_inventory',array('product_id' => $product_id))->row();
            return $data;

        }


    /**
     * @param null $store_id
     * @return mixed
     * Transfer or Received Data
     */
    function get_transfer_or_received_data($store_id = NULL)
    {
        $this->db->select('tbl_product.product_code,tbl_inventory_transfer_received.product_quantity, tbl_challan.challan_number, tbl_challan.challan_from, tbl_challan.challan_date');
        $this->db->from('tbl_inventory_transfer_received');
        $this->db->join('tbl_challan','tbl_inventory_transfer_received.challan_or_invoice_no = tbl_challan.challan_id');
        $this->db->join('tbl_product','tbl_inventory_transfer_received.product_id = tbl_product.id');
        $this->db->where('store',$store_id);
        $query = $this->db->get();
        return $query->result();
    }




        /**
         * @return array|bool
         */

        function get_product()
        {
            $this->db->select('tbl_product.id,tbl_product_name.product_name,tbl_product.product_code');
            $this->db->from('tbl_product');
            $this->db->join('tbl_product_name','tbl_product.product_name = tbl_product_name.id');
            $this->db->join('tbl_product_color','tbl_product.product_color = tbl_product_color.id');
            $this->db->join('tbl_product_fabric','tbl_product.product_fabric = tbl_product_fabric.id');
            $this->db->join('tbl_product_category','tbl_product.product_category = tbl_product_category.id');
            $this->db->order_by('product_code', 'ASC');
            $query = $this->db->get();
            $result = $query->result();

            //array to store department id & department name
            $product_id = array('');
            $product_code = array('-SELECT-');

            for ($i = 0; $i < count($result); $i++) {
                array_push($product_id, $result[$i]->id);
                array_push($product_code, $result[$i]->product_code);
            }
            return $doc_specility_result = array_combine($product_id, $product_code);
        }


		/**
         * @return array|bool
         */

        function get_product_code()
        {
            $this->db->select('tbl_product.id,tbl_product.product_code,tbl_product_name.product_name');
            $this->db->from('tbl_product');
            $this->db->join('tbl_product_name','tbl_product.product_name = tbl_product_name.id');
            $this->db->join('tbl_product_color','tbl_product.product_color = tbl_product_color.id');
            $this->db->join('tbl_product_fabric','tbl_product.product_fabric = tbl_product_fabric.id');
            $this->db->join('tbl_product_category','tbl_product.product_category = tbl_product_category.id');
            $this->db->order_by('product_code', 'ASC');
            $query = $this->db->get();
            $result = $query->result();

            //array to store department id & department name
            $product_id = array('');
            $product_code = array('-SELECT-');

            for ($i = 0; $i < count($result); $i++) {
                array_push($product_id, $result[$i]->id);
                array_push($product_code, $result[$i]->product_code);
            }
            return $doc_specility_result = array_combine($product_id, $product_code);
        }



    }

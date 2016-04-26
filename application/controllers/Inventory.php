<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Inventory extends CI_Controller {
	
	var $file_path;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this->load->model('user_model');
		$this->load->library('ion_auth');
		$this->load->library('pagination');
		
		$this->load->model('inventory_model');
		$data['product'] = $this->inventory_model->get_product();
		//$data['sells_person'] = $this->inventory_model->get_sells_person();
		//var_dump($data['sells_person']);
		$data['product_code'] = $this->inventory_model->get_product_code();

		$user_id = $this->session->userdata('user_id');
		$this->data['inventorys'] = $this->inventory_model->get_inventory($user_id);

		//$this->data['inventory_product_id'] = $this->inventory_model->get_left_product_on_inventory(23);
		//echo $this->data['inventory_product_id']->product_left();


		//var_dump($this->data['inventory_product_id']);


		//$username = $this->session->userdata('username');
		//$this->data['employee'] = $this->admin_model->get_user_employee($username);

		$this->file_path = realpath(APPPATH . '../assets');
	}


	/**
	 * Inventory Index
	 */
	public function index()
	{ //Check if user is logged in or not. If not then else statement works otherwise redirect to login page
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('login/index', 'refresh');
		} else {
			$this->load->view('admin/admin_header_view', $this->data);
			$this->load->view('inventory/view_inventory', $this->data);
			$this->load->view('admin/admin_footer_view', $this->data);
		}
	}

	public function json_search_product()
	{
		$query  = $this->inventory_model->get_all_p();
		$data = array();
		foreach ($query as $key => $value)
		{
			$data[] = array(
				'id' => $value->product_id,
				'pcode' => $value->product_code,
				//'name' => $value->product_name,
				'price' => $value->product_price

			);
		}
		echo json_encode($data);
	}

	public function json_all_invoice(){
		$limit = 0;
		$offset  = 0;
		$query = $this->inventory_model->get_all_invoice($limit, $offset);

		$data = array();
		foreach ($query as $key => $value)
		{
			$data[] = array(
				//'id' => $value->product_id,
				'date' => $value->date,
				//'name' => $value->product_name,
				'total' => $value->total

			);
		}
		echo json_encode($data);

	}



	public function GetCountryName(){
		$keyword = $this->input->post('searchbox');
		$data=$this->inventory_model->GetRow($keyword);
		echo json_encode($data);
	}


	public function get_product_name(){
		$this->db->select('tbl_product.id,tbl_product_name.product_name,tbl_product.product_code,tbl_product_color.product_color,tbl_product_fabric.product_fabric_name,tbl_product.product_price,tbl_product_category.product_category_name');
		$this->db->select('tbl_product.id as product_id');
		$this->db->from('tbl_product');
		$this->db->join('tbl_product_name','tbl_product.product_name = tbl_product_name.id');
		$this->db->join('tbl_product_color','tbl_product.product_color = tbl_product_color.id');
		$this->db->join('tbl_product_fabric','tbl_product.product_fabric = tbl_product_fabric.id');
		$this->db->join('tbl_product_category','tbl_product.product_category = tbl_product_category.id');
		$query = $this->db->get();

		$product_array = array();

		foreach ($query->result() as $row) {
			$product_array[] = $row->id;
			$product_array[] = $row->product_code;
			$product_array[] = $row->product_price;
		}
		$data = $product_array;
		echo json_encode($data);


	}


	/****************Product**********************/
	/**
	 * Get all Products from Database
	 */
	function all_products(){
		$this->data['products'] = $this->inventory_model->all_products();
		//var_dump($this->data['products']);
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_all_products',$this->data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}

	/**
	 * Show  Add New Product Page
	 */
	function add_product(){
		$data['name'] = $this->inventory_model->get_product_name();
		//$data['code'] = $this->inventory_model->get_product_code();
		$data['color'] = $this->inventory_model->get_product_color();
		$data['fabric'] = $this->inventory_model->get_product_fabric();
		$data['category'] = $this->inventory_model->get_product_category();
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_add_product',$data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}


	function all_data(){
		$data['name'] = $this->inventory_model->get_product_name();
		//$data['code'] = $this->inventory_model->get_product_code();
		$data['color'] = $this->inventory_model->get_product_color();
		$data['fabric'] = $this->inventory_model->get_product_fabric();
		$data['category'] = $this->inventory_model->get_product_category();
		return $data;
	}

	/**
	 * Save Product from Add New Product Page
	 */
	function save_to_products(){
		$this->form_validation->set_rules('name', 'Product Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('code', 'Product SKU', 'trim|required|xss_clean');
		$this->form_validation->set_rules('fabric', 'Product Fabric', 'trim|required|xss_clean');
		$this->form_validation->set_rules('color', 'Fabric Color', 'trim|required|xss_clean');
		$this->form_validation->set_rules('price', 'Product Price', 'trim|required|xss_clean|integer');
		$this->form_validation->set_rules('category', 'Product Category', 'trim|required|xss_clean');

		// hold error messages in div
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');


		if($this->form_validation->run() == FALSE)
		{
			$data['name'] = $this->inventory_model->get_product_name();
			//$data['code'] = $this->inventory_model->get_product_code();
			$data['color'] = $this->inventory_model->get_product_color();
			$data['fabric'] = $this->inventory_model->get_product_fabric();
			$data['category'] = $this->inventory_model->get_product_category();
			$data['error'] = validation_errors();
			//fail validation
			$this->load->view('admin/admin_header_view',$this->data);
			$this->load->view('variations/view_add_product',$data);
			$this->load->view('admin/admin_footer_view',$this->data);
		}
		else
		{
			$product_name = $this->input->post('name');
			$product_code = $this->input->post('code');
			$product_fabric = $this->input->post('fabric');
			$product_color = $this->input->post('color');
			$product_price= $this->input->post('price');
			$product_category = $this->input->post('category');
			$product_data = array(
				'product_name' => $product_name,
				'product_code' => $product_code,
				'product_fabric' => $product_fabric,
				'product_color' => $product_color,
				'product_price' => $product_price,
				'product_category' => $product_category,
			);
			$this->db->insert('tbl_product', $product_data);

			$this->session->set_flashdata('item', 'form submitted successfully');
			redirect('inventory/all_products');
		}
	}

	/**
	 * Edit product from a product List
	 */
	function edit_product(){
		$data['name'] = $this->inventory_model->get_product_name();
		$data['code'] = $this->inventory_model->get_product_code();
		$data['color'] = $this->inventory_model->get_product_color();
		$data['fabric'] = $this->inventory_model->get_product_fabric();
		$data['category'] = $this->inventory_model->get_product_category();

		$product_id = $this->uri->segment(3);
		if ($product_id == NULL) {
			redirect('inventory/all_products');
		}

		$dt = $this->inventory_model->edit_product($product_id);
		//var_dump($dt);
		$data['product_id'] = $dt->id;
		$data['product_name'] = $dt->product_name;
		$data['product_code'] = $dt->product_code;
		$data['product_fabric'] = $dt->product_fabric;
		$data['product_color'] = $dt->product_color;
		$data['product_price'] = $dt->product_price;
		$data['product_category'] = $dt->product_category;

		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_edit_product',$data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}

	/**
	 *Update a product from product list
	 */
	function update_product(){
		if ($this->input->post('update')) {
			$productId = $this->input->post('product-id');
			$this->inventory_model->update_product($productId);
			redirect('inventory/all_products');
		} else{
			$id = $this->input->post('product-id');
			redirect('inventory/edit_product/'. $id);
		}
	}

	/**+
	 * @param $product_id
	 * Delete a product from a product List
	 */
	public function delete_product($product_id){
		$this->inventory_model->delete_product($product_id);
		redirect(base_url('inventory/all_products'));
	}

	/**************** Product Category**********************/

	function add_product_category(){
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_add_category');
		$this->load->view('admin/admin_footer_view',$this->data);
	}

	function save_to_product_category(){
		$this->form_validation->set_rules('category', 'Product Category', 'trim|required|xss_clean');

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if($this->form_validation->run() == FALSE)
		{
			$data['error'] = validation_errors();
			//fail validation
			$this->load->view('admin/admin_header_view',$this->data);
			$this->load->view('variations/view_add_category');
			$this->load->view('admin/admin_footer_view',$this->data);
		}
		else
		{
			$product_category = $this->input->post('category');
			$product_data = array(
				'product_category_name' => $product_category,
			);
			$this->db->insert('tbl_product_category', $product_data);
			$this->session->set_flashdata('item', 'Category Saved successfully');
			redirect('inventory/add_product_category');
		}
	}

	function all_categories(){
		$this->data['categories'] = $this->inventory_model->get_all_categories();
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_all_categories',$this->data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}


	function edit_product_category(){

		$category_id = $this->uri->segment(3);
		if ($category_id == NULL) {
			redirect('inventory/all_categories');
		}

		$dt = $this->inventory_model->edit_category($category_id);
		$data['product_category_name'] = $dt->product_category_name;
		$data['category_id'] = $dt->id;

		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_edit_category',$data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}


	function update_product_category(){
		if ($this->input->post('update')) {
			$catId = $this->input->post('category-id');
			$this->inventory_model->update_category($catId);
			redirect('inventory/all_categories');
		} else{
			$id = $this->input->post('category-id');
			redirect('inventory/edit_product_category/'. $id);
		}
	}


	public function delete_product_category($category_id){
		$this->inventory_model->delete_category($category_id);
		redirect(base_url('inventory/all_categories'));
	}

	/**************** Product Name Start**********************/

	function all_product_name(){
		$this->data['product_name'] = $this->inventory_model->get_all_product_name();
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_all_product_name',$this->data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}

	function add_product_name(){
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_add_product_name');
		$this->load->view('admin/admin_footer_view',$this->data);
	}

	function save_to_product_name(){
		$this->form_validation->set_rules('product-name', 'Product Name', 'trim|required|xss_clean');
		// hold error messages in div
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		if($this->form_validation->run() == FALSE)
		{
			$data['error'] = validation_errors();
			//fail validation
			$this->load->view('admin/admin_header_view',$this->data);
			$this->load->view('variations/view_add_product_name');
			$this->load->view('admin/admin_footer_view',$this->data);
		}
		else
		{
			$product_name = $this->input->post('product-name');
			$product_data = array(
				'product_name' => $product_name,
			);
			$this->db->insert('tbl_product_name', $product_data);
			$this->session->set_flashdata('item', 'Name Added Successfully');
			redirect('inventory/all_product_name');
		}
	}

	function edit_product_name(){

		$product_name_id = $this->uri->segment(3);
		if ($product_name_id == NULL) {
			redirect('variations/get_all_product_name');
		}

		$dt = $this->inventory_model->edit_product_name($product_name_id);
		$data['product_name'] = $dt->product_name;
		$data['product_name_id'] = $dt->id;

		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_edit_product_name',$data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}

	function update_product_name(){
		if ($this->input->post('update')) {
			$productNameId = $this->input->post('product-name-id');
			$this->inventory_model->update_product_name($productNameId);
			redirect('inventory/all_product_name');
		} else{
			$id = $this->input->post('product-name-id');
			redirect('inventory/edit_product_name/'. $id);
		}
	}

	public function delete_product_name($product_name_id){
		$this->inventory_model->delete_product_name($product_name_id);
		redirect('inventory/all_product_name');
	}
	/********************Product Name End***************************/

	/********************* Product Code Start***********************/
	function all_product_code(){
		$this->data['product_code'] = $this->inventory_model->get_all_product_code();
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_all_product_code',$this->data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}

	function add_product_code(){
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_add_product_code');
		$this->load->view('admin/admin_footer_view',$this->data);
	}


	function save_to_product_code(){
		$this->form_validation->set_rules('product-code', 'Product Code', 'trim|required|xss_clean');
		// hold error messages in div
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		if($this->form_validation->run() == FALSE)
		{
			$data['error'] = validation_errors();
			//fail validation
			$this->load->view('admin/admin_header_view',$this->data);
			$this->load->view('variations/view_add_product_code');
			$this->load->view('admin/admin_footer_view',$this->data);
		}
		else
		{
			$product_code = $this->input->post('product-code');
			$product_data = array(
				'product_code' => $product_code,
			);
			$this->db->insert('tbl_product_code', $product_data);
			$this->session->set_flashdata('item', 'Code Added successfully');
			redirect('inventory/all_product_code');
		}
	}

	function edit_product_code(){

		$product_code_id = $this->uri->segment(3);
		if ($product_code_id == NULL) {
			redirect('inventory/all_product_code');
		}

		$dt = $this->inventory_model->edit_product_code($product_code_id);
		$data['product_code'] = $dt->product_code;
		$data['product_code_id'] = $dt->id;

		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_edit_product_code',$data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}


	function update_product_code(){
		if ($this->input->post('update')) {
			$productCodeId = $this->input->post('product-code-id');
			$this->inventory_model->update_product_code($productCodeId);
			redirect('inventory/all_product_code');
		} else{
			$id = $this->input->post('product-code-id');
			redirect('inventory/edit_product_code/'. $id);
		}
	}


	public function delete_product_code($product_code_id){
		$this->inventory_model->delete_product_code($product_code_id);
		redirect('inventory/all_product_code');
	}
	/********************Product Code End***************************/

	/********************* Product Color Start***********************/
	function all_product_color(){
		$this->data['product_color'] = $this->inventory_model->get_all_product_color();
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_all_product_color',$this->data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}

	function add_product_color(){
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_add_product_color');
		$this->load->view('admin/admin_footer_view',$this->data);
	}


	function save_to_product_color(){
		$this->form_validation->set_rules('product-color', 'Product Color', 'trim|required|xss_clean');
		// hold error messages in div
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		if($this->form_validation->run() == FALSE)
		{
			$data['error'] = validation_errors();
			//fail validation
			$this->load->view('admin/admin_header_view',$this->data);
			$this->load->view('variations/view_add_product_color');
			$this->load->view('admin/admin_footer_view',$this->data);
		}
		else
		{
			$product_color = $this->input->post('product-color');
			$product_data = array(
				'product_color' => $product_color,
			);
			$this->db->insert('tbl_product_color', $product_data);
			redirect('inventory/all_product_color');
		}
	}

	function edit_product_color(){

		$product_code_id = $this->uri->segment(3);
		if ($product_code_id == NULL) {
			redirect('inventory/all_product_color');
		}

		$dt = $this->inventory_model->edit_product_color($product_code_id);
		$data['product_color'] = $dt->product_color;
		$data['product_color_id'] = $dt->id;

		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_edit_product_color',$data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}


	function update_product_color(){
		if ($this->input->post('update')) {
			$productCodeId = $this->input->post('product-color-id');
			$this->inventory_model->update_product_color($productCodeId);
			redirect('inventory/all_product_color');
		} else{
			$id = $this->input->post('product-color-id');
			redirect('inventory/edit_product_color/'. $id);
		}
	}


	public function delete_product_color($product_color_id){
		$this->inventory_model->delete_product_color($product_color_id);
		redirect('inventory/all_product_color');
	}
	/********************Product Color End***************************/

	/********************* Product Size Start***********************/
	function all_product_size(){
		$this->data['product_size'] = $this->inventory_model->get_all_product_size();
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_all_product_size',$this->data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}

	function add_product_size(){
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_add_product_size');
		$this->load->view('admin/admin_footer_view',$this->data);
	}


	function save_to_product_size(){
		$this->form_validation->set_rules('product-size', 'Product Size', 'trim|required|xss_clean');
		// hold error messages in div
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		if($this->form_validation->run() == FALSE)
		{
			$data['error'] = validation_errors();
			//fail validation
			$this->load->view('admin/admin_header_view',$this->data);
			$this->load->view('variations/view_add_product_size');
			$this->load->view('admin/admin_footer_view',$this->data);
		}
		else
		{
			$product_color = $this->input->post('product-size');
			$product_data = array(
				'product_size' => $product_color,
			);
			$this->db->insert('tbl_product_size', $product_data);
			redirect('variations/all_product_size');
		}
	}

	function edit_product_size(){

		$product_size_id = $this->uri->segment(3);
		if ($product_size_id == NULL) {
			redirect('variations/all_product_size');
		}

		$dt = $this->inventory_model->edit_product_size($product_size_id);
		$data['product_size'] = $dt->product_color;
		$data['product_size_id'] = $dt->id;

		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_edit_product_color',$data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}


	function update_product_size(){
		if ($this->input->post('update')) {
			$productCodeId = $this->input->post('product-size-id');
			$this->inventory_model->update_product_size($productCodeId);
			redirect('variations/all_product_size');
		} else{
			$id = $this->input->post('product-size-id');
			redirect('variations/edit_product_size/'. $id);
		}
	}


	public function delete_product_size($product_size_id){
		$this->inventory_model->delete_product_color($product_size_id);
		redirect('variations/all_product_size');
	}
	/********************Product Size End***************************/

	/********************* Product Fabric Start***********************/
	function all_product_fabric(){
		$this->data['product_fabric'] = $this->inventory_model->get_all_product_fabric();
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_all_product_fabric',$this->data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}

	function add_product_fabric(){
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_add_product_fabric');
		$this->load->view('admin/admin_footer_view',$this->data);
	}


	function save_to_product_fabric(){
		$this->form_validation->set_rules('product-fabric', 'Product Fabric', 'trim|required|xss_clean');
		// hold error messages in div
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');


		if($this->form_validation->run() == FALSE)
		{
			$data['error'] = validation_errors();
			//fail validation
			$this->load->view('admin/admin_header_view',$this->data);
			$this->load->view('variations/view_add_product_fabric');
			$this->load->view('admin/admin_footer_view',$this->data);
		}
		else
		{
			$product_fabric = $this->input->post('product-fabric');
			$product_data = array(
				'product_fabric_name' => $product_fabric,
			);
			$this->db->insert('tbl_product_fabric', $product_data);
			$this->session->set_flashdata('item', 'form submitted successfully');
			redirect('inventory/all_product_fabric');
		}
	}

	function edit_product_fabric(){

		$product_fabric_id = $this->uri->segment(3);
		if ($product_fabric_id == NULL) {
			redirect('inventory/all_product_fabric');
		}

		$dt = $this->inventory_model->edit_product_fabric($product_fabric_id);
		$data['product_fabric'] = $dt->product_fabric_name;
		$data['product_fabric_id'] = $dt->id;

		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('variations/view_edit_product_fabric',$data);
		$this->load->view('admin/admin_footer_view',$this->data);
	}


	function update_product_fabric(){
		if ($this->input->post('update')) {
			$productFabricId = $this->input->post('product-fabric-id');
			$this->inventory_model->update_product_fabric($productFabricId);
			redirect('inventory/all_product_fabric');
		} else{
			$id = $this->input->post('product-fabric-id');
			redirect('inventory/edit_product_fabric/'. $id);
		}
	}


	public function delete_product_fabric($product_fabric_id){
		$this->inventory_model->delete_product_fabric($product_fabric_id);
		redirect('inventory/all_product_fabric');
	}
	/********************Product Color End***************************/

	/****************Inventory*******************/
	/**
	 * Get All Inventory Data
	 */
	function add_to_inventory(){
		//$data['product'] = $this->inventory_model->get_product();
		$this->load->view('admin/admin_header_view',$this->data);
		//$this->load->view('inventory/view_add_product_to_inventory',$data);
		$this->load->view('inventory/view_add_product_to_inventory');
		$this->load->view('admin/admin_footer_view',$this->data);
	}

	function transfer_or_return(){
		//$data['product'] = $this->inventory_model->get_product();
		$this->load->view('admin/admin_header_view',$this->data);
		$this->load->view('inventory/view_transfter_or_return_to_inventory');
		$this->load->view('admin/admin_footer_view',$this->data);
	}

	/**
	 * Save New product to inventory
	 */
	function save_products_to_inventory(){
		$challan_data = array(
			'challan_number'=> $this->input->post('chalan-no'),
			'challan_from'=> $this->input->post('received-from'),
			'challan_date'=> date("Y-m-d"),
			'challan_time'=> date("h:i:sa")
		);
		//echo "-----------Challan Data ----------";
		//var_dump($challan_data);
		//echo "-----------Challan Data ----------";

		$this->db->insert('tbl_challan', $challan_data);
		$challan_id = $this->db->insert_id();

		for($i = 0; $i < count($this->input->post('productcodeid-inventory')); $i++){
			$product_id = $this->input->post('productcodeid-inventory')[$i];
			$product_quantity = $this->input->post('quantity-inventory')[$i];

			//echo "-----------Product Data ----------";
			//echo "-----------Product ID ----------";
			//var_dump($product_id);
			//echo "-----------Product Quantity ----------";
			//var_dump($product_quantity);

			$store_id = $this->session->userdata('user_id');
			$this->db->select('product_id');
			$this->db->from('tbl_inventory');
			$this->db->where('store', $store_id);
			$this->db->where('product_id', $product_id);
			$num_rows = $this->db->count_all_results();

			//If row number is zero then save data to new row
			if($num_rows == NULL || $num_rows == '' ||$num_rows == 0  ) {
				$store_name =  $this->session->userdata('user_id');
				$product_data = array(
					'product_id' => $product_id,
					'product_left' => $product_quantity,
					'challan_no' => $challan_id,
					'store'=> $store_name
				);
				//echo "-----------Product Data----------";
				//var_dump($product_data);
				//echo "-----------Product Data----------";

				$this->db->insert('tbl_inventory', $product_data);
			}

			if($num_rows == 1){
				//Get Existing Left Products
				$product_left = $this->db->select('product_id,product_left')->get_where('tbl_inventory', array('product_id' => $product_id))->row()->product_left;

				//echo "-----------Product Left Before Added----------";
				//var_dump($product_left);

				$product_left = $product_left + $product_quantity;

				//echo "-----------Product Left After Added----------";
				//var_dump($product_left);
				$store_name =  $this->session->userdata('user_id');

				$update_data = array(
					'product_left' => $product_left,
				);
				$this->db->where('product_id', $product_id);
				$this->db->where('store', $store_name);
				$this->db->update('tbl_inventory', $update_data);
			}
			}
		redirect('inventory/index', 'refresh');

	}

	function save_product_transfer_or_received_at_inventory(){
		$challan_data = array(
			'challan_number'=> $this->input->post('chalan-or-inv-no'),
			'challan_from'=> $this->input->post('from-transfer-or-received-inventory'),
			'challan_date'=> date("Y-m-d"),
			'challan_time'=> date("h:i:sa")
		);
		//echo "-----------Challan Data ----------";
		//var_dump($challan_data);
		//echo "-----------Challan Data ----------";

		$this->db->insert('tbl_challan', $challan_data);
		$challan_id = $this->db->insert_id();

		/**
		 * This is for transfer or received
		 */
		$transfer_received_data = array(
			'challan_or_invoice_no'=> $challan_id,
			'product_transfer_or_received'=> $this->input->post('transfer-or-received'),
			'product_id'=> $this->input->post('productcodeid-inventory'),
			'product_quantity'=> $this->input->post('quantity-transfer-or-received-inventory'),
			'product_transfer_or_received_date'=> date("Y-m-d"),
			'product_transfer_or_received_time'=> date("h:i:sa"),
			'store'=>  $this->input->post('storeid'),

		);
		//echo "-----------Challan Data ----------";
		//var_dump($transfer_received_data);
		//echo "-----------Challan Data ----------";

		$this->db->insert('tbl_inventory_transfer_received', $transfer_received_data);


			$product_id = $this->input->post('productcodeid-inventory');
			$product_quantity = $this->input->post('quantity-transfer-or-received-inventory');

			//echo "-----------Product Data ----------";
			//echo "-----------Product ID ----------";
			//var_dump($product_id);
			//echo "-----------Product Quantity ----------";
			//var_dump($product_quantity);

			$store_id = $this->session->userdata('user_id');
			$this->db->select('product_id');
			$this->db->from('tbl_inventory');
			$this->db->where('store', $store_id);
			$this->db->where('product_id', $product_id);
			$num_rows = $this->db->count_all_results();


		/**
		 * If Transfer then minus form inventory
		 * If Recieved then add to inventory
		 */


		//If row number is zero then save data to new row
			if(($num_rows == NULL || $num_rows == '' ||$num_rows == 0) && (($this->input->post('transfer-or-received'))=="Received") ) {
				$store_name =  $this->session->userdata('user_id');
				$product_data = array(
					'product_id' => $product_id,
					'product_left' => $product_quantity,
					'challan_no' => $challan_id,
					'store'=> $store_name
				);
				//echo "-----------Product Data----------";
				//var_dump($product_data);
				//echo "-----------Product Data----------";

				$this->db->insert('tbl_inventory', $product_data);
			}

			if($num_rows == 1){
				//Get Existing Left Products
				$product_left = $this->db->select('product_id,product_left,store')->get_where('tbl_inventory', array('product_id' => $product_id,'store'=> $store_id))->row()->product_left;

				/**
				 *
				 */

				echo "-----------Product Left Before Added----------";
				var_dump($product_left);

				$transfer_or_received = $this->input->post('transfer-or-received');
				if($transfer_or_received == "Transfer"){
					$product_left = $product_left - $product_quantity;
				}else{
					$product_left = $product_left + $product_quantity;
				}


				//echo "-----------Product Left After Added----------";
				//var_dump($product_left);
				$store_id =  $this->session->userdata('user_id');

				$update_data = array(
					'product_left' => $product_left,
					'challan_no' => $challan_id,
				);
				$this->db->where('product_id', $product_id);
				$this->db->where('store', $store_id);
				$this->db->update('tbl_inventory', $update_data);
			}


		redirect('inventory/transfer_or_return', 'refresh');
	}

	/*
	public function c_get_all(){
		$data = $this->inventory_model->all_products();
		echo json_encode($data);
	}


	/****************Invoice***************/
	public function all_invoice_for_admin($offset = 0){
		// Config setup
		$config['base_url'] = base_url().'/inventory/all_invoice/';
		//$config['total_rows']= $this->db->count_all('brand');
		$config['total_rows']= $this->inventory_model->count_all_invoice_for_admin();

		$config['per_page'] = 10;
		// I added this extra one to control the number of links to show up at each page.
		$config['num_links'] = 10;
		/******************************/
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		/******************************/
		// Initialize
		$this->pagination->initialize($config);

		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('login/index', 'refresh');
		} else {
			//$data['total_rows']= $this->inventory_model->count_all_invoice();
			//var_dump($data['total_rows']);
			$user_id = $this->session->userdata('user_id');

			$this->data['invoices'] = $this->inventory_model->get_all_invoice_for_admin(10,$offset);
			$this->data['count_invoice'] = $this->inventory_model->count_all_invoice_for_admin();
			$this->data['total_sold_by']= $this->inventory_model->count_sold_by_seller();
			$this->data['total_sold_amount_by']= $this->inventory_model->count_sold_amount_by_seller();
			//var_dump($this->data['total_sold_by']);

			$this->load->view('admin/admin_header_view',$this->data);
			$this->load->view('inventory/view_all_invoice_for_admin',$this->data);
			$this->load->view('admin/admin_footer_view',$this->data);
		}
	}



	/****************Invoice***************/
	public function all_invoice($offset = 0){
		// Config setup
		$config['base_url'] = base_url().'/inventory/all_invoice/';
		//$config['total_rows']= $this->db->count_all('brand');
		$user_id = $this->session->userdata('user_id');
		$config['total_rows']= $this->inventory_model->count_all_invoice($user_id);

		$config['per_page'] = 10;
		// I added this extra one to control the number of links to show up at each page.
		$config['num_links'] = 10;
		/******************************/
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		/******************************/
		// Initialize
		$this->pagination->initialize($config);

		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('login/index', 'refresh');
		} else {
			//$data['total_rows']= $this->inventory_model->count_all_invoice();
			//var_dump($data['total_rows']);
			$user_id = $this->session->userdata('user_id');

			$this->data['invoices'] = $this->inventory_model->get_all_invoice(10,$offset,$user_id);
			$this->data['count_invoice'] = $this->inventory_model->count_all_invoice($user_id);
			$this->data['total_sold_by']= $this->inventory_model->count_sold_by_seller();
			$this->data['total_sold_amount_by']= $this->inventory_model->count_sold_amount_by_seller();
			//var_dump($this->data['total_sold_by']);

			$this->load->view('admin/admin_header_view',$this->data);
			$this->load->view('inventory/view_all_invoice',$this->data);
			$this->load->view('admin/admin_footer_view',$this->data);
		}
	}
	
	public function all_invoice_by_date($offset = 0){
		// Config setup
		$config['base_url'] = base_url().'/inventory/all_invoice_by_date/';
		//$config['total_rows']= $this->db->count_all('brand');
		$config['total_rows']= $this->inventory_model->count_all_invoice();

		$config['per_page'] = 100;
		// I added this extra one to control the number of links to show up at each page.
		$config['num_links'] = 10;
		/******************************/
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		/******************************/
		// Initialize
		$this->pagination->initialize($config);

		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('login/index', 'refresh');
		} else {
			//$data['total_rows']= $this->inventory_model->count_all_invoice();
			//var_dump($data['total_rows']);
			$date = $this->input->post('date');
			$this->data['show_date'] = $this->input->post('date');

			$this->data['invoices'] = $this->inventory_model->get_all_invoice_by_date(100,$offset, $date);
			//$user_id = $this->session->userdata('user_id');
			$this->data['count_invoice'] = $this->inventory_model->count_all_invoice();
			$this->data['total_sold_by']= $this->inventory_model->count_sold_by_seller();
			//var_dump($this->data['total_sold_by']);

			$this->load->view('admin/admin_header_view',$this->data);
			$this->load->view('inventory/view_all_invoice_by_date',$this->data);
			$this->load->view('admin/admin_footer_view',$this->data);
		}	
	}
	

	function gettotalreportbydate() {
		$this->load->dbutil();
		//get the object

		$date = $this->input->post('datereport');
		if ($date == ''){
			$date = date('Y-m-d');
		}else{
			$date = $this->input->post('datereport');
		}

		$report = $this->inventory_model->gettotalCSVByDate($date);

		$delimiter = ",";
		$newline = "\r\n";
		$new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
		// write file
		write_file($this->file_path . '/csv_file.csv', $new_report);
		//force download from server
		$this->load->helper('download');
		$data = file_get_contents($this->file_path . '/csv_file.csv');
		$name = 'Invoice-by-date-'.$date.'.csv';
		force_download($name, $data);
	}
	
	
	public function all_invoice_daily_summary(){
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('login/index', 'refresh');
		} else {
			$date = $this->input->post('date');
			$this->data['show_date'] = $this->input->post('date');
			$this->data['daily_summary'] = $this->inventory_model->get_daily_summary($date);
			$this->load->view('admin/admin_header_view',$this->data);
			$this->load->view('inventory/view_daily_summary',$this->data);
			$this->load->view('admin/admin_footer_view',$this->data);
		}
	}
	
	
	function get_daily_product_summary(){
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('login/index', 'refresh');
		} else {
			$date = $this->input->post('date');
			$this->data['show_date'] = $this->input->post('date');
			$user_id = $this->session->userdata('user_id');
			$this->data['daily_summary'] = $this->inventory_model->get_daily_product_summary($date,$user_id);
			$this->data['sell_today'] = $this->inventory_model->count_all_sell_today();
			$this->load->view('admin/admin_header_view',$this->data);
			$this->load->view('inventory/view_daily_summary',$this->data);
			$this->load->view('admin/admin_footer_view',$this->data);
		}
	}

	/**
	 * Daily Product Summary for all dates
	 */
	 
	function get_all_daily_product_summary(){
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('login/index', 'refresh');
		} else {
			$this->data['all_daily_summary'] = $this->inventory_model->get_all_daily_product_summary();
			$this->data['total_sold_by']= $this->inventory_model->count_sold_by_seller();
			$this->data['total_sold_amount_by']= $this->inventory_model->count_sold_amount_by_seller();
			$this->load->view('admin/admin_header_view',$this->data);
			$this->load->view('inventory/view_all_daily_summary',$this->data);
			$this->load->view('admin/admin_footer_view',$this->data);
		}
	}


	/**
	 * Get Report in CSV format
	 */
	function getreport() {
		$this->load->dbutil();
		//get the object
		$date = $this->input->post('datereport');
		if ($date == ''){
			$date = date('Y-m-d');
		}else{
			$date = $this->input->post('datereport');
		}
		$user_id = $this->session->userdata('user_id');
		$report = $this->inventory_model->getDailyCSV($date,$user_id);

		$delimiter = ",";
		$newline = "\r\n";
		$new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
		// write file
		write_file($this->file_path . '/csv_file.csv', $new_report);
		//force download from server
		$this->load->helper('download');
		$data = file_get_contents($this->file_path . '/csv_file.csv');
		$name = 'Daily-summary-'.$date.'.csv';
		force_download($name, $data);
	}


	/**
	 * Get Total Report in CSV format
	 */
	function gettotalreport() {
		$this->load->dbutil();
		//get the object
		/*
			$date = $this->input->post('datereport');
			if ($date == ''){
				$date = date('Y-m-d');
			}else{
				$date = $this->input->post('datereport');
			}
		*/
		$user_id = $this->session->userdata('user_id');
		$report = $this->inventory_model->gettotalCSV($user_id);

		$delimiter = ",";
		$newline = "\r\n";
		$new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
		// write file
		write_file($this->file_path . '/csv_file.csv', $new_report);
		//force download from server
		$this->load->helper('download');
		$data = file_get_contents($this->file_path . '/csv_file.csv');
		$name = 'Total-summary-'.date('Y-m-d').'.csv';
		force_download($name, $data);
	}


	/**
	 * Get Total Verbose Report in CSV format
	 */
	function gettotalverbosereport() {
		$this->load->dbutil();
		$user_id = $this->session->userdata('user_id');
		$report = $this->inventory_model->gettotalverboseCSV($user_id);
		$delimiter = ",";
		$newline = "\r\n";
		$new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
		// write file
		write_file($this->file_path . '/csv_file.csv', $new_report);
		//force download from server
		$this->load->helper('download');
		$data = file_get_contents($this->file_path . '/csv_file.csv');
		$name = 'All-Verbose-Data-'.date('d-m-Y').'.csv';
		force_download($name, $data);
	}

	function invno(){
		//Today
		$today = date("dmy");
		$total_invoice = $this->inventory_model->count_all_invoice();
		$leadingzeros = '0000';
		$dailyleadingzeros = '000';
		$total_invoice = $total_invoice + 1;

		//Query for maximum date in orderdails for last order date
		$this->db->select('max(date) as date');
		$this->db->from('tbl_orderdetail');
		$querymaxdate = $this->db->get();

		foreach ($querymaxdate->result() as $row) {
			$lastdate = $row->date;
		}

		//var_dump($lastdate);
		$todaydate = date('Y-m-d');

		$this->db->select('COUNT(date)as date,tbl_product.product_code,tbl_customer.customer_name');
		$this->db->from('tbl_customer');
		$this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
		$this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
		$this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
		$this->db->group_by('invoice_no');
		$this->db->where('date',$todaydate);
		$querytotalselltoday = $this->db->get();

		$total_today = $querytotalselltoday->num_rows();

		if ($querytotalselltoday->num_rows() > 0) {
			if ($todaydate == $lastdate) {
				$total_today = $total_today + 1;
			}else {
				$total_today = 1;
			}

		}else{
			$total_today = 1;
		}

		//Check if there is no invoice in total invoice
		if($total_invoice == 0 ){
			$total_invoice = 1;

			$firstinvoiceno = "SIN-".$today."-1-".substr($leadingzeros, 0, (-strlen($total_invoice))).$total_invoice;
			return $firstinvoiceno;
		}else{
			$total_invoice = $total_invoice;

			$firstinvoiceno = "SIN-".$today."-". substr($dailyleadingzeros, 0, (-strlen($total_today))).$total_today ."-".substr($leadingzeros, 0, (-strlen($total_invoice))).$total_invoice;
			return $firstinvoiceno;
		}
	}

	/**
	 * @return string
	 */
	function invno_outlet(){

		$today = date("dmy");
		$store_id = $this->session->userdata('user_id');
		$total_invoice = $this->inventory_model->count_all_outlet_invoice($store_id);

		echo "Total Invoice: ";
		var_dump($total_invoice);

		$leadingzeros = '0000';
		$dailyleadingzeros = '000';
		$total_invoice = $total_invoice + 1;

		//Query for maximum date in orderdails for last order date
		$this->db->select('max(date) as date');
		$this->db->from('tbl_orderdetail');
		$querymaxdate = $this->db->get();

		foreach ($querymaxdate->result() as $row) {
			$lastdate = $row->date;
		}

		//var_dump($lastdate);
		$todaydate = date('Y-m-d');

		$this->db->select('COUNT(date)as date,tbl_product.product_code,tbl_customer.customer_name,tbl_customer.sell_by,store_id');
		$this->db->from('tbl_customer');
		$this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
		$this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
		$this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
		$this->db->where('store_id',$store_id);
		$this->db->where('date',$todaydate);
		$this->db->group_by('invoice_no');

		$querytotalselltoday = $this->db->get();

		$total_today = $querytotalselltoday->num_rows();

		if ($querytotalselltoday->num_rows() > 0) {
			if ($todaydate == $lastdate) {
				$total_today = $total_today + 1;
			}else {
				$total_today = 1;
			}

		}else{
			$total_today = 1;
		}

		//Check if there is no invoice in total invoice
		//Today
		//Get username and changed based on username like if outlet1 it will change to OT1 and if Outlet2 it will change to OT2
		//And for Online sell it will be OL
		$username = $this->session->userdata('username');
		switch ($username) {
			case "online":
				$username = "OL";
				break;
			case "outlet1":
				$username = "OT1";
				break;
			case "outlet2":
				$username = "OT2";
				break;
			case "outlet3":
				$username = "OT3";
				break;
			default:
				$username = "OL";
		}


		if($total_invoice == 0 ){
			$total_invoice = 1;

			$firstinvoiceno = "SIN-". $username . $today."-1-".substr($leadingzeros, 0, (-strlen($total_invoice))).$total_invoice;
			return $firstinvoiceno;
		}else{
			$total_invoice = $total_invoice;

			$firstinvoiceno = "SIN-". $username ."-".$today."-". substr($dailyleadingzeros, 0, (-strlen($total_today))).$total_today ."-".substr($leadingzeros, 0, (-strlen($total_invoice))).$total_invoice;
			return $firstinvoiceno;
		}
	}


	public function invoice(){
		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('login/index', 'refresh');
		} else {
			//$data['invoiceno'] = $this->invoice_number();
			//$data['invoiceno'] = $this->invno();

			$data['invoiceno'] = $this->invno_outlet();

			//var_dump($data['invoiceno']);
			//$data['product'] = $this->inventory_model->get_product_code();
			//$data['sells_person_drop_down'] = $this->inventory_model->get_sells_person();
			//$data['products_codes'] = $this->inventory_model->get_product_code();

			//$data['products'] = $this->inventory_model->all_products();

			$this->load->view('admin/admin_header_view', $this->data);
			//$this->load->view('inventory/view_invoice', $data);
			$this->load->view('inventory/view_invoice_with_autocomplete', $data);
			$this->load->view('admin/admin_footer_view', $this->data);
		}
	}

/**
	 * Show Product From Inventory in Invoice
	 * If there are no product in inventory then product will now show in invoice
	 */

	public function show_product_from_inventory_in_invoice(){
		// process posted form data
		$keyword = $this->input->post('term');
		$user_id = $this->session->userdata('user_id');
		$query = $this->inventory_model->get_product_from_inventory($keyword,$user_id); //Search DB
		if( ! empty($query) )
		{
			foreach( $query as $row )
			{
				$data[] = array(
					'value' => $row->product_code,
					'id'=>$row->id,
					'price'=>$row->product_price
				);  //Add a row to array
			}
		}
			echo json_encode($data); //echo json string if ajax request

	}

	/**
	 * Get Products From All Products in Inventory when add product in the Inventory
	 * All Product will show there
	 */

	public function show_product_from_products_in_inventory(){
		// process posted form data
		$keyword = $this->input->post('term');
		$query = $this->inventory_model->get_product_from_all_products($keyword); //Search DB
		if( ! empty($query) )
		{
			foreach( $query as $row )
			{
				$data[] = array(
					'value' => $row->product_code,
					'id'=>$row->id
				);
			}
		}
			echo json_encode($data); //echo json string if ajax request
	}




	function save_invoice(){
		$customer_data = array(
			'customer_name' => $this->input->post('name'),
			'customer_phone' => $this->input->post('phone'),
			'customer_email' => $this->input->post('email'),
			'customer_address' => $this->input->post('address'),
			'sell_by' => $this->input->post('sellsperson'),
		);
		$this->db->insert('tbl_customer', $customer_data);
		$customer_id = $this->db->insert_id();

		for ($i = 0; $i < count($this->input->post('productcode')); $i++){
			//$store_id = $this->session->userdata('user_id');
			//var_dump($store_id);

			$sold_by = $this->input->post('sellsperson');


			$product_id = $this->input->post('productcodeid')[$i];
			$product_quantity = $this->input->post('quantity')[$i];
			$inventory  = $this->inventory_model->get_left_product_on_inventory($product_id,$sold_by);

			echo "Product id: ";
			var_dump($product_id)[$i];

			echo "Product Quantity: ";
			var_dump($product_quantity)[$i];

			echo "Inventory ";
			var_dump($inventory)[$i];



			foreach($inventory as $inventory){
				$product_left = $inventory->product_left;
				$product_sold = $inventory->product_sold;
			}

			$final_product_left = $product_left - $product_quantity;
			$final_product_sold = $product_sold + $product_quantity;

			echo "Product Left: ";
			var_dump($final_product_left);

			echo "Product Sold: ";
			var_dump($final_product_sold);


			$inventory_detail = array(
				'product_left' => $final_product_left,
				'product_sold' => $final_product_sold
			);

			echo "Inventory Array: ";
			var_dump($inventory_detail);

			$this->db->where('product_id',$product_id);
			$this->db->where('store',$sold_by);
			$this->db->update('tbl_inventory', $inventory_detail);


				$order_detail = array(
					'invoice_no' => $this->input->post('invoice-no'),
					'booking_code' => $this->input->post('booking-code'),
					'product_code' => $this->input->post('productcodeid')[$i],
					'quantity' => $this->input->post('quantity')[$i],
					'price' => $this->input->post('price')[$i],
					'discount' => $this->input->post('discount')[$i],
					'discount_amount' => $this->input->post('discountamount')[$i],
					'amount' => $this->input->post('amount')[$i],
					'delivery_charge' => $this->input->post('deliverycharge'),
					'date' => date("Y-m-d"),
				);

				echo "Order Details: ";
				var_dump($order_detail);

				$this->db->insert('tbl_orderdetail', $order_detail);
				$order_id = $this->db->insert_id();

				$order_data = array(
					'order_id' => $order_id,
					'customer_id' => $customer_id,
					'store_id' => $sold_by
				);

				$this->db->insert('tbl_order', $order_data);
			}
		redirect('inventory/invoice', 'refresh');

	}
	
	function print_later_from_invoice_data()
	{
		$customer_id = $this->uri->segment(3);
		if ($customer_id == NULL) {
			redirect('inventory/all_invoice_by_date');
		}


		//PDF output
		$this->fpdf->SetTitle("ICS - PDF Output");
		//Set Font for Header

		$this->fpdf->Ln(15);
		$this->fpdf->setFont('Arial', '', 30);
		$this->fpdf->setFillColor(255, 255, 255);
		//$this->fpdf->cell(200,0,"SIMURA",0,0,'C',1);
		//$this->fpdf->cell(100,6,' ',0,1,'C',1);

		$this->fpdf->Image(base_url('assets/images/simura.png'), 10, 15, 40);
		$this->fpdf->Cell(35);
		$this->fpdf->cell(100, 5, ' ', 0, 1, 'C', 1);
		$this->fpdf->SetFontSize(15);
		$this->fpdf->SetFillColor(131, 173, 246);
		$this->fpdf->cell(90, 6, "Invoice", 0, 0, 'R', 1);


		$this->db->select("tbl_customer.id,
							 DATE_FORMAT(tbl_orderdetail.date,'%d/%m/%Y') AS date ,
							 tbl_orderdetail.invoice_no,
							 tbl_customer.customer_name,
							 tbl_customer.customer_phone,
							 tbl_customer.customer_email,
							 tbl_customer.customer_address,
							 tbl_product.product_code,
							 tbl_orderdetail.quantity,
							 tbl_orderdetail.price,
							 tbl_orderdetail.discount,
							 tbl_orderdetail.discount_amount,
							 tbl_orderdetail.amount");
		$this->db->from("tbl_customer");
		$this->db->join("tbl_order", "tbl_order.customer_id = tbl_customer.id");
		$this->db->join("tbl_orderdetail", "tbl_order.order_id = tbl_orderdetail.id");
		$this->db->join("tbl_product", "tbl_product.id = tbl_orderdetail.product_code");
		$this->db->where("tbl_customer.id", $customer_id);
		$this->db->limit(1);
		$query = $this->db->get('');
		$result = $query->result();

		foreach ($result as $row) {


		$this->fpdf->cell(100, 6, ' ', 0, 1, 'L', 1);
		$this->fpdf->setFont('Arial', '', 10);
		$this->fpdf->setFillColor(255, 255, 255);
		$this->fpdf->cell(64.5, 6, "Name: " . $row->customer_name , 0, 0, 'L', 1);
		$this->fpdf->cell(90, 6, "Date : " . $row->date, 0, 1, 'R', 1);

		$this->fpdf->cell(50, 6, "Phone: " . $row->customer_phone, 0, 0, 'L', 1);
		$this->fpdf->cell(138, 6, "Invoice No. : " . $row->invoice_no, 0, 1, 'R', 1);

		$this->fpdf->cell(100, 6, "Email : " . $row->customer_email, 0, 0, 'L', 1);

		$this->fpdf->cell(50, 6, ' ', 0, 1, 'C', 1);
		$this->fpdf->cell(138, 6, "Address : " . $row->customer_address, 0, 0, 'L', 1);
		$this->fpdf->Ln(12);
		$this->fpdf->setFont('Arial', '', 14);
		$this->fpdf->setFillColor(255, 255, 255);
		$this->fpdf->cell(25, 6, '', 0, 0, 'C', 0);

		$this->fpdf->Ln(1);
		$this->fpdf->setFont('Arial', '', 10);
		$this->fpdf->SetFillColor(200, 220, 255);
	}
		/**
		 * Content
		 *
		 */

		$this->fpdf->cell(10,6,'#',1,0,'C',1);
		$this->fpdf->cell(85,6,'Product ID',1,0,'C',1);
		$this->fpdf->cell(25,6,'Quantity',1,0,'C',1);
		$this->fpdf->cell(30,6,'Unit Price',1,0,'C',1);
		//$this->fpdf->cell(25,6,'Discount (%)',1,0,'C',1);
		//$this->fpdf->cell(35,6,'Discount (BDT)',1,0,'C',1);
		$this->fpdf->cell(40,6,'Total (bdt)',1,0,'C',1);


		/**
		 * SQL
		 */

		$this->db->select('*');
		$this->db->from('tbl_customer');
		$this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
		$this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
		$this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
		$this->db->where('customer_id',$customer_id);
		$query = $this->db->get('');
		$result = $query->result();
		//var_dump($result);
		//
		$id = 0;
		foreach($result as $row) {

			$id++;
			$this->fpdf->Ln(6);
			$this->fpdf->cell(10,6,$id,1,0,1);

			$this->fpdf->cell(85,6,$row->product_code,1,0,1);
			$this->fpdf->cell(25,6,$row->quantity,1,0,1);
			$this->fpdf->cell(30,6,$row->price,1,0,1);
			//$this->fpdf->cell(25,6,$row->discount.'%',1,0,1);
			//$this->fpdf->cell(35,6,$row->discount_amount,1,0,1);
			$this->fpdf->cell(40,6,$row->amount,1,0,'R',1);
		}


		$this->db->select('delivery_charge, SUM(amount) AS subtotal, SUM(discount_amount) AS totaldiscount');
		$this->db->from('tbl_customer');
		$this->db->join('tbl_order','tbl_order.customer_id = tbl_customer.id');
		$this->db->join('tbl_orderdetail','tbl_order.order_id = tbl_orderdetail.id');
		$this->db->join('tbl_product','tbl_product.id = tbl_orderdetail.product_code');
		$this->db->where('customer_id',$customer_id);
		$query = $this->db->get('');

		$result = $query->result();
		foreach($result as $row) {

			$this->fpdf->Ln(6);
			$this->fpdf->Cell(120);
			$this->fpdf->cell(30, 6, 'Subtotal', 1, 0, 1);
			$this->fpdf->cell(40, 6, $row->subtotal, 1,0,'R',1);
			$this->fpdf->Ln(6);
			$this->fpdf->Cell(120);
			$this->fpdf->cell(30, 6, 'Discount', 1, 0, 1);
			$this->fpdf->cell(40, 6, $row->totaldiscount, 1, 0,'R',1);
			$this->fpdf->Ln(6);
			$this->fpdf->Cell(120);
			$this->fpdf->cell(30, 6, 'Delivery Charge', 1, 0, 1);
			$this->fpdf->cell(40, 6, $row->delivery_charge, 1, 0,'R',1);
			$this->fpdf->Ln(6);
			$this->fpdf->Cell(120);
			$this->fpdf->cell(30, 6, 'Grand Total', 1, 0, 1);
			$this->fpdf->cell(40, 6, (($row->subtotal - $row->totaldiscount) + $row->delivery_charge ).".00", 1, 0,'R',1);
		}

		$this->fpdf->Ln(20);
		//$this->fpdf->Cell(10);
		//$this->fpdf->Cell(0,10,'In Word: '.$this->input->post('inword'),0,0,'L');
		$this->fpdf->SetY(-30);
		$this->fpdf->SetLineWidth(0.1);
		$this->fpdf->SetDash(0,0); //5mm on, 5mm off
		$this->fpdf->Line(250, 265, 0, 265);
		//$this->fpdf->SetY(-80);
		$this->fpdf->Image(base_url('assets/images/simura-ddress.png'),30,270,150);

		//Open PDF on same page
		$this->fpdf->Output("Invoice.pdf", "I");
	}

}

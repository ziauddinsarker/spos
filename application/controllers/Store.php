 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->model('admin_model');
        $this->load->model('user_model');
        $this->load->model('inventory_model');
        $this->load->model('store_model');
        //$this->load->library('breadcrumb');
		$this->load->library(array('ion_auth','form_validation'));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->data['total_invoice_today']= $this->inventory_model->count_daily_invoice();
        $this->data['total_rows']= $this->inventory_model->count_all_invoice();
    }

    /**
     * Index
     * Check if user is logged in. If logged in then allow to see the admin page
     */
    public function index()
    {
        //Check if user is logged in or not. If not then else statement works otherwise redirect to login page
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('login/index', 'refresh');
        } else {
            //Get the group name
            $group = $this->ion_auth->get_users_groups()->row()->name;
            //If user is logged int then show the admin page. Admin page is not accessiable  if not logged in.

            $this->load->view('admin/admin_header_view', $this->data);
            $this->load->view('admin/admin_home_view', $this->data);

            if(!($group == 'admin' || $group == 'sales')) {
            }else{
                //$this->load->view('admin/admin_todo', $this->data);
                //$this->load->view('admin/admin_chart', $this->data);
            }

            //var_dump($group);

            $this->load->view('admin/admin_footer_view');

        }
    }


    /**
     * Show  Add New Product Page
     */
    function add_store(){
        $this->load->view('admin/admin_header_view',$this->data);
        $this->load->view('store/view_add_store');
        $this->load->view('admin/admin_footer_view',$this->data);
    }

    /**
     * Save Product from Add New Product Page
     */
    function save_to_stores(){
        $this->form_validation->set_rules('store-name', 'Store Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('store-address', 'Store Address', 'trim|required|xss_clean');

        // hold error messages in div
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');


        if($this->form_validation->run() == FALSE)
        {
            $data['error'] = validation_errors();
            //fail validation
            $this->load->view('admin/admin_header_view',$this->data);
            $this->load->view('store/view_add_store',$data);
            $this->load->view('admin/admin_footer_view',$this->data);
        }
        else
        {
            $store_name = $this->input->post('store-name');
            $store_address = $this->input->post('store-address');
            $store_data = array(
                'store_name' => $store_name,
                'store_address' => $store_address,
            );
            $this->db->insert('tbl_store', $store_data);

            $this->session->set_flashdata('store', 'Store Added Successfully');
            redirect('store/add_store');
        }
    }

    /**
     * Show  Add New Product Page
     */
    function add_sales_person(){
        $data['store'] = $this->store_model->get_store_name();
        $data['users'] = $this->store_model->get_user_name();
        $this->load->view('admin/admin_header_view',$this->data);
        $this->load->view('store/view_add_sales_person',$data);
        $this->load->view('admin/admin_footer_view',$this->data);
    }

    /**
     * Save Product from Add New Product Page
     */
    function save_to_sales_person(){
        $this->form_validation->set_rules('store-name', 'Store Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('user-name', 'User Name', 'trim|required|xss_clean');

        // hold error messages in div
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');


        if($this->form_validation->run() == FALSE)
        {
            $data['error'] = validation_errors();
            $data['store'] = $this->store_model->get_store_name();
            $data['users'] = $this->store_model->get_user_name();
            //fail validation
            $this->load->view('admin/admin_header_view',$this->data);
            $this->load->view('store/view_add_sales_person',$data);
            $this->load->view('admin/admin_footer_view',$this->data);
        }
        else
        {
            $sales_person_name = $this->input->post('user-name');
            $store_name = $this->input->post('store-name');
            $user_store_data = array(
                'user_id' => $sales_person_name,
                'store_id' => $store_name,
            );
            $this->db->insert('users_stores', $user_store_data);

            $this->session->set_flashdata('store', 'Sales Person Added Successfully');
            redirect('store/add_sales_person');
        }
    }


}
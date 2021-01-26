<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller{
	private $admin_data;

	public function __construct(){
		parent::__construct();
		$this->is_admin();
		$this->load->model('admin');
		$this->admin_data = $this->session->userdata();
		$this->can(9);
		$this->load->model('order');

	}

	public function index(){
		$head_data = [
			'title'	=> '訂單管理'
		];
		$view_data = [];
		$foot_data = [];

		$this->load->helper('text');
		$view_data['orders'] = $this->order->select_all();
        $head_data['links'][] = 'https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css';
        $foot_data['scripts'][] = 'https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js';
        $foot_data['scripts'][] = base_url('assets/js/datatable.js');
        $foot_data['scripts'][] = base_url('assets/js/order_index.js');


		$this->render('admin/order/index',$head_data,$view_data,$foot_data);
	}

	public function delete(){
		$where_data = [
			'id'	=> $this->input->post('id')
		];
		$result = $this->order->delete($where_data);
		if($result){
			return redirect(base_url('admin/orders'));
		}else{
			show_404();
		}		
	}

    private function can($id){

        if(!in_array($id,$this->admin->permissions(array('admin_id' => $this->admin_data['admin_id'])))){
            return redirect(base_url('admins'));
        }
    }

    private function is_admin(){
        if(!isset($_SESSION['admin_login']) || !$_SESSION['admin_login']){
            return redirect(base_url('admins/login'));
        }
    }

    private function render($page,$head=[],$view=[],$foot=[]){
    	$head['admin'] = $this->admin_data;
    	$head['permissions'] = $this->admin->permissions(array('admin_id'=>$this->admin_data['admin_id']));

    	$this->load->view('admin/layouts/header',$head);
    	$this->load->view($page,$view);
    	$this->load->view('admin/layouts/footer',$foot);
    }
}
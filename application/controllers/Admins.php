<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends CI_Controller {
    private $admin_data;

    public function __construct()
    {
            parent::__construct();
            $this->load->model('admin');
            $this->admin_data = $this->session->userdata();

    }

    public function login(){
        $this->is_login();
        // $head_data = [
        //     'title' => '管理員登入',
        //     ];
        $view_data = [];


        $this->load->library('form_validation');

        $this->form_validation
                    ->set_rules('username','帳號','trim|required|min_length[6]')
                    ->set_rules('password','密碼','trim|required|min_length[6]');

        if($this->form_validation->run()){
            $where_data = [
                'username'        => $this->input->post('username'),
                'password'        => md5(sha1($this->input->post('password'))),  
            ];
            $admin = $this->admin->select($where_data);
            if(is_object($admin)){
                $admin_login = [
                    'admin_login'   => true,
                    'admin_name'    => $admin->name,
                    'admin_id'      => $admin->id,
                    'admin_username'=> $admin->username
                ];
                $this->session->set_userdata($admin_login);
                return redirect(base_url('/admins'));
            }else{
                $view_data['login_error'] = "帳號或密碼錯誤!"; 
            }
        }
        $view_data['errors'] = $this->form_validation->error_array(); 
        // $this->render('admin/auth/login',$head_data,$view_data);
        $this->load->view('admin/auth/login',$view_data);
    }

    public function index(){
        $this->is_admin();
        $head_data = [
            'title' => '商品管理',
        ];
        $view_data = [];
        $foot_data = [];
        $head_data['links'][] = 'https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css';
        $foot_data['scripts'][] = 'https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js';
        $foot_data['scripts'][] = base_url('assets/js/datatable.js');
        $this->load->model(['product','type']);
        $this->load->helper('text');

        $products = $this->product->total();
        $view_data['products'] = $products;
        $types = $this->type->select_all();
        $view_data['types'] = $types;
       
        $this->render('admin/products/index',$head_data,$view_data,$foot_data);
    }



    public function logout(){
        $admin = [
            'admin_login','admin_name','admin_id','admin_username'
        ];
        $this->session->unset_userdata($admin);
        return redirect(base_url('admins/login'));
    }



    private function render($page,$head=[],$view=[],$foot=[]){
        $head['admin'] = $this->admin_data;
        $head['permissions'] = $this->admin->permissions(array('admin_id' => $this->admin_data['admin_id']));


    	$this->load->view('admin/layouts/header',$head);
    	$this->load->view($page,$view);
    	$this->load->view('admin/layouts/footer',$foot);
    }

    private function is_login(){
        if($this->session->has_userdata('admin_login') && $this->session->admin_login){
            return redirect(base_url('/admins'));
        }
    }

    private function is_admin(){
        if(!$this->session->has_userdata('admin_login') || !$this->session->admin_login){
            return redirect(base_url('admins/login'));
        }
    }
}

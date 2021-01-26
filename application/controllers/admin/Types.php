<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Types extends CI_Controller {
    private $admin_data; 
    public function __construct()
    {
            parent::__construct();
            $this->is_admin();
            $this->load->model('type');
            $this->load->model('admin');

            $this->admin_data = $this->session->userdata();
            $this->can('8');
    }

    public function index(){
        // $this->can('2');
        $head_data = [
            'title'  => '類別管理'
        ];
        $view_data = [];
        $foot_data = [];
        $head_data['links'][] = 'https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css';
        $foot_data['scripts'][] = 'https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js';
        $foot_data['scripts'][] = base_url('assets/js/datatable.js');
        $this->load->helper('text');

        $types = $this->type->select_all();
        $view_data['types'] = $types;

        $this->render('admin/type/index',$head_data,$view_data,$foot_data);
    }

    public function add(){

    	$view_data = [];
    	$head_data = [
    		'title' => '新增類型'
    	];
        $foot_data = [];
    	$this->load->library('form_validation');
		
		$this->form_validation
			->set_rules('name','類別名稱','required|min_length[3]');
		if($this->form_validation->run()){
			$insert_data = [
				'name' => $this->input->post('name'),
			];
			$new_id = $this->type->insert($insert_data);
            if($new_id){
                $view_data['success'] = '新增成功!';
            }else{
                $view_data['error'] = '新增失敗!';
            }
		}

		$this->render('admin/type/add',$head_data,$view_data,$foot_data);
    }

    public function edit($id){
        $head_data = [
            'title' => '修改類別'
        ];
        $view_data = [];
        $foot_data = [];
        $this->load->library('form_validation');


        $this->form_validation->set_rules('name','類別名稱','required|min_length[3]');
        if($this->form_validation->run()){
            $where_data = [
                'id'    => $id
            ];
            $update_data = [
                'name'  => $this->input->post('name')
            ];
            $result = $this->type->update($where_data,$update_data);
            if($result){
                $view_data['success'] = '修改成功!';
            }else{
                $view_data['error'] = '修改失敗!';
            }
        }

        $type = $this->type->select($id);
        $view_data['type'] = $type;
        
        $this->render('admin/type/edit',$head_data,$view_data,$foot_data);

    }

    public function delete(){
        $where_data = [
            'id'    => $this->input->post('id')
        ];
        $result = $this->type->delete($where_data);
        if(!$result){
            $this->session->set_flashdata('delete_error','查無此類別');
        }
        return redirect('admin/types');
    }

    private function is_admin(){
        if(!$this->session->has_userdata('admin_login') || !$this->session->admin_login){
            return redirect(base_url('admins/login'));
        }
    }

    private function can($id){
        if(!in_array($id,$this->admin->permissions(array('admin_id' => $this->admin_data['admin_id'])))){
            return redirect(base_url('admins'));
        }
    }


    private function render($page,$head,$view,$foot){
        $head['admin'] = $this->admin_data;
        $head['permissions'] = $this->admin->permissions(array('admin_id' => $this->admin_data['admin_id']));


    	$this->load->view('admin/layouts/header',$head);
    	$this->load->view($page,$view);
    	$this->load->view('admin/layouts/footer',$foot);
    }
}

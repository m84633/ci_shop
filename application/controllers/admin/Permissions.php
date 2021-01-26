<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends CI_Controller {
    private $admin_data;

    public function __construct()
    {
            parent::__construct();
            $this->is_admin();
            $this->load->model('permission');
            $this->load->model('admin');
            $this->admin_data = $this->session->userdata();
            $this->can('10');
    }


    public function index(){
        $head_data = [
            'title' => '權限管理'
        ];
        $view_data = [];
        $foot_data = [];
        $this->load->helper('text');

        $head_data['links'][] = 'https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css';
        $foot_data['scripts'][] = 'https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js';
        $foot_data['scripts'][] = base_url('assets/js/datatable.js'); 

        $permissions = $this->permission->select_all();
        $view_data['permissions'] = $permissions;

        $this->render('admin/permission/index',$head_data,$view_data,$foot_data);
    }

    public function add(){
        $head_data = [
            'title' => '新增權限'
        ];
        $view_data = [];
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name','權限名稱','trim|required')
                            ->set_rules('for','權限類型','trim|required');
        if($this->form_validation->run()){
            $insert_data = [
                'name'      => $this->input->post('name'),
                'for'     => $this->input->post('for'),
            ];
            $new_id = $this->permission->insert($insert_data);
            return redirect(base_url('admin/permissions'));
        }

        $this->render('admin/permission/add',$head_data,$view_data);
    }

    public function edit($id){
        $head_data = [
            'title' => '修改權限'
        ];
        $view_data = [];

        $where = [
            'id'    => $id
        ];

        $this->load->library('form_validation');
        $this->form_validation
                ->set_rules('name','權限名稱','trim|required')
                ->set_rules('for','類型','trim|required');

        if($this->form_validation->run()){
            $where_data = [
                'id' => $id
            ];
            $update_data = [
                'name'  => $this->input->post('name'),
                'for'   => $this->input->post('for')
            ];
            $update_result = $this->permission->update($where_data,$update_data);
            if($update_result){
                $view_data['success'] = '修改成功';
            }
        }
        $permission = $this->permission->select($where);
        if(is_object($permission)){
            $view_data['permission'] = $permission;
        }else{
            show_404();
        }

        $this->render('admin/permission/edit',$head_data,$view_data);
    }

    public function delete(){
        $where_data = [
            'id'    => $this->input->post('id')
        ];
        $result = $this->permission->delete($where_data);
        if(!$result){
            $this->session->set_flashdata('delete_error','查無此筆資料');
        }
        return redirect(base_url('admin/permissions'));
    }

    private function do_upload($user_id)
    {
            if(!is_dir('./uploads/'.$user_id)){
                mkdir('./uploads/'.$user_id,0777,true);
            }

            $config = [
                'upload_path'   => './uploads/'.$user_id,
                'allowed_types' => 'gif|jpg|png',
                'max_size'      => 1024,
                'encrypt_name'  => true
            ];


            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('avatar'))
            {
                   return  array('error' => $this->upload->display_errors($this->config->item('error_prefix'),$this->config->item('error_suffix')));
            }
            else
            {
                    return array('success' => $this->upload->data('file_name'));
            }
    }

    private function can($id){
        if(!in_array($id,$this->admin->permissions(array('admin_id' => $this->admin_data['admin_id'])))){
            return redirect(base_url('admins'));
        }
    }

    private function is_admin(){
        if(!$this->session->has_userdata('admin_login') || !$this->session->admin_login){
            return redirect(base_url('admins/login'));
        }
    }

    private function render($page,$head=[],$view=[],$foot=[]){
        $head['admin'] = $this->admin_data;
        $head['permissions'] = $this->admin->permissions(array('admin_id' => $this->admin_data['admin_id']));


    	$this->load->view('admin/layouts/header',$head);
    	$this->load->view($page,$view);
    	$this->load->view('admin/layouts/footer',$foot);
    }
}

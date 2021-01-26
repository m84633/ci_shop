<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {
    private $admin_data;

    public function __construct()
    {
            parent::__construct();
            $this->is_admin();
            $this->load->model('role');
            $this->load->model('permission');
            $this->load->model('permission_role');
            $this->load->model('admin');

            $this->admin_data = $this->session->userdata();
            $this->can('12');
    }


    public function index(){
        $head_data = [
            'title' => '角色管理'
        ];
        $view_data = [];
        $foot_data = [];
        $this->load->helper('text');

        $head_data['links'][] = 'https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css';
        $foot_data['scripts'][] = 'https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js';
        $foot_data['scripts'][] = base_url('assets/js/datatable.js'); 

        $roles = $this->role->select_all();
        $view_data['roles'] = $roles;

        $this->render('admin/role/index',$head_data,$view_data,$foot_data);
    }

    public function add(){
        $head_data = [
            'title' => '新增角色'
        ];
        $view_data = [];
        $this->load->library('form_validation');
       
        $permissions = $this->permission->select_all();
        $view_data['permissions'] = $permissions;


        $this->form_validation->set_rules('name','權限名稱','trim|required');
        if($this->form_validation->run()){
            $insert_data = [
                'name'      => $this->input->post('name'),
            ];
            $new_id = $this->role->insert($insert_data);
            //增加關聯至permissions_roles
            foreach($this->input->post('permissions') as $permission){
                $insert_data = [
                    'permission_id' => $permission,
                    'role_id'       => $new_id
                ];
                $this->permission_role->insert($insert_data);
            }
            return redirect(base_url('admin/roles'));
        }

        $this->render('admin/role/add',$head_data,$view_data);
    }

    public function edit($id){
        $head_data = [
            'title' => '修改角色'
        ];
        $view_data = [];

        $where = [
            'id'    => $id
        ];

        $this->load->library('form_validation');
        $this->form_validation
                ->set_rules('name','權限名稱','trim|required');

        if($this->form_validation->run()){
            $update_data = [
                'name'  => $this->input->post('name'),
            ];
            $where_data = [
                'id'    => $id
            ];
            $update_result = $this->role->update($where_data,$update_data);
            //刪掉以前的
            $this->permission_role->delete(array('role_id' => $id));
            //更新permissions_roles
            if($this->input->post('permissions')){
                foreach($this->input->post('permissions') as $permission){
                    $insert_data = [
                        'permission_id' => $permission,
                        'role_id'       => $id
                    ];
                    $permission_role_result = $this->permission_role->insert($insert_data);
                }
            }
            if($update_result || isset($permission_role_result)){
                $view_data['success'] = '修改成功';
            }
        }
        $view_data['role'] = $this->role->select($where);
        $view_data['has_permissions'] = $this->permission_role->select_all(array('role_id' => $id));
        $view_data['permissions'] = $this->permission->select_all();
        if(!is_object($view_data['role'])){
            show_404();
        }

        $this->render('admin/role/edit',$head_data,$view_data);
    }

    public function delete(){
        $where_data = [
            'id'    => $this->input->post('id')
        ];
        $result = $this->role->delete($where_data);
        if(!$result){
            $this->session->set_flashdata('delete_error','查無此筆資料');
        }
        return redirect(base_url('admin/roles'));
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

    private function render($page,$head=[],$view=[],$foot=[]){
        $head['admin'] = $this->admin_data;
        $head['permissions'] = $this->admin->permissions(array('admin_id' => $this->admin_data['admin_id']));


    	$this->load->view('admin/layouts/header',$head);
    	$this->load->view($page,$view);
    	$this->load->view('admin/layouts/footer',$foot);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Managers extends CI_Controller {
    private $admin_data;

    public function __construct()
    {
            parent::__construct();
            $this->is_admin();
            $this->admin_data = $this->session->userdata();
            $this->load->model('admin');
            $this->load->model('role');
            $this->load->model('admin_role');
            $this->can('7');
    }



    public function index(){
        $this->load->helper('text');
        $head_data = [
            'title' => '成員管理',
        ];
        $view_data = [];
        $foot_data = [];
        $head_data['links'][] = 'https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css';
        $foot_data['scripts'][] = 'https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js';
        $foot_data['scripts'][] = base_url('assets/js/datatable.js');

        // $admins = $this->admin->select_all();
        $view_data['admins'] = $this->admin->get_roles();


       
        $this->render('admin/index',$head_data,$view_data,$foot_data);
    }

    public function add(){
        $head_data = [
            'title' => '新增管理者'
        ];
        $view_data = [];
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username','帳號','required|trim|alpha_numeric')
                            ->set_rules('name','名稱','trim|required')
                            ->set_rules('password','密碼','trim|alpha_numeric|required')
                            ->set_rules('roles[]','角色','required');
        if($this->form_validation->run()){
            $insert_data = [
                'username'  => $this->input->post('username'),
                'name'      => $this->input->post('name'),
                'password'  => md5(sha1($this->input->post('password'))),
            ];
            $new_id = $this->admin->insert($insert_data);
            foreach($this->input->post('roles') as $role){
                $insert_data = [
                    'admin_id'  => $new_id,
                    'role_id'   => $role
                ];
                $this->admin_role->insert($insert_data);
            }
            return redirect(base_url('admin/managers'));
        }

        $view_data['roles'] = $this->role->select_all();

        $this->render('admin/add',$head_data,$view_data);
    }





    public function edit($id){
        $head_data = [
            'title' => '修改成員'
        ];
        $view_data = [];

        $where = [
            'id'    => $id
        ];

        $this->load->library('form_validation');
        $this->form_validation
                ->set_rules('name','名稱','trim|required')
                ->set_rules('username','帳號','trim|required')
                ->set_rules('password','密碼','trim|min_length[6]|alpha_numeric');

        if($this->form_validation->run()){
            $where_data = [
                'id' => $id
            ];
            if(trim($this->input->post('password')) == ''){
                //沒更改密碼
                $update_data = [
                    'username'  => $this->input->post('username'),
                    'name' => $this->input->post('name'),
                ];
            }else{
                //更改密碼
                $update_data = [
                   'username'       => $this->input->post('username'),
                   'name'          => $this->input->post('name'),
                   'password'       => md5(sha1($this->input->post('password')))
                ];
            }
            $update_result = $this->admin->update($where_data,$update_data);
            //更新關聯(先刪後增)
            $this->admin_role->delete(array('admin_id' => $id));
            foreach($this->input->post('roles') as $role){
                $insert_data = [
                    'role_id'   => $role,
                    'admin_id'  => $id
                ];
                $admin_role_result = $this->admin_role->insert($insert_data);
            }
            if($update_result || $admin_role_result){
                $view_data['success'] = '修改成功';
            }
        }
        $admin = $this->admin->select($where);
        $view_data['roles'] = $this->role->select_all();
        $view_data['has_roles'] = $this->admin_role->select_all(array('admin_id' => $id));
        if(is_object($admin)){
            $view_data['admin'] = $admin;
        }else{
            show_404();
        }

        $this->render('admin/edit',$head_data,$view_data);
    }

    public function delete(){
        $where_data = [
            'id'    => $this->input->post('id')
        ];
        $this->admin->delete($where_data);
        return redirect(base_url('admin/managers'));
    }

    private function can($id){
        if(!in_array($id,$this->admin->permissions(array('admin_id' => $this->admin_data['admin_id'])))){
            return redirect(base_url('admins'));
        }
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

    private function render($page,$head=[],$view=[],$foot=[]){
        $head['admin'] = $this->admin_data;
        $head['permissions'] = $this->admin->permissions(array('admin_id' => $this->admin_data['admin_id']));


    	$this->load->view('admin/layouts/header',$head);
    	$this->load->view($page,$view);
    	$this->load->view('admin/layouts/footer',$foot);
    }

    private function is_admin(){
        if(!$this->session->has_userdata('admin_login') || !$this->session->admin_login){
            return redirect(base_url('admins/login'));
        }
    }

}

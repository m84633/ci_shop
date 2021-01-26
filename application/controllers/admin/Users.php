<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    private $admin_data;

    public function __construct()
    {
            parent::__construct();
            $this->is_admin();
            $this->load->model('user');
            $this->load->model('admin');

            $this->admin_data = $this->session->userdata();
    }


    public function index(){
        $head_data = [
            'title' => '會員管理'
        ];
        $view_data = [];
        $foot_data = [];
        $this->load->helper('text');

        $head_data['links'][] = 'https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.css';
        $foot_data['scripts'][] = 'https://cdn.datatables.net/v/bs4/dt-1.10.23/datatables.min.js';
        $foot_data['scripts'][] = base_url('assets/js/datatable.js'); 

        $users = $this->user->select_all();
        $view_data['users'] = $users;

        $this->render('admin/user/index',$head_data,$view_data,$foot_data);
    }

    public function add(){
        $this->can('4');
        $head_data = [
            'title' => '新增會員'
        ];
        $view_data = [];
        $foot_data['scripts'][] = base_url('assets/js/add_img.js');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name','姓名','trim|required')
                            ->set_rules('email','Email','trim|required|valid_email|is_unique[users.email]')
                            ->set_rules('password','密碼','trim|min_length[6]|alpha_numeric');
        if($this->form_validation->run()){
            $insert_data = [
                'name'      => $this->input->post('name'),
                'email'     => $this->input->post('email'),
                'password'  => md5(sha1($this->input->post('email'))),
            ];
            $new_id = $this->user->insert($insert_data);
            $upload = $this->do_upload($new_id);
            if(isset($upload['success']) && $upload['success']){
                $where_data = [
                    'id'    =>  $new_id
                ];
                $update_data = [
                    'avatar'    => $upload['success']
                ];
                $this->user->update($where_data,$update_data);
            }
            return redirect(base_url('admin/users'));
        }

        $this->render('admin/user/add',$head_data,$view_data,$foot_data);
    }

    public function edit($id){
        $this->can('5');
        $head_data = [
            'title' => '修改會員'
        ];
        $view_data = [];
        $foot_data['scripts'][] = base_url('assets').'/js/image.js';
        $where = [
            'id'    => $id
        ];

        $user = $this->user->select($where);
        if(is_object($user)){
            $view_data['user_edit'] = $user;
        }else{
            show_404();
        }

        $this->load->library('form_validation');
        $this->form_validation
                ->set_rules('name','名稱','trim|required')
                ->set_rules('email','Email','trim|required|valid_email')
                ->set_rules('password','密碼','trim|min_length[6]|alpha_numeric');

        if($this->form_validation->run()){
            $avatar = $this->do_upload($id);
            //若上傳成功,刪除原來圖片
            if(isset($avatar['success']) && $avatar['success'] && $user->avatar){
                unlink('./uploads/'.$user->id.'/'.$user->avatar);
            }

            $where_data = [
                'id' => $id
            ];
            if(trim($this->input->post('password')) == ''){
                //沒更改密碼
                $update_data = [
                    'name'  => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'avatar'=> $avatar['success'] ?? $user->avatar 
                ];
            }else{
                //更改密碼
                $update_data = [
                   'name'       => $this->input->post('name'),
                   'email'      => $this->input->post('email'),
                   'avatar'     => $avatar['success'] ?? $user->avatar,
                   'password'   => md5(sha1($this->input->post('password')))
                ];
            }
            $update_result = $this->user->update($where_data,$update_data);
            if($update_result){
                $login_update = [
                    'login'     => true,
                    'name'      => $this->input->post('name'),
                    'email'     => $this->input->post('email'),
                    'avatar'    => $avatar['success'] ?? $user->avatar,
                    'user_id'   => $id
                ];
                $this->user_data = $login_update;
                $user = [
                    'login','user_id','email','name','avatar'
                ];
                $this->session->unset_userdata($user);
                $this->session->set_userdata($login_update);
            }
            $user = $this->user->select($where);
            if(is_object($user)){
                $view_data['user_edit'] = $user;
            }else{
                show_404();
            }
            $this->session->set_flashdata('success', '已修改完成!');
        }

        $this->render('admin/user/edit',$head_data,$view_data,$foot_data);
    }

    public function delete(){
        $this->can('6');
        $where_data = [
            'id'    => $this->input->post('id')
        ];
        $result = $this->user->delete($where_data);
        if(!$result){
            $this->session->set_flashdata('delete_error','查無此筆資料');
        }
        return redirect(base_url('admin/users'));
    }

    private function can($id){
        if(!in_array($id,$this->admin->permissions(array('admin_id' => $this->admin_data['admin_id'])))){
            return redirect(base_url('admin/users'));
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

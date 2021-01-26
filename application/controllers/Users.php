<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    private $user_data;

    public function __construct()
    {
            parent::__construct();
            $this->load->model('user');
            $this->user_data = $this->session->userdata();
    }

    public function login(){
        $this->is_login();
        $head_data = [
            'title' => '會員登入',
            ];
        $view_data = [];
        $head_data['links'][] =  base_url().'/assets/login.css'; 

        $this->load->library('form_validation');

        $this->form_validation
                    ->set_rules('email','Email','trim|required|valid_email')
                    ->set_rules('password','密碼','trim|required');

        if($this->form_validation->run()){
            $user = [
                'email'        => $this->input->post('email'),
                'password'     => md5(sha1($this->input->post('password'))),  
            ];
            $user_info = $this->user->select($user);
            if(is_object($user_info)){
                $user_login = [
                    'login'     => true,
                    'name'      => $user_info->name,
                    'email'     => $user_info->email,
                    'user_id'   => $user_info->id,
                    'avatar'    => $user_info->avatar
                ];
                $this->session->set_userdata($user_login);
                return redirect(base_url());
            }else{
                $view_data['login_error'] = "帳號或密碼錯誤!"; 
            }
        }

        $this->render('user/login',$head_data,$view_data);

    }

    public function register(){
        $this->is_login();
        $head_data=[
            'title' => '會員註冊',
        ];
        $view_data = [];
        $head_data['links'][] = base_url().'assets/register.css';

        $this->load->library('form_validation');

        $this->form_validation
            ->set_rules('name','名稱','trim|required')
            ->set_rules('email','Email','trim|required|valid_email|is_unique[users.email]')
            ->set_rules('password','密碼','trim|required|min_length[6]|alpha_numeric')
            ->set_rules('passconf','確認密碼','trim|required|min_length[6]|matches[password]|alpha_numeric');

        if($this->form_validation->run()){
            $insert_data = [
                'name'      => $this->input->post('name'),
                'email'     => $this->input->post('email'),
                'password'  => md5(sha1($this->input->post('password'))),
            ];
            $new_id = $this->user->insert($insert_data);
            if($new_id){
                $user_login = [
                    'login'     => true,
                    'user_id'   => $new_id,
                    'email'     => $insert_data['email'],
                    'name'      => $insert_data['name']
                ];
                $this->session->set_userdata($user_login);
            }
            $upload = $this->do_upload($new_id);
            if(isset($upload['success'])){
                $where_data = [
                    'id'    => $new_id
                ];
                $upload_data = [
                    'avatar' => $upload['success'],
                ];

                $this->user->update($where_data,$upload_data);
            }
            return redirect(base_url());
        }
        $view_data['errors'] = $this->form_validation->error_array();
        $this->render('user/register',$head_data,$view_data);
    }

    public function logout(){
        $user = [
            'login','user_id','email','name','avatar'
        ];
        $this->session->unset_userdata($user);
        return redirect(base_url());
    }

    public function edit($id){
        $this->can($id);
        $head_data = [
            'title' => '會員專區'
        ];
        $view_data = [];
        $where = [
            'id'    => $id
        ];
        $user = $this->user->select($where);
        if(is_object($user)){
            $view_data['user_edit'] = $user;
        }else{
            show_404();
        }
        if($user->avatar){
            $foot_data['scripts'][] = base_url('assets/js/image.js');
        }else{
            $foot_data['scripts'][] = base_url('assets/js/add_img.js');
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

            $this->session->set_flashdata('success', '已修改完成!');
        }

        $this->render('user/edit',$head_data,$view_data,$foot_data);
    }

    public function forgot_password(){
        $head_data = [
            'title' => '忘記密碼'
        ];
        $view_data = [];
        $head_data['links'][] = base_url('assets/forgot_password.css');
        $this->load->library('form_validation');
        $this->load->library('email');
        $this->load->helper('string');

        $this->form_validation->set_rules('email','Email','required|valid_email');
        if($this->form_validation->run()){
            $where_data = [
                'email' => $this->input->post('email')
            ];
            $user = $this->user->select($where_data);
            if($user){
                $token = random_string('alnum', 16);
                $message = "請點選以重置密碼<br><a href='".base_url('users/reset_password?token=').$token."'>點選</a>";
                $user_token = [
                    'email'         => $user->email,
                    'token'         => $token,
                    'created_at'    => time()
                ];
                $this->db->insert('users_token',$user_token);
                $this->email->from('tygh987654#gmail.com','王人霈')
                            ->to($user->email)
                            ->subject('重置密碼')
                            ->message($message);
                if($this->email->send()){
                    $view_data['success'] = '信件已發送至您的Email!';
                }else{
                    echo $this->email->print_debugger();
                    die();
                }

            }else{
                $view_data['error'] = '查無此email!';
            }
        }

        $this->render('user/forgot_password',$head_data,$view_data);
    }


    public function reset_password(){
        $head_data = [
            'title' => '重置密碼'
        ];

        $this->load->library('form_validation');

        $token = $this->input->get('token');
        $where_data = [
            'token' => $token,
        ];
        $view_data = [];
        $email = $this->db->select('email')
                        ->where($where_data)
                        ->get('users_token')
                        ->row();
        if($email){
            $this->form_validation->set_rules('password','密碼','trim|required|alpha_numeric|min_length[6]')
                                ->set_rules('confpasswd','確認密碼','trim|required|alpha_numeric|min_length[6]|matches[password]');
            if($this->form_validation->run()){
                $update_data = [
                    'password'  => md5(sha1($this->input->post('password')))
                ];
                $where_data = [
                    'email' => $email->email
                ];
                $result = $this->user->update($where_data,$update_data);
                if($result){
                    $view_data['success'] = '密碼重置成功';
                    $this->db->where(array('token'  => $token))
                            ->delete('users_token');
                }
            }
        }else{
            show_404();
        }

        $this->render('user/reset_password',$head_data,$view_data);
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

    private function render($page,$head,$view=[],$foot=[]){
        $head['user'] = $this->user_data;

    	$this->load->view('layouts/header',$head);
    	$this->load->view($page,$view);
    	$this->load->view('layouts/footer',$foot);
    }

    private function is_login(){
        if($this->session->has_userdata('login') && $this->session->login){
            return redirect(base_url());
        }
    }
    /**
        *
    **/
    private function can($id){
        if($this->user_data['user_id'] != $id){
            return redirect(base_url());
        }
    }
}

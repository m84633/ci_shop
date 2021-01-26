<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	private $admin_data;
    public function __construct()
    {
            parent::__construct();
            $this->load->model('product');
            $this->load->model('admin');

            $this->is_admin();
            $this->admin_data = $this->session->userdata();

    }

	public function add(){
        $this->can('1');
		$head_data = [
			'title' => "新增商品",
		];
		$view_data = [];
        $foot_data['scripts'][] = base_url('assets/js').'/add_img.js';
		$this->load->library('form_validation');
        $this->load->model('type');
        $view_data['types'] = $this->type->select_all();

		$this->form_validation
			->set_rules('name','商品名稱','trim|required|min_length[3]|is_unique[products.name]')
			->set_rules('desc','商品描述','trim|required')
			->set_rules('price','價格','required|numeric|greater_than[0]')
            ->set_rules('type_id','商品類型','required|numeric',array('numeric' => '請選擇商品類型'));

		if($this->form_validation->run()){
			$upload = $this->do_upload();
			if(isset($upload['error'])){
				$view_data['error'] = $upload['error'];
			}else{
				$insert_data = [
					'name'     => $this->input->post('name'),
					'desc'     => $this->input->post('desc'),
					'price'    => $this->input->post('price'),
					'image'    => $upload['success'],
                    'type_id'  => $this->input->post('type_id'),
				];
				$new_id = $this->product->insert($insert_data);
                if($new_id){
                    $view_data['success'] = '新增成功!';
                }
			}

		}
		$this->render('admin/products/add',$head_data,$view_data,$foot_data);
	}

    public function edit($id){
        $this->can('2');
    	$head_data = [
    		'title'	=> '修改商品'
    	];
    	$view_data = [];

    	$where_data = [
    		'id' => $id,
    	];
        $foot_data['scripts'][] = base_url('assets/js').'/image.js'; 
    	$product = $this->product->select($where_data);
    	$view_data['product'] = $product;
    	//修改錯誤可能是名稱有人用了
    	$this->load->library('form_validation');
    	$this->form_validation
    			->set_rules('name','商品名稱','trim|required|min_length[3]')
    			->set_rules('desc','商品描述','trim|required')
    			->set_rules('price','價格','required|numeric|greater_than[0]');
    	if($this->form_validation->run()){
    		$upload = $this->do_upload();
    		if(isset($upload['success']) && $upload['success']){
    			unlink('./uploads/'.$product->image);
    		}
    		$update_data = [
    			'name'	=> $this->input->post('name'),
    			'desc'	=> $this->input->post('desc'),
    			'price'	=> $this->input->post('price'),
    			'image' => $upload['success'] ?? $product->image
    		];
    		$where_data = [
    			'id'	=> $id
    		];
    		$result = $this->product->update($where_data,$update_data);
    		if($result){
    			$view_data['success'] = '修改成功!';
		    	$product = $this->product->select($where_data);
    			$view_data['product'] = $product;
    		}else{
    			$view_data['error'] = '發生錯誤,未更改資料或此商品名稱可能已被使用';
    		}
    	}

    	$this->render('admin/products/edit',$head_data,$view_data,$foot_data);;
    }

    public function delete(){
        $this->can('3');
        $where_data = [
            'id' => $this->input->post('id')
        ];
        $product = $this->product->select($where_data);
        if($product){
            unlink('./uploads/'.$product->image);
        }else{
            set_flashdata('delete_error','找不到此商品');
        }
        $result = $this->product->delete($where_data);
        return redirect(base_url('admins'));
    }


    private function do_upload(){
    	$config = [
    		'upload_path'		=> './uploads/',
    		'allowed_types' 	=> 'gif|jpg|png',
    		'max_size'			=> 1024,
    		'encrypt_name'      => true
    	];
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('image'))
            {
                return array('error' => $this->upload->display_errors($this->config->item('error_prefix'),$this->config->item('error_suffix')));
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
            return redirect($this->back());
        }
    }

    private function back(){
        $this->load->library('user_agent');
        return $this->agent->referrer();
    }

    private function render($page,$head,$view,$foot=[]){
    	$head['admin'] = $this->admin_data;
        $head['permissions'] = $this->admin->permissions(array('admin_id' => $this->admin_data['admin_id']));


    	$this->load->view('admin/layouts/header',$head);
    	$this->load->view($page,$view);
    	$this->load->view('admin/layouts/footer',$foot);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	private $user_data;
    public function __construct()
    {
            parent::__construct();
            $this->load->model('product');
            $this->user_data = $this->session->userdata();
    }
	public function index($type_id=0)
	{	
		$this->load->helper('text');


		$head_data = [
			'title' => "首頁",
		];
		$view_data = [
			'type_counts' => $this->product->count_by_type(),
			'total_counts' => $this->product->count_all(),
		];
		$head_data['links'][] = base_url('assets/jquery.toast.min.css');
		$foot_data['scripts'][] = base_url('assets/js/add_cart.js');
		$foot_data['scripts'][] = base_url('assets/js/jquery.toast.min.js');
		$search = $this->input->get('search');
		$start = $this->input->get('page');
		$limit = $this->config->item('per_page');
		$where = [];
		$or_where = [];
		if($search){
			$where = [
				'name LIKE' => '%'.$search.'%'
			];
			$or_where = [
				'`desc` LIKE' => '%'.$search.'%'
			];
		}
		if($type_id){
			$this->load->model('type');
			$type = $this->type->select($type_id);
			$head_data['title'] = $type->name; 
			$where['type_id'] = $type_id;
			$view_data['type_id'] = $type_id;
		}


		$this->load->model('type');
		$view_data['types'] = $this->type->select_all();

		$view_data['products'] = $this->product->select_all($start,$limit,$where,$or_where);
		$this->pagination->initialize([
			'base_url'		=> current_url().($type_id ? 'types'.$type_id : '').($search ? '?search='.$search : ''),
			'total_rows'	=> $this->product->count_all($where,$or_where), 
		]);
		$view_data['pageination'] = $this->pagination->create_links();


		$this->render('product/index',$head_data,$view_data,$foot_data);
	}

	public function shop_cart(){
		$this->is_login();
		$head_data =  [
			'title'	=> '購物車',
			'links'	=> [base_url('assets/cart.css')]
		];
		$view_data = [];
		$foot_data['scripts'][] = base_url('assets/js/shop_cart.js'); 


		$this->render('cart',$head_data,$view_data,$foot_data);
	}

	//購物車
	public function add(){
		$id = $this->input->post('id');
		$count = 0;
		if(!isset($_SESSION['cart'])){
			$_SESSION['cart'] = [];
			$_SESSION['cart'][$id] = [
				'item'	=> $this->product->select(array('id'=>$id)),
				'count'	=> $count+1
			];
		}else{
			if(isset($_SESSION['cart'][$id])){
				$_SESSION['cart'][$id]['count']+=1;
			}elseif(!isset($_SESSION['cart'][$id])){
				$_SESSION['cart'][$id] = [
					'item'	=> $this->product->select(array('id'=>$id)),
					'count'	=> $count+1
				];
			}
		}
		$this->cart_total_sum();
		echo json_encode(array('message' => $_SESSION['cart'],'sum'	=> $_SESSION['sum'],'total'	=> $_SESSION['total'],'ajax' =>  $this->security->get_csrf_hash()));
	}

	public function minus(){
		$id = $this->input->post('id');
		$count = 0;
		if(!isset($_SESSION['cart'])){
			echo json_encode(array('message' => $_SESSION['cart'],'sum'	=> $_SESSION['sum'],'total'	=> $_SESSION['total'],'ajax' =>  $this->security->get_csrf_hash()));
			return false;
		}
		if(isset($_SESSION['cart'][$id])){
			if($_SESSION['cart'][$id]['count'] == 1){
				echo json_encode(array('message' => $_SESSION['cart'],'sum'	=> $_SESSION['sum'],'total'	=> $_SESSION['total'],'ajax' =>  $this->security->get_csrf_hash())); 
				return false;
			}
			$_SESSION['cart'][$id]['count']-=1;
		}else{
			echo json_encode(array('message' => $_SESSION['cart'],'sum'	=> $_SESSION['sum'],'total'	=> $_SESSION['total'],'ajax' =>  $this->security->get_csrf_hash()));
			return false;
		}
		$this->cart_total_sum();
		echo json_encode(array('message' => $_SESSION['cart'],'sum'	=> $_SESSION['sum'],'total'	=> $_SESSION['total'],'ajax' =>  $this->security->get_csrf_hash()));
	}

	public function unset(){
		$id = $this->input->post('id');
		if(!isset($_SESSION['cart'])){
			return false;
		}
		if(isset($_SESSION['cart'][$id])){
			unset($_SESSION['cart'][$id]);
		}else{
			return false;
		}
		$this->cart_total_sum();
		echo json_encode(array('message' => $_SESSION['cart'],'sum'	=> $_SESSION['sum'],'total'	=> $_SESSION['total'],'ajax' =>  $this->security->get_csrf_hash()));
	}

	public function checkout(){
		$head_data = [
			'title'	=> '訂單確認'
		];
		$view_data = [];

		$this->render('checkout',$head_data,$view_data);
	}

	private function is_login(){
		if(!isset($_SESSION['login']) && !$_SESSION['login']){
			return redirect(base_url('users/login'));
		}		
	}

	private function cart_total_sum(){
		if(!isset($_SESSION['cart'])){
			return false;
		}
		$_SESSION['total'] = 0;
		$_SESSION['sum'] = 0;
		foreach($_SESSION['cart'] as $product){
			$_SESSION['sum'] += $product['item']->price*$product['count'];
			$_SESSION['total'] += $product['count'];
		}
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
                return array('file_name' => $this->upload->data('file_name'));
            }
    }

    private function render($page,$head,$view,$foot=[]){
    	$head['user'] = $this->user_data;

    	$this->load->view('layouts/header',$head);
    	$this->load->view($page,$view);
    	$this->load->view('layouts/footer',$foot);
    }
}

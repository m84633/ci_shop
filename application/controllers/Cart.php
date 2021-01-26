<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
    private $user_data;

    public function __construct()
    {
            parent::__construct();
            $this->load->model('product');
            
            $this->user_data = $this->session->userdata();

    }

    public function index(){
        $this->render('');
    }

    public function add(){
        $where_data = [
            'id'    => $this->input->post('id')
        ];
        $book = $this->product->select($where_data);
        $last_cart = $this->session->userdata('cart') ?? null;
        $this->load->library('shopcart',$last_cart);
        $this->shopcart->add($book,$book->id);
        $this->session->set_userdata('cart',) ;

    }

    private function render($page,$head,$view=[],$foot=[]){
        $head['user'] = $this->user_data;

    	$this->load->view('layouts/header',$head);
    	$this->load->view($page,$view);
    	$this->load->view('layouts/footer',$foot);
    }

    private function is_login(){
        if(!$this->session->has_userdata('login')){
            return redirect(base_url('carts'));
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

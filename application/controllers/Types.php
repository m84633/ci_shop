<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Types extends CI_Controller {
    public function __construct()
    {
            parent::__construct();
            $this->load->model('type');
    }

    public function add(){
    	$view_data = [];
    	$head_data = [
    		'title' => '新增類型'
    	];
    	$this->load->library('form_validation');
		
		$this->form_validation
			->set_rules('name','類別名稱','required|min_length[3]');
		if($this->form_validation->run()){
			$insert_data = [
				'name' => $this->input->post('name'),
			];
			$this->type->insert($insert_data);
		}

		$this->render('type/add',$head_data,$view_data);
    }

    private function render($page,$head,$view){
    	$this->load->view('layouts/header',$head);
    	$this->load->view($page,$view);
    	$this->load->view('layouts/footer');
    }
}

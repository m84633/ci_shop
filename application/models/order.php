<?php
class Order extends CI_Model {
		protected $table = 'orders';
		protected $primary_key = 'id';
        public function __construct()
        {
                parent::__construct();
        }


        public function count_all($where=[],$or_where=[]){
        	return $this->db->where($where)->or_where($or_where)->count_all_results($this->table);
        }

        public function count_by_type(){ //x用select_all再count,類別一多很麻煩
                return $this->db->select('type_id,COUNT(type_id) as total')
                                ->group_by('type_id')
                                ->order_by('type_id','desc')
                                ->get($this->table)
                                ->result();
        }

        public function total(){
                return $this->db
                        ->get($this->table)
                        ->result();
        }



        public function select($where=[],$or_where=[]){
                return $this->db->where($where)
                                ->or_where($or_where)
                                ->get($this->table)
                                ->row();
        }

        public function select_all($where=[],$or_where=[]){
                return $this->db->where($where)
                                ->or_where($or_where)
                                ->get($this->table)
                                ->result();
        }

        public function detail($where=[]){
                return $this->db->select('cart')
                        ->where($where)
                        ->get($this->table)
                        ->row_array();
        }

        public function select_index($where=[],$or_where=[]){
                return $this->db->select('uuid,cart,payment,created_at,id')
                                ->where($where)
                                ->or_where($or_where)
                                ->get($this->table)
                                ->result();
        }

        public function update($where,$update){
                $this->db->where($where)
                        ->update($this->table,$update);
                return $this->db->affected_rows();
        }

        public function insert($data){
        	$this->db->insert($this->table,$data);
        	return $this->db->insert_id();
        }

        public function delete($where=[]){
                $this->db->where($where)
                        ->delete($this->table);
                return $this->db->affected_rows();
        }


}
<?php
class User extends CI_Model {
	protected $table = 'users';
	protected $primary_key = 'id';
        public function __construct()
        {
                parent::__construct();
        }

        public function insert($data){
        	$this->db->insert($this->table,$data);
        	return $this->db->insert_id();
        }

        public function update($where=[],$data=[]){
        	$this->db
        		->where($where)
        		->update($this->table,$data);
        	return $this->db->affected_rows();
        }

        public function select($where=[],$or_where=[]){
                return $this->db
                        ->where($where)
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

        public function delete($where){
                $this->db->where($where)
                        ->delete($this->table);
                return $this->db->affected_rows();
        }        



}
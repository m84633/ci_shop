<?php
class Type extends CI_Model {
	protected $table = 'types';
	protected $primary_key = 'id';
        public function __construct()
        {
                parent::__construct();
        }

        public function count_all($where,$or_where){
        	return $this->db->where($where)->or_where($or_where)->count_all_results($this->table);
        }

        public function select_all($start=null,$limit=null,$where=[],$or_where=[],$order='ASC'){
        	return $this->db->order_by('id',$order)
        			->where($where)
        			->or_where($or_where)
        			->limit($limit,$start)
        			->get($this->table)
        			->result();
        }


        public function select($id){
                return $this->db->where($this->primary_key,$id)->get($this->table)->row();
        }

        public function insert($data){
        	$this->db->insert($this->table,$data);
        	return $this->db->insert_id();
        }

        public function update($where=[],$update=[]){
                $this->db->where($where)
                        ->update($this->table,$update);
                return $this->db->affected_rows();
        }

        public function delete($where){
                $this->db->where($where)
                        ->delete($this->table);
                return $this->db->affected_rows();
        }
}
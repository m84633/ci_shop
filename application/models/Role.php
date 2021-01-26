<?php
class Role extends CI_Model {
		protected $table = 'roles';
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

        public function select($where=[],$or_where=[]){
                return $this->db->where($where)
                                ->get($this->table)
                                ->row();
        }

        public function select_all($where=[],$or_where=[],$order='ASC',$start=null,$limit=null){
        	return $this->db->where($where)
        			->or_where($or_where)
                                ->order_by('id',$order)
        			->limit($limit,$start)
        			->get($this->table)
        			->result();
        }

        public function insert($data){
        	$this->db->insert($this->table,$data);
        	return $this->db->insert_id();
        }

        public function update($where,$update){
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
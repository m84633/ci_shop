<?php
class Admin extends CI_Model {
		protected $table = 'admins';
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

        public function update($where=[],$update=[]){
                $this->db->where($where)
                        ->update($this->table,$update);
                return $this->db->affected_rows();
        }

        public function get_roles(){
                  return $this->db->select('admins.id,admins.name,admins.username,GROUP_CONCAT(roles.name) as roles')
                           ->from('admins')
                           ->join('admins_roles', 'admins.id = admins_roles.admin_id', 'inner')
                           ->join('roles', 'admins_roles.role_id = roles.id', 'inner')
                           ->group_by('id')
                           ->get()
                           ->result();

        }

        public function delete($where){
            $this->db->where($where)
                    ->delete($this->table);
            return $this->db->affected_rows;
        }

        public function permissions($where){
            $permissions = $this->db->select('admins_roles.admin_id,GROUP_CONCAT(permissions.id) as permissions')
                    ->from('admins_roles')
                    ->where($where)
                    ->join('roles','roles.id = admins_roles.role_id','inner')
                    ->join('permissions_roles','permissions_roles.role_id = roles.id')
                    ->join('permissions','permissions.id = permissions_roles.permission_id')
                    ->group_by('admin_id')
                    ->get()
                    ->row();
            if(isset($permissions->permissions)){
                return explode(',',$permissions->permissions);
            }else{
                return array();
            }
        }


}
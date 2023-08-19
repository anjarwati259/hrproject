<?php 

/**
 * 
 */
class User_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//login user
	public function login($username, $password)
	{
		$this->db->select('*');
		$this->db->from('tb_user');
		$this->db->where(array(	'username'	=> $username,
								'password'	=> hash('sha3-256', $password)));
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		return $query->row();
	}

	public function getUser($id){
		$this->db->select('tb_user.id, tb_karyawan.nama, tb_karyawan.nik, tb_role_user.role_id');
		$this->db->from('tb_user');
		$this->db->join('tb_karyawan','tb_karyawan.nik = tb_user.username', 'left');
		$this->db->join('tb_role_user','tb_role_user.user_id = tb_user.id', 'left');
		$this->db->where('tb_user.id',$id);
		$this->db->order_by('id','desc');
		$query = $this->db->get()->row();
		return $query;
	}

	public function getRole($id){
		$this->db->select('*');
		$this->db->from('tb_role');
		$this->db->where('id', $id);
		$this->db->where('status', '1');
		$this->db->order_by('id','asc');
		$query = $this->db->get();
		return $query->row();
	}

	public function getMenu($role){
		$this->db->select('*');
		$this->db->from('tb_menu');
		$this->db->where('role_id', $role);
		$this->db->where('status', '1');
		$this->db->order_by('order','asc');
		$query = $this->db->get();
		return $query->result();
	}
}
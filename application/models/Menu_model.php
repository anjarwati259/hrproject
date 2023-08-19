<?php 

/**
 * 
 */
class Menu_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
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
<?php 

/**
 * 
 */
class Karyawan_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//login user
	public function getKaryawanById($nik){
		$this->db->select('tb_karyawan.*, tb_divisi.nama_divisi, tb_jabatan.nama_jabatan');
		$this->db->from('tb_karyawan');
		$this->db->join('tb_divisi','tb_divisi.id = tb_karyawan.divisi_id', 'left');
		$this->db->join('tb_jabatan','tb_jabatan.id = tb_karyawan.jabatan_id', 'left');
		$this->db->where('tb_karyawan.nik',$nik);
		$this->db->order_by('id','desc');
		$query = $this->db->get()->row();
		return $query;
	}
}
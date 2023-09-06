<?php 

/**
 * 
 */
class Karyawan_model extends CI_Model
{
	var $table = 'tb_karyawan';
    var $column_order = array(null, 'kode_karyawan','nama_karyawan'); 
    var $column_search = array('kode_karyawan','nama_karyawan'); 
    var $order = array('id' => 'desc');
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function query_karyawan(){
        $this->db->select('tb_karyawan.*, tb_jabatan.nama_jabatan, tb_divisi.nama_divisi'); 
        $this->db->from($this->table);
        $this->db->join('tb_divisi','tb_divisi.id = tb_karyawan.divisi_id', 'left');
        $this->db->join('tb_jabatan','tb_jabatan.id = tb_karyawan.jabatan_id', 'left');
        $this->db->where('tb_karyawan.status','1');
        $i = 0;
        foreach ($this->column_search as $item){
            if($_POST['search']['value'])
            {
                if($i===0){
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }else{
                        $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) 
                        $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])){
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function getKaryawan(){
        $this->query_karyawan();
        if($_POST['length'] != -1){
        	$this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered(){
        $this->query_karyawan();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function insert($data){
        try {
            $this->db->trans_begin();
            $this->db->insert('tb_karyawan', $data);

            $db_error = $this->db->error();
            if (!empty($db_error['message'])) {
                throw new Exception($db_error['message']);
            }
            $this->db->trans_commit();
            $result = array('status' => 'success',
                            'message' => 'Data Berhasil Disimpan',
                            'atribute' => '');
        }catch (Exception $e) {
            $this->db->trans_rollback();
            $result = array('status' => 'error',
                            'message' => $e->getMessage(),
                            'atribute' => '');
        }
        return $result;
    }

	public function getKaryawanByNik($nik){
		$this->db->select('tb_karyawan.*, tb_divisi.nama_divisi, tb_jabatan.nama_jabatan');
		$this->db->from('tb_karyawan');
		$this->db->join('tb_divisi','tb_divisi.id = tb_karyawan.divisi_id', 'left');
		$this->db->join('tb_jabatan','tb_jabatan.id = tb_karyawan.jabatan_id', 'left');
		$this->db->where('tb_karyawan.nik',$nik);
		$this->db->order_by('id','desc');
		$query = $this->db->get()->row();
		return $query;
	}

    public function getKaryawanById($id){
        $this->db->select('tb_karyawan.*, tb_divisi.nama_divisi, tb_jabatan.nama_jabatan');
        $this->db->from('tb_karyawan');
        $this->db->join('tb_divisi','tb_divisi.id = tb_karyawan.divisi_id', 'left');
        $this->db->join('tb_jabatan','tb_jabatan.id = tb_karyawan.jabatan_id', 'left');
        $this->db->where('tb_karyawan.id',$id);
        $this->db->order_by('id','desc');
        $query = $this->db->get()->row();
        return $query;
    }

	public function edit($data){
        try {
            $this->db->trans_begin();
            $this->db->where('id', $data['id']);
            $this->db->update('tb_karyawan',$data);

            $db_error = $this->db->error();
            if (!empty($db_error['message'])) {
                throw new Exception($db_error['message']);
            }
            $this->db->trans_commit();
            $result = array('status' => 'success',
                            'message' => 'Data Berhasil Disimpan',
                            'atribute' => '');
        }catch (Exception $e) {
            $this->db->trans_rollback();
            $result = array('status' => 'error',
                            'message' => $e->getMessage(),
                            'atribute' => '');
        }
        return $result;
    }

    public function delete($id){
        $this->db->where('id', $id);
        $this->db->update('tb_karyawan', array('status' => '0'));
    }
}
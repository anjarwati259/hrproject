<?php 

/**
 * 
 */
class Divisi_model extends CI_Model
{
	
	var $table = 'tb_divisi';
    var $column_order = array(null, 'kode_divisi','nama_divisi'); 
    var $column_search = array('kode_divisi','nama_divisi'); 
    var $order = array('id' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    

    private function query_divisi(){
        $this->db->from($this->table);
        $this->db->where('status','1');
        $i = 0;
        foreach ($this->column_search as $item){
            if(isset($_POST['search']['value']))
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

    function getDivisi(){
        $this->query_divisi();
        if(isset($_POST['length'])){
            if($_POST['length'] != -1){
            	$this->db->limit($_POST['length'], $_POST['start']);
            }
        }
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered(){
        $this->query_divisi();
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
            $this->db->insert('tb_divisi', $data);

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

    public function getDivisiById($id){
        $this->db->select('*');
        $this->db->from('tb_divisi');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function edit($data){
        try {
            $this->db->trans_begin();
            $this->db->where('id', $data['id']);
            $this->db->update('tb_divisi',$data);

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
        $this->db->update('tb_divisi', array('status' => '0'));
    }
}
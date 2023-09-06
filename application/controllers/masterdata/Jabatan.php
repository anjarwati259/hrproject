<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller {

	public function __construct()
  	{
	    parent::__construct();
	    $this->load->model('user_model');
	    $this->load->model('jabatan_model');
  	}

	public function index(){
		$data = array('title' => 'Data Jabatan',
                      'isi' => 'masterdata/jabatan' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function getJabatan(){
		$fetch_data = $this->jabatan_model->getJabatan(); 
        $data = array(); 
        $no=1; 
        foreach($fetch_data as $row)  
        {  
            $sub_array = array(); 
            $sub_array[] = '<td class="text-nowrap" style="width: 10%">'.$no.'</td>';               
            $sub_array[] = '<td class="text-nowrap" style="width: 10%">'.$row->kode_jabatan.'</td>';               
            $sub_array[] = '<td class="text-nowrap" style="width: 10%">'.$row->nama_jabatan.'</td>';  
            $sub_array[] = '<td class="text-nowrap" style="width: 20%"><div class="d-inline-flex"><button type="button" class="btn btn-outline-primary waves-effect" data-bs-toggle="modal" data-bs-target="#addNewCard" onclick="edit('.$row->id.')">Edit</button> <button type="button" class="btn btn-outline-danger waves-effect ms-1" onclick="hapus('.$row->id.')">Hapus</button></div></td>';
            $data[] = $sub_array;
            $no++;  
        }  
        $output = array(  
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->jabatan_model->count_all(),
            "recordsFiltered" => $this->jabatan_model->count_filtered(),
            "data" => $data,
        );  
        echo json_encode($output);
	}

    public function getJabatanById(){
        $id     = $this->input->post('id');
        $jabatan = $this->jabatan_model->getJabatanById($id);

        echo json_encode($jabatan);
    }

    public function save(){
        $nama_jabatan = $this->input->post('nama_jabatan');
        $kode_jabatan = $this->input->post('kode_jabatan');
        $id = $this->input->post('id');

        // validation form
        $this->form_validation->set_rules('nama_jabatan', 'Nama jabatan', 'required');
        $this->form_validation->set_rules('kode_jabatan', 'Kode jabatan', 'required');

        if($this->form_validation->run()){
            if(empty($id)){
                $data = array(  'nama_jabatan' => $nama_jabatan,
                                'kode_jabatan' => $kode_jabatan,
                                'status'        => '1',
                                'created_at'    => date('Y-m-d H:i:sa')
                        );
                $result = $this->jabatan_model->insert($data);
            }else{
                $data = array(  'nama_jabatan' => $nama_jabatan,
                                'kode_jabatan' => $kode_jabatan,
                                'status'        => '1',
                                'id'            => $id
                        );
                $result = $this->jabatan_model->edit($data);
            }
        }else{
            $atribute = array(
                'nama_jabatan' => form_error('nama_jabatan'),
                'kode_jabatan' => form_error('kode_jabatan'),
            );

            $result = array('status' => 'error',
                            'message' => 'Data Ada yang Belum Terisi, Silahkan Lengkapi Terlebih Dahulu !',
                            'atribute' => $atribute
            );
        }
        echo json_encode($result);
    }

    public function delete(){
        $id     = $this->input->post('id');
        $this->jabatan_model->delete($id);
        $result = array('status' => 'success',
                        'message' => 'Data Berhasil Dihapus',
                        'atribute' => '');
        echo json_encode($result);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Divisi extends CI_Controller {

	public function __construct()
  	{
	    parent::__construct();
	    $this->load->model('user_model');
	    $this->load->model('divisi_model');
  	}

	public function index(){
		$data = array('title' => 'Data Divisi',
                      'isi' => 'masterdata/divisi' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function getDivisi(){
		$fetch_data = $this->divisi_model->getDivisi(); 
        $data = array(); 
        $no=1; 
        foreach($fetch_data as $row)  
        {  
            $sub_array = array(); 
            $sub_array[] = '<td class="text-nowrap" style="width: 10%">'.$no.'</td>';               
            $sub_array[] = '<td class="text-nowrap" style="width: 10%">'.$row->kode_divisi.'</td>';               
            $sub_array[] = '<td class="text-nowrap" style="width: 10%">'.$row->nama_divisi.'</td>';  
            $sub_array[] = '<td class="text-nowrap" style="width: 20%"><div class="d-inline-flex"><button type="button" class="btn btn-outline-primary waves-effect" data-bs-toggle="modal" data-bs-target="#addNewCard" onclick="edit('.$row->id.')">Edit</button> <button type="button" class="btn btn-outline-danger waves-effect ms-1" onclick="hapus('.$row->id.')">Hapus</button></div></td>';
            $data[] = $sub_array;
            $no++;  
        }  
        $output = array(  
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->divisi_model->count_all(),
            "recordsFiltered" => $this->divisi_model->count_filtered(),
            "data" => $data,
        );  
        echo json_encode($output);
	}

    public function getDivisiById(){
        $id     = $this->input->post('id');
        $divisi = $this->divisi_model->getDivisiById($id);

        echo json_encode($divisi);
    }

    public function save(){
        $nama_divisi = $this->input->post('nama_divisi');
        $kode_divisi = $this->input->post('kode_divisi');
        $id = $this->input->post('id');

        // validation form
        $this->form_validation->set_rules('nama_divisi', 'Nama divisi', 'required');
        $this->form_validation->set_rules('kode_divisi', 'Kode divisi', 'required');

        if($this->form_validation->run()){
            if(empty($id)){
                $data = array(  'nama_divisi' => $nama_divisi,
                                'kode_divisi' => $kode_divisi,
                                'status'        => '1',
                                'created_at'    => date('Y-m-d H:i:sa'),
                                'created_by'    => $this->session->userdata('nik')
                        );
                $result = $this->divisi_model->insert($data);
            }else{
                $data = array(  'nama_divisi' => $nama_divisi,
                                'kode_divisi' => $kode_divisi,
                                'status'        => '1',
                                'id'            => $id,
                        );
                $result = $this->divisi_model->edit($data);
            }
        }else{
            $atribute = array(
                'nama_divisi' => form_error('nama_divisi'),
                'kode_divisi' => form_error('kode_divisi'),
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
        $this->divisi_model->delete($id);
        $result = array('status' => 'success',
                        'message' => 'Data Berhasil Dihapus',
                        'atribute' => '');
        echo json_encode($result);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {

	public function __construct()
  	{
	    parent::__construct();
	    $this->load->model('user_model');
        $this->load->model('karyawan_model');
        $this->load->model('divisi_model');
	    $this->load->model('jabatan_model');
  	}

	public function index(){
        $divisi = $this->divisi_model->getDivisi();
        $jabatan = $this->jabatan_model->getJabatan();
		$data = array('title' => 'Data Karyawan',
                      'divisi' => $divisi,
                      'jabatan' => $jabatan,
                      'isi' => 'masterdata/karyawan' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}

	public function getKaryawan(){
		$fetch_data = $this->karyawan_model->getKaryawan(); 
        $data = array(); 
        $no=1; 
        foreach($fetch_data as $row)  
        {  
            $sub_array = array(); 
            $sub_array[] = '<td class="text-nowrap">'.$no.'</td>';               
            $sub_array[] = '<td class="text-nowrap">'.$row->nik.'</td>';               
            $sub_array[] = '<td class="text-nowrap">'.$row->nama.'</td>';  
            $sub_array[] = '<td class="text-nowrap">'.$row->nama_divisi.'</td>';               
            $sub_array[] = '<td class="text-nowrap">'.$row->nama_jabatan.'</td>';               
            $sub_array[] = '<td class="text-nowrap" style="width: 20%">'.$row->alamat.'</td>';  
            $sub_array[] = '<td class="text-nowrap">'.$row->email.'</td>';               
            $sub_array[] = '<td class="text-nowrap">'.$row->no_hp.'</td>';  
            $sub_array[] = '<td class="text-nowrap">'.$row->tempat_lahir.'</td>';               
            $sub_array[] = '<td class="text-nowrap">'.$row->tgl_lahir.'</td>';    
            $sub_array[] = '<td class="text-nowrap" style="width: 20%"><div class="d-inline-flex"><button type="button" class="btn btn-outline-primary waves-effect" data-bs-toggle="modal" data-bs-target="#addNewCard" onclick="edit('.$row->id.')">Edit</button> <button type="button" class="btn btn-outline-danger waves-effect ms-1" onclick="hapus('.$row->id.')">Hapus</button></div></td>';
            $data[] = $sub_array;
            $no++;  
        }  
        $output = array(  
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->karyawan_model->count_all(),
            "recordsFiltered" => $this->karyawan_model->count_filtered(),
            "data" => $data,
        );  
        echo json_encode($output);
	}

    public function getKaryawanById(){
        $id     = $this->input->post('id');
        $karyawan = $this->karyawan_model->getKaryawanById($id);

        echo json_encode($karyawan);
    }

    public function save(){
        $nama = $this->input->post('nama');
        $divisi_id = $this->input->post('divisi_id');
        $jabatan_id = $this->input->post('jabatan_id');
        $email = $this->input->post('email');
        $nik = $this->input->post('nik');
        $no_hp = $this->input->post('no_hp');
        $tgl_lahir = $this->input->post('tgl_lahir');
        $tempat_lahir = $this->input->post('tempat_lahir');
        $alamat = $this->input->post('alamat');
        $id = $this->input->post('id');

        // validation form
        $this->form_validation->set_rules('nama', 'Nama karyawan', 'required');
        $this->form_validation->set_rules('divisi_id', 'Divisi', 'required');
        $this->form_validation->set_rules('jabatan_id', 'Jabatan', 'required');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('nik', 'NIK Karyawan', 'required');
        $this->form_validation->set_rules('no_hp', 'No. Handphone', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if($this->form_validation->run()){
            if(empty($id)){
                $data = array(  'nama' => $nama,
                                'divisi_id' => $divisi_id,
                                'jabatan_id' => $jabatan_id,
                                'email' => $email,
                                'nik' => $nik,
                                'no_hp' => $no_hp,
                                'tgl_lahir' => $tgl_lahir,
                                'tempat_lahir' => $tempat_lahir,
                                'alamat' => $alamat,
                                'status'        => '1',
                                'created_at'    => date('Y-m-d H:i:sa'),
                                'created_by'    => $this->session->userdata('nik')
                        );
                $result = $this->karyawan_model->insert($data);
            }else{
                $data = array(  'nama' => $nama,
                                'divisi_id' => $divisi_id,
                                'jabatan_id' => $jabatan_id,
                                'email' => $email,
                                'nik' => $nik,
                                'no_hp' => $no_hp,
                                'tgl_lahir' => $tgl_lahir,
                                'tempat_lahir' => $tempat_lahir,
                                'alamat' => $alamat,
                                'status'        => '1',
                                'id'            => $id
                        );
                $result = $this->karyawan_model->edit($data);
            }
        }else{
            $atribute = array(
                'nama' => form_error('nama'),
                'divisi_id' => form_error('divisi_id'),
                'jabatan_id' => form_error('jabatan_id'),
                'email' => form_error('email'),
                'nik' => form_error('nik'),
                'no_hp' => form_error('no_hp'),
                'tgl_lahir' => form_error('tgl_lahir'),
                'tempat_lahir' => form_error('tempat_lahir'),
                'alamat' => form_error('alamat'),
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
        $this->karyawan_model->delete($id);
        $result = array('status' => 'success',
                        'message' => 'Data Berhasil Dihapus',
                        'atribute' => '');
        echo json_encode($result);
    }
}

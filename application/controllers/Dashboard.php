<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
  	{
	    parent::__construct();
	    $this->load->model('user_model');
	    $this->load->model('karyawan_model');
  	}

	public function dashboard_absensi(){
		$karyawan = $this->karyawan_model->getKaryawanById($this->session->userdata('nik'));
		$data = array('title' => 'Dashboard Absensi',
					  'karyawan' => $karyawan,
                      'isi' => 'absensi/dashboard/dashboard_absensi' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}
}

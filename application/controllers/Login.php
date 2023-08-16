<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$data = array('title' => 'Dashboard Absensi',
                      'isi' => 'absensi/dashboard/dashboard_absensi' );
        $this->load->view('layout/wrapper',$data, FALSE);
	}
}

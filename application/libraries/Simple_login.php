<?php 
/**
 * 
 */
class Simple_login
{
  protected $CI;

  public function __construct()
  {
    $this->CI =& get_instance();
    //load data model user
    $this->CI->load->model('user_model');
  }

  //fungsi login
  public function login($username, $password)
  {
      $check = $this->CI->user_model->login($username, $password);
      // $role = $this->CI->user_model->getRole();
      //jika ada data user, maka create session login
      if($check){
        $user = $this->CI->user_model->getUser($check->id);
        if(!empty($user)){
          $role = $this->CI->user_model->getRole($user->role_id);
          $this->CI->session->set_userdata('id',$user->id);
          $this->CI->session->set_userdata('nama_user',$user->nama);
          $this->CI->session->set_userdata('nik',$user->nik);
          $this->CI->session->set_userdata('id_role',$user->role_id);
          $this->CI->session->set_userdata('hak_akses',$role->role);
          redirect(base_url($role->url),'refresh');
        }else{
          $this->CI->session->set_flashdata('error','Anda Tidak Memiliki Akses');
          redirect(base_url('login'),'refresh');
        }
    }else{
      //kalau tidak ada, maka suruh login lagi
      $this->CI->session->set_flashdata('error','Username atau password salah');
      redirect(base_url('login'),'refresh');
    }
  }

  //fungsi cek login
  public function cek_login()
  {
    //memeriksa apakah session sudah atau belum, jika belum alihkan ke halaman login
    if($this->CI->session->userdata('username')==""){
      $this->CI->session->set_flashdata('error','Anda belum login');
      redirect(base_url('login'),'refresh');
    }
  }
  //fungsi cek hak akses
  // public function admin()
  // {
  //   //memeriksa apakah session sudah atau belum, jika belum alihkan ke halaman login
  //   if($this->CI->session->userdata('hak_akses')!="4"){
  //     $this->CI->session->set_flashdata('warning','Anda Tidak Memiliki Akses');
  //     redirect(base_url('login'),'refresh');
  //     //echo "anda tidak memiliki akses";
  //   }
  // }
  //fungsi logout
  public function logout()
  {
    //membuang semua session yang telah diset pada saat login
    $this->CI->session->unset_userdata('id');
    $this->CI->session->unset_userdata('nama_user');
    $this->CI->session->unset_userdata('nik');
    $this->CI->session->unset_userdata('id_role');
    $this->CI->session->unset_userdata('hak_akses');
    //setelah session dibuang, maka redirect ke login
    $this->CI->session->set_flashdata('sukses','Anda berhasil logout');
    redirect(base_url('login'),'refresh');
  }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
    }
    public function index(){
    	$username=$this->session->userdata('username');
    	$x=array(
    	);
        //echo $this->session->userdata('user_namalengkap');
        if(!empty($username)){
            $data['content']    = $this->load->view('view_home',$x,true);
            $this->load->view('view_layout',$data);
        }else{
            $this->session->set_flashdata('error', 'Maaf anda belum login, atau esseion anda expired!' );
            header('location:' .base_url() ."login");
        }
    	
    }
    function menu(){
        $q=urldecode($this->input->get('q',TRUE));
        $role=$this->session->userdata('level');
        //if(empty($role)) $role=1;

        $data=$this->auth_model->getMenu($role,$q);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    function login(){
        $data['content']    = $this->load->view('admin/view_login','',true);
        $this->load->view('admin/view_layout',$data);
    }
    public function cekuser(){
        $user=$this->Auth_model->cek_user($this->input->post('username'),$this->input->post('userpass'),1);
        //print_r($user);
        //exit;
        if(empty($user)){
            $this->session->set_flashdata('error', 'Maaf Username Atau Password Yang Anda masukkan Salah!' );
            header('location:' .base_url() ."login");
        }else{
            $data=array(
                'username'              => $this->input->post('username'),
                'level'             => $user->role,
                'user_namalengkap'  => $user->nama_lengkap
            );  //print_r($data);exit;
            $this->session->set_userdata($data);
            $this->session->set_flashdata('Info', 'Selamat Datang ' .$user->user_namalengkap );
            header('location:' .base_url() ."home");
        }
    }
    public function logout(){
        $this->session->sess_destroy();
        header('location:'.base_url().'login');

    }
}

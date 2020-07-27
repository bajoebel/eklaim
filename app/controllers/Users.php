<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
        $level=$this->session->userdata('level');
        $this->akses=$this->users_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
			'list_m_role'=>$this->users_model->getM_role(),
                'menu'  => array(),
                'akses'=> $this->akses
            );
            $content=$this->load->view('admin/users/view_tabel', $data, true);
            $view=array(
                'content'   => $content
            );
            $this->load->view('view_layout',$view);
        }
        else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
        
    }
	public function data(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $q = urldecode($this->input->get('q', TRUE));
            $start = intval($this->input->get('start'));
            $limit = 20;
            $row_count=$this->users_model->countUsers($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->users_model->getUserslimit($limit,$start,$q),
            );
        }else{
            $list=array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini",
                'data'      => array()
            );
        }
        header('Content-Type: application/json');
        echo json_encode($list);
    }
	function edit($id=""){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $row=$this->users_model->getUsers_by_id($id);
            if(!empty($row)){
                $response=array(
                    'status'    => true,
                    'message'   => "OK",
                    'data'      => $row,
                    'csrf'      => $this->security->get_csrf_hash(),
                );
            }else{
                $response=array(
                    'status'    => false,
                    'message'   => "Data Tidak ditemukan",
                    'data'      => array(),
                    'csrf'      => $this->security->get_csrf_hash(),
                );
            }
            
        }else{
            $response=array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini"
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
	function save(){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $username=$this->input->post('username');
        if($this->input->post('status_user')==1) $status_user=1; else $status_user=0;
            
            //$row=$this->users_model->getUsers_by_id($username);
        $row=$this->input->post('id');
            if(empty($row)){
                
                $this->form_validation->set_rules('username', 'username', 'required|is_unique[m_users.username]');
                $this->form_validation->set_rules('password', 'password', 'required');
                $this->form_validation->set_rules('nama_lengkap', 'nama lengkap', 'required');
                $this->form_validation->set_rules('nohp', 'nohp', 'required');
                $this->form_validation->set_rules('role', 'role', 'required');
                if($this->form_validation->run())
                {
                    $data = array(
                        'username' => $this->input->post('username'),
                        'password' => md5($this->input->post('password')),
                        'nama_lengkap' => $this->input->post('nama_lengkap'),
                        'nohp' => $this->input->post('nohp'),
                        'role' => $this->input->post('role'),
                        'status_user' => $status_user,
                    );
                    $insert = $this->users_model->insertUsers($data);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan",'csrf'=> $this->security->get_csrf_hash()));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_username' => form_error('username'),
                        'err_password' => form_error('password'),
                        'err_nama_lengkap' => form_error('nama_lengkap'),
                        'err_nohp' => form_error('nohp'),
                        'err_role' => form_error('role'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                
                $this->form_validation->set_rules('username', 'username', 'required');
                $this->form_validation->set_rules('password', 'password', 'required');
                $this->form_validation->set_rules('nama_lengkap', 'nama lengkap', 'required');
                $this->form_validation->set_rules('nohp', 'nohp', 'required');
                $this->form_validation->set_rules('role', 'role', 'required');
                if($this->form_validation->run())
                {
                    $data = array(
                        'nama_lengkap' => $this->input->post('nama_lengkap'),
                        'nohp' => $this->input->post('nohp'),
                        'role' => $this->input->post('role'),
                        'status_user' => $status_user,
                    );
                    $this->users_model->updateUsers($data,$username);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_username' => form_error('username'),
                        'err_password' => form_error('password'),
                        'err_nama_lengkap' => form_error('nama_lengkap'),
                        'err_nohp' => form_error('nohp'),
                        'err_role' => form_error('role'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => False,'error'=>TRUE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
        }
    }
	function delete($id){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $this->users_model->deleteUsers($id);
            header('Content-Type: application/json');
            echo json_encode(array("status" => TRUE, "message"=> "Data Berhasil dihapus"));
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
        }
        
    }
	function excel(){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->users_model->getUsers(),
            );
            $this->load->view('admin/users/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->users_model->getUsers(),
            );
            $html=$this->load->view('admin/users/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_USERS.pdf";
            $this->load->library('m_pdf');
            $pdf = $this->m_pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pdfFilePath, "D");
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
        
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('role_model');
        $level=$this->session->userdata('level');
        $this->akses=$this->role_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'akses'=> $this->akses
            );
            $content=$this->load->view('admin/role/view_tabel', $data, true);
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
            $row_count=$this->role_model->countRole($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->role_model->getRolelimit($limit,$start,$q),
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
            $row=$this->role_model->getRole_by_id($id);
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
    function berkas($id){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $row=$this->role_model->getRole_by_id($id);
            if(!empty($row)){
                $data=array(
                    'role'  => $id,
                    'berkas'=>$this->role_model->getBerkas()
                );
                $response=array(
                    'status'    => true,
                    'message'   => "OK",
                    'data'      => $row,
                    'berkas'    => $this->load->view('admin/role/view_berkas',$data,true),
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
    function akses($id){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            $row=$this->role_model->getRole_by_id($id);
            if(!empty($row)){
                $data=array(
                    'role'  => $id,
                    'akses'=>$this->role_model->getHakakses($id)
                );
                $response=array(
                    'status'    => true,
                    'message'   => "OK",
                    'data'      => $row,
                    'akses'    => $this->load->view('admin/role/view_akses',$data,true),
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

    function roleberkas($id_berkas, $role,$value){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            if($value=="1"){
                $data=array('id_berkas'=>$id_berkas,'role_id'=>$role);
                $this->db->insert('m_role_berkas',$data);
                $id=$this->db->insert_id();
                if(!empty($id)){
                    $response=array(
                        'status'    => true,
                        'message'   => "OK"
                    );
                }else{
                    $response=array(
                        'status'    => false,
                        'message'   => "Terjadi Kesalahan saat update hak akses"
                    );
                }
            }else{
                $this->db->where('id_berkas',$id_berkas);
                $this->db->where('role_id',$role);
                $this->db->delete('m_role_berkas');
                $response=array(
                    'status'    => true,
                    'message'   => "Berhasil Update Hak akses"
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
            $role_id=$this->input->post('role_id');
            $data = array(
                
                'role_nama' => $this->input->post('role_nama'),
            );
            $row=$this->role_model->getRole_by_id($role_id);
            if(empty($row)){
                
                $this->form_validation->set_rules('role_nama', 'role nama', 'required');
                if($this->form_validation->run())
                {
                    $insert = $this->role_model->insertRole($data);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_role_nama' => form_error('role_nama'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                
                    $this->form_validation->set_rules('role_nama', 'role nama', 'required');
                if($this->form_validation->run())
                {
                    $this->role_model->updateRole($data,$role_id);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        
                'err_role_nama' => form_error('role_nama'),
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
            $this->role_model->deleteRole($id);
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
                'data'  => $this->role_model->getRole(),
            );
            $this->load->view('admin/role/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->role_model->getRole(),
            );
            $html=$this->load->view('admin/role/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_ROLE.pdf";
            $this->load->library('m_pdf');
            $pdf = $this->m_pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pdfFilePath, "D");
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
        
    }
    function roleakses($modulid,$role,$aksi,$value){
        $cek=array('aksi'=>'Edit');
        if(in_array($cek, $this->akses)){
            if($aksi==1){
                if($value==0){
                    $this->role_model->removeAkses($modulid, $role);
                    $response=array('status'=>true,'message'=>"Semua Hak akses dihapus");
                }else{
                    $data=array('role_id'=>$role,'modul_id'=>$modulid,'id_aksi'=>$aksi,'tampil_menu'=>1);
                    $insert = $this->role_model->addAkses($data);
                    if($insert){
                        $response=array('status'=>true,'message'=>"Hak akses berhasil ditambahkan");
                    }
                }
            }else{
                if($value==0){
                    $this->role_model->removeAksesbyaksi($modulid, $role, $aksi);
                    $response=array('status'=>true,'message'=>"OK");
                }else{
                    $data=array('role_id'=>$role,'modul_id'=>$modulid,'id_aksi'=>$aksi);
                    $insert = $this->role_model->addAkses($data);
                    if($insert){
                        $response=array('status'=>true,'message'=>"Hak akses berhasil ditambahkan");
                    }
                }
            }
            header('Content-Type: application/json');
            echo json_encode($response);
        }else{
            $response=array(
                'status'    => false,
                'message'   => "Anda tidak berhak untuk mengakases halaman ini"
            );
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}
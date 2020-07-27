<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenisberkas extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('jenisberkas_model');
        $level=$this->session->userdata('level');
        $this->akses=$this->jenisberkas_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'akses'=> $this->akses
            );
            $content=$this->load->view('admin/jenisberkas/view_tabel', $data, true);
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
    function berkasklaim($kode){
        $cek=array('aksi'=>"Edit");
        if(in_array($cek, $this->akses)){
            $data=array(
                'kode'          => $kode,
                'berkas'    => $this->jenisberkas_model->getBerkas(),
            );
            $tabel=$this->load->view('admin/jenisberkas/view_berkasklaim',$data,true);
            $response=array('status'=>true,'message'=>"Show",'data'=>$tabel);
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
    function softcopy($jenis,$id_berkas,$value){
        $cek=array('aksi'=>"Edit");
        if(in_array($cek, $this->akses)){
            $periksa=$this->jenisberkas_model->getBerkasklaim($jenis,$id_berkas);
            if(empty($periksa)){
                $soft=array('kode_jenis'=>$jenis,'id_berkas'=>$id_berkas,'softcopy'=>$value);
                $this->db->insert('m_berkasklaim',$soft);
                $id=$this->db->insert_id();
                if(!empty($id)){
                    $response=array('status'=>true,'message'=>"Success");
                }else{
                    $response=array('status'=>false,'message'=>"Terjadi Kesalahan saat penginputan data" .$id);
                }
            }else{
                $soft=array('softcopy'=>$value);
                $this->db->where('kode_jenis',$jenis);
                $this->db->where('id_berkas',$id_berkas);
                $this->db->update('m_berkasklaim',$soft);
                $response=array('status'=>true,'message'=>'OK');
            }
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
    function hardcopy($jenis,$id_berkas,$value){
        $cek=array('aksi'=>"Edit");
        if(in_array($cek, $this->akses)){
            $periksa=$this->jenisberkas_model->getBerkasklaim($jenis,$id_berkas);
            if(empty($periksa)){
                $soft=array('kode_jenis'=>$jenis,'id_berkas'=>$id_berkas,'hardcopy'=>$value);
                $this->db->insert('m_berkasklaim',$soft);
                $id=$this->db->insert_id();
                if(!empty($id)){
                    $response=array('status'=>true,'message'=>"Success");
                }else{
                    $response=array('status'=>false,'message'=>"Terjadi Kesalahan saat penginputan data" .$id);
                }
            }else{
                $soft=array('hardcopy'=>$value);
                $this->db->where('kode_jenis',$jenis);
                $this->db->where('id_berkas',$id_berkas);
                $this->db->update('m_berkasklaim',$soft);
                $response=array('status'=>true,'message'=>'OK');
            }
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
    function wajib($jenis,$id_berkas,$value){
        $cek=array('aksi'=>"Edit");
        if(in_array($cek, $this->akses)){
            $periksa=$this->jenisberkas_model->getBerkasklaim($jenis,$id_berkas);
            if(empty($periksa)){
                $soft=array('kode_jenis'=>$jenis,'id_berkas'=>$id_berkas,'wajib'=>$value);
                $this->db->insert('m_berkasklaim',$soft);
                $id=$this->db->insert_id();
                if(!empty($id)){
                    $response=array('status'=>true,'message'=>"Success");
                }else{
                    $response=array('status'=>false,'message'=>"Terjadi Kesalahan saat penginputan data" .$id);
                }
            }else{
                $soft=array('wajib'=>$value);
                $this->db->where('kode_jenis',$jenis);
                $this->db->where('id_berkas',$id_berkas);
                $this->db->update('m_berkasklaim',$soft);
                $response=array('status'=>true,'message'=>'OK');
            }
            header('Content-Type: application/json');
            echo json_encode($response);
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
            $row_count=$this->jenisberkas_model->countJenisberkas($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->jenisberkas_model->getJenisberkaslimit($limit,$start,$q),
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
            $row=$this->jenisberkas_model->getJenisberkas_by_id($id);
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
            $kode_jenis=$this->input->post('kode_jenis');
            $data = array(
                
                'kode_jenis' => $this->input->post('kode_jenis'),
                'jenis_berkas' => $this->input->post('jenis_berkas'),
            );
            $row=$this->jenisberkas_model->getJenisberkas_by_id($kode_jenis);
            if(empty($row)){
                
                $this->form_validation->set_rules('kode_jenis', 'kode jenis', 'required|is_unique[m_jenisberkas.kode_jenis]');
                    $this->form_validation->set_rules('jenis_berkas', 'jenis berkas', 'required');
                if($this->form_validation->run())
                {
                    $insert = $this->jenisberkas_model->insertJenisberkas($data);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,'csrf'=> $this->security->get_csrf_hash(),"message"=>"Data berhasil di simpan"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        
                'err_kode_jenis' => form_error('kode_jenis'),
                'err_jenis_berkas' => form_error('jenis_berkas'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                
                $this->form_validation->set_rules('kode_jenis', 'kode jenis', 'required');
                    $this->form_validation->set_rules('jenis_berkas', 'jenis berkas', 'required');
                if($this->form_validation->run())
                {
                    $this->jenisberkas_model->updateJenisberkas($data,$kode_jenis);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        
                'err_kode_jenis' => form_error('kode_jenis'),
                'err_jenis_berkas' => form_error('jenis_berkas'),
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
            $this->jenisberkas_model->deleteJenisberkas($id);
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
                'data'  => $this->jenisberkas_model->getJenisberkas(),
            );
            $this->load->view('admin/jenisberkas/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->jenisberkas_model->getJenisberkas(),
            );
            $html=$this->load->view('admin/jenisberkas/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_JENISBERKAS.pdf";
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
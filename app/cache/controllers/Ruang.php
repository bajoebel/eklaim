<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ruang extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('ruang_model');
        $level=$this->session->userdata('level');
        $this->akses=$this->ruang_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'akses'=> $this->akses
            );
            $content=$this->load->view('admin/ruang/view_tabel', $data, true);
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
            $row_count=$this->ruang_model->countRuang($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->ruang_model->getRuanglimit($limit,$start,$q),
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
            $row=$this->ruang_model->getRuang_by_id($id);
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
            $id_ruang=$this->input->post('id_ruang');
        if($this->input->post('status_ruang')==1) $status_ruang=1; else $status_ruang=0;
            $data = array(
                
                'nama_ruang' => $this->input->post('nama_ruang'),
                'status_ruang' => $status_ruang,
            );
            $row=$this->ruang_model->getRuang_by_id($id_ruang);
            if(empty($row)){
                
                    $this->form_validation->set_rules('nama_ruang', 'nama ruang', 'required');
                if($this->form_validation->run())
                {
                    $insert = $this->ruang_model->insertRuang($data);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        
                'err_nama_ruang' => form_error('nama_ruang'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                
                    $this->form_validation->set_rules('nama_ruang', 'nama ruang', 'required');
                if($this->form_validation->run())
                {
                    $this->ruang_model->updateRuang($data,$id_ruang);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        
                'err_nama_ruang' => form_error('nama_ruang'),
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
            $this->ruang_model->deleteRuang($id);
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
                'data'  => $this->ruang_model->getRuang(),
            );
            $this->load->view('admin/ruang/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->ruang_model->getRuang(),
            );
            $html=$this->load->view('admin/ruang/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_RUANG.pdf";
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
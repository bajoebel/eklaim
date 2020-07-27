<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berkasklaim extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('berkasklaim_model');
        $level=$this->session->userdata('level');
        $this->akses=$this->berkasklaim_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
    			'list_m_jenisberkas'=>$this->berkasklaim_model->getM_jenisberkas(),
    			'list_m_berkas'=>$this->berkasklaim_model->getM_berkas(),
                'menu'  => array(),
                'akses'=> $this->akses
            );
            $content=$this->load->view('admin/berkasklaim/view_tabel', $data, true);
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
            $row_count=$this->berkasklaim_model->countBerkasklaim($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->berkasklaim_model->getBerkasklaimlimit($limit,$start,$q),
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
            $row=$this->berkasklaim_model->getBerkasklaim_by_id($id);
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
            $id_bklaim=$this->input->post('id_bklaim');
        if($this->input->post('hardcopy')==1) $hardcopy=1; else $hardcopy=0;
        if($this->input->post('softcopy')==1) $softcopy=1; else $softcopy=0;
        if($this->input->post('wajib')==1) $wajib=1; else $wajib=0;
            $data = array(
                'kode_jenis' => $this->input->post('kode_jenis'),
                'id_berkas' => $this->input->post('id_berkas'),
                'hardcopy' => $hardcopy,
                'softcopy' => $softcopy,
                'wajib' => $wajib,
            );
            $row=$this->berkasklaim_model->getBerkasklaim_by_id($id_bklaim);
            if(empty($row)){
                
                    $this->form_validation->set_rules('kode_jenis', 'kode jenis', 'required');
                    $this->form_validation->set_rules('id_berkas', 'id berkas', 'required');
                if($this->form_validation->run())
                {
                    $insert = $this->berkasklaim_model->insertBerkasklaim($data);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,'csrf'=> $this->security->get_csrf_hash(),"message"=>"Data berhasil di simpan"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_kode_jenis' => form_error('kode_jenis'),
                        'err_id_berkas' => form_error('id_berkas'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                
                    $this->form_validation->set_rules('kode_jenis', 'kode jenis', 'required');
                    $this->form_validation->set_rules('id_berkas', 'id berkas', 'required');
                if($this->form_validation->run())
                {
                    $this->berkasklaim_model->updateBerkasklaim($data,$id_bklaim);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        
                'err_kode_jenis' => form_error('kode_jenis'),
                'err_id_berkas' => form_error('id_berkas'),
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
            $this->berkasklaim_model->deleteBerkasklaim($id);
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
                'data'  => $this->berkasklaim_model->getBerkasklaim(),
            );
            $this->load->view('admin/berkasklaim/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->berkasklaim_model->getBerkasklaim(),
            );
            $html=$this->load->view('admin/berkasklaim/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_BERKASKLAIM.pdf";
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
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('laporan_model');
        $level=$this->session->userdata('level');
        $this->akses=$this->laporan_model->getAkses($level);
    }

	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'akses'=> $this->akses,
                'dir'   => $this->laporan_model->getDir()
            );
            $content=$this->load->view('admin/laporan/view_form', $data, true);
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

    function opendir($sub1="",$sub2="",$sub3="", $sub4=""){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $dir=$this->laporan_model->getDir($sub1,$sub2,$sub3, $sub4);
            $list=array('status'=>true,'message'=>'OK','data'=>$dir);
        }
        else{
            //$this->session->set_flashdata('error', 'Opps... Session expired' );
            //header('location:'.base_url() ."login");
            $list=array('status'=>false,'message'=>'Opps... Session expired','data'=>array());
        }
        header('Content-Type: application/json');
        echo json_encode($list);
    }

    function zip($dir1="",$dir2="",$dir3=""){
        $this->load->library(array('Zip', 'MY_Zip')); // load library zip dan my zip
        $path = '/report/'.$dir1.'/'.$dir2.'/'.$dir3.'/';

        $folder_in_zip = "/";  // tujuan sementara folder zip
        $this->zip->get_files_from_folder($path, $folder_in_zip);
        $this->zip->download('report.zip');
    }

    function dzip($dir1="",$dir2="",$dir3=""){
        $this->load->library('zip'); // load library zip dan my zip
        $path = '/report/'.$dir1.'/'.$dir2.'/'.$dir3.'/80001.pdf';
        $this->zip->read_file($path);

        // Download the file to your desktop. Name it "my_backup.zip"
        $this->zip->download('my_backup.zip');
        //echo $path;exit;
        //$this->zip->read_dir($path);
        //$this->zip->download('report.zip'); 
    }

    function download($dir1="",$dir2="",$dir3="", $dir4=""){
        $this->load->library('zip'); 
        $this->load->helper('file'); 
        $path = 'report/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.$dir4;
        /*$files=get_filenames($path);
        foreach ($files as $f) {
            $this->zip->read_file($path.$f,true);
        }*/
        $bln=array('01'=>'JAN','02'=>'FEB','03'=>'MAR','04'=>'APR','05'=>'MEI','06'=>'JUN','07'=>'JUL','08'=>'AGS','09'=>'SEP','10'=>'OKT','11'=>'NOV','12'=>'DES');
        if(empty($dir1)&&empty($dir2)&&empty($dir3)&&empty($dir4)){
            $path = 'report/';
            $filename="REPORT";
        }else{
            if(empty($dir2)&&empty($dir3)&&empty($dir4)){
                $path = 'report/' .$dir1 ."/";
                $filename="REPORT_".strtoupper($dir1);
            }else{
                if(empty($dir3)&&empty($dir4)){
                    $path = 'report/'.$dir1 ."/".$dir2 ."/";
                    $filename="REPORT_" .strtoupper($dir1) ."_" .$dir2;
                }else{
                    if(empty($dir4)){
                        $path = 'report/'.$dir1 ."/".$dir2 ."/".$dir3 ."/";
                        $filename="REPORT_" .strtoupper($dir1) ."_" .$bln[$dir3]."_" .$dir2;
                    }else{
                        $path = 'report/'.$dir1 ."/".$dir2 ."/".$dir3 ."/"+$dir4 ."/";
                        $filename="REPORT_" .strtoupper($dir1) ."_" .$dir4 ."_".$bln[$dir3]."_" .$dir2;
                    }
                }
            }
        }
        
        $this->zip->read_dir($path, FALSE);

        //echo $path;
        //print_r($files);exit;
        //$this->zip->read_file($path, $new_path);
        /*$fileName = 'myfolder/itsolutionstuff.txt';
        $fileData = 'This file created by Itsolutionstuff.com';
        $this->zip->add_data($fileName, $fileData);
        $fileName2 = 'myfolder/itsolutionstuff_file2.txt';
        $fileData2 = 'This file created by Itsolutionstuff.com - 2';
        $this->zip->add_data($fileName2, $fileData2);*/


        $this->zip->download($filename);
    }

    public function download_zip()
    {
        $this->load->library(array('Zip', 'MY_Zip')); // load library zip dan my zip
        $path = './foto/'; // folder yang ingin kita download
        $folder_in_zip = "/";  // tujuan sementara folder zip
        $this->zip->get_files_from_folder($path, $folder_in_zip);
        $this->zip->download('myzip.zip');
    }
	public function data(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $q = urldecode($this->input->get('q', TRUE));
            $start = intval($this->input->get('start'));
            $limit = 20;
            $row_count=$this->laporan_model->countlaporan($q);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->laporan_model->getlaporanlimit($limit,$start,$q),
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
            $row=$this->laporan_model->getlaporan_by_id($id);
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

    function form($nosep,$id_dokumen=""){
        $cek=array('aksi'=>'laporan');
        if(in_array($cek, $this->akses)){
            $kunjungan=$this->laporan_model->getKunjunganbysep($nosep);
            if(!empty($kunjungan)) $dokumen=$this->laporan_model->getDokumenbysep($kunjungan->kode_jenis);
            else $dokumen=array();
            $data=array(
                'kunjungan' => $kunjungan,
                'dokumen'   => $dokumen,
                'no_sep'    => $nosep,
                'dokumen_id'=> $id_dokumen,
                'priview'   => $this->laporan_model->getPriview($nosep,$id_dokumen),
            );
            $content=$this->load->view('admin/laporan/view_form', $data, true);
            $view=array(
                'content'   => $content
            );
            $this->load->view('view_layout',$view);

        }else{
            header('location:'.base_url() ."login");
        }
    }

    function laporan_dokumen($nosep,$dokumen_id){
        $cek=array('aksi'=>'laporan');
        if(in_array($cek, $this->akses)){
            $data=array('status_laporan'=>1);
            $this->laporan_model->laporan_dokumen($data,$nosep,$dokumen_id);
            header('Content-Type: application/json');
            echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di laporan"));
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE,'error'=>FALSE,"message"=>"Anda Tidak memiliki hak akses"));
        }
    }
    function sep($nosep){
        echo intval(substr($nosep, 13,6));
    }
    function generate_report($nosep){
        $cek=array('aksi'=>'laporan');
        if(in_array($cek, $this->akses)){
            $dokumen=$this->laporan_model->getKunjunganbysep($nosep);
            if(!empty($dokumen)){
                $no_urutsep=substr($nosep, 13,6);
                if(!empty($dokumen->tgl_reg)){
                    $t1=explode(' ', $dokumen->tgl_reg);
                    if(!empty($t1)) $t2=explode('-', $t1[0]);
                    else $t2=explode('-', $dokumen->tgl_reg);
                    if(!empty($t2)){
                        if (!file_exists('report/'.$t2[0].'/'.$t2[1])) {
                            mkdir('report/'.$t2[0].'/'.$t2[1], 0777, true);
                        }
                    } 
                }
                $data=array(
                    'tgl_reg'   => $dokumen->tgl_reg,
                    'nomr'      => $dokumen->nomr,
                    'dokumen'   => $dokumen,
                    'nosep'     => $nosep,
                    'berkas'    => $this->laporan_model->getBerkas($nosep)
                );
                $html=$this->load->view('admin/laporan/view_pdf', $data, true);
                $this->load->library('m_pdf');
                $pdf = $this->m_pdf->load();
                $pdf->WriteHTML($html);
                $pdf->Output('report/'.$t2[0].'/' .$t2[1] .'/' .$no_urutsep .'.pdf','F');
                //echo $content;
                //Simpan Log Generator
                $log=array(
                    'log_nosep'     => $nosep,
                    'log_tglbuat'   => date('Y-m-d'),
                    'log_dir_root'  => 'report',
                    'log_sub_dir1'  => $t2[0],
                    'log_sub_dir2'  => $t2[1],
                    'log_file'      => $no_urutsep .'.pdf'
                );
                $this->laporan_model->insertLog($log,$nosep);
                header('Content-Type: application/json');
                echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"laporan Berhasil Digenerate"));
            }else{
                header('Content-Type: application/json');
                echo json_encode(array("status" => FALSE,'error'=>FALSE,"message"=>"Data Tidak Ditemukan"));
            }
            
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE,'error'=>FALSE,"message"=>"Anda Tidak memiliki hak akses"));
        }
    }
	function save(){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $no_sep =$this->input->post('no_sep');
            $data = array(
                
                'no_sep' => $this->input->post('no_sep'),
                'nomr' => $this->input->post('nomr'),
                'nama_pasien' => $this->input->post('nama_pasien'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tgl_lahir' => $this->input->post('tgl_lahir'),
                'jns_kelamin' => $this->input->post('jns_kelamin'),
                'kode_jenis' => $this->input->post('kode_jenis'),
                'jenis_berkas' => $this->input->post('jenis_berkas'),
                'poliklinik' => $this->input->post('poliklinik'),
                'berkas_wajib' => $this->input->post('berkas_wajib'),
                'jml_laporan' => $this->input->post('jml_laporan'),
                'jml_berkas' => $this->input->post('jml_berkas'),
            );
            $row=$this->laporan_model->getlaporan_by_id($no_sep);
            if(empty($row)){
                
                    $this->form_validation->set_rules('no_sep', 'no sep', 'required');
                    $this->form_validation->set_rules('nomr', 'nomr', 'required');
                    $this->form_validation->set_rules('nama_pasien', 'nama pasien', 'required');
                    $this->form_validation->set_rules('tempat_lahir', 'tempat lahir', 'required');
                    $this->form_validation->set_rules('tgl_lahir', 'tgl lahir', 'required');
                    $this->form_validation->set_rules('jns_kelamin', 'jns kelamin', 'required');
                    $this->form_validation->set_rules('kode_jenis', 'kode jenis', 'required');
                    $this->form_validation->set_rules('jenis_berkas', 'jenis berkas', 'required');
                    $this->form_validation->set_rules('poliklinik', 'poliklinik', 'required');
                    $this->form_validation->set_rules('berkas_wajib', 'berkas wajib', 'required');
                    $this->form_validation->set_rules('jml_laporan', 'jml laporan', 'required');
                    $this->form_validation->set_rules('jml_berkas', 'jml berkas', 'required');
                if($this->form_validation->run())
                {
                    $insert = $this->laporan_model->insertlaporan($data);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di simpan"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_no_sep' => form_error('no_sep'),
                        'err_nomr' => form_error('nomr'),
                        'err_nama_pasien' => form_error('nama_pasien'),
                        'err_tempat_lahir' => form_error('tempat_lahir'),
                        'err_tgl_lahir' => form_error('tgl_lahir'),
                        'err_jns_kelamin' => form_error('jns_kelamin'),
                        'err_kode_jenis' => form_error('kode_jenis'),
                        'err_jenis_berkas' => form_error('jenis_berkas'),
                        'err_poliklinik' => form_error('poliklinik'),
                        'err_berkas_wajib' => form_error('berkas_wajib'),
                        'err_jml_laporan' => form_error('jml_laporan'),
                        'err_jml_berkas' => form_error('jml_berkas'),
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
            }else{
                
                    $this->form_validation->set_rules('no_sep', 'no sep', 'required');
                    $this->form_validation->set_rules('nomr', 'nomr', 'required');
                    $this->form_validation->set_rules('nama_pasien', 'nama pasien', 'required');
                    $this->form_validation->set_rules('tempat_lahir', 'tempat lahir', 'required');
                    $this->form_validation->set_rules('tgl_lahir', 'tgl lahir', 'required');
                    $this->form_validation->set_rules('jns_kelamin', 'jns kelamin', 'required');
                    $this->form_validation->set_rules('kode_jenis', 'kode jenis', 'required');
                    $this->form_validation->set_rules('jenis_berkas', 'jenis berkas', 'required');
                    $this->form_validation->set_rules('poliklinik', 'poliklinik', 'required');
                    $this->form_validation->set_rules('berkas_wajib', 'berkas wajib', 'required');
                    $this->form_validation->set_rules('jml_laporan', 'jml laporan', 'required');
                    $this->form_validation->set_rules('jml_berkas', 'jml berkas', 'required');
                if($this->form_validation->run())
                {
                    $this->laporan_model->updatelaporan($data,$no_sep);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                }else{
                    $array = array(
                        'status'    => TRUE,
                        'error'     => TRUE,
                        'csrf'      => $this->security->get_csrf_hash(),
                        'message'   => "Data Belum Lengkap",
                        'err_no_sep' => form_error('no_sep'),
                        'err_nomr' => form_error('nomr'),
                        'err_nama_pasien' => form_error('nama_pasien'),
                        'err_tempat_lahir' => form_error('tempat_lahir'),
                        'err_tgl_lahir' => form_error('tgl_lahir'),
                        'err_jns_kelamin' => form_error('jns_kelamin'),
                        'err_kode_jenis' => form_error('kode_jenis'),
                        'err_jenis_berkas' => form_error('jenis_berkas'),
                        'err_poliklinik' => form_error('poliklinik'),
                        'err_berkas_wajib' => form_error('berkas_wajib'),
                        'err_jml_laporan' => form_error('jml_laporan'),
                        'err_jml_berkas' => form_error('jml_berkas'),
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
            $this->laporan_model->deletelaporan($id);
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
                'data'  => $this->laporan_model->getlaporan(),
            );
            $this->load->view('admin/laporan/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->laporan_model->getlaporan(),
            );
            $html=$this->load->view('admin/laporan/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_laporan.pdf";
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
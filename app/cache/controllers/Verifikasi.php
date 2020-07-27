<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifikasi extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('verifikasi_model');
        $level=$this->session->userdata('level');
        $this->akses=$this->verifikasi_model->getAkses($level);
    }

	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
                'menu'  => array(),
                'akses'=> $this->akses
            );
            $content=$this->load->view('admin/verifikasi/view_tabel', $data, true);
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
            $ritl = intval($this->input->get('ritl'));
            $rjtl = intval($this->input->get('rjtl'));
            $limit = 20;
            $row_count=$this->verifikasi_model->countVerifikasi($q, $ritl, $rjtl);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->verifikasi_model->getVerifikasilimit($limit,$start,$q, $ritl, $rjtl),
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
	function edit($iddaftar=""){
        $cek=array('aksi'=>'Verifikasi');
        if(in_array($cek, $this->akses)){
            $row=$this->verifikasi_model->getVerifikasi_by_id($iddaftar);
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

    function form($id_daftar,$id_dokumen=""){
        $cek=array('aksi'=>'Verifikasi');
        if(in_array($cek, $this->akses)){
            $kunjungan=$this->verifikasi_model->getKunjunganbyid($id_daftar);
            if(!empty($kunjungan)) $dokumen=$this->verifikasi_model->getDokumenbysep($kunjungan->kode_jenis);
            else $dokumen=array();
            $data=array(
                'kunjungan' => $kunjungan,
                'dokumen'   => $dokumen,
                'id_daftar'    => $id_daftar,
                'dokumen_id'=> $id_dokumen,
                'jenis_berkas'=> $this->verifikasi_model->getJenis(),
                'priview'   => $this->verifikasi_model->getPriview($id_daftar,$id_dokumen),
            );
            $content=$this->load->view('admin/verifikasi/view_form', $data, true);
            $view=array(
                'content'   => $content
            );
            $this->load->view('view_layout',$view);

        }else{
            header('location:'.base_url() ."login");
        }
    }

    function verifikasi_dokumen($iddaftar,$dokumen_id){
        $cek=array('aksi'=>'Verifikasi');
        if(in_array($cek, $this->akses)){
            $data=array('status_verifikasi'=>1,'user_verifikasi'=>$this->session->userdata('username'));
            $this->verifikasi_model->verifikasi_dokumen($data,$iddaftar,$dokumen_id);
            header('Content-Type: application/json');
            echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di verifikasi"));
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE,'error'=>FALSE,"message"=>"Anda Tidak memiliki hak akses"));
        }
    }

    function pulangkan(){
        $cek=array('aksi'=>'Verifikasi');
        if(in_array($cek, $this->akses)){
            $iddaftar=$this->input->post('id_daftar');
            $data=array(
                'tgl_pulang'=>$this->input->post('tgl_pulang'),
                'keadaan_pulang'=> $this->input->post('keadaan_pulang')
            );
            $data_api=array(
                'tgl_keluar'=> $this->input->post('tgl_pulang'),
                'keadaan_pulang'=> $this->input->post('keadaan_pulang')
            );
            $this->load->model('upload_berkas_model');
            $ws=$this->upload_berkas_model->get_web_service('simrs');
            if(!empty($ws)){
                
                $req=array(
                    'client_id'     => $ws->ws_clientid,
                    'client_key'    => $ws->ws_key,
                    'data'          => $data_api,
                    'id_daftar'     => $iddaftar
                );
                $list = $this->upload_berkas_model->request_data($req,$ws->ws_url ."pulangkan");
                //header('Content-Type: application/json');
                //echo $list;
            }else{
                $list=array(
                    'code'      => '999',
                    'status'    => false,
                    'message'   => "Web Service Tidak Aktif",
                    'data'      => array()
                );
                //header('Content-Type: application/json');
                //echo json_encode($list);
            }

            $this->verifikasi_model->pulangkan($data,$iddaftar);
            header('Content-Type: application/json');
            echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Pasien sudah dipulangkan",'csrf'=>$this->security->get_csrf_token_name()));
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE,'error'=>FALSE,"message"=>"Anda Tidak memiliki hak akses"));
        }
    }
    function sep($nosep){
        echo intval(substr($nosep, 13,6));
    }
    function generate_report($id_daftar){
        $cek=array('aksi'=>'Verifikasi');
        if(in_array($cek, $this->akses)){
            $dokumen=$this->verifikasi_model->getKunjunganbyid($id_daftar);
            //print_r($dokumen);exit;
            if(!empty($dokumen)){
                $no_urutsep=substr($dokumen->no_sep, 13,6);
                if($dokumen->kode_jenis=='RJTL'){
                    if(!empty($dokumen->tgl_reg)){
                        $t1=explode(' ', $dokumen->tgl_reg);
                        if(!empty($t1)) $t2=explode('-', $t1[0]);
                        else $t2=explode('-', $dokumen->tgl_reg);
                        if(!empty($t2)){
                            if (!file_exists('report/'.$t2[0].'/'.$t2[1] ."/" .$t2[2])) {
                                mkdir('report/'.$t2[0].'/'.$t2[1]."/" .$t2[2], 0777, true);
                            }
                        } 
                    }
                    $data=array(
                        'tgl_reg'   => $dokumen->tgl_reg,
                        'nomr'      => $dokumen->nomr,
                        'dokumen'   => $dokumen,
                        'nosep'     => $dokumen->no_sep,
                        'id_daftar' => $dokumen->id_daftar,
                        'berkas'    => $this->verifikasi_model->getBerkas($dokumen->no_sep)
                    );
                    $html=$this->load->view('admin/verifikasi/view_pdf', $data, true);
                    $this->load->library('m_pdf');
                    $pdf = $this->m_pdf->load();
                    $pdf->WriteHTML($html);
                    $pdf->Output('report/'.$t2[0].'/' .$t2[1] .'/' .$t2[2] .'/' .$no_urutsep .'.pdf','F');
                    //echo $content;
                    //Simpan Log Generator
                    $log=array(
                        'log_nosep'     => $dokumen->no_sep,
                        'log_iddaftar'  => $dokumen->id_daftar,
                        'log_tglbuat'   => date('Y-m-d'),
                        'log_dir_root'  => 'report',
                        'log_sub_dir1'  => $t2[0],
                        'log_sub_dir2'  => $t2[1],
                        'log_sub_dir3'  => $t2[2],
                        'log_file'      => $no_urutsep .'.pdf'
                    );
                    $this->verifikasi_model->insertLog($log,$dokumen->no_sep);
                    header('Content-Type: application/json');
                    echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"laporan Berhasil Digenerate"));
                }else{
                    $tgl_pulang =  $dokumen->tgl_pulang; 
                    //echo $tgl_pulang;exit;
                    if(empty($tgl_pulang) || $tgl_pulang=='0000-00-00'){
                        //echo $tgl_pulang;exit;
                        header('Content-Type: application/json');
                        echo json_encode(array("status" => FALSE,'error'=>TRUE,"message"=>"Pasien Belum Dipulangkan..."));
                    }else{
                        $t1=explode(' ', $dokumen->tgl_pulang);
                        if(!empty($t1)) $t2=explode('-', $t1[0]);
                        else $t2=explode('-', $dokumen->tgl_pulang);
                        if(!empty($t2)){
                            if (!file_exists('report/'.$t2[0].'/'.$t2[1] ."/" .$t2[2])) {
                                mkdir('report/'.$t2[0].'/'.$t2[1]."/" .$t2[2], 0777, true);
                            }
                        } 
                        //print_r($t1);exit;
                        $data=array(
                            'tgl_reg'   => $dokumen->tgl_reg,
                            'nomr'      => $dokumen->nomr,
                            'dokumen'   => $dokumen,
                            'nosep'     => $dokumen->no_sep,
                            'id_daftar' => $dokumen->id_daftar,
                            'berkas'    => $this->verifikasi_model->getBerkas($dokumen->no_sep)
                        );
                        $html=$this->load->view('admin/verifikasi/view_pdf', $data, true);
                        $this->load->library('m_pdf');
                        $pdf = $this->m_pdf->load();
                        $pdf->WriteHTML($html);
                        $pdf->Output('report/'.$t2[0].'/' .$t2[1] .'/' .$t2[2] .'/' .$no_urutsep .'.pdf','F');
                        //echo $content;
                        //Simpan Log Generator
                        $log=array(
                            'log_nosep'     => $dokumen->no_sep,
                            'log_iddaftar'  => $dokumen->id_daftar,
                            'log_tglbuat'   => date('Y-m-d'),
                            'log_dir_root'  => 'report',
                            'log_sub_dir1'  => $t2[0],
                            'log_sub_dir2'  => $t2[1],
                            'log_sub_dir3'  => $t2[2],
                            'log_file'      => $no_urutsep .'.pdf'
                        );
                        $this->verifikasi_model->insertLog($log,$dokumen->no_sep);
                        header('Content-Type: application/json');
                        echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"laporan Berhasil Digenerate"));
                    }
                }
                    
            }else{
                header('Content-Type: application/json');
                echo json_encode(array("status" => FALSE,'error'=>FALSE,"message"=>"Data Tidak Ditemukan"));
            }
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE,'error'=>FALSE,"message"=>"Anda Tidak memiliki hak akses"));
        }
    }
	function update(){
        $cek=array('aksi'=>'Verifikasi');
        if(in_array($cek, $this->akses)){
            $id_daftar =$this->input->post('id_daftar');
            $data = array(
                'no_sep' => $this->input->post('no_sep'),
                'kode_jenis' => $this->input->post('kode_jenis'),
            );
            $this->db->where('id_daftar',$id_daftar);
            $this->db->update('t_berkaspasien',$data);
            header('Content-Type: application/json');
            echo json_encode(array("status" => true,'error'=>false, "message"=> "Data Sudah diupdate"));
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => False,'error'=>TRUE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
        }
    }
    function save(){
        $this->load->model('upload_berkas_model');
        $cek=array('aksi'=>'Verifikasi');
        if(in_array($cek, $this->akses)){
            $id_file=$this->input->post('id_file');
            if($this->input->post('status_verifikasi')==1) $status_verifikasi=1; else $status_verifikasi=0;
            //Import data pasien
            $nomr=$this->input->post('nomr');
            $cek=$this->upload_berkas_model->cekPasien($nomr);
            $ws=$this->upload_berkas_model->get_web_service('simrs');
            if(empty($cek)){
                $ws=$this->upload_berkas_model->get_web_service('simrs');
                if(!empty($ws)){
                    $parameter=array(
                        'nomr'   => $nomr,
                    );
                    $req=array(
                        'client_id'     => $ws->ws_clientid,
                        'client_key'    => $ws->ws_key,
                        'parameter'     => $parameter
                    );
                    $list = $this->upload_berkas_model->request_data($req,$ws->ws_url ."getpasien");
                    $data_array=json_decode($list);
                    //($data_array->data);exit;
                    if($data_array->code==200){
                        $data_pasien=$data_array->data;
                        $this->db->insert('m_pasien',$data_pasien);
                    }
                }
            }
            if(!empty($ws)){
                //Update no_sep di tabel t_pendaftaran
                    $param=array(
                        'id_daftar'   => $this->input->post('id_daftar'),
                    );
                    $data=array(
                        'no_sep'    => $this->input->post('no_sep')
                    );
                    $req=array(
                        'client_id'     => $ws->ws_clientid,
                        'client_key'    => $ws->ws_key,
                        'parameter'     => $param,
                        'data'          => $data
                    );
                    if($this->input->post('kode_jenis')=="RITL"){
                        $test = $this->upload_berkas_model->request_data($req,$ws->ws_url ."updateranap");
                    }else{
                        $test = $this->upload_berkas_model->request_data($req,$ws->ws_url ."updatependaftaran");
                    }
                    
                    //print_r(json_decode($test));exit;
            }    
            $data = array(
                'tgl_upload' => date('Y-m-d H:i:s'),
                'nomr' => $this->input->post('nomr'),
                'id_daftar' => $this->input->post('id_daftar'),
                'no_sep' => $this->input->post('no_sep'),
                'nama_pasien' => $this->input->post('nama_pasien'),
                'kode_jenis' => $this->input->post('kode_jenis'),
                'tgl_reg'=> $this->input->post('tgl_reg'),
                'tgl_pulang'    => $this->input->post('tgl_pulang'),
                'grId'  => $this->input->post('grId'),
                'id_berkas' => $this->input->post('id_berkas'),
                'keadaan_pulang'=> $this->input->post('keadaan_pulang'),
                'user_upload' => $this->session->userdata('username'),
            );


            $row=$this->upload_berkas_model->getUpload_berkas_by_id($id_file);
            
            if(empty($row)){
                $cek=$this->upload_berkas_model->cekBerkas($this->input->post('no_sep'),$this->input->post('id_berkas'));
                if(empty($cek)){
                    $this->form_validation->set_rules('nomr', 'nomr', 'required');
                    $this->form_validation->set_rules('id_daftar', 'id daftar', 'required');
                    $this->form_validation->set_rules('no_sep', 'no sep', 'required');
                    $this->form_validation->set_rules('nama_pasien', 'nama pasien', 'required');
                    $this->form_validation->set_rules('kode_jenis', 'kode jenis', 'required');
                    $this->form_validation->set_rules('id_berkas', 'id berkas', 'required');
                    if($this->form_validation->run())
                    {
                        $nomr=$this->input->post('nomr');
                        $tgl_reg=$this->input->post('tgl_reg');
                        $id_daftar=$this->input->post('id_daftar');
                        $no_sep=$this->input->post('no_sep');
                        if(!empty($tgl_reg)){
                           $t1=explode(' ', $tgl_reg);
                            if(!empty($t1)) $t2=explode('-', $t1[0]);
                            else $t2=explode('-', $tgl_reg);
                            if(!empty($t2)){
                                if (!file_exists('files/'.$t2[0].'/'.$t2[1]."/".$nomr ."/" .$id_daftar)) {
                                    mkdir('files/'.$t2[0].'/'.$t2[1]."/".$nomr ."/" .$id_daftar, 0777, true);
                                }
                            } 
                        }
                        
                        if(!empty($_FILES['userfile'])){
                            //$no_sep=$this->input->post('no_sep');
                            $id_berkas=str_pad($this->input->post('id_berkas'), '2','0',STR_PAD_LEFT);
                            $image=$this->upload_berkas_model->upload_files('./files/'.$t2[0].'/'.$t2[1]."/".$nomr."/" .$id_daftar,'BERKAS_'.$id_berkas.'_'.$no_sep,$_FILES['userfile']);
                            //print_r($image);exit;
                            if(!empty($image)){
                                $insert = $this->upload_berkas_model->insertUpload_berkas($data);
                                //UPDATE SEP DENGAN NOSEP RAWAT INAP
                                if(!empty($insert)){
                                    if($this->input->post('kode_jenis')=='RITL'){
                                        $data_ranap = array(
                                            'no_sep'=>$this->input->post('no_sep'),
                                            'kode_jenis'=> $this->input->post('kode_jenis'),
                                            'grId'  => $this->input->post('grId')
                                        );

                                        $this->upload_berkas_model->updateBerkas($data_ranap,$this->input->post('id_daftar'));
                                    }
                                }
                                foreach ($image as $im) {
                                   // echo $im ."<br>";
                                    $img[]=array(
                                        'd_idfile'=>$insert,
                                        'd_nama_file'=>$im
                                    );
                                }

                                //exit;
                                $this->db->insert_batch('d_berkaspasien',$img);

                                $response=array('status'=>true,'error'=>false,'message'=>'Berhasil Upload Berkas');
                            }else{
                                $response=array('status'=>false,'error'=>true,'message'=>'Gagal Upload Data');
                            }
                        }else{
                            $response=array('status'=>false,'error'=>true,'message'=>'Tidak ada file yang akan diupload');
                        }
                        header('Content-Type: application/json');
                        echo json_encode($response);
                    }else{
                        $array = array(
                            'status'            => TRUE,
                            'error'             => TRUE,
                            'csrf'              => $this->security->get_csrf_hash(),
                            'message'           => "Data Belum Lengkap",
                            'err_tgl_upload'    => form_error('tgl_upload'),
                            'err_nomr'          => form_error('nomr'),
                            'err_id_daftar'     => form_error('id_daftar'),
                            'err_no_sep'        => form_error('no_sep'),
                            'err_nama_pasien'   => form_error('nama_pasien'),
                            'err_kode_jenis'    => form_error('kode_jenis'),
                            'err_id_berkas'     => form_error('id_berkas'),
                        );
                        header('Content-Type: application/json');
                        echo json_encode($array);
                    }
                }else{
                    $array = array(
                        'status'            => TRUE,
                        'error'             => TRUE,
                        'csrf'              => $this->security->get_csrf_hash(),
                        'message'           => 'Berkas untuk nosep ' .$this->input->post('no_sep') ." Sudah ada",
                        'err_tgl_upload'    => '',
                        'err_nomr'          => '',
                        'err_id_daftar'     => '',
                        'err_no_sep'        => '',
                        'err_nama_pasien'   => '',
                        'err_kode_jenis'    => '',
                        'err_id_berkas'     => 'Berkas untuk nosep ' .$this->input->post('no_sep') ." Sudah ada",
                    );
                    header('Content-Type: application/json');
                    echo json_encode($array);
                }
                    
            }else{
                $this->form_validation->set_rules('tgl_upload', 'tgl upload', 'required');
                $this->form_validation->set_rules('nomr', 'nomr', 'required');
                $this->form_validation->set_rules('id_daftar', 'id daftar', 'required');
                $this->form_validation->set_rules('no_sep', 'no sep', 'required');
                $this->form_validation->set_rules('nama_pasien', 'nama pasien', 'required');
                $this->form_validation->set_rules('kode_jenis', 'kode jenis', 'required');
                $this->form_validation->set_rules('id_berkas', 'id berkas', 'required');
                if($this->form_validation->run())
                {
                    $nomr=$this->input->post('nomr');
                        $tgl_reg=$this->input->post('tgl_reg');
                        $no_sep=$this->input->post('no_sep');
                        $id_daftar=$this->input->post('id_daftar');
                        if(!empty($tgl_reg)){
                           $t1=explode(' ', $tgl_reg);
                            if(!empty($t1)) $t2=explode('-', $t1[0]);
                            else $t2=explode('-', $tgl_reg);
                            if(!empty($t2)){
                                if (!file_exists('files/'.$t2[0].'/'.$t2[1]."/".$nomr ."/" .$id_daftar)) {
                                    mkdir('files/'.$t2[0].'/'.$t2[1]."/".$nomr ."/" .$id_daftar, 0777, true);
                                }
                            } 
                        }
                        
                        if(!empty($_FILES['userfile'])){
                            //$no_sep=$this->input->post('no_sep');
                            $id_berkas=str_pad($this->input->post('id_berkas'), '2','0',STR_PAD_LEFT);
                            $image=$this->upload_berkas_model->upload_files('./files/'.$t2[0].'/'.$t2[1]."/".$nomr."/" .$id_daftar,'BERKAS_'.$id_berkas.'_'.$no_sep,$_FILES['userfile']);
                            //print_r($image);exit;
                            if(!empty($image)){
                                $this->upload_berkas_model->updateUpload_berkas($data,$id_file);

                                if($this->input->post('kode_jenis')=='RITL'){
                                        $data_ranap = array(
                                            'no_sep'=>$this->input->post('no_sep'),
                                            'kode_jenis'=> $this->input->post('kode_jenis'),
                                            'grId'  => $this->input->post('grId')
                                        );

                                        $this->upload_berkas_model->updateBerkas($data_ranap,$this->input->post('id_daftar'));
                                    }

                                    //echo $this->input->post('kode_jenis'); exit;
                                foreach ($image as $im) {
                                   // echo $im ."<br>";
                                    $img[]=array(
                                        'd_idfile'=>$id_file,
                                        'd_nama_file'=>$im
                                    );
                                }

                                //exit;
                                $this->db->insert_batch('d_berkaspasien',$img);
                                $response=array('status'=>true,'error'=>false,'message'=>'Berhasil Upload Berkas');
                            }else{
                                $response=array('status'=>false,'error'=>true,'message'=>'Gagal Upload Data');
                            }
                        }else{
                            $this->upload_berkas_model->updateUpload_berkas($data,$id_file);
                            $response=array('status'=>true,'error'=>false,'message'=>'Data berhasil diupdate');
                        }
                        header('Content-Type: application/json');
                        echo json_encode($response);
                    
                    //header('Content-Type: application/json');
                    //echo json_encode(array("status" => TRUE,'error'=>FALSE,"message"=>"Data berhasil di update"));
                }else{
                    $array = array(
                        'status'            => TRUE,
                        'error'             => TRUE,
                        'csrf'              => $this->security->get_csrf_hash(),
                        'message'           => "Data Belum Lengkap",
                        'err_tgl_upload'    => form_error('tgl_upload'),
                        'err_nomr'          => form_error('nomr'),
                        'err_id_daftar'     => form_error('id_daftar'),
                        'err_no_sep'        => form_error('no_sep'),
                        'err_nama_pasien'   => form_error('nama_pasien'),
                        'err_kode_jenis'    => form_error('kode_jenis'),
                        'err_id_berkas'     => form_error('id_berkas'),
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
            $this->verifikasi_model->deleteVerifikasi($id);
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
                'data'  => $this->verifikasi_model->getVerifikasi(),
            );
            $this->load->view('admin/verifikasi/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->verifikasi_model->getVerifikasi(),
            );
            $html=$this->load->view('admin/verifikasi/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_VERIFIKASI.pdf";
            $this->load->library('m_pdf');
            $pdf = $this->m_pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pdfFilePath, "D");
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
        
    }

    function update_file(){
        $cek=array('aksi'=>'Verifikasi');
        if(in_array($cek, $this->akses)){

            $d_id=$this->input->post('d_id');
            $tgl_reg=$this->input->post('tgl_reg');
            $nomr=$this->input->post('nomr');
            $no_sep=$this->input->post('no_sep');
            $id_daftar=$this->input->post('id_daftar');
            $id_berkas=$this->input->post('id_berkas');
            if(!empty($tgl_reg)){
                $t1=explode(' ', $tgl_reg);
                if(!empty($t1)) $t2=explode('-', $t1[0]);
                else $t2=explode('-', $tgl_reg);
                if(!empty($t2)){
                    if (!file_exists('files/'.$t2[0].'/'.$t2[1]."/".$nomr ."/" .$id_daftar)) {
                        mkdir('files/'.$t2[0].'/'.$t2[1]."/".$nomr ."/" .$id_daftar, 0777, true);
                    }
                } 
            }
            $this->load->model("upload_berkas_model");
            $image=$this->upload_berkas_model->upload_files('./files/'.$t2[0].'/'.$t2[1]."/".$nomr."/" .$id_daftar,'BERKAS_'.$id_berkas.'_'.$no_sep,$_FILES['userfile']);
            if(!empty($image)){
                foreach ($image as $im) {
                    $img[]=array(
                        'd_id'=>$d_id,
                        'd_nama_file'=>$im
                    );
                }
                $this->db->update_batch('d_berkaspasien',$img,'d_id');
                header('Content-Type: application/json');
                echo json_encode(array("status" => TRUE, "message"=> "Data Berhasil diupdate"));
            }else{
                header('Content-Type: application/json');
                echo json_encode(array("status" => FALSE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
            }
        }
    }

    function add_file(){
        $cek=array('aksi'=>'Verifikasi');
        if(in_array($cek, $this->akses)){

            $d_id=$this->input->post('d_id');
            $tgl_reg=$this->input->post('tgl_reg');
            $nomr=$this->input->post('nomr');
            $no_sep=$this->input->post('no_sep');
            $id_daftar=$this->input->post('id_daftar');
            $id_berkas=$this->input->post('id_berkas');
            if(!empty($tgl_reg)){
                $t1=explode(' ', $tgl_reg);
                if(!empty($t1)) $t2=explode('-', $t1[0]);
                else $t2=explode('-', $tgl_reg);
                if(!empty($t2)){
                    if (!file_exists('files/'.$t2[0].'/'.$t2[1]."/".$nomr ."/" .$id_daftar)) {
                        mkdir('files/'.$t2[0].'/'.$t2[1]."/".$nomr ."/" .$id_daftar, 0777, true);
                    }
                } 
            }
            $this->load->model("upload_berkas_model");
            $image=$this->upload_berkas_model->upload_files('./files/'.$t2[0].'/'.$t2[1]."/".$nomr."/" .$id_daftar,'BERKAS_'.$id_berkas.'_'.$no_sep,$_FILES['userfile']);
            if(!empty($image)){
                foreach ($image as $im) {
                    $img[]=array(
                        'd_idfile'=> $this->input->post('d_idfile'),
                        'd_nama_file'=>$im
                    );
                }
                $this->db->insert_batch('d_berkaspasien',$img,'d_id');
                header('Content-Type: application/json');
                echo json_encode(array("status" => TRUE, "message"=> "Data Berhasil diupdate"));
            }else{
                header('Content-Type: application/json');
                echo json_encode(array("status" => FALSE, "message"=> "Anda tidak berhak untuk mengakases halaman ini"));
            }
        }
    }

    
}
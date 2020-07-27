<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_berkas extends CI_Controller {
    private $akses=array();
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('upload_berkas_model');
        $level=$this->session->userdata('level');
        if(empty($level)) $level=1;
        $this->akses=$this->upload_berkas_model->getAkses($level);
    }
        
	public function index(){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $data=array(
    			'list_m_jenisberkas'=>$this->upload_berkas_model->getM_jenisberkas(),
    			'list_m_berkas'=>$this->upload_berkas_model->getM_berkas(),
                'menu'  => array(),
                'akses'=> $this->akses
            );
            $content=$this->load->view('admin/upload_berkas/view_tabel', $data, true);
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
    function form($id=""){
        $cek=array('aksi'=>"Save");
        if(in_array($cek, $this->akses)){
            $berkas=$this->upload_berkas_model->getUpload_berkas_by_id($id);
            //print_r($berkas);exit;
            //echo $berkas->id_daftar; exit;
            if(!empty($berkas)) $id_daftar=$berkas->id_daftar; else $id_daftar="";
            //$histori=$this->upload_berkas_model->getHistori($id_daftar);
            //print_r($histori);exit;
            $data=array(
                'list_m_jenisberkas'=>$this->upload_berkas_model->getM_jenisberkas(),
                'list_m_berkas'=>$this->upload_berkas_model->getM_berkas(),
                'berkas'    => $this->upload_berkas_model->getUpload_berkas_by_id($id),
                'menu'  => array(),
                'akses'=> $this->akses
            );
            $content=$this->load->view('admin/upload_berkas/view_form', $data, true);
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

    function detail_berkas($id_file){
        $cek=array('aksi'=>"Save");
        if(in_array($cek, $this->akses)){
            $data=array(
                'berkas'    => $this->upload_berkas_model->getDetailberkas($id_file),
                'akses'=> $this->akses
            );
            $this->load->view('admin/upload_berkas/view_detail', $data);
            
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
            $row_count=$this->upload_berkas_model->countUpload_berkas($q, $ritl, $rjtl);
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'start'     => $start,
                'row_count' => $row_count,
                'limit'     => $limit,
                'data'     => $this->upload_berkas_model->getUpload_berkaslimit($limit,$start,$q, $ritl, $rjtl),
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

    public function histori($id_daftar){
        $cek=array('aksi'=>"Index");
        if(in_array($cek, $this->akses)){
            $q = urldecode($this->input->get('q', TRUE));
            $start = intval($this->input->get('start'));
            $limit = 20;
            $list=array(
                'status'    => true,
                'message'   => "OK",
                'data'     => $this->upload_berkas_model->getHistori($id_daftar),
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
    function ruangan($jenis=""){
        
            $ws=$this->upload_berkas_model->get_web_service('simrs');
            if(!empty($ws)){
                if($jenis=="RJTL"){
                    $glid=array('GL002','GL003','GL005');
                }elseif($jenis=="RITL"){
                    $glid=array('GL001');
                }else{
                    $glid=array();
                }
                $req=array(
                    'client_id'     => $ws->ws_clientid,
                    'client_key'    => $ws->ws_key,
                    'parameter'     => $glid
                );
                $list = $this->upload_berkas_model->request_data($req,$ws->ws_url ."ruangan");
                //print_r($list);exit;
                //$list = json_decode($res_json);
                header('Content-Type: application/json');
                echo $list;
            }else{
                $list=array(
                    'code'      => '999',
                    'status'    => false,
                    'message'   => "Web Service Tidak Aktif",
                    'data'      => array()
                );
                header('Content-Type: application/json');
                echo json_encode($list);
            }
            
        
    }

    function rjtl($start=0){
        $ws=$this->upload_berkas_model->get_web_service('simrs');
        if(!empty($ws)){
            $tgl_reg=urldecode($this->input->get('tglreg'));
            $grId=urldecode($this->input->get('ruang'));
            $keyword=urldecode($this->input->get('key_word'));

            $parameter=array(
                'tgl_reg'   => $tgl_reg,
                'grId'      => $grId,
                'key_word'   => $keyword,
                'limit'     => 20,
                'start'     => $start
            );
            $req=array(
                'client_id'     => $ws->ws_clientid,
                'client_key'    => $ws->ws_key,
                'parameter'     => $parameter
            );
            $list = $this->upload_berkas_model->request_data($req,$ws->ws_url ."rjtl");
            header('Content-Type: application/json');
            //echo $ws->ws_url ."rjtl";
            echo $list;
        }else{
            $list=array(
                'code'      => '999',
                'status'    => false,
                'message'   => "Web Service Tidak Aktif",
                'data'      => array()
            );
            header('Content-Type: application/json');
            echo json_encode($list);
        }
    }

    function ritl($start=0){
        $ws=$this->upload_berkas_model->get_web_service('simrs');
        if(!empty($ws)){
            $tgl_reg=urldecode($this->input->get('tglreg'));
            $grId=urldecode($this->input->get('ruang'));
            $keyword=urldecode($this->input->get('key_word'));

            $parameter=array(
                'tgl_reg'   => $tgl_reg,
                'grId'      => $grId,
                'key_word'   => $keyword,
                'limit'     => 20,
                'start'     => $start
            );
            $req=array(
                'client_id'     => $ws->ws_clientid,
                'client_key'    => $ws->ws_key,
                'parameter'     => $parameter
            );
            $list = $this->upload_berkas_model->request_data($req,$ws->ws_url ."ritl");
            header('Content-Type: application/json');
            echo $list;
        }else{
            $list=array(
                'code'      => '999',
                'status'    => false,
                'message'   => "Web Service Tidak Aktif",
                'data'      => array()
            );
            header('Content-Type: application/json');
            echo json_encode($list);
        }
    }

    function rjtlbyid($id_daftar=0){
        $ws=$this->upload_berkas_model->get_web_service('simrs');
        if(!empty($ws)){
            $parameter=array(
                'id_daftar'   => $id_daftar,
            );
            $req=array(
                'client_id'     => $ws->ws_clientid,
                'client_key'    => $ws->ws_key,
                'parameter'     => $parameter
            );
            $list = $this->upload_berkas_model->request_data($req,$ws->ws_url ."rjtlbyid/".$id_daftar);
            header('Content-Type: application/json');
            echo $list;
        }else{
            $list=array(
                'code'      => '999',
                'status'    => false,
                'message'   => "Web Service Tidak Aktif",
                'data'      => array()
            );
            header('Content-Type: application/json');
            echo json_encode($list);
        }
    }

    function ritlbyid($id_daftar=0){
        $ws=$this->upload_berkas_model->get_web_service('simrs');
        if(!empty($ws)){
            $parameter=array(
                'id_daftar'   => $id_daftar,
            );
            $req=array(
                'client_id'     => $ws->ws_clientid,
                'client_key'    => $ws->ws_key,
                'parameter'     => $parameter
            );
            $list = $this->upload_berkas_model->request_data($req,$ws->ws_url ."ritlbyid/".$id_daftar);
            header('Content-Type: application/json');
            echo $list;
        }else{
            $list=array(
                'code'      => '999',
                'status'    => false,
                'message'   => "Web Service Tidak Aktif",
                'data'      => array()
            );
            header('Content-Type: application/json');
            echo json_encode($list);
        }
    }

	function edit($id=""){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $row=$this->upload_berkas_model->getUpload_berkas_by_id($id);
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

                                $response=array('status'=>true,'error'=>false,'message'=>'Berhasil Upload Berkas','csrf'=>$this->security->get_csrf_hash());
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
                                $response=array('status'=>true,'error'=>false,'message'=>'Berhasil Upload Berkas','csrf'=>$this->security->get_csrf_hash());

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
            $this->upload_berkas_model->deleteUpload_berkas($id);
            header('Content-Type: application/json');
            echo json_encode(array("status" => TRUE, "message"=> "Data Berhasil dihapus"));
        }else{
            header('Content-Type: application/json');
            echo json_encode(array("status" => FALSE, "message"=> "Anda tidak berhak untuk menghapus data ini"));
        }
        
    }
	function excel(){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->upload_berkas_model->getUpload_berkas(),
            );
            $this->load->view('admin/upload_berkas/view_data_excel',$data);
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
    }
	function pdf(){
        $cek=array('aksi'=>ucwords($this->uri->segment(2)));
        if(in_array($cek, $this->akses)){
            $data=array(
                'data'  => $this->upload_berkas_model->getUpload_berkas(),
            );
            $html=$this->load->view('admin/upload_berkas/view_data_pdf',$data, true);
            $pdfFilePath = "DATA_UPLOAD_BERKAS.pdf";
            $this->load->library('m_pdf');
            $pdf = $this->m_pdf->load();
            $pdf->WriteHTML($html);
            $pdf->Output($pdfFilePath, "D");
        }else{
            $this->session->set_flashdata('error', 'Opps... Session expired' );
            header('location:'.base_url() ."login");
        }
        
    }
    function berkas($kode_jenis=""){
        $level=$this->session->userdata('level');
        if(empty($level)) $level=1;
        $berkas=$this->upload_berkas_model->getBerkas($kode_jenis,$level);
        header('Content-Type: application/json');
        echo json_encode($berkas);
    }

    function delete_berkas($id){
        $level=$this->session->userdata('level');
        if(empty($level)) $level=1;
        if(!empty($level)){
            $this->upload_berkas_model->hapusBerkas($id);
            header('Content-Type: application/json');
            echo json_encode(array('status'=>true,'message'=>"Hapus Data Berhasil"));
        }

    }
}
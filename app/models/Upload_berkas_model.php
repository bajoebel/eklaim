<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Upload_berkas_model extends CI_Model
{
    public $table = 't_berkaspasien';
    public $key = 'id_file';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getUpload_berkas()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getUpload_berkaslimit($limit, $start = 0, $q = NULL, $ritl="0", $rjtl="0") {
        $this->db->order_by($this->key, $this->order);
        $this->db->select('*,count(d_nama_file) as jml_halaman');
        $this->db->join('m_berkas','t_berkaspasien.id_berkas=m_berkas.id_berkas');
        $this->db->join('d_berkaspasien','d_berkaspasien.d_idfile=id_file');
        $this->db->group_by('id_file');
        /*$this->db->group_start();
        $this->db->where_in("id_file","SELECT d_idfile FROM d_berkaspasien GROUP BY d_idfile");
        $this->db->or_where_not_in("id_file","SELECT d_idfile FROM d_berkaspasien GROUP BY d_idfile");
        $this->db->group_end();*/
        if($ritl=="1" && $rjtl=="1") {
            $this->db->group_start();
            $this->db->where("kode_jenis","RITL");
            $this->db->or_where("kode_jenis","RJTL");
            $this->db->group_end();
        }else{
            if($ritl=="0"&&$rjtl=="0"){
                $this->db->group_start();
                $this->db->where("kode_jenis","RITL");
                $this->db->where("kode_jenis","RJTL");
                $this->db->group_end();
            }else{
                $this->db->group_start();
                if($ritl=="1") $this->db->where("kode_jenis","RITL");
                if($rjtl=="1") $this->db->where("kode_jenis","RJTL");
                $this->db->group_end();
            }
            
        }
        $this->db->group_start();
        $this->db->like('id_file', $q);
                $this->db->or_like('tgl_upload', $q);
                $this->db->or_like('nomr', $q);
                $this->db->or_like('id_daftar', $q);
                $this->db->or_like('no_sep', $q);
                $this->db->or_like('nama_pasien', $q);
                $this->db->or_like('kode_jenis', $q);
                $this->db->or_like('nama_berkas', $q);
                $this->db->or_like('status_verifikasi', $q);
                $this->db->or_like('user_upload', $q);
                $this->db->or_like('user_verifikasi', $q);
        $this->db->group_end();
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countUpload_berkas($q = NULL, $ritl="0", $rjtl="0") {
        $this->db->join('m_berkas','t_berkaspasien.id_berkas=m_berkas.id_berkas');
        if($ritl=="1" && $rjtl=="1") {
            $this->db->group_start();
            $this->db->where("kode_jenis","RITL");
            $this->db->or_where("kode_jenis","RJTL");
            $this->db->group_end();
        }else{
            if($ritl=="0"&&$rjtl=="0"){
                $this->db->group_start();
                $this->db->where("kode_jenis","RITL");
                $this->db->where("kode_jenis","RJTL");
                $this->db->group_end();
            }else{
                $this->db->group_start();
                if($ritl=="1") $this->db->where("kode_jenis","RITL");
                if($rjtl=="1") $this->db->where("kode_jenis","RJTL");
                $this->db->group_end();
            }
        }
        $this->db->group_start();
        $this->db->like('id_file', $q);
        $this->db->or_like('tgl_upload', $q);
        $this->db->or_like('nomr', $q);
        $this->db->or_like('id_daftar', $q);
        $this->db->or_like('no_sep', $q);
        $this->db->or_like('nama_pasien', $q);
        $this->db->or_like('kode_jenis', $q);
        $this->db->or_like('nama_berkas', $q);
        $this->db->or_like('status_verifikasi', $q);
        $this->db->or_like('user_upload', $q);
        $this->db->or_like('user_verifikasi', $q);
        $this->db->group_end();
        return $this->db->get($this->table)->num_rows();
    }
    public function insertUpload_berkas($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteUpload_berkas($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getUpload_berkas_by_id($id){
        $this->db->select('*,count(d_id) as jml_halaman');
        $this->db->join('m_jenisberkas','m_jenisberkas.kode_jenis=t_berkaspasien.kode_jenis');
        //$this->db->join('m_pasien','t_berkaspasien.nomr=m_pasien.nomr');
        //$this->db->join('group_ruang','t_berkaspasien.grId=group_ruang.grId');
        $this->db->join('m_berkas','t_berkaspasien.id_berkas=m_berkas.id_berkas');
        $this->db->join('d_berkaspasien','d_berkaspasien.d_idfile=t_berkaspasien.id_file','left');
        $this->db->group_by('id_file');
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updateUpload_berkas($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }

    function updateBerkas($data,$id_daftar){
        $this->db->where('id_daftar',$id_daftar);
        $this->db->update('t_berkaspasien',$data);
    }

    function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','upload_berkas');
            return $this->db->get('m_role_akses')->result_array();
        }
    function getTIMESTAMPS(){
        return $this->db->get('TIMESTAMPS')->result();
    }
    function getM_jenisberkas(){
        return $this->db->get('m_jenisberkas')->result();
    }
    function getM_berkas(){
        return $this->db->get('m_berkas')->result();
    }

    function request_data($data,$url){
        //$data = array("name" => "Hagrid", "age" => "36");                                                                    
        $data_string = json_encode($data);                                                           
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );                                                                                                                   
        $result = curl_exec($ch);
        return $result;
    }
    function get_web_service($nama="simrs"){
        $this->db->where('ws_status', 1);
        $this->db->where('ws_nama',$nama);
        return $this->db->get('m_webservice')->row();
    }
    function getBerkas($kode_jenis="",$role_id=""){
        $jenis=strtolower($kode_jenis);
        $this->db->order_by('m_role_berkas.id_berkas');
        $this->db->select('role_id,m_role_berkas.id_berkas,nama_berkas,softcopy,hardcopy,wajib');
        $this->db->where('role_id',$role_id);
        $this->db->where('softcopy',1);
        $this->db->join('dokumen_'.$jenis,'m_role_berkas.id_berkas=dokumen_'.$jenis.'.id_berkas');
        return $this->db->get('m_role_berkas')->result();
    }
    function hapusBerkas($id){
        $this->db->where('d_id',$id);
        return $this->db->delete('d_berkaspasien');
    }
    function upload_files($path, $title, $files)
    {
        $config = array(
            'upload_path'   => $path,
            'allowed_types' => 'jpg|gif|png',
            'overwrite'     => 1,                       
        );


        $this->load->library('upload', $config);

        $images = array();
        $i=0;
        foreach ($files['name'] as $key => $image) {
            $i++;
            $_FILES['images[]']['name']= $files['name'][$key];
            $_FILES['images[]']['type']= $files['type'][$key];
            $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
            $_FILES['images[]']['error']= $files['error'][$key];
            $_FILES['images[]']['size']= $files['size'][$key];

            $fileName = $title .'_HAL_'. $i ."_" .str_replace(' ', '_', $_FILES['images[]']['name']);
            $ext=explode('/', $_FILES['images[]']['type']);
            $images[] = $fileName;

            $config['file_name'] = $fileName;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('images[]')) {
                $this->upload->data();
            } else {
                return false;
            }
        }

        return $images;
    }

    function cekPasien($nomr){
        $this->db->where('nomr',$nomr);
        return $this->db->get('m_pasien')->num_rows();
    }
    function getPasiensimrs($nomr){
        $this->dbsimrs = $this->load->database('simrs', true);
        $this->dbsimrs->select('`nomr`,`no_ktp`,`nama`,`tempat_lahir`,`tgl_lahir`,`jns_kelamin`,`status_kawin`,`pekerjaan`,`agama`,`no_telpon`,`kewarganegaraan`,`nama_negara`,`nama_provinsi`,`nama_kab_kota`,`nama_kecamatan`,`nama_kelurahan`,`dalam_kota`,`suku`,`bahasa`,`alamat`,`penanggung_jawab`,`no_penanggung_jawab`,`no_bpjs`,`tgl_daftar`,`user_created`,`session_id`,`arc`,`status_lengkap`');
        $this->dbsimrs->where('nomr',$nomr);
        return $this->dbsimrs->get('tbl01_pasien')->result_array();
    }

    function getBerkasdata($id_daftar)
    {
        $this->db->where('id_daftar', $id_daftar);
        return $this->db->get('t_berkaspasien')->row();
    }

    function cekBerkas($id_daftar,$id_berkas){
        $this->db->where('id_daftar',$id_daftar);
        $this->db->where('id_berkas',$id_berkas);
        return $this->db->get('t_berkaspasien')->row();

    }

    function getHistori($id_daftar){
        $this->db->select("d_id,d_idfile,nama_berkas,count(d_id) as jml_halaman");
        $this->db->where('id_daftar',$id_daftar);
        $this->db->join('d_berkaspasien','d_idfile=id_file');
        $this->db->join('m_berkas','m_berkas.id_berkas=t_berkaspasien.id_berkas');
        $this->db->group_by('id_file');
        return $this->db->get('t_berkaspasien')->result();
    }

    function getListberkas($id_file){
        $this->db->where('d_idfile', $id_file);
        return $this->db->get('d_berkaspasien')->result();
    }

    function getDetailberkas($id_file){
        $this->db->join('d_berkaspasien','d_idfile=id_file');
        $this->db->where('d_idfile',$id_file);
        $this->db->order_by('d_id');
        return $this->db->get('t_berkaspasien')->result();
    }
    function countKunjungan($ruang, $tgl, $q, $jns_layanan){
        $this->dbsimrs = $this->load->database('simrs', true);
        //nomr, id_daftar,reg_unit, no_bpjs, no_ktp, nama_pasien, tgl_reg, tempat_lahir, tgl_lahir,grId,grNama,no_sep,tgl_keluar,id_daftar
        
        if(!empty($ruang)) $this->dbsimrs->where('id_ruang', $ruang);
        if(!empty($tgl)) $this->dbsimrs->where("DATE_FORMAT(tgl_masuk,'%Y-%m-%d')", $tgl);
        if(!empty($jns_layanan)) $this->dbsimrs->where_in('jns_layanan', $jns_layanan);
        $this->dbsimrs->group_start();
        $this->dbsimrs->like('no_jaminan', $q);
        $this->dbsimrs->or_like('nomr', $q);
        $this->dbsimrs->or_like('no_bpjs', $q);
        $this->dbsimrs->or_like('no_ktp', $q);
        $this->dbsimrs->or_like('nama_pasien', $q);
        $this->dbsimrs->or_like('nama_ruang', $q);
        $this->dbsimrs->group_end();
        return $this->dbsimrs->get('tbl02_pendaftaran')->num_rows();
    }

    function getKunjunganLimit($limit, $start, $ruang, $tgl, $q, $jns_layanan){
        $this->dbsimrs = $this->load->database('simrs', true);
        $this->dbsimrs->select('idx,id_daftar,reg_unit,nomr,no_ktp,nama_pasien as nama,no_bpjs, 
        nama_ruang, no_jaminan as no_sep, tgl_masuk as tgl_reg, tempat_lahir,tgl_lahir, 
        id_ruang as grId, nama_ruang as grNama');
        if (!empty($ruang)) $this->dbsimrs->where('id_ruang', $ruang);
        if (!empty($tgl)) $this->dbsimrs->where("DATE_FORMAT(tgl_masuk,'%Y-%m-%d')", $tgl);
        if (!empty($jns_layanan)) $this->dbsimrs->where_in('jns_layanan', $jns_layanan);
        $this->dbsimrs->group_start();
        $this->dbsimrs->like('no_jaminan', $q);
        $this->dbsimrs->or_like('nomr', $q);
        $this->dbsimrs->or_like('no_bpjs', $q);
        $this->dbsimrs->or_like('no_ktp', $q);
        $this->dbsimrs->or_like('nama_pasien', $q);
        $this->dbsimrs->or_like('nama_ruang', $q);
        $this->dbsimrs->group_end();
        $this->dbsimrs->limit($limit, $start);
        return $this->dbsimrs->get('tbl02_pendaftaran')->result();
    }

    function getRuang($group){
        $this->dbsimrs = $this->load->database('simrs', true);
        $this->dbsimrs->where('status_ruang',1);
        $this->dbsimrs->where_in('grid', $group);
        return $this->dbsimrs->get('tbl01_ruang')->result();    
    }
    function getKunjungan($id_daftar){
        $this->dbsimrs = $this->load->database('simrs', true);
        $this->dbsimrs->where('id_daftar', $id_daftar);
        return $this->dbsimrs->get('tbl02_pendaftaran')->row();
    }
}
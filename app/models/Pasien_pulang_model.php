<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Pasien_pulang_model extends CI_Model
{
    public $table = 't_berkaspasien';
    public $key = 'id_file';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getpasien_pulang()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getpasien_pulanglimit($limit, $start = 0, $q = NULL) {
        $this->db->select('*,count(d_nama_file) as jml_halaman');
        $this->db->order_by($this->key, $this->order);
        $this->db->join('m_berkas','t_berkaspasien.id_berkas=m_berkas.id_berkas');
        $this->db->join('d_berkaspasien','d_berkaspasien.d_idfile=id_file','left');
        $this->db->group_by('id_file');
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
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countpasien_pulang($q = NULL) {
        $this->db->join('m_berkas','t_berkaspasien.id_berkas=m_berkas.id_berkas');
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
        return $this->db->get($this->table)->num_rows();
    }
    public function insertpasien_pulang($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deletepasien_pulang($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getpasien_pulang_by_id($id){
        $this->db->select('*,count(d_id) as jml_halaman');
        $this->db->join('m_jenisberkas','m_jenisberkas.kode_jenis=t_berkaspasien.kode_jenis');
        $this->db->join('m_pasien','t_berkaspasien.nomr=m_pasien.nomr');
        $this->db->join('group_ruang','t_berkaspasien.grId=group_ruang.grId');
        $this->db->join('m_berkas','t_berkaspasien.id_berkas=m_berkas.id_berkas');
        $this->db->join('d_berkaspasien','d_berkaspasien.d_idfile=t_berkaspasien.id_file','left');
        $this->db->group_by('id_file');
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updatepasien_pulang($data,$id){
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
            $this->db->where('link','pasien_pulang');
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

            $fileName = $title .'_HAL_'. $i ."_" .$_FILES['images[]']['name'];
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

    function cekBerkas($no_sep,$id_berkas){
        $this->db->where('no_sep',$no_sep);
        $this->db->where('id_berkas',$id_berkas);
        return $this->db->get('t_berkaspasien')->row();

    }

    function getHistori($id_daftar){
        $this->db->select("d_id,nama_berkas,count(d_id) as jml_halaman");
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

    function pulangkan($data,$id_daftar){
        $this->db->where('id_daftar',$id_daftar);
        $this->db->update('t_berkaspasien',$data);
    }
}
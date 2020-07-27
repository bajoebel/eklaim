<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Verifikasi_model extends CI_Model
{
    public $table = 'view_berkaspasien';
    public $key = 'id_daftar';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getVerifikasi()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getVerifikasilimit($limit, $start = 0, $q = NULL,$ritl="0", $rjtl="0") {
        $this->db->select('*,count(log_id) as status_generate');
        $this->db->join('log_berkaspasien','id_daftar=log_iddaftar','left');
        $this->db->order_by($this->key, $this->order);
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
        $this->db->like('no_sep', $q);
                $this->db->or_like('nomr', $q);
                $this->db->or_like('nama_pasien', $q);
                $this->db->or_like('tempat_lahir', $q);
                $this->db->or_like('tgl_lahir', $q);
                $this->db->or_like('jns_kelamin', $q);
                $this->db->or_like('kode_jenis', $q);
                $this->db->or_like('jenis_berkas', $q);
                $this->db->or_like('poliklinik', $q);
                $this->db->or_like('berkas_wajib', $q);
                $this->db->or_like('jml_verifikasi', $q);
                $this->db->or_like('jml_berkas', $q);
        $this->db->group_end();
        $this->db->limit($limit, $start);
        $this->db->group_by('no_sep');
        return $this->db->get($this->table)->result();
    }
    function countVerifikasi($q = NULL, $ritl="0", $rjtl="0") {
        $this->db->select('*,count(log_id) as status_generate');
        $this->db->join('log_berkaspasien','id_daftar=log_iddaftar','left');
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
        $this->db->like('no_sep', $q);
        $this->db->or_like('nomr', $q);
        $this->db->or_like('nama_pasien', $q);
        $this->db->or_like('tempat_lahir', $q);
        $this->db->or_like('tgl_lahir', $q);
        $this->db->or_like('jns_kelamin', $q);
        $this->db->or_like('kode_jenis', $q);
        $this->db->or_like('jenis_berkas', $q);
        $this->db->or_like('poliklinik', $q);
        $this->db->or_like('berkas_wajib', $q);
        $this->db->or_like('jml_verifikasi', $q);
        $this->db->or_like('jml_berkas', $q);
        $this->db->group_end();
        $this->db->group_by('no_sep');
        return $this->db->get($this->table)->num_rows();
    }
    public function insertVerifikasi($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteVerifikasi($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getVerifikasi_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function getJenis(){
        return $this->db->get('m_jenisberkas')->result();
    }
    function updateVerifikasi($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }
    function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','verifikasi');
            return $this->db->get('m_role_akses')->result_array();
    }

    function getKunjunganbyid($id_daftar){
        $this->db->where('id_daftar', $id_daftar);
        $this->db->join('log_berkaspasien','view_berkaspasien.id_daftar=log_berkaspasien.log_iddaftar','left');
        return $this->db->get('view_berkaspasien')->row();
    }
    function insertLog($log, $nosep){
        $this->db->where('log_nosep', $nosep);
        $cek=$this->db->get('log_berkaspasien')->num_rows();
        if(empty($cek)){
            $this->db->insert('log_berkaspasien',$log);
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    function getDokumenbysep($kode_jenis){
        if($kode_jenis=="RJTL") {
            /*$this->db->where('dokumen_rjtl.kode_jenis',$kode_jenis);
            $this->db->select('*,count(id_file) as jml_berkas');
            $this->db->join('t_berkaspasien','dokumen_rjtl.id_berkas=t_berkaspasien.id_berkas','left');
            $this->db->group_by('dokumen_rjtl.id_berkas');*/
            return $this->db->get('dokumen_rjtl')->result();
        }
        else {
            /*$this->db->where('dokumen_ritl.kode_jenis',$kode_jenis);
            $this->db->select('*,count(id_file) as jml_berkas');
            $this->db->join('t_berkaspasien','dokumen_ritl.id_berkas=t_berkaspasien.id_berkas','left');
            $this->db->group_by('dokumen_ritl.id_berkas');*/
            return $this->db->get('dokumen_ritl')->result();
        }
    }

    function jmlBerkas($id_daftar,$id_berkas){
        $this->db->select('*,count(d_id) as jml_berkas');
        $this->db->where('id_daftar',$id_daftar);
        $this->db->where('id_berkas',$id_berkas);
        $this->db->join('d_berkaspasien','d_berkaspasien.d_idfile=t_berkaspasien.id_file');
        return $this->db->get('t_berkaspasien')->row();
    }

    function getPriview($id_daftar,$idberkas){
        $this->db->where('id_daftar', $id_daftar);
        $this->db->where('t_berkaspasien.id_berkas', $idberkas);
        $this->db->join('m_berkas','m_berkas.id_berkas=t_berkaspasien.id_berkas');
        $this->db->join('d_berkaspasien','d_idfile=id_file');
        return $this->db->get('t_berkaspasien')->result();
    }

    function verifikasi_dokumen($data,$id_daftar,$idberkas){
        $this->db->where('id_daftar',$id_daftar);
        $this->db->where('id_berkas', $idberkas);
        $this->db->update('t_berkaspasien',$data);
    }

    function getBerkas($nosep){
        $this->db->select('m_berkas.id_berkas,no_sep,nama_berkas,d_nama_file, status_verifikasi');
        $this->db->join('m_berkas','t_berkaspasien.id_berkas=m_berkas.id_berkas');
        $this->db->join('d_berkaspasien','d_berkaspasien.d_idfile=t_berkaspasien.id_file');
        $this->db->where('no_sep',$nosep);
        $this->db->where('status_verifikasi','1');
        $this->db->order_by('m_berkas.id_berkas');
        return $this->db->get('t_berkaspasien')->result();
    }

    function pulangkan($data,$id_daftar){
        $this->db->where('id_daftar',$id_daftar);
        $this->db->update('t_berkaspasien',$data);
    }
}
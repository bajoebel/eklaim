<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Laporan_model extends CI_Model
{
    public $table = 'view_berkaspasien';
    public $key = 'no_sep';
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
    function getVerifikasilimit($limit, $start = 0, $q = NULL) {
        //$this->db->join('');
        $this->db->order_by($this->key, $this->order);
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
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countVerifikasi($q = NULL) {
        
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
        return $this->db->get($this->table)->num_rows();
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

    function getDir($sub1="",$sub2="",$sub3="", $sub4=""){
        if(empty($sub1) && empty($sub2) && empty($sub3) && empty($sub4)){
            $this->db->select('log_dir_root as root, log_sub_dir1 as dir1, log_sub_dir2 as dir2, log_sub_dir3 as dir3,log_sub_dir4 as dir4,log_file as file');
            $this->db->group_by('log_sub_dir1');
        }else{
            if(empty($sub2) && empty($sub3) && empty($sub4)){
                $this->db->where('log_sub_dir1',$sub1);
                $this->db->select('log_dir_root as root, log_sub_dir1 as dir1, log_sub_dir2 as dir2, log_sub_dir3 as dir3,log_sub_dir4 as dir4,log_file as file');
                $this->db->group_by('log_sub_dir2');
            }else{
                if(empty($sub3)&&empty($sub4)){
                    $this->db->where('log_sub_dir1',$sub1);
                    $this->db->where('log_sub_dir2',$sub2);
                    $this->db->select('log_dir_root as root, log_sub_dir1 as dir1, log_sub_dir2 as dir2, log_sub_dir3 as dir3,log_sub_dir4 as dir4, log_file as file');
                    $this->db->group_by('log_sub_dir3');
                }else{
                    if(empty($sub4)){
                        $this->db->where('log_sub_dir1',$sub1);
                        $this->db->where('log_sub_dir2',$sub2);
                        $this->db->where('log_sub_dir3',$sub3);
                        $this->db->select('log_dir_root as root, log_sub_dir1 as dir1, log_sub_dir2 as dir2, log_sub_dir3 as dir3,log_sub_dir4 as dir4, log_file as file');
                        $this->db->group_by('log_sub_dir4');
                    }else{
                        $this->db->where('log_sub_dir1',$sub1);
                        $this->db->where('log_sub_dir2',$sub2);
                        $this->db->where('log_sub_dir3',$sub3);
                        $this->db->where('log_sub_dir4',$sub4);
                        $this->db->select('log_dir_root as root, log_sub_dir1 as dir1, log_sub_dir2 as dir2, log_sub_dir3 as dir3,log_sub_dir4 as dir4, log_file as file');
                    }
                        
                }
            }
        }
        return $this->db->get('log_berkaspasien')->result();
    }
}
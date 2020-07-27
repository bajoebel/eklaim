<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Berkasklaim_model extends CI_Model
{
    public $table = 'm_berkasklaim';
    public $key = 'id_bklaim';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getBerkasklaim()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getBerkasklaimlimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->key, $this->order);
        $this->db->join('m_jenisberkas','m_jenisberkas.kode_jenis=m_berkasklaim.kode_jenis');
        $this->db->join('m_berkas','m_berkasklaim.id_berkas=m_berkas.id_berkas');
        $this->db->like('id_bklaim', $q);
                $this->db->or_like('m_berkasklaim.kode_jenis', $q);
                $this->db->or_like('m_berkasklaim.id_berkas', $q);
                $this->db->or_like('jenis_berkas', $q);
                $this->db->or_like('nama_berkas', $q);
                $this->db->or_like('hardcopy', $q);
                $this->db->or_like('softcopy', $q);
                $this->db->or_like('wajib', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countBerkasklaim($q = NULL) {
        $this->db->join('m_jenisberkas','m_jenisberkas.kode_jenis=m_berkasklaim.kode_jenis');
        $this->db->join('m_berkas','m_berkasklaim.id_berkas=m_berkas.id_berkas');
        $this->db->like('id_bklaim', $q);
        $this->db->or_like('m_berkasklaim.kode_jenis', $q);
                $this->db->or_like('m_berkasklaim.id_berkas', $q);
                $this->db->or_like('jenis_berkas', $q);
                $this->db->or_like('nama_berkas', $q);
                $this->db->or_like('hardcopy', $q);
                $this->db->or_like('softcopy', $q);
                $this->db->or_like('wajib', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertBerkasklaim($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteBerkasklaim($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getBerkasklaim_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updateBerkasklaim($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','berkasklaim');
            return $this->db->get('m_role_akses')->result_array();
        }
    function getM_jenisberkas(){
        return $this->db->get('m_jenisberkas')->result();
    }
    function getM_berkas(){
        return $this->db->get('m_berkas')->result();
    }
}
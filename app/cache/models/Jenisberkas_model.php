
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Jenisberkas_model extends CI_Model
{
    public $table = 'm_jenisberkas';
    public $key = 'kode_jenis';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getJenisberkas()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getJenisberkaslimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->key, $this->order);
        $this->db->like('kode_jenis', $q);
        $this->db->or_like('jenis_berkas', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countJenisberkas($q = NULL) {
        
        $this->db->like('kode_jenis', $q);
        $this->db->or_like('jenis_berkas', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertJenisberkas($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteJenisberkas($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getJenisberkas_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updateJenisberkas($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }
    function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','jenisberkas');
            return $this->db->get('m_role_akses')->result_array();
    }
    function getBerkas(){
        return $this->db->get('m_berkas')->result();
    }
    function getBerkasklaim($kode,$id_berkas){
        $this->db->join('m_berkasklaim','m_berkasklaim.id_berkas=m_berkas.id_berkas');
        $this->db->where('m_berkasklaim.kode_jenis',$kode);
        $this->db->where('m_berkasklaim.id_berkas',$id_berkas);
        return $this->db->get('m_berkas')->row();
    }
}

<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Berkas_model extends CI_Model
{
    public $table = 'm_berkas';
    public $key = 'id_berkas';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getBerkas()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getBerkaslimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->key, $this->order);
        $this->db->like('id_berkas', $q);
                $this->db->or_like('nama_berkas', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countBerkas($q = NULL) {
        
        $this->db->like('id_berkas', $q);
        $this->db->or_like('nama_berkas', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertBerkas($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteBerkas($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getBerkas_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updateBerkas($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','berkas');
            return $this->db->get('m_role_akses')->result_array();
        }
}
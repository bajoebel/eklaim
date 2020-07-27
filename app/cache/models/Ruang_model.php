
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Ruang_model extends CI_Model
{
    public $table = 'm_ruang';
    public $key = 'id_ruang';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getRuang()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getRuanglimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->key, $this->order);
        $this->db->like('id_ruang', $q);
                $this->db->or_like('nama_ruang', $q);
                $this->db->or_like('status_ruang', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countRuang($q = NULL) {
        
        $this->db->like('id_ruang', $q);
        $this->db->or_like('nama_ruang', $q);
        $this->db->or_like('status_ruang', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertRuang($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteRuang($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getRuang_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updateRuang($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','ruang');
            return $this->db->get('m_role_akses')->result_array();
        }
}
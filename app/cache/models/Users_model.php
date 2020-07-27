<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Users_model extends CI_Model
{
    public $table = 'm_users';
    public $key = 'username';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getUsers()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getUserslimit($limit, $start = 0, $q = NULL) {
        $this->db->join('m_role','m_users.role=m_role.role_id');
        $this->db->order_by($this->key, $this->order);
        $this->db->like('username', $q);
                $this->db->or_like('password', $q);
                $this->db->or_like('nama_lengkap', $q);
                $this->db->or_like('nohp', $q);
                $this->db->or_like('role_nama', $q);
                $this->db->or_like('status_user', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countUsers($q = NULL) {
        $this->db->join('m_role','m_users.role=m_role.role_id');
        $this->db->like('username', $q);
        $this->db->or_like('password', $q);
        $this->db->or_like('nama_lengkap', $q);
        $this->db->or_like('nohp', $q);
        $this->db->or_like('role_nama', $q);
        $this->db->or_like('status_user', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertUsers($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteUsers($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getUsers_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updateUsers($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','users');
            return $this->db->get('m_role_akses')->result_array();
        }
    function getM_role(){
        return $this->db->get('m_role')->result();
    }
}
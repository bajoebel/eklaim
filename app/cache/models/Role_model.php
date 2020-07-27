
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Role_model extends CI_Model
{
    public $table = 'm_role';
    public $key = 'role_id';
    public $order = 'DESC';
    function __construct()
    {
        parent::__construct();
    }
    function getRole()
    {
        $this->db->order_by($this->key, $this->order);
        return $this->db->get($this->table)->result();
    }
    function getRolelimit($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->key, $this->order);
        $this->db->like('role_id', $q);
                $this->db->or_like('role_nama', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }
    function countRole($q = NULL) {
        
        $this->db->like('role_id', $q);
        $this->db->or_like('role_nama', $q);
        return $this->db->get($this->table)->num_rows();
    }
    public function insertRole($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function deleteRole($id)
    {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    public function getRole_by_id($id){
        $this->db->where($this->key,$id);
        return $this->db->get($this->table)->row();
    }
    function updateRole($data,$id){
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $data);
    }
    function getAkses($level){
        
            $this->db->select('nama_aksi as aksi');
            $this->db->join('m_role','m_role_akses.role_id=m_role.role_id');
            $this->db->join('m_moduls','m_role_akses.modul_id=m_moduls.id_modul');
            $this->db->join('m_aksi','m_role_akses.id_aksi=m_aksi.id_aksi');
            $this->db->where('m_role_akses.role_id',$level);
            $this->db->where('link','role');
            return $this->db->get('m_role_akses')->result_array();
    }
    function getBerkas(){
        return $this->db->get('m_berkas')->result();
    }
    function getRoleberkas($role_id,$id_berkas){
        $this->db->join('m_role','m_role_berkas.role_id=m_role.role_id');
        $this->db->where('m_role_berkas.id_berkas',$id_berkas);
        $this->db->where('m_role_berkas.role_id',$role_id);
        return $this->db->get('m_role_berkas')->row();
    }

    function getHakakses($rolid){
        $this->db->group_by('modul_id');
        return $this->db->get('view_aksi')->result();
    }

    function getRoleaksi($modulid){
        $this->db->where('aksi_id > ', 1);
        $this->db->select('aksi_id,nama_aksi');
        $this->db->where('modul_id',$modulid);
        return $this->db->get('view_aksi')->result();
    }

    function getHakaksesbymodul($modulid,$role){
        $this->db->where('role_id', $role);
        $this->db->where('modul_id',$modulid);
        return $this->db->get('m_role_akses')->result();
    }

    function removeAkses($modulid,$role){
        $this->db->where('role_id', $role);
        $this->db->where('modul_id',$modulid);
        $this->db->delete('m_role_akses');
    }

    function addAkses($data){
        $this->db->insert('m_role_akses',$data);
        $id=$this->db->insert_id();
        return $id;
    }
    function removeAksesbyaksi($modulid, $role, $aksi){
        $this->db->where('role_id', $role);
        $this->db->where('modul_id',$modulid);
        $this->db->where('id_aksi',$aksi);
        $this->db->delete('m_role_akses');
    }
}
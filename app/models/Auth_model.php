<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth_model extends CI_Model {

    public function cek_user($username, $password, $status){
        $this->db->select('*');
        $this->db->from('m_users');
        $this->db->join('m_role','role=role_id');
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $this->db->where('status_user',$status);
        return $this->db->get()->row();
    }
    function getAdmin($id){
        $this->db->where('id_admin',$id);
        return $this->db->get('m_admin')->row();
    }

    public function get_info($table, $key, $key_val){
        $this->db->where($key,$key_val);
        return $this->db->get($table)->row();
    }

    function longdate($date){
        $d=explode('-', $date);
        $m=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
        $new_date=$d[2] ." " .$m[intval($d[1])] ." " .$d[0];
        return $new_date;
    }
    
    public function getMenu($role,$q=""){
        $this->db->select('induk_id,induk_nama,induk_urut,anak_urut,role_id,role_nama,modul_id,nama_modul,link,status_modul,induk_icon');
        $this->db->join('m_menuanak','m_menuinduk.induk_id=m_menuanak.anak_indukid');
        $this->db->join('view_modul','view_modul.modul_id=m_menuanak.anak_modulid');
        $this->db->order_by('induk_urut');
        $this->db->order_by('anak_urut');
        $this->db->where('role_id',$role);
        $this->db->group_start();
        $this->db->like('induk_nama',$q);
        $this->db->or_like('nama_modul',$q);
        $this->db->or_like('link',$q);
        $this->db->group_end();
        return $this->db->get('m_menuinduk')->result();
    }
    function indukaktif($link){
        $this->db->select('induk_id');
        $this->db->join('m_menuanak','m_menuinduk.induk_id=m_menuanak.anak_indukid');
        $this->db->join('m_moduls','anak_modulid=id_modul');
        $this->db->where('link',$link);
        $data=$this->db->get('m_menuinduk')->row();
        if(!empty($data)){
            return $data->induk_id;
        }else{
            return 0;
        }
    }
    public function menu($group){

        $str_menu="";
        if(!empty($group)){
            $this->db->join('stx_moduls_parent','parent_id=modul_parent_id');
            $this->db->where('modul_status','Active');
            $this->db->where('modul_' .$group,'Yes');
            $this->db->order_by('parent_id');
            $this->db->group_by('modul_parent_id');
            $q=$this->db->get('stx_moduls');
            if ($q->num_rows() > 0){
                $menu_l1=$q->result();
                foreach ($menu_l1 as $l1) {
                    $modul_parent_id=$l1->modul_parent_id;
                    $modul_title=$l1->parent_name;
                    
                    $moduls_url='#';
                    $current=$this->uri->segment(2);
                    
                    $this->db->join('stx_moduls_parent','parent_id=modul_parent_id');
                    $this->db->where('modul_status','Active');
                    $this->db->where('modul_' .$group,'Yes');
                    $this->db->where('modul_parent_id',$modul_parent_id);
                    $this->db->order_by('modul_idx');
                    $q2=$this->db->get('stx_moduls');
                    /*Menu Level 2*/
                    if($q2->num_rows() > 0) {
                        /*Jika Parent mempunyai Child*/
                        $str_menu=$str_menu .'
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-home"></i>' .$modul_title .'</a>
                            <ul class="dropdown-menu" data-role="dropdown">';
                            $menu_l2=$q2->result();
                            foreach ($menu_l2 as $l2) {
                                if($l2->modul_url!="dasboard"){
                                $str_menu=$str_menu .'
                                <li>
                                    <a href="' .base_url() .$l2->modul_url .'"><span class="fa fa-circle-o"></span>' .$l2->modul_name .'</a>
                                </li>';
                                }
                            }
                            $str_menu=$str_menu .'
                            </ul>
                        </li>';
                    }
                    else{
                        /*Jika Parent Tidak ada Child*/
                        if($moduls_url!="dasboard"){
                            $str_menu=$str_menu .'<li><a href="' .base_url() .strtolower($moduls_url) .'"><i class="fa fa-home"></i>' .$modul_title .'<span class="sr-only">' .$modul_title .'</span>' .'</a></li>';
                        }
                        
                    }
                }
                return $str_menu;
            }
            else
            {
                return $str_menu;   
            }
        }else{
            //return $str_menu;
            $this->db->join('stx_moduls_parent','parent_id=modul_parent_id');
            $this->db->where('modul_status','Active');
            $this->db->where('modul_nologin','Yes');
            $this->db->order_by('parent_id');
            $this->db->group_by('modul_parent_id');
            $q=$this->db->get('stx_moduls');
            if ($q->num_rows() > 0){
                $menu_l1=$q->result();
                foreach ($menu_l1 as $l1) {
                    $modul_parent_id=$l1->modul_parent_id;
                    $modul_title=$l1->parent_name;
                    
                    $moduls_url='#';
                    $current=$this->uri->segment(2);
                    
                    $this->db->join('stx_moduls_parent','parent_id=modul_parent_id');
                    $this->db->where('modul_status','Active');
                    $this->db->where('modul_nologin','Yes');
                    $this->db->where('modul_parent_id',$modul_parent_id);
                    $this->db->order_by('modul_idx');
                    $q2=$this->db->get('stx_moduls');
                    /*Menu Level 2*/
                    if($q2->num_rows() > 0) {
                        /*Jika Parent mempunyai Child*/
                        $str_menu=$str_menu .'
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-home"></i>' .$modul_title .'</a>
                            <ul class="dropdown-menu" data-role="dropdown">';
                            $menu_l2=$q2->result();
                            foreach ($menu_l2 as $l2) {
                                if($l2->modul_url!="dasboard"){
                                $str_menu=$str_menu .'
                                <li>
                                    <a href="' .base_url() .$l2->modul_url .'"><span class="fa fa-circle-o"></span>' .$l2->modul_name .'</a>
                                </li>';
                                }
                            }
                            $str_menu=$str_menu .'
                            </ul>
                        </li>';
                    }
                    else{
                        /*Jika Parent Tidak ada Child*/
                        if($moduls_url!="dasboard"){
                            $str_menu=$str_menu .'<li><a href="' .base_url() .strtolower($moduls_url) .'"><i class="fa fa-home"></i>' .$modul_title .'<span class="sr-only">' .$modul_title .'</span>' .'</a></li>';
                        }
                        
                    }
                }
                return $str_menu;
            }
            else
            {
                return $str_menu;   
            }
        }
        
    }

    public function left_menu($group){

        $str_menu="";
        if(!empty($group)){
            $this->db->join('stx_moduls_parent','parent_id=modul_parent_id');
            $this->db->where('modul_status','Active');
            $this->db->where('modul_' .$group,'Yes');
            $this->db->order_by('parent_id');
            $this->db->group_by('modul_parent_id');
            $q=$this->db->get('stx_moduls');
            if ($q->num_rows() > 0){
                $menu_l1=$q->result();
                foreach ($menu_l1 as $l1) {
                    $modul_parent_id=$l1->modul_parent_id;
                    $modul_title=$l1->parent_name;
                    
                    $moduls_url='#';
                    $current=$this->uri->segment(2);
                    
                    $this->db->join('stx_moduls_parent','parent_id=modul_parent_id');
                    $this->db->where('modul_status','Active');
                    $this->db->where('modul_' .$group,'Yes');
                    $this->db->where('modul_parent_id',$modul_parent_id);
                    $this->db->order_by('modul_idx');
                    $q2=$this->db->get('stx_moduls');
                    /*Menu Level 2*/
                    /*
                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>Layout Options</span>
                        <span class="pull-right-container">
                          <span class="label label-primary pull-right">4</span>
                        </span>
                      </a>
                      <ul class="treeview-menu" style="display: block;">
                        <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                        <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
                        <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                        <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
                      </ul>
                    </li>
                    */
                    if($q2->num_rows() > 0) {
                        /*Jika Parent mempunyai Child*/
                        $str_menu=$str_menu .'
                        <li class="treeview">
                            <a href="#"><i class="fa fa-home"></i>' .$modul_title .'</a>
                            <ul class="treeview-menu" style="display: block;">';
                            $menu_l2=$q2->result();
                            foreach ($menu_l2 as $l2) {
                                if($l2->modul_url!="dasboard"){
                                $str_menu=$str_menu .'
                                <li>
                                    <a href="' .base_url() .$l2->modul_url .'"><span class="fa fa-circle-o"></span>' .$l2->modul_name .'</a>
                                </li>';
                                }
                            }
                            $str_menu=$str_menu .'
                            </ul>
                        </li>';
                    }
                    else{
                        /*Jika Parent Tidak ada Child*/
                        if($moduls_url!="dasboard"){
                            $str_menu=$str_menu .'<li><i class="fa fa-home"></i><a href="' .base_url() .strtolower($moduls_url) .'">' .$modul_title .'<span class="sr-only">' .$modul_title .'</span>' .'</a></li>';
                        }
                        
                    }
                }
                return $str_menu;
            }
            else
            {
                return $str_menu;   
            }
        }else{
            //return $str_menu;
            $this->db->join('stx_moduls_parent','parent_id=modul_parent_id');
            $this->db->where('modul_status','Active');
            $this->db->where('modul_nologin','Yes');
            $this->db->order_by('parent_id');
            $this->db->group_by('modul_parent_id');
            $q=$this->db->get('stx_moduls');
            if ($q->num_rows() > 0){
                $menu_l1=$q->result();
                foreach ($menu_l1 as $l1) {
                    $modul_parent_id=$l1->modul_parent_id;
                    $modul_title=$l1->parent_name;
                    
                    $moduls_url='#';
                    $current=$this->uri->segment(2);
                    
                    $this->db->join('stx_moduls_parent','parent_id=modul_parent_id');
                    $this->db->where('modul_status','Active');
                    $this->db->where('modul_nologin','Yes');
                    $this->db->where('modul_parent_id',$modul_parent_id);
                    $this->db->order_by('modul_idx');
                    $q2=$this->db->get('stx_moduls');
                    /*Menu Level 2*/
                    if($q2->num_rows() > 0) {
                        /*Jika Parent mempunyai Child*/
                        $str_menu=$str_menu .'
                        <li class="treeview">
                            <a href="#"><i class="fa fa-home"></i>' .$modul_title .'</a>
                            <ul class="treeview-menu">';
                            $menu_l2=$q2->result();
                            foreach ($menu_l2 as $l2) {
                                if($l2->modul_url!="dasboard"){
                                $str_menu=$str_menu .'
                                <li>
                                    <a href="' .base_url() .$l2->modul_url .'"><span class="fa fa-circle-o"></span>' .$l2->modul_name .'</a>
                                </li>';
                                }
                            }
                            $str_menu=$str_menu .'
                            </ul>
                        </li>';
                    }
                    else{
                        /*Jika Parent Tidak ada Child*/
                        if($moduls_url!="dasboard"){
                            $str_menu=$str_menu .'<li><a href="' .base_url() .strtolower($moduls_url) .'"><i class="fa fa-home"></i>' .$modul_title .'<span class="sr-only">' .$modul_title .'</span>' .'</a></li>';
                        }
                        
                    }
                }
                return $str_menu;
            }
            else
            {
                return $str_menu;   
            }
        }
        
    }

    function cek_modul($group){
        $this->db->join('stx_moduls_parent','parent_id=modul_parent_id');
            $this->db->where('modul_status','Active');
            $this->db->where('modul_' .$group,'Yes');
            $this->db->order_by('parent_id');
            $this->db->group_by('modul_parent_id');
            return $this->db->get('stx_moduls')->result_array();
            //if ($q->num_rows() > 0){
    }

    public function get_privilage($group_id,$link){
        $this->db->select('moduls_group.moduls_id,group.group_id,moduls.moduls_title,moduls.moduls_url, add1,update1, delete1,report1');
        $this->db->from('moduls_group');
        $this->db->join('group','group.group_id=moduls_group.group_id');
        $this->db->join('moduls','moduls_group.moduls_id=moduls.moduls_id');
        $this->db->where('moduls_group.group_id',$group_id);
        $this->db->where('moduls.moduls_url',$link);
        $q=$this->db->get();
        if ($q->num_rows() > 0){
            return $q->result_array();
        }
        else
        {
            return array(); 
        }
     }

    public function cek_privilage($level,$link){
        if(!empty($level)){
            $this->db->where('modul_status','Active');
            $this->db->where('modul_' .$level,'Yes');
            $this->db->where('modul_url',$link);
            $q=$this->db->get('stx_moduls');
            return $q->num_rows();
        }
        else{
            $this->db->where('modul_status','Active');
            $this->db->where('modul_nologin','Yes');
            $this->db->where('modul_url',$link);
            $q=$this->db->get('stx_moduls');
            return $q->num_rows();
        }
        
    }

    public function insert_user($data){
        $this->db->insert('ref_user', $data);
        return $this->db->insert_id();
    }
    public function ambil_provinsi() {
        $this->db->where('aktif','Y');
        $this->db->order_by('nama_provinsi','asc');
        $sql_kabupaten=$this->db->get('ref_provinsi');
        return $sql_kabupaten->result();
    }

    public function ambil_kabupaten($kode_prop){
        $this->db->where('id_provinsi',$kode_prop);
        $this->db->order_by('nama_kabupaten','asc');
        $sql_kabupaten=$this->db->get('ref_kabupaten');
        return $sql_kabupaten->result();
    }

    public function ambil_kecamatan($kode_kab){
        $this->db->where('id_kabupaten',$kode_kab);
        $this->db->order_by('nama_kecamatan','asc');
        $sql_kecamatan=$this->db->get('ref_kecamatan');
        return $sql_kecamatan->result();
    }

    public function ambil_kelurahan($kode_kec){
        $this->db->where('id_kecamatan',$kode_kec);
        $this->db->order_by('nama_kelurahan','asc');
        $sql_kelurahan=$this->db->get('ref_kelurahan');
        return $sql_kelurahan->result();
    }

    public function ambil_level($skema_id){
        $this->db->join('ref_tipe_asesmen','ref_tipe_asesmen.id_tipe_asesmen=ref_harga_skema.id_tipe_asesmen');
        $this->db->join('ref_skema','ref_harga_skema.id_skema=ref_skema.id_skema');
        $this->db->where('ref_skema.id_skema',$skema_id);
        $this->db->order_by('judul_skema','asc');
        $sql_kelurahan=$this->db->get('ref_harga_skema');
        return $sql_kelurahan->result();
    }

    public function ambil_skema_skkni(){
        $this->db->where('jenis_skema','SKKNI');
        $this->db->where('aktif','Y');
        return $this->db->get('ref_skema')->result();
    }

    public function ambil_pendidikan(){
        $this->db->where('aktif','Y');
        return $this->db->get('ref_pendidikan')->result();
    }

    public function ambil_tipe_asesmen(){
        $this->db->where('aktif','Y');
        return $this->db->get('ref_pendidikan')->result();
    }

    public function ambil_unit($id_skema){
        $this->db->join('ref_skema','ref_skema.id_skema=skema_uk.id_skema');
        $this->db->join('ref_uk','ref_uk.id_uk=skema_uk.id_uk');
        $this->db->where('ref_uk.aktif','Y');
        $this->db->where('skema_uk.id_skema',$id_skema);
        $this->db->order_by('skema_uk.id_uk','asc');
        $sql_kabupaten=$this->db->get('skema_uk');
        return $sql_kabupaten->result();
    }

    public function ambil_elemen($id_uk){
        $this->db->where('id_uk',$id_uk);
        return $this->db->get('ref_elemen')->result();
    }

    public function ambil_kuk($id_elemen){
        $this->db->where('id_elemen',$id_elemen);
        return $this->db->get('ref_kuk')->result();
    }
    function auto_replace($source, $exeption=null){
        $src=array('<','>',"'",'"');
        $repl=array('&lt;','&gt;','&apos;','&quot;');
        $i=0;
        foreach ($src as $r) {
            $source=str_replace($r, $repl[$i], $source);
            $i++;
        }
        
        if(!empty($exeption)){
            $exp=explode(',', $exeption);
            foreach ($exp as $exp) {
                $j=0;
                $new_exp=str_replace("<", "&lt;", $exp);
                $new_exp=str_replace(">", "&gt;", $new_exp);
                $source=str_replace($new_exp, $exp, $source);
                $j++;
            }
        }
        $hasil=$source;
        return $hasil;
    }


    public function add_users($data){
        $this->db->insert('ref_user', $data);
        $id=$this->db->insert_id();
        return $id;
    }

    public function add_asesi($data){
        $this->db->insert('asesi', $data);
        $id=$this->db->insert_id();
        return $id;
    }

    public function add_tuk($data){
        $this->db->insert('tempat_uji_kompetensi', $data);
        $id=$this->db->insert_id();
        return $id;
    }
}
<?php 

foreach ($akses as $b) {
	/*$berkas=$this->role_model->getRoleberkas($role,$b->id_berkas);
	$id_berkas="";
	if(!empty($berkas)){
		$id_berkas=$berkas->id_berkas;
	}*/
    $aksi=$this->role_model->getRoleaksi($b->modul_id);
    $hak=$this->role_model->getHakaksesbymodul($b->modul_id,$role);
    foreach ($hak as $h) {
        $ha[]=$h->id_aksi;
    }
    if(empty($ha)) $ha=array();
    ?>
    <div class="form-group">
    	<div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <input type="checkbox" name="aksi<?php echo $b->modul_id; ?>_1" id="aksi<?php echo $b->modul_id; ?>_1" value="1" <?php if(in_array(1, $ha)) echo "checked"; ?> onclick="setAkses('<?php echo $b->modul_id;  ?>','<?php echo $role; ?>',1)"><?php echo $b->nama_modul ?>
                </div>
                <div class="col-md-8">
                    <?php 
                    foreach ($aksi as $a) {
                        ?>
                        <input type="checkbox" name="aksi<?php echo $b->modul_id; ?>_<?php echo $a->aksi_id ?>" id="aksi<?php echo $b->modul_id; ?>_<?php echo $a->aksi_id ?>" value="<?php echo $a->aksi_id ?>" <?php if(in_array($a->aksi_id, $ha)) echo "checked"; ?> onclick='setAkses("<?php echo $b->modul_id;  ?>","<?php echo $role; ?>","<?php echo $a->aksi_id; ?>")'><?php echo $a->nama_aksi; ?>
                        <?php
                    }
                    //print_r($ha);
                    ?>
                </div>
            </div>
    		
    	</div>
    </div>
    
    <?php
    $ha=array();
}
?>
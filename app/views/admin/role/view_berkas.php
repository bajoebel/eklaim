<?php 

foreach ($berkas as $b) {
	$berkas=$this->role_model->getRoleberkas($role,$b->id_berkas);
	$id_berkas="";
	if(!empty($berkas)){
		$id_berkas=$berkas->id_berkas;
	}
    ?>
    <div class="form-group">
    	<div class="col-md-12">
    		<input type="checkbox" name="id_berkas" id="id_berkas<?php echo $b->id_berkas; ?>" value="<?php echo $b->id_berkas ?>" <?php if($b->id_berkas==$id_berkas) echo "checked"; ?> onclick="setBerkas('<?php echo $b->id_berkas;  ?>','<?php echo $role; ?>')"><?php echo $b->nama_berkas ?>
    	</div>
    </div>
    
    <?php
}
?>
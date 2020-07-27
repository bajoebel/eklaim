<?php 

foreach ($berkas as $b) {
	$klaim=$this->jenisberkas_model->getBerkasklaim($kode,$b->id_berkas);
	$softcopy="";
	$hardcopy="";
	$wajib="";
	if(!empty($klaim)){
		$softcopy=$klaim->softcopy;
		$hardcopy=$klaim->hardcopy;
		$wajib=$klaim->wajib;
	}
    ?>
    <tr>
        <td><?php echo $b->nama_berkas ?></td>
        <td><input type="checkbox" name="softcopy" id="softcopy<?php echo $b->id_berkas; ?>" onclick="setSoftcopy('<?php echo $b->id_berkas ?>','<?php echo $kode; ?>')" value="1" <?php if($softcopy==1) echo "checked"; ?>></td>
        <td><input type="checkbox" name="hardcopy" id="hardcopy<?php echo $b->id_berkas; ?>" onclick="setHardcopy('<?php echo $b->id_berkas ?>','<?php echo $kode; ?>')" value="1" <?php if($hardcopy==1) echo "checked"; ?>></td>
        <td><input type="checkbox" name="wajib" id="wajib<?php echo $b->id_berkas; ?>" onclick="setWajib('<?php echo $b->id_berkas ?>','<?php echo $kode ?>')" value="1" <?php if($wajib==1) echo "checked"; ?>></td>
    </tr>
    <?php
}
?>
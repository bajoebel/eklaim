<div class="col-md-12">
    <?php 
    //print_r($berkas);
    foreach ($berkas as $b) {
        $tgl_daftar=$b->tgl_reg;
        $t=explode('-', $tgl_daftar);
        ?>
        <img src="<?php echo base_url() ."files/" .$t[0] ."/" .$t[1] ."/" .$b->nomr ."/" .$b->id_daftar ."/" .$b->d_nama_file; ?>" class='img img-responsive'>
        <?php
    }
    ?>
</div>
<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
</head>
<body>
    <?php 
    $tgl=explode('-', $tgl_reg);
    $nama_berkas="";
    foreach ($berkas as $b) {
        if($nama_berkas!=$b->nama_berkas){
            ?>
            <h3><?php echo $b->nama_berkas; ?></h3>
            <?php
        }
        ?>
        <img src="<?php echo base_url() ."files/" .$tgl[0] ."/" .$tgl[1] ."/" .$nomr ."/" .$id_daftar ."/" .$b->d_nama_file; ?>">
        <?php
        $nama_berkas=$b->nama_berkas;
    }
    ?>
</body>
</html>
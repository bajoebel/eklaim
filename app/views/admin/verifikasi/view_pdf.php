<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style type="text/css">
        .newpage {page-break-before: always;}
    </style>
</head>
<body>
    <?php 
    $tgl=explode('-', $tgl_reg);
    $nama_berkas="";
    foreach ($berkas as $b) {
        if($nama_berkas!=$b->nama_berkas){
            ?>
            <p><?php echo $b->nama_berkas; ?></p>
            <?php
        }
        ?>
        <img src="<?php echo base_url() ."files/" .$tgl[0] ."/" .$tgl[1] ."/" .$nomr ."/" .$id_daftar ."/" .$b->d_nama_file; ?>" style="width:100%">
        <div class="newpage"></div>
        <?php
        //$nama_berkas=$b->nama_berkas;
    }
    ?>
</body>
</html>
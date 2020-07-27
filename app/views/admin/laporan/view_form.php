
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>File Manager </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> FILE MANAGER </a></li>
        <li class="active"> FORM</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?php if(!empty($notif)) echo $notif; ?>
    <div class="row">
        <div class="col-md-3">
            <div class="box box-widget widget-user-2">                    
                <div class="widget-user-header bg-green">
                    <div class="widget-user-image">
                        <img class="img-circle" src="<?php //if($kunjungan->jns_kelamin=="") echo base_url() ."assets/img/female.png"; else echo base_url() ."assets/img/male.png" ?>" alt="" id="imgFemale">
                    </div>
                    
                </div>

                <div class="box-body">
                    <ul class="nav nav-stacked">
                        <li><a href=""><span class="fa fa-home"></span>/root</a></li>
                        <?php 
                        $i=0;
                        foreach ($dir as $d) {
                            $i++;
                            ?>
                            <li>
                                <a href="#" style="padding-left: 30px;"  onclick="openDir('<?php echo $d->dir1 ?>',<?php echo $i; ?>)"><span class="fa fa-folder"></span> 
                                <?php echo $d->dir1; ?> 
                                <button class="pull-right badge bg-green"><span id='point<?php echo $i; ?>' class="point fa fa-plus"></span></button>
                                </a>
                                <div class="sub" id="sub<?php echo $i; ?>" style="display: none;"></div>
                                    
                            </li>
                            <?php
                        }
                        ?>
                        
                        
                    </ul>

                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">
                    DIRECTORY
                    </h3>
                    <div class="box-tools">
                        <input type="hidden" name="root" id="root" value="report">
                        <input type="hidden" name="sub_dir1" id="sub_dir1" value="">
                        <input type="hidden" name="sub_dir2" id="sub_dir2" value="">
                        <input type="hidden" name="sub_dir3" id="sub_dir3" value="">
                        <input type="hidden" name="sub_dir4" id="sub_dir4" value="">
                        <button onclick="unduh()" class=""><span class="fa fa-file-archive-o"></span> Download Zip</button>
                        
                    </div>
                </div>
                <div class="box-body">
                    <div id="priview_location">
                        <?php 
                        if(!empty($dir)){
                            $i=0;
                            foreach ($dir as $p) {
                                $i++;
                                ?>
                                <a href="#" onclick="openDir('<?php echo $p->dir1 ?>',<?php echo $i; ?>)">
                                    <div class="col-md-1 text-center">
                                        <img src="<?php echo base_url() ."assets/img/folder.png" ?>" class="img img-responsive">
                                        <span class="text-center"><?php echo $p->dir1; ?></span>
                                    </div>
                                </a>
                                <?php
                            }
                        }

                        ?>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="btn-group" id="pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
    var base_url= "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url() ."js/laporan.js"; ?>"></script>
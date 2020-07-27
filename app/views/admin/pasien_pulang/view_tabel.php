
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Data Upload_berkas</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> UPLOAD_BERKAS</a></li>
        <li class="active"> INDEX</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?php if(!empty($notif)) echo $notif; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">
                    <?php 
                    $save=array('aksi'=>'Save');
                    if(in_array($save, $akses)){
                        ?>
                        <a href="<?php echo base_url() ."upload_berkas/form" ?>" type="button" class="btn btn-success btn-sm"><span class="fa fa-plus"></span> Tambah</a>
                        <?php
                    }
                    ?>
                    </h3>
                    <div class="box-tools">
                        <form action="#" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="hidden" name="start" id="start" value="0">
                                <input type="text" name="q" id="q" class="form-control pull-right" placeholder="Search">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default" onclick="getpasien_pulang(0)"><i class="fa fa-search"></i></button>
                                    <?php 
                                    $excel=array('aksi'=>'Excel');
                                    $pdf=array('aksi'=>'Pdf');
                                    if(in_array($excel, $akses)){
                                        ?>
                                        <a href="<?php echo base_url() ."upload_berkas/exel" ?>" class="btn btn-success btn-sm"><span class="fa fa-file-excel-o"></span></a>
                                        <?php
                                    }
                                    if(in_array($pdf, $akses)){
                                        ?>
                                        <a href="<?php echo base_url() ."upload_berkas/pdf" ?>" class="btn btn-danger btn-sm"><span class="fa fa-file-pdf-o"></span></a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead class="bg-green">
                            <th>#</th>
                            <th>ID DAFTAR</th>
                            <th>NOMR</th>
                            <th>NO BPJS</th>
                            <!--th>NO KTP</th-->
                            <th>NO SEP</th>
                            <th>NAMA PASIEN</th>
                            <th>JEKEL</th>
                            <th>ALAMAT</th>
                            <th>TEMPAT LAHIR</th>
                            <th>TGL REG</th>
                            <th>TGL PULANG</th>
                            <th>KEADAAN PULANG</th>
                            <th>RUANG RAWAT</th>
                            <th class="text-right" style="width: 80px;">#</th>
                        </thead>
                        <tbody id="data"></tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <div class="btn-group" id="pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Modal-->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">COBA</h3>
                </div>

                <div class="modal-body form">
                    <form class="form-horizontal" method="POST" id="form" action="#" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
                            <input type="hidden" name="id_daftar" id="id_daftar" value="">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Daftar</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="tgl_reg" name="tgl_reg" placeholder="Tanggal Registrasi" value="<?php //echo $kunjungan->tgl_reg ?>" readonly >
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                   
                                    <span class ext-error" id="err_tgl_pulang"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Pulang</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="tgl_pulang" name="tgl_pulang" placeholder="Tanggal Pulang">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                   
                                    <span class ext-error" id="err_tgl_pulang"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Keadaan Keluar</label>
                                <div class="col-sm-9">
                                    <select class="form-control input-sm" name="keadaan_pulang" id="keadaan_pulang">
                                        <option value="">Keadaan Keluar</option>
                                        <option value="Sembuh">Sembuh</option>
                                        <option value="Membaik">Membaik</option>
                                        <option value="Belum Sembuh">Belum Sembuh</option>
                                        <option value="Meninggal < 48 Jam">Meninggal < 48 Jam</option>
                                        <option value="Meninggal > 48 Jam">Meninggal > 48 Jam</option>
                                    </select>
                                    <span class ext-error" id="err_tgl_pulang"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="pulangkanPasien()" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
<script type="text/javascript">
    var base_url= "<?php echo base_url(); ?>";
    var username="<?php echo $this->session->userdata('username'); ?>";
    $(function () {
        //Date picker
        $('.datepicker').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          minDate: new Date("2019-10-14"),
          maxDate: new Date("2019-10-20"),
        })
    })
</script>
<script src="<?php echo base_url() ."js/pasien_pulang.js"; ?>"></script>
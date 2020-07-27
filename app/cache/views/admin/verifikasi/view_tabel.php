<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Data Verifikasi</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> VERIFIKASI</a></li>
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
                        <button type="button" class="btn btn-success btn-sm" onclick="add()"><span class="fa fa-plus"></span> Tambah</button>
                        <?php
                    }
                    ?>
                    </h3>
                    <div class="box-tools">
                        <form action="#" method="GET">
                            <div class="col-md-5">
                                <input type="checkbox" name="rjtl"  id="rjtl" value="1" onclick="getVerifikasi(0)" checked >RJTL
                                <input type="checkbox" name="ritl"  id="ritl" value="1" onclick="getVerifikasi(0)" checked>RITL
                            </div>
                            <div class="col-md-7">
                                <div class="input-group input-group-sm">
                                    <input type="hidden" name="start" id="start" value="0">
                                    <input type="text" name="q" id="q" class="form-control pull-right" placeholder="Search">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default" onclick="getVerifikasi(0)"><i class="fa fa-search"></i></button>
                                        <?php 
                                        $excel=array('aksi'=>'Excel');
                                        $pdf=array('aksi'=>'Pdf');
                                        if(in_array($excel, $akses)){
                                            ?>
                                            <a href="<?php echo base_url() ."verifikasi/exel" ?>" class="btn btn-success btn-sm"><span class="fa fa-file-excel-o"></span></a>
                                            <?php
                                        }
                                        if(in_array($pdf, $akses)){
                                            ?>
                                            <a href="<?php echo base_url() ."verifikasi/pdf" ?>" class="btn btn-danger btn-sm"><span class="fa fa-file-pdf-o"></span></a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead class="bg-green">
                            <th>#</th>
                            <th>No Sep</th>
                            <th>Nomr</th>
                            <th>Nama Pasien</th>
                            <th>Tempat Lahir</th>
                            <th>Tgl Lahir</th>
                            <th>Jns Kelamin</th>
                            <th>Kode Jenis</th>
                            <th>Jenis Berkas</th>
                            <th>Poliklinik / Ruang Rawat</th>
                            <th>Berkas Wajib</th>
                            <th>Jml Berkas</th>
                            <th>Jml Verifikasi</th>
                            <th>Verifikasi</th>
                            <!--th class="text-right">#</th-->
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
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Nosep</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="no_sep" name="no_sep" placeholder="Nosep">
                                    <span class	ext-error" id="err_no_sep"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Nomr</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nomr" name="nomr" placeholder="Nomr">
                                    <span class	ext-error" id="err_nomr"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Namapasien</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Namapasien">
                                    <span class	ext-error" id="err_nama_pasien"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Tempatlahir</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempatlahir">
                                    <span class	ext-error" id="err_tempat_lahir"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Tgllahir</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" placeholder="Tgllahir">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <span class	ext-error" id="err_tgl_lahir"></span>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Jnskelamin</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="jns_kelamin" name="jns_kelamin" placeholder="Jnskelamin">
                                    <span class	ext-error" id="err_jns_kelamin"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Kodejenis</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="kode_jenis" name="kode_jenis" placeholder="Kodejenis">
                                    <span class	ext-error" id="err_kode_jenis"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Jenisberkas</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="jenis_berkas" name="jenis_berkas" placeholder="Jenisberkas">
                                    <span class	ext-error" id="err_jenis_berkas"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Poliklinik</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="poliklinik" name="poliklinik" placeholder="Poliklinik">
                                    <span class	ext-error" id="err_poliklinik"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Berkaswajib</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="berkas_wajib" name="berkas_wajib" placeholder="Berkaswajib">
                                    <span class	ext-error" id="err_berkas_wajib"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Jmlverifikasi</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="jml_verifikasi" name="jml_verifikasi" placeholder="Jmlverifikasi">
                                    <span class	ext-error" id="err_jml_verifikasi"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Jmlberkas</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="jml_berkas" name="jml_berkas" placeholder="Jmlberkas">
                                    <span class	ext-error" id="err_jml_berkas"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
<script type="text/javascript">
    var base_url= "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url() ."js/verifikasi.js"; ?>"></script>
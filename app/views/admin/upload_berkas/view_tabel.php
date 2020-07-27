<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Data Upload berkas</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> UPLOAD BERKAS</a></li>
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
                        <div class="col-md-5">
                            <input type="checkbox" name="rjtl"  id="rjtl" value="1" onclick="getUpload_berkas(0)" checked >RJTL
                            <input type="checkbox" name="ritl"  id="ritl" value="1" onclick="getUpload_berkas(0)" checked>RITL
                        </div>
                        <div class="col-md-7">
                            <form action="#" method="GET">
                                <div class="input-group input-group-sm">
                                    <input type="hidden" name="start" id="start" value="0">
                                    <input type="text" name="q" id="q" class="form-control pull-right" placeholder="Search">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default" onclick="getUpload_berkas(0)"><i class="fa fa-search"></i></button>
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
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead class="bg-green">
                            <th>#</th>
                            <th>Tgl Upload</th>
                            <th>Nomr</th>
                            <th>Id Daftar</th>
                            <th>No Sep</th>
                            <th>Nama Pasien</th>
                            <th>Jenis</th>
                            <th>Berkas</th>
                            <th>Jml Halaman</th>
                            <th>Status Verifikasi</th>
                            <th>User Upload</th>
                            <th>Tgl Reg</th>
                            <th>User Verfikasi</th><th class="text-right">#</th>
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
                            <input type="hidden" name="id_file" id="id_file" value="">
                            <input type="hidden" name="tgl_upload" id="tgl_upload" value="">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Nomr</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nomr" name="nomr" placeholder="Nomr">
                                    <span class	ext-error" id="err_nomr"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Iddaftar</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="id_daftar" name="id_daftar" placeholder="Iddaftar">
                                    <span class	ext-error" id="err_id_daftar"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Nosep</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="no_sep" name="no_sep" placeholder="Nosep">
                                    <span class	ext-error" id="err_no_sep"></span>
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
                                <label for="inputEmail3" class="col-sm-3 control-label">Kodejenis</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="kode_jenis" id="kode_jenis">
                                        <?php 
                                foreach ($list_m_jenisberkas as $list) {
                                    ?>
                                    <option value='<?php echo $list->kode_jenis; ?>' ><?php echo $list->jenis_berkas; ?></option>
                                    <?php
                                }
                            ?>
                                    </select>
                                    <span class	ext-error" id="err_kode_jenis"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Idberkas</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="id_berkas" id="id_berkas">
                                        <?php 
                                foreach ($list_m_berkas as $list) {
                                    ?>
                                    <option value='<?php echo $list->id_berkas; ?>' ><?php echo $list->nama_berkas; ?></option>
                                    <?php
                                }
                            ?>
                                    </select>
                                    <span class	ext-error" id="err_id_berkas"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Namafile</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_file" name="nama_file" placeholder="Namafile">
                                    <span class	ext-error" id="err_nama_file"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="checkbox" id="status_verifikasi" name="status_verifikasi" value="1">status_verifikasi
                                </div>
                            </div>
                            <input type="hidden" name="user_upload" id="user_upload" value="">
                            <input type="hidden" name="user_verfikasi" id="user_verfikasi" value="">
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
    var username="<?php echo $this->session->userdata('username'); ?>";
</script>
<script src="<?php echo base_url() ."js/upload_berkas.js"; ?>"></script>
<script type="text/javascript">
    getUpload_berkas(0);
</script>
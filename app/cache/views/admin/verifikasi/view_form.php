<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Form Verifikasi </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> VERIFIKASI </a></li>
        <li class="active"> FORM</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?php if(!empty($notif)) echo $notif; ?>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-widget widget-user-2">                    
                <div class="widget-user-header bg-green">
                    <div class="widget-user-image">
                        <img class="img-circle" src="<?php if($kunjungan->jns_kelamin=="") echo base_url() ."assets/img/female.png"; else echo base_url() ."assets/img/male.png" ?>" alt="" id="imgFemale">

                    </div>
                    <h4 class="widget-user-username" id="lblnama"><?php echo $kunjungan->nama_pasien; ?> <a style="float: right;" class='btn btn-default btn-sm' onclick="edit('<?= $kunjungan->id_daftar; ?>')"><span class="fa fa-pencil"></span> Edit</a></h4>
                    <h5 class="widget-user-desc"><?php echo $kunjungan->tempat_lahir ." / " .$kunjungan->tgl_lahir ?></h5>
                    <h5 class="widget-user-desc"><?php echo $kunjungan->no_bpjs ?></h5>
                </div>

                <div class="box-body">
                    <ul class="nav nav-stacked">
                        <li><a href="#">POLIKLINIK <?php echo $kunjungan->poliklinik ?> </a></li>
                        <li><a href="#">BERKAS <?php echo strtoupper($kunjungan->jenis_berkas) ."(" .$kunjungan->kode_jenis .")" ?> <span class="pull-right badge bg-aqua"><?php echo $kunjungan->jml_berkas; ?></span></a></li>
                    </ul>
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1" title="Histori" data-toggle="tab" id="tabHistori">
                                    <span class="fa fa-list"></span> Dokumen Klaim
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div id="divHistori" class="list-group">
                                    <?php 
                                    $jml_berkas_wajib=0;
                                        $upload_berkas_wajib=0;
                                        $jml_upload=0;
                                        $jml_verifikasi=0;
                                        $link=base_url() ."verifikasi/form/" .$id_daftar ;
                                        foreach ($dokumen as $d) {
                                            $ver="";
                                            /*
                                            if($d->jml_berkas>0) {
                                                $jml_upload++;
                                                $bg= "bg-green"; 
                                                $link=base_url() ."verifikasi/form/" .$id_daftar ."/" .$d->id_berkas;
                                                if($d->status_verifikasi==1) {
                                                    $jml_verifikasi++;
                                                    $ver="<span class='pull-right badge bg-green '><span class='fa fa-check'></span></span>";
                                                }
                                                else {
                                                    $ver="<span class='pull-right badge bg-red '><span class='fa fa-remove'></span></span>";
                                                }
                                                //echo "Status Verifikasi " .$ver;
                                            }
                                            else {
                                                if($d->wajib==1) {
                                                    
                                                    if($d->softcopy==1) {
                                                        $jml_berkas_wajib++;
                                                        if($d->jml_berkas>0) $upload_berkas_wajib++;
                                                        $bg = "bg-red"; 
                                                    }
                                                    else {
                                                        $bg="bg-black";
                                                    }
                                                }else {
                                                    $bg="bg-yellow";
                                                }
                                                $link= base_url() ."verifikasi/form/" .$id_daftar;
                                            }
                                            */
                                            if($d->wajib==1 && $d->softcopy==1) $jml_berkas_wajib++;
                                            $ber=$this->verifikasi_model->jmlBerkas($id_daftar,$d->id_berkas);
                                            $bg="";
                                            $action="";
                                            if(!empty($ber)) {
                                                $bg='bg-green';
                                                $link=base_url() ."verifikasi/form/" .$id_daftar ."/" .$d->id_berkas;
                                                $jml_berkas=$ber->jml_berkas;
                                                if($ber->status_verifikasi==1) {
                                                    $jml_verifikasi++;
                                                    $ver="<span class='pull-right badge bg-green '><span class='fa fa-check'></span></span>";
                                                }else{
                                                    if($jml_berkas>0) {
                                                        $ver="<span class='pull-right badge bg-red '><span class='fa fa-remove'></span></span>";
                                                        if($d->wajib==1) $upload_berkas_wajib++;
                                                    }
                                                }

                                                if($jml_berkas>0) {
                                                    if($d->wajib==1) $upload_berkas_wajib++;
                                                    $jml_upload++;
                                                }

                                            }
                                            else{
                                                $jml_berkas=0;
                                                $link='#';
                                                $action="onclick='uploadDokumen(\"".$id_daftar."\",\"".$d->id_berkas."\",\"".$d->nama_berkas."\")'";
                                                /*if($d->wajib==1 && $d->hardcopy==1) $bg='bg-black';
                                                else $bg='bg-yellow';*/
                                            }
                                            if($jml_berkas<=0){
                                                
                                                if($d->wajib==1 && $d->softcopy==1) {
                                                    $link='#';
                                                    $action="onclick='uploadDokumen(\"".$id_daftar."\",\"".$d->id_berkas."\",\"".$d->nama_berkas."\")'";
                                                    $bg='bg-red';
                                                }
                                                elseif($d->wajib==1 && $d->hardcopy==1) {
                                                    $bg="bg-black";
                                                    $link=base_url() .'verifikasi/form/'.$id_daftar;
                                                    $action="";
                                                }
                                                else {
                                                    $bg='bg-yellow';
                                                    $link='#';
                                                    $action="onclick='uploadDokumen(\"".$id_daftar."\",\"".$d->id_berkas."\",\"".$d->nama_berkas."\")'";
                                                    //echo $action;
                                                }
                                            }
                                            //$link=base_url() ."verifikasi/form/" .$id_daftar ."/" .$d->id_berkas;
                                            ?>
                                                <a href="<?php echo $link ?>" class="list-group-item" <?php echo $action; ?>> 
                                                    <h5 class="list-group-item-heading"><b><u><?php if($d->wajib == 1) echo "*" .$d->nama_berkas; else echo $d->nama_berkas ?></u></b> <span class="pull-right badge <?php echo $bg; ?>"><?php echo $jml_berkas; ?></span><?php echo $ver ?></h5>  
                                                    
                                                </a>
                                            <?php
                                        }
                                        if($upload_berkas_wajib<$jml_berkas_wajib){
                                            //echo "Berkas Sudah DIupload : ".$upload_berkas_wajib ." Dan Minimal Berkas Wajib : " .$jml_berkas_wajib;
                                            ?>
                                            <button type="button" class="btn btn-danger btn-block"> Berkas Belum Lengkap</button>
                                            <?php
                                        }else{
                                            if($jml_upload>$jml_verifikasi){
                                                ?>
                                                <button type="button" class="btn btn-warning btn-block"> Masih ada data yang belum diverifikasi</button>
                                                <?php
                                            }else{
                                                if($kunjungan->kode_jenis=="RJTL"){
                                                    ?>
                                                    <button type="button" class="btn btn-primary btn-block" onclick="generateReport('<?php echo $id_daftar; ?>')"> Generate Report Pdf</button>
                                                    <?php
                                                }else{
                                                    if(empty($kunjungan->tgl_pulang)||$kunjungan->tgl_pulang=="0000-00-00"){
                                                        ?>
                                                        <button type="button" class="btn btn-danger btn-block" onclick="pulangkan('<?php echo $id_daftar; ?>')" > Pasien Belum dipulangkan</button>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <button type="button" class="btn btn-primary btn-block" onclick="generateReport('<?php echo $id_daftar; ?>')"> Generate Report Pdf</button>
                                                        <?php
                                                    }
                                                }
                                                
                                            }
                                        }
                                        if(!empty($kunjungan->log_file)){
                                            ?>
                                            <a href="<?php echo base_url() .$kunjungan->log_dir_root ."/" .$kunjungan->log_sub_dir1."/" .$kunjungan->log_sub_dir2."/" .$kunjungan->log_sub_dir3."/" .$kunjungan->log_file; ?>" class="btn btn-danger btn-block" target="_blank"> Download Dokumen </a>
                                            <?php
                                        }
                                    ?>
                                </div>                
                                                    
                                <div>
                                    <span class="badge bg-black">&nbsp;</span> Dokumen Wajib Ada Dalam Bentuk Hardcopy<br>
                                    <span class="badge bg-green">&nbsp;</span> Dokumen Sudah Diupload<br>
                                    <span class="badge bg-red">&nbsp;</span> Dokumen wajib yang belum diupload<br>
                                    <span class="badge bg-yellow">&nbsp;</span> Dokumen belum diupload<br>
                                    <span class="badge bg-aqua">&nbsp;</span> Total Dokumen Yang Sudah diupload<br>
                                    <span class="badge bg-red"><span class='fa fa-remove'></span></span> Belum Diverifikasi<br>
                                    <span class="badge bg-green"><span class='fa fa-check'></span></span> Sudah Diverifikasi
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">
                    FORM VERIFIKASI <?php if(!empty($kunjungan)) echo "SEP <b><span style='color:#c62525;font-weight:bold'>" .strtoupper($kunjungan->no_sep) ."</span></b>"; ?>  <?php if(!empty($priview)) echo "DOKUMEN <b>" .strtoupper($priview[0]->nama_berkas); ?></b>
                    </h3>
                    <div class="box-tools">
                        <?php 
                        if(!empty($priview)) {
                            $sv=$priview[0]->status_verifikasi; 
                            if($sv==1){
                                ?>
                                <button class="btn btn-success btn-sm">Sudah Diverifikasi</button>
                                <?php
                            }else{
                                ?>
                                <button class="btn btn-danger btn-sm" onclick="verifikasi('<?php echo $id_daftar; ?>','<?php echo $dokumen_id; ?>')">Belum Diverifikasi</button>
                                <?php
                            }
                        }else {
                            $sv=0;

                        }
                        
                        ?>
                        
                    </div>
                </div>
                <div class="box-body">
                    <?php 
                    if(!empty($priview)){
                        foreach ($priview as $p) {
                            $tgl_reg=explode('-', $p->tgl_reg);
                            ?>
                            <p style="text-align: center;">
                                <div class="row">
                                <?php
                                if($sv!=1){
                                    ?>
                                    <div class='col-md-6'>
                                        <form id="form<?= $p->d_id; ?>" method="POST" action="#" enctype="multipart/form-data">
                                            Ubah File
                                            <input type="hidden" id="csrf" class='csrf' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
                                            <input type="hidden" name="d_id" id="d_id" value="<?= $p->d_id; ?>">
                                            <input type="hidden" name="tgl_reg" value="<?= $p->tgl_reg; ?>">
                                            <input type="hidden" name="nomr" value="<?= $p->nomr; ?>">
                                            <input type="hidden" name="id_daftar" value="<?= $p->id_daftar; ?>">
                                            <input type="hidden" name="no_sep" value="<?= $p->no_sep; ?>">
                                            <input type="hidden" name="id_berkas" value="<?= $p->id_berkas; ?>">
                                            <input type="hidden" name="d_idfile" value="<?= $p->d_idfile; ?>">
                                            <input type='file' name="userfile[]" class="btn btn-warning btn-xs" onchange="updateFile('<?= $p->d_id ?>')">
                                            
                                        </form>
                                    </div>
                                    <div class="col-md-6 text-right"><label>&nbsp;</label><br><button class="btn btn-danger btn-xs" onclick="hapusFile('<?= $p->d_id ?>')"><span class="fa fa-remove"></span> Hapus</button></div>
                                    <?php
                                }
                                ?>
                            </div>
                            </p>    
                            <img src="<?php echo base_url() ."files/" .$tgl_reg[0] ."/" .$tgl_reg[1] ."/" .$p->nomr ."/" .$p->id_daftar ."/" .$p->d_nama_file; ?>" class='img img-responsive'>
                            
                            <hr>
                            <?php
                        }
                    }
                    if(!empty($priview)){
                    ?>

                    <form id="form_addfile" method="POST" action="#" enctype="multipart/form-data">
                        <input type="hidden" id="csrf" class='csrf' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
                                        <input type="hidden" name="d_id" id="d_id" value="">
                                        <input type="hidden" name="tgl_reg" value="<?= $p->tgl_reg; ?>">
                                        <input type="hidden" name="nomr" value="<?= $p->nomr; ?>">
                                        <input type="hidden" name="id_daftar" value="<?= $p->id_daftar; ?>">
                                        <input type="hidden" name="no_sep" value="<?= $p->no_sep; ?>">
                                        <input type="hidden" name="id_berkas" value="<?= $p->id_berkas; ?>">
                                        <input type="hidden" name="d_idfile" value="<?= $p->d_idfile; ?>">
                                        <label>Tambahkan File</label>
                                        <input type='file' name="userfile[]" class="btn btn-primary btn-xs" onchange="addFile('<?= $p->d_id ?>')">
                    </form>
                    <?php } ?>
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
                            <input type="hidden" id="csrf" class='csrf' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
                            <input type="hidden" name="id_daftar" id="id_daftar" value="">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Daftar</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="tgl_reg" name="tgl_reg" placeholder="Tanggal Registrasi" value="<?php echo $kunjungan->tgl_reg ?>"  readonly >
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

<!--Modal-->
    <div class="modal fade" id="modal_upload" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">COBA</h3>
                </div>

                <div class="modal-body form">
                    <form class="form-horizontal" method="POST" id="form_upload" action="<?php echo base_url() ."verifikasi/save" ?>" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" id="csrf" class='csrf' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
                            <input type="hidden" class="form-control" id="xid_daftar" name="id_daftar" placeholder="ID DAFTAR" >
                            <input type="hidden" class="form-control" id="no_sep" name="no_sep" placeholder="Nosep" >
                            <input type="hidden" class="form-control" id="nomr" name="nomr" placeholder="Nomr" >
                            <input type="hidden" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Namapasien" >
                            <input type="hidden" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempatlahir" >
                            <input type="hidden" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" placeholder="Tgllahir" >
                            <input type="hidden" class="form-control" id="kode_jenis" name="kode_jenis" placeholder="Kodejenis">
                            <input type="hidden" class="form-control" id="jenis_berkas" name="jenis_berkas" placeholder="Jenisberkas" >   
                            <input type="hidden" class="form-control" id="grId" name="grId" placeholder="GrId" >
                            <input type="hidden" class="form-control" id="poliklinik" name="poliklinik" placeholder="Poliklinik" >
                            <input type="hidden" class="form-control" id="xtgl_reg" name="tgl_reg" placeholder="Tanggal Registrasi" >
                            <input type="hidden" class="form-control" id="xtgl_pulang" name="tgl_pulang" placeholder="TGL PULANG" >
                            <input type="hidden" class="form-control" id="xkeadaan_pulang" name="keadaan_pulang" placeholder="keadaan_pulang" >
                            <input type="hidden" class="form-control" id="id_berkas" name="id_berkas" placeholder="ID BERKAS">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">JML HALAMAN BERKAS</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="halaman_berkas" id="halaman_berkas" onchange ="halamanBerkas()">
                                        <option value="1">1 Halaman</option>
                                        <option value="2">2 Halaman</option>
                                        <option value="3">3 Halaman</option>
                                        <option value="4">4 Halaman</option>
                                        <option value="5">5 Halaman</option>
                                    </select>
                                    <span class ext-error" id="err_jml_halaman"></span>
                                </div>
                            </div>

                            <div id="file_berkas">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">HALAMAN 1</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" class="form-control" id="nama_file" name="nama_file" placeholder="Namafile">
                                            <input type="file" id="halaman1" name="userfile[]" placeholder="Nama File">
                                            <span class ext-error" id="err_nama_file"></span>
                                        </div>
                                    </div>
                                </div>
                                <!--input type="submit" name="simpan" value="simpan"-->
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
<!--Modal-->
    <div class="modal fade" id="modal_pasien" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">COBA</h3>
                </div>

                <div class="modal-body form">
                    <form class="form-horizontal" method="POST" id="form_pasien" action="#" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" id="csrf" class='csrf' name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
                            
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">NOMR</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="x-nomr" name="nomr" placeholder="Nomr" readonly>
                                    <span class ext-error" id="err_nomr"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">ID DAFTAR</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="x-id_daftar" name="id_daftar" placeholder="Id Daftar" readonly>
                                    <span class ext-error" id="err_iddaftar"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">NAMA PASIEN</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="x-nama_pasien" name="nama_pasien" placeholder="Namapasien" readonly>
                                    <span class ext-error" id="err_nama_pasien"></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">JENIS BERKAS</label>
                                <div class="col-sm-9">
                                    <select class="form-control input-sm" name="kode_jenis" id="x-kode_jenis">
                                        <option value="">Pilih</option>
                                        <?php 
                                        foreach ($jenis_berkas as $j) {
                                            ?>
                                            <option value="<?= $j->kode_jenis ?>"><?= $j->jenis_berkas ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <span class ext-error" id="err_jenis_berkas"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">SEP</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="x-no_sep" name="no_sep" placeholder="Nosep">
                                    <span class ext-error" id="err_no_sep"></span>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="update()" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
<script type="text/javascript">
    var base_url= "<?php echo base_url(); ?>";
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

<script src="<?php echo base_url() ."js/verifikasi.js"; ?>"></script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Form Upload berkas</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> UPLOAD_BERKAS</a></li>
        <li class="active"> FORM</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <?php if(!empty($notif)) echo $notif; ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">
                        Upload Berkas
                    </h3>
                    <div class="box-tools">
                        
                    </div>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="POST" id="form" action="<?php echo base_url() ."upload_berkas/save" ?>" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
                            <input type="hidden" name="id_file" id="id_file" value="<?php if(!empty($berkas)) echo $berkas->id_file; ?>">
                            <input type="hidden" name="tgl_upload" id="tgl_upload" value="<?php if(!empty($berkas)) echo $berkas->tgl_upload; ?>">
                            <?php if(!empty($berkas)) { ?>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">JENIS BERKAS</label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="kode_jenis" id="kode_jenis" value="<?php echo $berkas->kode_jenis; ?>">
                                    <input type="text" name="jenis_berkas" id="jenis_berkas" value="<?php echo $berkas->jenis_berkas ." (" .$berkas->kode_jenis .")"; ?>" class='form-control' readonly>
                                    <span class ext-error" id="err_kode_jenis"></span>
                                </div>
                            </div>
                            <?php } else{ ?>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">JENIS BERKAS</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="kode_jenis" id="kode_jenis" onchange="getBerkas()">
                                        <option value="">Pilih Jenis Berkas</option>
                                        <?php 
                                            if(!empty($berkas)) $kode_jenis= $berkas->kode_jenis;else $kode_jenis="";
                                            foreach ($list_m_jenisberkas as $list) {
                                                ?>
                                                <option value='<?php echo $list->kode_jenis; ?>' <?php if($kode_jenis==$list->kode_jenis) echo "selected"; ?>><?php echo $list->jenis_berkas; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    <span class ext-error" id="err_kode_jenis"></span>
                                </div>
                            </div>
                            <?php }?>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">NOMR</label>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" id="nomr" name="nomr" placeholder="NOMR" value="<?php if(!empty($berkas)) echo $berkas->nomr; ?>" readonly>
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default" onclick="cariKunjungan(0)"><i class="fa fa-search"></i> Cari Pasien</button>
                                            
                                        </div>
                                    </div>
                                    <span class ext-error" id="err_nomr"></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">ID DAFTAR</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="id_daftar" name="id_daftar" placeholder="ID DAFTAR" value="<?php if(!empty($berkas)) echo $berkas->id_daftar; ?>" readonly>
                                    <span class ext-error" id="err_id_daftar"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">NO BPJS</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="no_bpjs" name="no_bpjs" placeholder="NO BPJS" value="<?php if(!empty($berkas)) echo $berkas->no_bpjs; ?>" readonly>
                                    <span class ext-error" id="err_no_bpjs"></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">NIK</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="no_ktp" name="no_ktp" placeholder="NO KTP" value="<?php if(!empty($berkas)) echo $berkas->no_ktp; ?>" readonly>
                                    <span class ext-error" id="err_no_bpjs"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">NAMA PASIEN</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="NAMA PASIEN" value="<?php if(!empty($berkas)) echo $berkas->nama_pasien; ?>" readonly>
                                    <span class ext-error" id="err_nama_pasien"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">TEMPAT / TGL LAHIR</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" value="<?php if(!empty($berkas)) echo $berkas->tempat_lahir; ?>" readonly>
                                    <span class ext-error" id="err_tempat_Lahir"></span>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal Lahir" value="<?php if(!empty($berkas)) echo $berkas->tgl_lahir; ?>" readonly>
                                    <span class ext-error" id="err_tgl_lahir"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">TGL REGISTRASI</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tgl_reg" name="tgl_reg" placeholder="TANGGAL REGISTRASI" value="<?php if(!empty($berkas)) echo $berkas->tgl_reg; ?>" readonly>
                                    <input type="hidden" class="form-control" id="tgl_pulang" name="tgl_pulang" placeholder="TANGGAL REGISTRASI" value="<?php if(!empty($berkas)) echo $berkas->tgl_pulang; ?>" readonly>
                                    <span class ext-error" id="err_nama_pasien"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">POLY TUJUAN / RUANG RAWATAN</label>
                                <div class="col-sm-9">
                                    <input type="hidden" class="form-control" id="grId" name="grId" value="<?php if(!empty($berkas)) echo $berkas->grId; ?>" >
                                    <input type="text" class="form-control" id="grNama" name="grNama" placeholder="Poly Tujuan / Ruang Rawatan" value="<?php if(!empty($berkas)) echo $berkas->grNama; ?>" readonly>
                                    <span class ext-error" id="err_grId"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">SEP</label>
                                <div class="col-sm-9">
                                    <?php if(!empty($berkas)) $sep= $berkas->no_sep; else $sep=""; ?>
                                    <input type="text" class="form-control" id="no_sep" name="no_sep" placeholder="NO SEP" value="<?php if(!empty($berkas)) echo $berkas->no_sep; ?>" <?php if(!empty($sep)) echo "readonly" ?>>
                                    <span class ="text-error" id="err_no_sep"></span>
                                </div>
                            </div>
                            <?php 
                            if(empty($berkas)){
                                ?>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">BERKAS</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="id_berkas" id="id_berkas">
                                            <option value="">Pilih Berkas</option>
                                            <?php 
                                                if(!empty($berkas)) $id_berkas= $berkas->id_berkas; else $id_berkas=""; 
                                                foreach ($list_m_berkas as $list) {
                                                    ?>
                                                    <option value='<?php echo $list->id_berkas; ?>' <?php if($id_berkas==$list->id_berkas) echo "selected"; ?> ><?php echo $list->nama_berkas; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        <span class ext-error" id="err_id_berkas"></span>
                                    </div>
                                </div>
                                <?php
                            }else{
                                ?>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">BERKAS</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="id_berkas" id="id_berkas" value="<?php echo $berkas->id_berkas; ?>">
                                        <input type="text" name="nama_berkas" id="nama_berkas" class="form-control " value="<?php echo $berkas->nama_berkas; ?>" readonly>
                                        
                                        <span class ext-error" id="err_id_berkas"></span>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            
                            <?php 
                            if(!empty($berkas)){
                                $file=$this->upload_berkas_model->getListberkas($berkas->id_file);
                                $histori=$this->upload_berkas_model->getHistori($berkas->no_sep);
                                $tgl_registrasi=$berkas->tgl_reg;
                                $tgl=explode('-', $tgl_registrasi);
                                $nomr=$berkas->nomr;
                                ?>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">TAMBAH BERKAS</label>
                                    <div class="col-sm-9">
                                        <?php 
                                        //print_r($berkas);
                                        //if(!empty($berkas)) $jml_halaman= $berkas->jml_halaman; else $jml_halaman=""; ?>
                                        <select class="form-control" name="halaman_berkas" id="halaman_berkas" onchange="halamanBerkas()">
                                            <option value="">Tambahkan berkas</option>
                                            <option value="1">1 Halaman</option>
                                            <option value="2">2 Halaman</option>
                                            <option value="3">3 Halaman</option>
                                            <option value="4">4 Halaman</option>
                                            <option value="5">5 Halaman</option>
                                        </select>
                                        <span class ext-error" id="err_halaman_berkas"></span>
                                    </div>
                                </div>
                                <div id="list_berkas">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">FILE</label>
                                        <div class="col-md-9">
                                        <?php 
                                        $i=0;
                                        foreach ($file as $f) {
                                            $i++;
                                            ?>
                                            <div class="col-sm-4">
                                                <div class="row">
                                                    <div class="col-md-12" style="bottom-border:1px solid; border-collapse: collapse;"><div style="float: left;">Halaman <?php echo $i; ?></div><div class="text-right"><button type="button" class="btn btn-danger btn-xs" onclick="hapusBerkas('<?php echo $f->d_id; ?>')"><span class="fa fa-remove"></span></button></div></div>
                                                    <div class="col-md-12" style="min-height: 180px;">
                                                        <img src="<?php echo base_url() ."files/" .$tgl[0] ."/" .$tgl[1] ."/" .$berkas->nomr ."/" .$berkas->id_daftar ."/" .$f->d_nama_file; ?>" class='img img-responsive'>
                                                    </div>
                                                    <!--div class="col-md-12"><input type="file" name="userfile<?php //echo $i; ?>"></div-->
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        </div>
                                    </div>
                                </div>
                                <div id="file_berkas"></div>
                                <?php
                            }else{
                                ?>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">JML HALAMAN BERKAS</label>
                                    <div class="col-sm-9">
                                        <?php 
                                        //print_r($berkas);
                                        if(!empty($berkas)) $jml_halaman= $berkas->jml_halaman; else $jml_halaman=""; ?>
                                        <select class="form-control" name="halaman_berkas" id="halaman_berkas" onchange="halamanBerkas()">
                                            <option value="1" <?php if($jml_halaman==1) echo "selected"; ?>>1 Halaman</option>
                                            <option value="2" <?php if($jml_halaman==2) echo "selected"; ?>>2 Halaman</option>
                                            <option value="3" <?php if($jml_halaman==3) echo "selected"; ?>>3 Halaman</option>
                                            <option value="4" <?php if($jml_halaman==4) echo "selected"; ?>>4 Halaman</option>
                                            <option value="5" <?php if($jml_halaman==5) echo "selected"; ?>>5 Halaman</option>
                                        </select>
                                        <span class ext-error" id="err_halaman_berkas"></span>
                                    </div>
                                </div>
                                <div id="file_berkas">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">HALAMAN 1</label>
                                        <div class="col-sm-9">
                                            <input type="hidden" class="form-control" id="nama_file" name="nama_file" placeholder="Namafile">
                                            <input type="file" id="halaman1" name="userfile[]" placeholder="Nama File">
                                            <span class ext-error" id="err_nama_file"></span>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            
                            
                            <input type="hidden" id="status_verifikasi" name="status_verifikasi" value="0">
                            <input type="hidden" name="user_upload" id="user_upload" value="">
                            <input type="hidden" name="user_verfikasi" id="user_verfikasi" value="">
                            <!--input type="submit" name="simpan" value="Simpan"-->
                        </div>
                    </form>
                </div>
                <div class="box-footer text-right">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-success">Save</button>
                    
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">
                    Berkas Yang Sudah Diupload
                    </h3>
                    <div class="box-tools">
                        
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead class="bg-blue">
                            <tr>
                                <td>Nama Berkas</td>
                                <td>Jml Halaman</td>
                            </tr>
                        </thead>
                        <tbody id="histori_berkas">
                            <?php  
                            if(!empty($histori)){
                                foreach ($histori as $h) {
                                    ?>
                                    <tr>
                                        <td><?php echo $h->nama_berkas; ?></td>
                                        <td><?php echo $h->jml_halaman; ?> Halaman </td>
                                    </tr>
                                    <?php
                                }
                            }
                                
                            ?>
                        </tbody>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!--div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Cari Data Pasien</h3>
                </div-->

                <div class="modal-body form">
                    <form class="form-horizontal" method="POST" id="form" action="#" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
                            <div class="row">
                                <!--div class="col-md-12"-->
                                    <div class="box box-success">
                                        <div class="box-header">

                                            
                                        </div>
                                        <div class="box-body">
                                            <form action="#" method="GET">
                                                <div class="col-md-4">
                                                    <label>Tanggal Registrasi</label>
                                                    <div class="form-group">
                                                        
                                                        <div class="input-group">
                                                            <input type="text" class="form-control input-sm datepicker" id="tgl_registrasi" name="tgl_registrasi" placeholder="Tanggal Registrasi" value="<?php echo date('Y-m-d') ?>" onchange="getKunjungan(0)">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <label>Ruangan</label>
                                                    <div class="form-group">
                                                        <!--div class="input-group"-->
                                                            <select class="form-control input-sm" name="grId" id="ruangan" onchange="getKunjungan(0)">
                                                                <option value="">-- Pilih Ruangan --</option>
                                                            </select>
                                                            <!--span class="input-group-addon"><i class="fa fa-calendar"></i></span-->
                                                        <!--/div-->
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Keyword</label>
                                                        <div class="input-group input-group-sm">
                                                                <input type="hidden" name="start" id="start" value="0">
                                                                <input type="text" name="q" id="q" class="form-control pull-right" placeholder="Search" onkeyup="getKunjungan(0)">
                                                                <div class="input-group-btn">
                                                                    <button type="button" class="btn btn-default" onclick="getKunjungan(0)"><i class="fa fa-search"></i></button>
                                                                </div>
                                                            <!--span class="input-group-addon"><i class="fa fa-calendar"></i></span-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <hr>
                                            <table class="table table-bordered">
                                                <thead class="bg-green">
                                                    <tr>
                                                        <td>NOSEP</td>
                                                        <td>NOMR</td>
                                                        <td>NOBPJS</td>
                                                        <td>NIK</td>
                                                        <td>NAMA</td>
                                                        <td>RUANGAN</td>
                                                        <td>#</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="data-pendaftaran">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="box-footer">
                                            <div class="btn-group" id="pagination"></div>
                                        </div>
                                    </div>
                                <!--/div-->
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <div class="btn-group" id="pagination"></div>
                    <!--button type="button" id="btnSave" onclick="save()" class="btn btn-success">Save</button-->
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
<script type="text/javascript">
    $(function () {
        //CKEDITOR.replace('isi_posting');
        //Date picker
        $('.datepicker').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
        })
    })
    var base_url= "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url() ."js/upload_berkas.js"; ?>"></script>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Data Users</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> USERS</a></li>
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
                            <div class="input-group input-group-sm">
                                <input type="hidden" name="start" id="start" value="0">
                                <input type="text" name="q" id="q" class="form-control pull-right" placeholder="Search">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default" onclick="getUsers(0)"><i class="fa fa-search"></i></button>
                                    <?php 
                                    $excel=array('aksi'=>'Excel');
                                    $pdf=array('aksi'=>'Pdf');
                                    if(in_array($excel, $akses)){
                                        ?>
                                        <a href="<?php echo base_url() ."users/exel" ?>" class="btn btn-success btn-sm"><span class="fa fa-file-excel-o"></span></a>
                                        <?php
                                    }
                                    if(in_array($pdf, $akses)){
                                        ?>
                                        <a href="<?php echo base_url() ."users/pdf" ?>" class="btn btn-danger btn-sm"><span class="fa fa-file-pdf-o"></span></a>
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
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Nohp</th>
                            <th>Role</th>
                            <th>Status User</th><th class="text-right">#</th>
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
                                <label for="inputEmail3" class="col-sm-3 control-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="id" id="id">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                                    <span class	ext-error" id="err_username"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                    <span class	ext-error" id="err_password"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Namalengkap</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Namalengkap">
                                    <span class	ext-error" id="err_nama_lengkap"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Nohp</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nohp" name="nohp" placeholder="Nohp">
                                    <span class	ext-error" id="err_nohp"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Role</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="role" id="role">
                                        <?php 
                                foreach ($list_m_role as $list) {
                                    ?>
                                    <option value='<?php echo $list->role_id; ?>' ><?php echo $list->role_nama; ?></option>
                                    <?php
                                }
                            ?>
                                    </select>
                                    <span class	ext-error" id="err_role"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">&nbsp;</label>
                                <div class="col-sm-9">
                                    <input type="checkbox" id="status_user" name="status_user" value="1">Aktif
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
<script src="<?php echo base_url() ."js/users.js"; ?>"></script>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>E-KLAIM | APP</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url() ."assets/" ?>components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <!--link rel="stylesheet" href="<?php //echo base_url() ."assets/" ?>components/font-awesome/css/font-awesome.min.css"-->
  <!-- Ionicons -->
  <!--link rel="stylesheet" href="<?php //echo base_url() ."assets/" ?>components/Ionicons/css/ionicons.min.css"-->
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ."assets/" ?>css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url() ."assets/" ?>css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url() ."assets/" ?>components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url() ."assets/" ?>components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url() ."assets/" ?>components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url() ."assets/" ?>components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() ."assets/" ?>components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <script src="<?php echo base_url() ."assets/" ?>swal/sweetalert.js"></script>
  <link rel="stylesheet" href="<?php echo base_url() ."assets/" ?>swal/sweetalert.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <!--link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"-->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <!--link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"-->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/font-awesome-4.7.0/css/font-awesome.min.css">

  <!-- jQuery 3 -->
<script src="<?php echo base_url() ."assets/" ?>components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url() ."assets/" ?>components/bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
  <?php $link=$this->uri->segment(1); ?>
  <header class="main-header bg-green">
    <!-- Logo -->
    <a href="<?php echo base_url() ."home"; ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>E</b>KLAIM</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>E-KLAIM APP</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url() ."assets" ?>/img/stikerrsudpp.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $this->session->userdata('user_namalengkap') ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url() ."assets" ?>/img/stikerrsudpp.png" class="img-circle" alt="User Image">

                <p>
                  <?php echo $this->session->userdata('user_namalengkap') ?>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url() ."home/logout" ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url() ."assets" ?>/img/stikerrsudpp.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('user_namalengkap') ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="cari" id="cari" class="form-control" placeholder="Search..." onkeyup="menu('<?php echo $this->auth_model->indukaktif($link); ?>','<?php echo $link ?>');">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
        <li>
          <a href="<?php echo base_url() ."home"; ?>">
            <i class="fa fa-home"></i> <span>Home</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->

  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php echo $content; ?>
    <!--Modal-->
    <div class="modal fade" id="modal_user" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">COBA</h3>
                </div>

                <div class="modal-body form">
                    <form class="form-horizontal" method="POST" id="form" action="#" enctype="multipart/form-data">
                        <div class="box-body">
                            
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
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.0
    </div>
    <strong>Copyright &copy; 2019 <a href="#">Team IT RSUD Kota Padang Panjang</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url() ."assets/" ?>components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
  var base_url="<?php echo base_url(); ?>";

  
  menu('<?php echo $this->auth_model->indukaktif($link); ?>','<?php echo $link ?>');
  function menu(buka,link)
  {
    var cari=$('#cari').val();
    //alert(cari);
    $.ajax({
        url : "<?php echo base_url(); ?>" + "home/menu?q="+cari,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          
          var jmlData=data.length;
          var menu='<li class="header">MAIN NAVIGATION</li>';
          menu+='<li>'
          menu+='<a href="<?php echo base_url() ."home"; ?>">';
          menu+='<i class="fa fa-home"></i> <span>Home</span>';
          menu+='<span class="pull-right-container">';
          menu+='<small class="label pull-right bg-green">new</small>';
          menu+='</span>';
          menu+='</a>';
          menu+='</li>';
          var induk="";
          var open="";
          var link1="";
          //console.log(data[0]["induk_nama"]);
          for(var i=0; i<jmlData;i++){
           //alert(i);
            //console.log("MENU INDUK : "+data[i]["induk_nama"]);
            //alert(data[i]["induk_id"]);
            if(buka==data[i]["induk_id"]) open='active';
            else open="";
            if(link==data[i]["link"]) link1='active';
            else link1='';
            if(i==0){
              menu+="<li class=\"treeview "+open+"\">";
              menu+="<a href=\"#\"><i class=\""+data[i]["induk_icon"]+"\"></i>" +data[i]["induk_nama"] +"</a>";
              menu+="<ul class=\"treeview-menu\">'";
              menu+="<li class='"+link+"'><a href=\""+base_url+data[i]["link"]+"\"><span class=\"fa fa-circle-o\"></span>"+data[i]["nama_modul"]+"</a></li>";
              induk=data[i]["induk_nama"];
            }else{
              if(induk==data[i]["induk_nama"]){
                if(i-1==jmlData){
                  menu+="<li class='"+link1+"'><a href=\""+base_url+data[i]["link"]+"\"><span class=\"fa fa-circle-o\"></span>"+data[i]["nama_modul"]+"</a></li>";
                  menu+="</ul></li>";
                  
                }else{
                  menu+="<li class='"+link1+"'><a href=\""+base_url+data[i]["link"]+"\"><span class=\"fa fa-circle-o\"></span>"+data[i]["nama_modul"]+"</a></li>";
                  //alert("INDUK LAMA "+induk+" INDUK : "+data[i]["induk_nama"]+" ANAK NAMA: "+data[i]["nama_modul"]);
                }
                induk=data[i]["induk_nama"];
              }else{
                //alert("BEDA INDUK LAMA "+induk+" INDUK : "+data[i]["induk_nama"]+" ANAK NAMA: "+data[i]["nama_modul"]);
                menu+="</ul></li>";
                if(i-1==jmlData){
                  
                  menu+="<li class=\"treeview\">";
                  menu+="<a href=\"#\"><i class=\""+data[i]["induk_icon"]+"\"></i>" +data[i]["induk_nama"] +"</a>";
                  menu+="<ul class=\"treeview-menu "+open+"\">'";
                  menu+="<li class='"+link1+"'><a href=\""+base_url+data[i]["link"]+"\"><span class=\"fa fa-circle-o\"></span>"+data[i]["nama_modul"]+"</a></li>";
                  
                }else{
                  menu+="<li class=\"treeview "+open+"\">";
                  menu+="<a href=\"#\"><i class=\""+data[i]["induk_icon"]+"\"></i>" +data[i]["induk_nama"] +"</a>";
                  menu+="<ul class=\"treeview-menu\">'";
                  menu+="<li class='"+link1+"'><a href=\""+base_url+data[i]["link"]+"\"><span class=\"fa fa-circle-o\"></span>"+data[i]["nama_modul"]+"</a></li>";
                  induk=data[i]["induk_nama"];
                }
                
                
              }
              
            }
          }
          $('.sidebar-menu').html(menu);
          console.clear();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            swal({
             title: "Error",
             text: "Terjadi Kesalahan Saat Pengambilan data",
             type: "error",
             timer: 5000
            });
        }
    });
  }
</script>


<!-- Morris.js charts -->
<script src="<?php echo base_url() ."assets/" ?>components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url() ."assets/" ?>components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url() ."assets/" ?>components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<!--script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script-->
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url() ."assets/" ?>components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url() ."assets/" ?>components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ."assets/" ?>components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url() ."assets/" ?>components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<!--script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script-->
<!-- Slimscroll -->
<script src="<?php echo base_url() ."assets/" ?>components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<!--script src="<?php //echo base_url() ."assets/" ?>components/fastclick/lib/fastclick.js"></script-->
<!-- AdminLTE App -->
<script src="<?php echo base_url() ."assets/" ?>js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url() ."assets/" ?>js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ."assets/" ?>js/demo.js"></script>
</body>
</html>

<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <?php 
          $error=$this->session->flashdata('error');
          if (!empty($error)) {
            if(is_array($error)){
            foreach ($error as $key => $value) {
          ?>
            <div class="alert alert-error">
              <h4><i class="icon fa fa-ban"></i> Error</h4>
              <p>
              <?php 
                $err=$error[$key];
                if(is_array($err)){
                  foreach ($err as $e) {
                    echo $e;
                  }
                }else{
                  echo $error[$key];
                }
              
              ?>
                
              </p>
            </div>
          <?php
            }
              //echo "<p align='center'><span class='btn btn-sq btn-danger'>" .$error[$key] ."</p></span>";
            }else{
            ?>
              <div class="alert alert-error">
                <h4><i class="icon fa fa-ban"></i> Error</h4>
                <p><?php echo $error; ?></p>
              </div>
            <?php
            }
          }

          $warning=$this->session->flashdata('warning');
          if (!empty($warning)) {
            if(is_array($error)){
              foreach ($warning as $key => $value) {
          ?>
              <div class="alert alert-warning">
                <h4><i class="icon fa fa-ban"></i> Warning</h4>
                <p><?php echo $warning[$key]?></p>
              </div>
          <?php
              //echo "<p align='center'><span class='btn btn-sq btn-danger'>" .$error[$key] ."</p></span>";
              }
            }else{
          ?>
              <div class="alert alert-warning">
                <h4><i class="icon fa fa-ban"></i> Warning</h4>
                <p><?php echo $warning; ?></p>
              </div>
          <?php    
            }
          }

         
          $success=$this->session->flashdata('message');
          if (!empty($success)) {
            if(is_array($success)){
            foreach ($success as $key => $value) {
              ?>
                <div class="alert alert-success">
                  <h4 ><i class="fa fa-thumbs-up"></i>Success</h4>
                  <p><?php echo $success[$key]?></p>
                </div>
              <?php
            }
          }else{
            ?>
              <div class="alert alert-success">
                  <h4 ><i class="fa fa-thumbs-up"></i>Success</h4>
                  <p><?php echo $success; ?></p>
                </div>
            <?php
          }
          }
        ?>
        </div>
      </div>
      <div class="row">
        
      </div>
      

    </section>

   
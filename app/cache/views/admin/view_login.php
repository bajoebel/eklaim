<section class="content">
  <div class="login-box" style="border:solid 1px #00a65a; border-collapse: collapse;box-shadow: 5px 5px; border-radius: 10px;">
    <div class="login-logo">
      <p style="text-align: center;"><a href="#" >
    </div>
    <div class="login-box-body">
      <?php 
        $error=$this->session->flashdata('error');
      ?>
      <p class="login-box-msg" style="text-align: center;"><img src="<?php echo base_url() ."assets/img/stikerrsudpp.png" ?>"><br>
      <?php if(!empty($error)) echo "<span class='text-error'>$error</span>"; else echo "Sign in to start your session"; ?></p>

      <form action="<?php echo base_url() ."home/cekuser" ?>" method="post">
        <div class="form-group has-feedback">
          <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" >
          <input type="text" name="username" class="form-control" placeholder="Username">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="userpass" class="form-control" placeholder="Password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            &nbsp;
          </div>
          <div class="col-xs-4">
            <button type="submit" class="btn btn-success btn-block btn-flat">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
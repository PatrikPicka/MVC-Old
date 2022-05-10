<?php $this->start('head'); ?>

<?php $this->end(); ?>


<?php $this->start('body'); ?>

 <div class="col-md-6 offset-md-3 well">
 	<form class="form" action="<?=PROOT?>register/login" method="post">
 		<h3 class="text-center">Log In</h3>
 		<div class="form-group">
 			<label for="username">
 				Username:<?php 
				if (Session::exists('log_username')) {
					echo Session::flash('log_username');
				}

				?>
 			</label>
 			<input type="text" name="username" id="username" class="form-control">
 		</div>
 		<div class="form-group">
 			<label for="password">
				Password:<?php if (Session::exists('reg_pass')) {
					echo Session::flash('reg_pass');
				} ?>
			</label>
 			<input type="text" name="password" id="password" class="form-control">
 		</div> 		
 	<div class="form-group">
 			<label for="remember_me">Remember me <input type="checkbox" name="remember_me" id="remember_me" value="on"></label>
 		</div> 
 	 	<div class="form-group text-right">
 			<input type="submit" value="Login" class="btn btn-primary"><br>
 			<a href="<?= PROOT ?>register/register">Register</a>
 		</div>	
 	</form>

 </div>
<?php $this->end(); ?>
<?php $this->start('head');?>


<?php $this->end('head');?>


<?php $this->start('body');?>
<div class="col-md-6 offset-md-3 well">
	<h3 class="text-center">Register Form</h3>
	<form class="form" action="" method="post">
		<div class="form-group">
			<label for="fname">First Name</label>
			<input type="text" name="fname" id="fname" class="form-control" value="<?=$this->post['fname']?>">
		</div>
		<div class="form-group">
			<label for="lname">Last Name</label>
			<input type="text" name="lname" id="lname" class="form-control" value="<?=$this->post['lname']?>">
		</div>
		<div class="form-group">
			<label for="email">E-mail</label>
			<input type="email" name="email" id="email" class="form-control" value="<?=$this->post['email']?>">
		</div>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" class="form-control" value="<?=$this->post['username']?>">
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="form-control">
		</div>
		<div class="form-group">
			<label for="confirm">Password</label>
			<input type="password" name="confirm" id="confirm" class="form-control">
		</div>
		<div class="text-right">
			<input type="submit" name="submit" class="btn btn-primary" class="form-control">
		</div>
	</form>

</div>

<?php $this->end('body');?>
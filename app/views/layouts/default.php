<!DOCTYPE html>
<html lang="cz">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= $this->content('head'); ?>
	<title><?= $this->siteTitle();?></title>
	<script type="text/javascript" src="<?=PROOT?>js/jquery.js"></script>
	<script type="text/javascript" src="<?=PROOT?>js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=PROOT?>css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=PROOT?>css/custom.css">
	
</head>
<body>
	<?php include ROOT.DS.'app'.DS.'views'.DS.'layouts'.DS.'main_menu.php'; ?>

	<div class="container-fluid" style="min-height:cal(100% - 125px);">
		<?= $this->content('body'); ?>
	</div>

</body>
</html>
<?php
	require '../config/initialize.inc';

	$session->checkApplicant();

	$header = new Header(array(
		'title' => 'Dashboard'
	));
	$detail = Applicant::getDetail();
	checkPermitExpiry();
?>
<?php if(!ajax()) { ?>
	<!DOCTYPE html>
	<html>
		<?=$header->setHead()?>
		<body>
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
			  	<a class="navbar-brand" href="index.php">BPLS</a>
			  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			    	<span class="navbar-toggler-icon"></span>
			  	</button>
			  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
			    	<ul class="navbar-nav mr-auto">
			      		<li class="nav-item active">
			        		<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
			      		</li>
			      		<li class="nav-item">
			        		<a class="nav-link" href="businesses.php">Businesses</a>
			      		</li>
			    	</ul>
			    	<ul class="navbar-nav navbar-right">
			    		<li class="nav-item dropdown">
			        		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			          			<?=htmlentities($_SESSION['user_username'])?>
			        		</a>
			        		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
			          			<a class="dropdown-item" href="logout.php">Logout</a>
			       			</div>
			      		</li>
			    	</ul>
			  </div>
			</nav>
<?php } ?>
		<div id="container">
			<br />
			<div class="container">
				<h2>Welcome, <?=htmlentities($detail->first_name)?>!</h2>
				<?=$session->message()?>
			</div>
		</div>
<?php if(!ajax()) { ?>
		</body>
		<?=$header->loadScripts()?>
	</html>
<?php } ?>
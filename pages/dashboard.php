<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Title</title>
	<style>
		body {
			width: 100%;
		}
		.main {
			width: 80%;
			margin: 0 auto;
		}

		.login-form {
			width: 300px;
			position: absolute;
			top: 50%;
			left: 50%;
			-webkit-transform: translate(-50%, -50%);
			-moz-transform: translate(-50%, -50%);
			-ms-transform: translate(-50%, -50%);
			-o-transform: translate(-50%, -50%);
			transform: translate(-50%, -50%);
		}
		.form-field {
			width: 100%;
			padding: 2px;
		}
		.form-field input {
			padding: 4px;
		}
	</style>
</head>
<body>
<div class="main">

	<?php if ($app->session()->hasMessage()) : ?>
		<div>
			<?php print $app->session()->flush(); ?>
		</div>
	<?php endif; ?>

	<div class="message">
		You are logged in <?php print_r($app->session()->getUser()->getAllKeys()); ?>
	</div>
	<div class="logout">
		<form action="/auth/logout.php" method="post">
			<?php csrf_field(); ?>
			<input type="hidden" name="action" value="logout">
			<button>Logout</button>
		</form>
	</div>

</div>
</body>
</html>
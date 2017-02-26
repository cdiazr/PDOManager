<?php 
# Incluimos la configuracion y la clase de Mensajería
include 'config.php';

$users = $mp->getUsers();


if(isset($_POST['Send'])) {
	$data = $mp->checkUserExist($_POST['User']);

	if(count($data) > 0) {
		# Iniciamos sesion
		$_SESSION['LoggedIn'] = 1;
		$_SESSION['Username'] = $data['Username'];
		$_SESSION['UserID'] = $data['UserID'];
	} else
		echo "Usuario incorrecto";

	if($_SESSION['LoggedIn']) 
		header('location: listar.php?tipo=e');
} ?>
<!DOCTYPE html>
<html>
<head>
	<title>Mensajería Interna</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
	<div class="row">
		<div class="col-md-12">
			<form method="post" action="">
				<div class="col-md-12"><h3>Usuarios para la prueba: <?=$users?></h3></div>
				<div class="col-md-2">
					<input type="text" name="User" class="form-control" placeholder="Nombre de usuario"/><br /><br />
				</div>
				<div class="col-md-2">
					<button type="submit" name="Send" class="btn btn-success">Entrar</button>
				</div>
			</form>
		</div>
	</div>	
</body>
</html>
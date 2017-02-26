<?php 
# Incluimos la configuracion
include('config.php'); 

$msgs = $mp->getMessages($_SESSION['UserID'], 0, 1);
# Obtenemos el mensaje privado
$id = $_GET['id'];
$msg = $mp->showMessage($id);
$rawDate = new DateTime($msg['date']);
$date = $rawDate->format('l jS \of F Y h:i:s A');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Mensajería Interna</title>
		<meta charset="utf-8">
		<!-- Latest compiled and minified CSS -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
	    <nav class="navbar navbar-default">
	    	<div class="container-fluid">
	    		<div class="navbar-header">
	    			<a class="navbar-brand" href="#">Mensajes Internos</a>
	    		</div>
		    	<ul class="nav navbar-nav">
		    		<li><i class="fa fa-mail"></i><a href="listar.php?tipo=e">Mensajes <span class="label label-danger"><?=$msgs?></span></a></li>
		    		<li><a href="crear.php">Enviar</a></li>
		    	</ul>
		    	<ul class="nav navbar-nav navbar-right">
			      <li><a href="#"><span class="glyphicon glyphicon-user"></span> Bienvenido <?=$_SESSION['Username']?></a></li>
			      <li><a href="cerrar.php"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
			    </ul>
			</div>
	    </nav>
	    <div class="container">
	    	<div class="panel panel-default">
	        	<div class="panel-heading">
	        		<h3>Leer correo de <?=$msg['FromUser'] ?></h3>
	        		<small><?=$date ?></small>
	    		</div>

	    		<div class="panel-body">
	          		<div class="row">
	            		<div class="col-md-12">
							<strong>Asunto:</strong> <?=$msg['subject'] ?><br /><br />
							<strong>Mensaje:</strong><br />
							<?=$msg['msg']?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
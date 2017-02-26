<?php 
# Incluimos la configuracion
include 'config.php';

$msgs = $mp->getMessages($_SESSION['UserID'], 0, 1); 

if(isset($_POST['enviar']))
{
	foreach ($_POST as $key => $value)
		$$key = $value;

	if(!empty($ToUserID) && !empty($subject) && !empty($msg))
	{
		$mp->postStore($_POST);
				
		echo "Mensaje enviado correctamente.";
	}
}
?>
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
			<form method="post" action="" >
				<input type="hidden" name="FromUserID" value="<?=$_SESSION['UserID'] ?>">
				<div class="panel panel-default">
					<div class="panel-heading"><label>Formulario de envío de mensaje</label></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-2">
										<p>Para</p>
										<input type="text" name="ToUserID" class="form-control" placeholder="Usuario" />
										<label class="label label-default">Usuarios para la prueba: marcofbb, entra-ya, dedydamy</label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<p>Asunto</p>
										<input type="text" name="subject" class="form-control" placeholder="Asunto" />
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<p>Mensaje</p>
										<textarea name="msg" class="form-control" placeholder="Mensaje"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<p></p>
										<button type="submit" name="enviar" class="btn btn-success">Enviar</button>
									</div>
								</div>							
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
<?php 
# Incluimos la configuracion
include 'config.php'; 

$msgs = $mp->getIndex($_SESSION['UserID'], $_GET['tipo']);
$field = $_GET['tipo'] == 'e'? 'De' : 'Para';
$user = $_GET['tipo'] == 'e'? 'FromUser' : 'ToUser';
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
       <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">Mensajes Internos</a>
        </div>
        <ul class="nav navbar-nav">
          <li><i class="fa fa-mail"></i><a href="listar.php?tipo=e">Mensajes <span class="label label-danger"><?=count($msgs) ?></span></a></li>
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
          <?=$_SESSION['Username'] . ' tienes ' ?>
          <?=count($msgs) ?> mensajes en tu bandeja de (<a href="listar.php?tipo=e">entrada</a> / <a href="listar.php?tipo=s">salida</a>)
        </div>

        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-responsive table-hover table-sm table-striped table-bordered">
                <tr>
                  <td width="53" align="center" valign="top"><strong>ID</strong></td>
                  <td width="426" align="center" valign="top"><strong>Asunto</strong></td>
                  <td width="321" align="center" valign="top"><strong><?=$field ?></strong></td>
                <td width="321" align="center" valign="top"><strong>Fecha</strong></td>
                </tr>
                <?php foreach($msgs as $msg) { ?>
                <tr <?php $msg['MsgRead'] == 0? 'style="font-weight: bold;"' : ''; ?>>
                  <td align="center" valign="top"><?=$msg['MsgID']?></td>
                  <td align="center" valign="top"><a href="leer.php?id=<?=$msg['MsgID']?>"><?=$msg['subject']?></a></td>
                  <td align="center" valign="top"><?=$msg[$user]?></td>
                <td align="center" valign="top"><?=$msg['date']?></td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
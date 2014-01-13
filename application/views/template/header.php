<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php if(isset($titulo)) echo $titulo; else echo "Admin";?></title>
	<?php
	echo "\t".link_tag("assets/css/style.default.css")."\n";
	echo "\t".link_tag("assets/css/style.dark.css")."\n";
	echo "\t".link_tag("assets/css/style.css")."\n";
	if(isset($css))
	{
		foreach ($css as $style) {
				echo "\t".link_tag("assets/css/$style.css")."\n";
			}
	}
	?>
</head>
<body>
	<div class="mainwrapper">
		<header class="leftpanel">

			<div class="logopanel">
				<h1><a href="<?=$url?>/main">Admin</a></h1>
			</div>
			
			<div id="time" class="datewidget"></div>

			<nav class="leftmenu">
				<ul class="nav nav-tabs nav-stacked">
					<li class="nav-header">Controladores</li>
					<li><a href="<?=$url?>/orcamento">Orçamento</a></li>
					<li class="dropdown">
						<a>Equipamentos</a>
						<ul>
							<li><a href="<?=$url?>/equipamento">Lista</a></li>
							<li><a href="<?=$url?>/equipamentotipo">Tipos</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a>Pessoas</a>
						<ul>
							<li><a href="<?=$url?>/pessoa">Lista</a></li>
							<li><a href="<?=$url?>/pessoafuncao">Funções</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</header>
		<main class="rightpanel">
			<header class="headerpanel">
				<a href="" class="showmenu"></a>
				<div class="headerright">
					<div class="dropdown userinfo">
						<a class="dropdown-toggle" data-toggle="dropdown" data-target="#">Olá <?=humanize($this->session->userdata('user'))?>! <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?=$url?>/login/logout"><span class="icon-off"></span>Logout</a></li>
						</ul>
					</div>
				</div>
			</header>
			<div class="pagetitle">
				<h1><?php if(isset($titulo)) echo $titulo; else echo "&nbsp;"; if(isset($registros)):?> <span>Total de <?php echo $registros; if($registros>1) echo " registros"; else echo " registro";?></span><?php endif;?></h1>
			</div>

			<div class="maincontent">
				<div class="contentinner">
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Administração - Login</title>
	<?php
	echo "\t".link_tag("assets/css/style.default.css")."\n";
	echo "\t".link_tag("assets/css/style.css")."\n";
	?>
</head>

<body class="loginbody">
	
	<div class="loginwrapper">
		<div class="loginwrap zindex100">
			<h1 class="logintitle"><span class="iconfa-lock"></span> Logue-se <span class="subtitle">Senão, não dá pra entrar )':</span></h1>
			<?php if (validation_errors()){
				$errors = $this->form_validation->error_array();
				if(count($errors)==1)
				{
					if(isset($errors['username']))
						echo "<div class='alert alert-error alert-login'>".$errors['username']."</div>";
					else
						echo "<div class='alert alert-error alert-login'>".$errors['password']."</div>";
				}
				else
					echo "<div class='alert alert-error alert-login'>".$errors['username']."</br>".$errors['password']."</div>";
			}
			
			$msg = $this->session->flashdata('msg');
			if ($msg){
				echo "<div class='alert alert-error alert-login'>$msg</div>";
			}?>
			<div class="loginwrapperinner">
				<form id="loginform" method="post">
					<p class="animate4 bounceIn"><input type="text" id="username" name="username" placeholder="Usuário"></p>
					<p class="animate5 bounceIn"><input type="password" id="password" name="password" placeholder="Senha"></p>
					<p class="animate6 bounceIn"><button class="btn btn-default btn-block">Enviar</button></p>
				</form>
			</div><!--loginwrapperinner-->
		</div>
		<div class="loginshadow animate3 fadeInUp"></div>
	</div>
	
	<script src='<?=$assets?>js/jquery.min.js'></script>
	<script src='<?=$assets?>js/jquery-migrate.min.js'></script>
	<script src='<?=$assets?>js/login.js'></script>
</body>
</html>
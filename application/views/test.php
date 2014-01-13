<?php 
?>
<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
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
	
	<form class="formtable" method="post">
		<div class="row-fluid">
			<table class="table equipamento table-bordered">
				<thead>
					<tr class="tablegray">
						<td colspan="6"><b>Equipamentos</b></td>
					</tr>
					<tr class="tablegray">
						<td></td>
						<td>Nome</td>
						<td>Valor Diária</td>
						<td>Data de Começo</td>
						<td>Data de Termino</td>
						<td>Valor Final</td>
					</tr>
				</thead>
				<tbody>
					<tr id="add">
						<td></td>
						<td>
							<select data-placeholder="Escolha o equipamento..." id="equipamento">
								<option disabled selected ></option>
								<?php 
									foreach ($equipamentos as $id => $nome) {
										echo "<option value=\"$id\">$nome</option>";
									}
								?>
							</select>
						</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td class="tablegray table-footer" colspan="6">Total: R$ <span id="total">0</span>,00</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</form>
	
	
	
	<script src='<?=$assets?>js/jquery.min.js'></script>
	<?php if(isset($js)): foreach ($js as $j):?>
	<script src='<?=$assets?>js/<?=$j?>.js'></script>
	<?php endforeach;endif;?>
	<?php if(isset($javascript)):?><script><?=$javascript;?></script><?php endif; ?>
	<script src='<?=$assets?>js/orcamento.js'></script>
</body>
</html>
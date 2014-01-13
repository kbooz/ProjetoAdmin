<?php
print_r($orcamento);
$a=$this->session->userdata('update');
if (validation_errors()):?>
<div class="alert alert-block alert-error">
	<button data-dismiss="alert" class="close" type="button">×</button>
	<h4>Erro!</h4>
	Foram encontrados os seguintes erros:
	<ul class="erro">
		<?=validation_errors();?>
	</ul>
</div>
<?php endif; ?>
<table class="table table-invoice tablewhite table-bordered">
	<tr>
		<td colspan=6 class="titulo" id="orcamento_nome"><?=$orcamento['nome'];?></td>
	</tr>
	<tr>
		<td class="tablegray">Cliente</td>
		<td><input type='hidden' id="orcamento_cliente" value='<?=$orcamento['cliente']?>'/><?=$this->pessoas->getName($orcamento['cliente']);?></td>
		<td class="tablegray">Data de Começo</td>
		<td id="orcamento_dataentrada"><?=$orcamento['dataentrada'];?></td>
		<td class="tablegray">Data de Término</td>
		<td id="orcamento_datasaida"><?=$orcamento['datasaida'];?></td>
	</tr>
</table>

&nbsp;

<form class="formtable" method="post">
	<div class="row-fluid">
		<table class="table tablewhite equipamento table-bordered">
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
				<?php if(isset($lista_equipamentos))
				foreach($lista_equipamentos as $linha): ?>
				<?php if(isset($linha['idEquipamento'])) $linha['id'] = $linha['idEquipamento'];?>
				<tr id="equipamento_row<?=$linha['id']?>">
					<td><a onclick='deleteRow("<?=$linha['id']?>","<?=$this->equipamentos->getName($linha['id'])?>","equipamento")'>X</a></td>
					<td><?=$this->equipamentos->getName($linha['id'])?></td>
					<td><div class="input-prepend input-append"><span class="add-on">R$</span><input name="number" min="0" class="number input-small"  id="equipamento_row<?=$linha['id']?>_diaria" placeholder="<?=$linha['valordiaria']?>" value="<?=$linha['valordiaria']?>"></input><span class="add-on">,00</span></div></td>
					<td><input class="input-small" id="equipamento_row<?=$linha['id']?>_entrada" placeholder="<?=$orcamento['dataentrada']?>" value="<?=$orcamento['dataentrada']?>" readonly></input></td>
					<td><input class="input-small" id="equipamento_row<?=$linha['id']?>_saida" placeholder="<?=$orcamento['datasaida']?>" value="<?=$orcamento['datasaida']?>" readonly></input></td>
					<td>R$ <span class="final" id="equipamento_row<?=$linha['id']?>_final">0</span>,00</td>
				</tr>
			<?php endforeach;?>
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

&nbsp;

<div class="row-fluid">
	<table class="table tablewhite funcionario table-bordered">
	<thead>
		<tr class="tablegray">
			<td colspan="6"><b>Funcionarios</b></td>
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
		<?php if(isset($lista_funcionarios))
		foreach($lista_funcionarios as $linha):?>
		<?php if(isset($linha['idPessoa'])) $linha['id'] = $linha['idPessoa'];?>
		<tr id="funcionario_row<?=$linha['id']?>">
			<td><a onclick='deleteRow("<?=$linha['id']?>","<?=$this->pessoas->getName($linha['id'])?>","funcionario")'>X</a></td>
			<td><?=$this->pessoas->getName($linha['id'])?></td>
			<td><div class="input-prepend input-append"><span class="add-on">R$</span><input name="number" min="0" class="number input-small"  id="funcionario_row<?=$linha['id']?>_diaria" placeholder="<?=$linha['valordiaria']?>" value="<?=$linha['valordiaria']?>"></input><span class="add-on">,00</span></div></td>
			<td><input class="input-small" id="funcionario_row<?=$linha['id']?>_entrada" placeholder="<?=$orcamento['dataentrada']?>" value="<?=$orcamento['dataentrada']?>" readonly></input></td>
			<td><input class="input-small" id="funcionario_row<?=$linha['id']?>_saida" placeholder="<?=$orcamento['datasaida']?>" value="<?=$orcamento['datasaida']?>" readonly></input></td>
			<td>R$ <span class="final" id="funcionario_row<?=$linha['id']?>_final">0</span>,00</td>
		</tr>
	<?php endforeach;?>
	<tr id="add">
		<td></td>
		<td>
			<select data-placeholder="Escolha o funcionario..." id="funcionario">
				<option disabled selected ></option>
				<?php 
				foreach ($funcionarios as $id => $nome) {
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
		<td class="tablegray  table-footer" colspan="6">Total: R$ <span id="total">0</span>,00</td>
	</tr>
</tfoot>
</table>
</div>

&nbsp;

<div class="row-fluid">
	<table class="table tablewhite despesa table-bordered">
		<thead>
			<tr class="tablegray">
				<td colspan="6"><b>Despesas</b></td>
			</tr>
			<tr class="tablegray">
				<td></td>
				<td>Nome</td>
				<td>Valor Despesa</td>
				<td>Data de Começo</td>
				<td>Data de Termino</td>
				<td>Valor Final</td>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($lista_despesas))
			foreach($lista_despesas as $linha):?>
			<tr id="despesa_row<?=$linha['id']?>">
				<td><a onclick='deleteRow("<?=$linha['id']?>","<?=$linha['nome']?>","despesa")'>X</a></td>
				<td><input type='text' placeholder='Nome da despesa' value="<?=$linha['nome']?>" id="despesa_row<?=$linha['id']?>_nome" /></td>
				<td><div class="input-prepend input-append"><span class="add-on">R$</span><input name="number" min="0" class="number input-small"  id="despesa_row<?=$linha['id']?>_valor" placeholder="<?=$linha['valor']?>" value="<?=$linha['valor']?>"></input><span class="add-on">,00</span></div></td>
				<td><input class="input-small" id="despesa_row<?=$linha['id']?>_entrada" placeholder="<?=$orcamento['dataentrada']?>" value="<?=$orcamento['dataentrada']?>" readonly></input></td>
				<td><input class="input-small" id="despesa_row<?=$linha['id']?>_saida" placeholder="<?=$orcamento['datasaida']?>" value="<?=$orcamento['datasaida']?>" readonly></input></td>
				<td>R$ <span class="final" id="despesa_row<?=$linha['id']?>_final">0</span>,00</td>
			</tr>
		<?php endforeach;?>
		<tr id="add">
			<td></td>
			<td>
				<button id="addbutton" class="buttonGrey">Adicionar Despesa</button>
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
<br>
<div class="amountdue">
	<h1>
		<span>Despesas:</span>R$ <span id="orcamento_despesa" class="orcamento_lucro_valor red">0</span>,00
		<span>Valor do orçamento:</span>R$ <input type='text' value="<?php if(isset($orcamento['valor'])) echo $orcamento['valor']; else echo 0?>" id="orcamento_valor" class="orcamentoValor blue" />,00
	<span style="margin-top:5px;">Lucro:</span>R$ <span id="orcamento_lucro" class="orcamento_lucro_valor red">0</span>,00</h1>
</div>


	<div class="actionBar" align="right">
		<?php 
		echo " ".form_submit( 'send', 'Cancelar', 'class="buttonRed" id="cancel"')." ";
		echo form_submit( 'send', 'Voltar', 'class="buttonBlue" id="back"' )." ";
		if($do=='add') echo form_submit( 'send', 'Avancar', 'class="buttonGreen" id="submit"' );
		elseif($do=='edit') echo form_submit( 'send', 'Avancar', 'class="buttonOrange" id="submit"' );
		?>
		<?php
		$this->session->unset_userdata('update');?>
	</div>
</form>
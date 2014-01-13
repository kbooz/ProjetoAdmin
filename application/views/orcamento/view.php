<table class="table tablewhite table-invoice table-bordered">
	<tr>
		<td colspan=6 class="titulo"><?=$orcamento['nome'];?></td>
	</tr>
	<tr>
		<td class="tablegray">Cliente</td>
		<td><?=$this->pessoas->getName($orcamento['idCliente']);?></td>
		<td class="tablegray">Data de Começo</td>
		<td id="orcamento_dataentrada"><?=$orcamento['dataentrada'];?></td>
		<td class="tablegray">Data de Término</td>
		<td id="orcamento_datasaida"><?=$orcamento['datasaida'];?></td>
	</tr>
</table>
<br>
<table class="table tablewhite equipamento table-bordered">
	<thead>
		<tr class="tablegray">
			<td colspan="6"><b>Equipamentos</b></td>
		</tr>
		<tr class="tablegray">
			<td>#</td>
			<td>Nome</td>
			<td>Valor Diária</td>
			<td>Data de Começo</td>
			<td>Data de Termino</td>
			<td>Valor Final</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$count=0;
		if(isset($equipamentos))
			foreach($equipamentos as $linha):?>
		<tr id="equipamento_row<?=$linha['idEquipamento']?>">
			<td><?=++$count;?></td>
			<td><?=$this->equipamentos->getName($linha['idEquipamento'])?></td>
			<td>R$ <span id="equipamento_row<?=$linha['idEquipamento']?>_diaria"><?=$linha['valordiaria']?></span>,00</td>
			<td id="equipamento_row<?=$linha['idEquipamento']?>_entrada"><?=$orcamento['dataentrada']?></td>
			<td id="equipamento_row<?=$linha['idEquipamento']?>_saida"><?=$orcamento['datasaida']?></td>
			<td>R$ <span class="final" id="equipamento_row<?=$linha['idEquipamento']?>_final">0</span>,00</td>
		</tr>
	<?php endforeach;?>
</tbody>
<tfoot>
	<tr>
		<td class="tablegray table-footer" colspan="6">Total: R$ <span id="total">0</span>,00</td>
	</tr>
</tfoot>
</table>
<br>
<table class="table tablewhite funcionario table-bordered">
	<thead>
		<tr class="tablegray">
			<td colspan="6"><b>Funcionarios</b></td>
		</tr>
		<tr class="tablegray">
			<td>#</td>
			<td>Nome</td>
			<td>Valor Diária</td>
			<td>Data de Começo</td>
			<td>Data de Termino</td>
			<td>Valor Final</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$count=0;
		if(isset($funcionarios))
			foreach($funcionarios as $linha):?>
		<tr id="funcionario_row<?=$linha['idPessoa']?>">
			<td><?=++$count;?></td>
			<td><?=$this->pessoas->getName($linha['idPessoa'])?></td>
			<td>R$ <span id="funcionario_row<?=$linha['idPessoa']?>_diaria"><?=$linha['valordiaria']?></span>,00</td>
			<td id="funcionario_row<?=$linha['idPessoa']?>_entrada"><?=$orcamento['dataentrada']?></td>
			<td id="funcionario_row<?=$linha['idPessoa']?>_saida"><?=$orcamento['datasaida']?></td>
			<td>R$ <span class="final" id="funcionario_row<?=$linha['idPessoa']?>_final">0</span>,00</td>
		</tr>
	<?php endforeach;?>
</tbody>
<tfoot>
	<tr>
		<td class="tablegray table-footer" colspan="6">Total: R$ <span id="total">0</span>,00</td>
	</tr>
</tfoot>
</table>
<br>
<table class="table tablewhite despesa table-bordered">
	<thead>
		<tr class="tablegray">
			<td colspan="6"><b>Despesas</b></td>
		</tr>
		<tr class="tablegray">
			<td>#</td>
			<td>Nome</td>
			<td>Valor Despesa</td>
			<td>Data de Começo</td>
			<td>Data de Termino</td>
			<td>Valor Final</td>
		</tr>
	</thead>
	<tbody>
		<?php
		$count=0;
		if(isset($despesas))
			foreach($despesas as $linha):?>
		<tr id="despesa_row<?=$linha['id']?>">
			<td><?=++$count;?></td>
			<td><?=$linha['nome']?></td>
			<td>R$ <span id="despesa_row<?=$linha['id']?>_valor"><?=$linha['valor']?></span>,00</td>
			<td id="despesa_row<?=$linha['id']?>_entrada"><?=$orcamento['dataentrada']?></td>
			<td id="despesa_row<?=$linha['id']?>_saida"><?=$orcamento['datasaida']?></td>
			<td>R$ <span class="final" id="despesa_row<?=$linha['id']?>_final">0</span>,00</td>
		</tr>
	<?php endforeach;?>
</tbody>
<tfoot>
	<tr>
		<td class="tablegray table-footer" colspan="6">Total: R$ <span id="total">0</span>,00</td>
	</tr>
</tfoot>
</table>
<br>
<table class="table  invoice-table">
	<colgroup>
	<col class="con0 width70">
	<col class="con0 width30">
</colgroup>
<tbody>
	<tr>
		<td class="msg-invoice">
			<h4 style="line-height: 0!important;">Obs:</h4>
			<p><?=nl2br($orcamento['obs']);?></p>
		</td>
		<td class="right">
			<div class="amountdue">
				<h1>
					<span>Despesas:</span>R$ <span id="orcamento_despesa" class="orcamento_lucro_valor red"><?=$orcamento['despesa'];?></span>,00
					<span style="margin-top:5px;">Valor do orçamento:</span> R$ <span id="orcamento_valor" class=" orcamento_lucro_valor blue"><?=$orcamento['valor'];?></span>,00
					<span style="margin-top:5px;">Lucro:</span> R$ <span id="orcamento_lucro" class="orcamento_lucro_valor"><?=$orcamento['lucro'];?></span>,00</h1>
				</div>
			</td>
		</tr>
	</tbody>
</table>

<div class="actionBar" align="right">
	<a href="http://localhost/ci/<?=$tabela?>/edit/<?=$id?>" class="buttonOrange">Editar</a>
	<a href="http://localhost/ci/<?=$tabela?>/delete/<?=$id?>" class="buttonRed">Apagar</a>
	<a href="http://localhost/ci/<?=$tabela?>" class="buttonBlue">Voltar</a>
</div>
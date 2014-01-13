<?php

$a=$this->session->userdata('update');
$val = array();

foreach ($columns as $column) {
	if(isset($values))
	{
		if($values[$column]!=null)
			$val[$column] = $values[$column];
		else
			$val[$column] = $this->input->post($column);
	}
	else
		$val[$column] = $this->input->post($column);
}


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

<div class="row-fluid">
	<form class="formtable" method="post">
		<table id="orcamento" class="table tablewhite table-bordered table-invoice">
			<thead>
				<tr>
					<td class="tablegray" colspan=6>Parte 1/3</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan=6><?=form_input(array('name'=> "nome", 'id'=> "nome", 'value' => $val['nome'], 'class' => 'bb', 'placeholder'=>'Titulo'))?></td>
				</tr>
				<tr>
					<td class="tablegray"><label for="idCliente">Cliente</label></td>
					<td>
						<select name="cliente" data-placeholder="Escolha o cliente..." id="cliente">
							<?php
							if($val['cliente']==null)
								echo "<option disabled selected ></option>";
							else
								echo "<option disabled ></option>";
							
							foreach ($foreign as $id => $nome)
							{
								$sel = "";
								if($val['cliente']==$id)
									$sel = 'selected';
								echo "<option $sel value=\"$id\">$nome</option>";
							}
							?>
						</select>
					</td>
					<td class="tablegray"><label for="dataentrada">Data de Começo</label></td>
					<td><?=form_input( array( 'name'=>"dataentrada", 'id'=> "dataentrada", 'class'=>'date input-small', 'placeholder'=>'dd/mm/aa', 'value' => $val["dataentrada"]))?></td>
					<td class="tablegray"><label for="datasaida">Data de Término</label></td>
					<td><?=form_input( array( 'name'=>"datasaida", 'id'=> "datasaida", 'class'=>'date input-small', 'placeholder'=>'dd/mm/aa', 'value' => $val["datasaida"]))?></td>	
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td class="tablegray table-footer" colspan="6">
						<?=form_submit( 'send', 'Cancelar', 'class="buttonRed" id="cancel"')?> <?php if($do=='add') echo form_submit( 'send', 'Avancar', 'class="buttonGreen" id="submit"' );
						elseif($do=='edit') echo form_submit( 'send', 'Avancar', 'class="buttonOrange" id="submit"' );
						?>
					</td>
				</tr>
			</tfoot>
		</table>
	</form>
</div>
<?php
$this->session->unset_userdata('update');?>
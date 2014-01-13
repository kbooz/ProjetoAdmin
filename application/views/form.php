<?php

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

<div class="row-fluid">
	<div class='span8'>
		<form  action="" class="formtable" method="post">
			<table class="table table-bordered table-invoice">
			<?php foreach ( $columns as $column ) {
				
				if(isset($values[$column]))
					$v = $values[$column];
				else
					$v = $this->input->post($column);
				

				$name = humanize( $column );
				if(isset($rename[$column]))
					$name = humanize( $rename[$column] );
				
				$pre = "<tr><td class='width30'><label for='$column'>$name</label></td>";

				if ( $column!='id' ) {
					if(isset($set[$column]))
					{
						switch ( $set[$column] ) {
							case 'string':
								$input = array( 'name'=> "$column", 'id'=> "$column", 'value' => $v );
								$content = form_input( $input );
								break;

							case 'text':
								$input = array( 'name'=> "$column", 'id'=> "$column", 'value' => $v );
								$content =form_textarea( $input );
								break;

							case 'date':
								$input = array( 'name'=>"$column", 'id'=> "$column", 'class'=>'date input-small', 'placeholder'=>'dd/mm/aa', 'value' => $v);
								$content = form_input( $input );
								break;

							case 'foreign':
								$foreign[''] = null;
								$text = "data-placeholder='Escolha o $name' class='chzn-select' value='".$v."'";
								$selected = ($v) ? $v : '';
								$content = form_dropdown( $column, $foreign, $selected, $text );
								break;

							case 'money':
								$before = '<div class="input-prepend input-append"><span class="add-on">R$</span>';
								$after = '<span class="add-on">,00</span></div>';
								$input = array('type'=>'number', 'min'=>'0' ,'name'=>"$column", 'id'=>"$column", 'class'=>'input-small', 'value' => $v );
								$content = $before.form_input( $input ).$after;
								break;

							case 'bool':
								$input = array( 'name'=> "$column", 'id'=> "$column", "value" => "1");
								$check = $v;
								if(!empty($check))
								{
									$input['checked'] = 'checked';
								}
								
								$content = form_checkbox($input);
									
								break;
						}
					}
					else
					{
						$input = array( 'name'=> "$column", 'id'=> "$column", 'value' => $v );
						$content = form_input( $input );
					}

					echo $pre."<td>".$content."</td></tr>";
				}
				
			}
		?>
			</table>
			<div class="actionBar" align="right">
				
				<?php if($do=='add') echo form_submit( 'send', 'Adicionar', 'class="buttonGreen"' );
					  elseif($do=='edit') echo form_submit( 'send', 'Editar', 'class="buttonOrange"' );
					?>
				<?php echo form_submit( 'send', 'Cancelar', 'class="buttonBlue"' );
				$this->session->unset_userdata('update');?>
			</div>
		</form>
	</div>
</div>
<?php $v = $values['id']; ?>
<div class="row-fluid">
	<div class='span8'>
		<table class="table table-bordered table-invoice">
			<tbody>
			<?php foreach ($values as $column => $value): if($column!='id'):?>
			<tr>
				<td class="width30"><?php
				if(isset($rename[$column]))
					echo $rename[$column];
				else
					echo humanize($column);
				?></td>
				<td class="width70"><?php
				$content = $value;
				if(isset($set[$column])){
					switch ($set[$column]){
						case('money'):
							if($value!=0)
								$content = 'R$ '.$content.',00';
							else
								$content = 'Sem valor';
							break;
						case('date'):
							if($value =='00/00/0000')
								$content = 'Sem data';
							break;
						case('bool'):
							if($value)
								$bool = array('green','&#10003;');
							else
								$bool = array('red','&#10005;');
							$content = "<span style='color:$bool[0]; font-size:14px;'>$bool[1]</span>";
							break;
					}
				}
				echo $content;
				?></td>
			</tr>
			<?php endif;endforeach;?>
		</tbody></table>

		<div class="actionBar" align="right">
			<a href="http://localhost/ci/<?=$tabela?>/edit/<?=$v?>" class="buttonOrange">Editar</a>
			<a href="http://localhost/ci/<?=$tabela?>/delete/<?=$v?>" class="buttonRed">Apagar</a>
			<a href="http://localhost/ci/<?=$tabela?>" class="buttonBlue">Voltar</a>
		</div>
	</div>
</div>
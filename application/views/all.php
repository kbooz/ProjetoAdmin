
<?php 
$class = $this->session->flashdata('class');
$msg = $this->session->flashdata('msg');

$hide = array();
$count = -1;

foreach ($columns as $column=>$bool){
	$count++;
	if(!$bool)
		array_push($hide, $count);
}

if($msg):?>

<div class="<?="alert alert-$class";?>"><?=$msg?></div>

<?php endif;?>

<table id="tabelaData" class="table table-bordered">
	<thead>
		<tr>
			<!-- <th>#</th> -->
			<?php foreach ($columns as $column=>$bool):?>
			<th><?php if(isset($rename[$column]))
			echo $rename[$column];
			else
				echo humanize($column);?></th>
		<?php endforeach; ?>
		<th>Ações</th>
	</tr>
</thead>


<?php foreach ($lista as $linha):?>
	<tr>
		<!-- <td><?=$linha['id'] ?></td> -->
		<?php foreach ($columns as $column=>$bool):
		$content = $linha[$column];
		
		//Caso seja necessário 'view'
		$id=$linha['id'];
		$pre = "<a href='$url/$tabela/view/$id'>";
		$pos = "</a>";
		if(isset($set[$column]))
		{
			if($set[$column]=='bool')
			{
				if($content)
					$bool = array('green','&#10003;');
				else
					$bool = array('red','&#10005;');
				$content = "<span style='color:$bool[0]; font-size:14px;'>$bool[1]</span>";
			}
			if($set[$column]=='money')
			{
				$content = "R$ $content,00";
			}
		}
		if($actions['view'])
			$content = $pre.$content.$pos;
			?>
			<td><?=$content?></a></td>
		<?php endforeach; ?>
		<td class="actions">
			<?php if($actions['view']): ?>
			<a href="<?=$url?>/<?=$tabela?>/view/<?=$linha['id'] ?>" class="buttonBlue">Ver</a>
			<?php endif;
			if($actions['delete']):
				?>
			<a href="<?=$url?>/<?=$tabela?>/delete/<?=$linha['id'] ?>" class="buttonRed">Apagar</a>
			<?php endif;
			if($actions['edit']):
				?>
			<a href="<?=$url?>/<?=$tabela?>/edit/<?=$linha['id'] ?>" class="buttonOrange">Editar</a></td>
		<?php endif;?>
	</tr>
<?php endforeach ?>
</table>

<div class="actionBar" align="right">
	<a href="<?=$url?>/<?=$tabela?>/add" class="buttonGreen">Adicionar <?php if(isset($altertable)) echo humanize($altertable); else echo humanize($tabela);?></a> <?php if(isset($external)):
	foreach ($external as $link):?>
	<a href="<?=$link['href']?>" class="<?=$link['class']?>"><?=$link['text']?></a>
<?php endforeach;endif; ?>
</div>

<script>
var hide = new Array();
<?php foreach ($hide as $h) {
	echo "hide.push($h);\n";
} ?>
</script>
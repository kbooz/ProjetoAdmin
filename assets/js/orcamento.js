//Valores gerais
var dataentrada = jQuery('#orcamento_dataentrada').html();
var datasaida =  jQuery('#orcamento_datasaida').html();

//Orcamento
jQuery('#dataentrada').datepicker();
jQuery('#datasaida').datepicker();
jQuery('#cliente').select2();


//Equipamento
jQuery("#equipamento").select2();			
jQuery("#equipamento").change(function(e){
	var table = 'equipamento';
	var query = jQuery("#"+table);
	
	jQuery.ajax({
		url: localurl+"/orcamento/"+table+"s/"+query.val(),
		dataType: "json", 
		success: function(row){
			var linha = "#"+table+"_row"+row.id;
			
			//Adiciona a table
			var a = "<tr id='"+table+"_row"+row.id+"'>\
			<td><a onclick='deleteRow("+row.id+",\""+row.nome+"\",\""+table+"\")'>X</a></td>\
			<td>"+row.nome+"</td>\
			<td><div class=\"input-prepend input-append\"><span class=\"add-on\">R$</span><input name=\"number\" min=\"0\" class=\"number input-small\"  id=\""+table+"_row"+row.id+"_diaria\" placeholder=\""+row.aluguel+"\" value=\""+row.aluguel+"\"></input><span class=\"add-on\">,00</span></div></td>\
			<td><input class=\"input-small\" id=\""+table+"_row"+row.id+"_entrada\" placeholder=\""+dataentrada+"\" value=\""+dataentrada+"\" readonly></input></td>\
			<td><input class=\"input-small\" id=\""+table+"_row"+row.id+"_saida\" placeholder=\""+datasaida+"\" value=\""+datasaida+"\" readonly></input></td>\
			<td>R$ <span class=\"final\" id=\""+table+"_row"+row.id+"_final\">0</span>,00</td>\
			</tr>";
			jQuery("."+table+" #add").before(a);
			
			
			//Adiciona o date
			updateDate(linha);
			
			//Detecta se o input numeral tem apenas números!
			jQuery(linha+' .number').keyup(function (e){
				valor = jQuery(this).val();
				
				if(valor != valor.replace(/[^0-9]/g,''))
				{
					valor = valor.replace(/[^0-9]/g,'');
					jQuery(this).val(valor);
				}

			});
			
			//Altera o texto do dropdown
			var newtext = query.attr('data-placeholder');
			//select2-choice select2-default
			jQuery('#select2-chosen-1').text(newtext);
			jQuery('#select2-chosen-1').parent().addClass('select2-default')
			query.val('');
			
			
			//Remove do select
			jQuery("#"+table+" option[value='"+row.id+"']").remove();
			
			//Atualiza total da linha
			updateLinha(table, linha, 'diaria');
			updateLinha(table, linha, 'entrada');
			updateLinha(table, linha, 'saida');
			
			//Atualiza o total da table
			updateTable(table);
		}
	});
});
jQuery('.equipamento tbody').ready(function(){ updateTable('equipamento');});
jQuery('.equipamento tbody').change(function(){ updateTable('equipamento');});
jQuery(document).ready(function(){
	updateSelect('equipamento');});


//Funcionarios
jQuery("#funcionario").select2();			
jQuery("#funcionario").change(function(e){
	var table = 'funcionario';
	var query = jQuery("#"+table);
	jQuery.ajax({
		url: localurl+"/orcamento/"+table+"s/"+query.val(),
		dataType: "json", 
		success: function(row){
			var linha = "#"+table+"_row"+row.id;
			
			//Adiciona a table
			var a = "<tr id='"+table+"_row"+row.id+"'>\
			<td><a onclick='deleteRow("+row.id+",\""+row.nome+"\",\""+table+"\")'>X</a></td>\
			<td>"+row.nome+"</td>\
			<td><div class=\"input-prepend input-append\"><span class=\"add-on\">R$</span><input name=\"number\" min=\"0\" class=\"number input-small\"  id=\""+table+"_row"+row.id+"_diaria\" placeholder=\""+row.valorpadrao+"\" value=\""+row.valorpadrao+"\"></input><span class=\"add-on\">,00</span></div></td>\
			<td><input class=\"input-small\" id=\""+table+"_row"+row.id+"_entrada\" placeholder=\""+dataentrada+"\" value=\""+dataentrada+"\" readonly></input></td>\
			<td><input class=\"input-small\" id=\""+table+"_row"+row.id+"_saida\" placeholder=\""+datasaida+"\" value=\""+datasaida+"\" readonly></input></td>\
			<td>R$ <span class=\"final\" id=\""+table+"_row"+row.id+"_final\">0</span>,00</td>\
			</tr>";
			jQuery("."+table+" #add").before(a);
			
			
			//Adiciona o date
			updateDate(linha);
			
			//Detecta se o input numeral tem apenas números!
			jQuery(linha+' .number').keyup(function (e){
				valor = jQuery(this).val();
				
				if(valor != valor.replace(/[^0-9]/g,''))
				{
					valor = valor.replace(/[^0-9]/g,'');
					jQuery(this).val(valor);
				}

			});
			
			//Altera o texto do dropdown
			var newtext = query.attr('data-placeholder');
			//select2-choice select2-default
			jQuery('#select2-chosen-2').text(newtext);
			jQuery('#select2-chosen-2').parent().addClass('select2-default')
			query.val('');
			
			
			//Remove do select
			jQuery("#"+table+" option[value='"+row.id+"']").remove();
			
			//Atualiza total da linha
			updateLinha(table, linha, 'diaria');
			updateLinha(table, linha, 'entrada');
			updateLinha(table, linha, 'saida');
			
			//Atualiza o total da table
			updateTable(table);
		}
	});
});
jQuery('.funcionario tbody').ready(function(){ updateTable('funcionario');});
jQuery('.funcionario tbody').change(function(){ updateTable('funcionario');});
jQuery(document).ready(function(){
	updateSelect('funcionario');});

//Despesa
var ultDespesa = receiveDespesa();
jQuery('.despesa #addbutton').click(function(e){
	e.preventDefault();
	ultDespesa++;
	var table = 'despesa';
	var query = jQuery("#"+table);
	var linha = "#"+table+"_row"+ultDespesa;
	var a = "<tr id='"+table+"_row"+ultDespesa+"'>\
	<td><a onclick='deleteRow("+ultDespesa+",\"\",\""+table+"\")'>X</a></td>\
	<td><input type='text' placeholder='Nome da despesa' id=\""+table+"_row"+ultDespesa+"_nome\" /></td>\
	<td><div class=\"input-prepend input-append\"><span class=\"add-on\">R$</span><input name=\"number\" min=\"0\" class=\"number input-small\"  id=\""+table+"_row"+ultDespesa+"_valor\" placeholder=\"Valor da Despesa\" value=\"\"></input><span class=\"add-on\">,00</span></div></td>\
	<td><input class=\"input-small\" id=\""+table+"_row"+ultDespesa+"_entrada\" placeholder=\""+dataentrada+"\" value=\""+dataentrada+"\" readonly></input></td>\
	<td><input class=\"input-small\" id=\""+table+"_row"+ultDespesa+"_saida\" placeholder=\""+datasaida+"\" value=\""+datasaida+"\" readonly></input></td>\
	<td>R$ <span class=\"final\" id=\""+table+"_row"+ultDespesa+"_final\">0</span>,00</td>\
	</tr>";
	jQuery("."+table+" #add").before(a);
	
	//Detecta se o input numeral tem apenas números!
	jQuery(linha+' .number').keyup(function (e){
		valor = jQuery(this).val();
		
		if(valor != valor.replace(/[^0-9]/g,''))
		{
			valor = valor.replace(/[^0-9]/g,'');
			jQuery(this).val(valor);
		}

	});
	
	//Atualiza total da linha
	updateLinha(table, linha, 'valor');
	updateLinha(table, linha, 'entrada');
	updateLinha(table, linha, 'saida');
	
	//Atualiza o total da table
	updateTable(table);
	
	//Adiciona o date
	updateDate(linha);
	
});
jQuery('.despesa tbody').ready(function(){ updateTable('despesa');});
jQuery('.despesa tbody').change(function(){ updateTable('despesa');});
jQuery(document).ready(function(){
	updateSelect('despesa');});

//Valor do Orçamento
jQuery('#orcamento_valor').change(function(){ updateLucro();});
jQuery('#orcamento_valor').keyup(function(){
	valor = jQuery(this).val();
	if(valor != valor.replace(/[^0-9]/g,''))
	{
		valor = valor.replace(/[^0-9]/g,'');
		jQuery(this).val(valor);
	}
	updateLucro();
});

//Envio de Formulário
jQuery('#submit').click(function(e){
	if(pg==2)
		sessionSave(e,3);
	if(pg==3)
		sendSave(e);
});

jQuery('#back').click(function(e){
	if(pg==2)
		sessionSave(e,1);
	if(pg==3)
		pushObs(e);
});

//Impede o envio pelo Enter
jQuery('form').bind("keyup keypress", function(e) {
	var code = e.keyCode || e.which; 
	if (code  == 13) {               
		e.preventDefault();
		return false;
	}
});




//Funcao envia pro servidor
function sessionSave (e,page)
{
	e.preventDefault();
	equipamentos = tableArray('equipamento');
	funcionarios = tableArray('funcionario');
	despesas = tableArray('despesa');
	orcamento = {
		'nome' : jQuery('#orcamento_nome').html(),
		'cliente' : jQuery('#orcamento_cliente').val(),
		'dataentrada' : jQuery('#orcamento_dataentrada').html(),
		'datasaida' : jQuery('#orcamento_datasaida').html(),
		'despesa' : jQuery('#orcamento_despesa').html(),
		'lucro' : jQuery('#orcamento_lucro').html(),
		'valor' : jQuery('#orcamento_valor').val()
	};
	
	
	equip = JSON.stringify(equipamentos);
	func = JSON.stringify(funcionarios);
	desp = JSON.stringify(despesas);
	orc = JSON.stringify(orcamento);
	
	var pass = false;

	jQuery.post(
		localurl+'/orcamento/setarrays',
		{
			'equipamentos':equip,
			'funcionarios':func,
			'despesas':desp,
			'orcamento':orc
		},
		function(data, status){
			if(status=='success')
				window.location.href = localurl+'/orcamento/add/'+page;
		});
}

function sendSave (e)
{
	e.preventDefault();
	obs = jQuery('#orcamento_obs').val();
	jQuery.post(
		localurl+'/orcamento/save',
		{'obs':obs},
		function(data,status){
			if(status=='success')
				window.location.href = localurl+'/orcamento/';
		}
		)
}

function pushObs (e)
{
	e.preventDefault();
	obs = jQuery('#orcamento_obs').val();
	jQuery.post(
		localurl+'/orcamento/pushobs',
		{'obs':obs},
		function(data,status){
			if(status=='success')
				window.location.href = localurl+'/orcamento/add/2';
		}
		)
}


function updateGastos()
{
	gastos = 0;
	
	gastos += +jQuery('.equipamento #total').text()
	gastos += +jQuery('.funcionario #total').text()
	gastos += +jQuery('.despesa #total').text()
	
	jQuery('#orcamento_despesa').text(gastos);
	updateLucro();
}

function updateLucro()
{
	if(pg==2)
		valor = +jQuery('#orcamento_valor').val();
	else
		valor = +jQuery('#orcamento_valor').text();
	despesa = +jQuery('#orcamento_despesa').text();
	lucro = valor - despesa;
	jQuery('#orcamento_lucro').text(lucro);
	if(lucro>0)
	{
		jQuery('#orcamento_lucro').attr('class',"orcamento_lucro_valor green");
	}
	else
	{
		jQuery('#orcamento_lucro').attr('class',"orcamento_lucro_valor red");
	}
}

//table para Array
function tableArray(table)
{
	var Ar = Array();
	jQuery('.'+table+' tr[id^="'+table+'_row"]').each(function(){
		var tAr = new Array();
		var linha = '#'+jQuery(this).attr('id');
		var id = linha.split('#'+table+'_row');
		id = id[1];
		var fin = jQuery(linha+'_final').text();
		var fin = jQuery(linha+'_final').text();
		var dataentrada = jQuery(linha+'_entrada').val();
		var datasaida = jQuery(linha+'_saida').val();
		if(table != 'despesa')
		{	
			var diaria = jQuery(linha+'_diaria').val();
			tAr = {
				'id' : id,
				'valordiaria' : diaria,
				'dataentrada' : dataentrada,
				'datasaida' : datasaida,
				'valorfim' : fin
			};
		}
		else
		{
			var valor = jQuery(linha+'_valor').val();
			var nome = jQuery(linha+'_nome').val();
			tAr = {
				'id' : id,
				'nome' : nome,
				'valor' : valor,
				'dataentrada' : dataentrada,
				'datasaida' : datasaida,
				'valorfim' : fin
			};
		}
		
		Ar.push(tAr);
	});
	return Ar;
}

function receiveDespesa()
{
	aux = 0;
	jQuery('.despesa tr[id^="despesa_row"]').each(function(){
		aux++;
	});
	return aux;
}

//Atualiza o total da table
function updateTable(table)
{
	var content=0;
	if(jQuery('.'+table+' .final').length){
		jQuery('.'+table+' .final').each(
			function()
			{
				content += +jQuery(this).html();
			}
			);
	}
	jQuery('.'+table+' #total').text(content);
	updateGastos();
}

function checkLastPosition (number,table)
{
	for (var i = (number-1); i > 0 ; i--) {
		if(jQuery("#"+table+" option[value='"+i+"']").length)
			return i;
	};
	return 0;
}

function addOption (id,nome,table)
{
	var number = checkLastPosition(id,table);
	if(number!=0)
		jQuery("#"+table+" option[value='"+number+"']").after(new Option(nome,id));
	else
		jQuery("#"+table+" option:first-child").after(new Option(nome,id));
}

//Deletar Linha
function deleteRow (id,nome,table)
{
	if(("#"+table+"_row"+id+" .date").length)
		jQuery("#"+table+"_row"+id+" .date").datepicker('destroy');
	if(table!='despesa')
		addOption(id,nome,table);
	else
	{
		if(jQuery('#'+table+'_row'+id).next().attr('id') == jQuery('.'+table+' #add').attr('id'))
			ultDespesa--;
	}
	jQuery('#'+table+'_row'+id).remove();
	updateTable(table);
}

//Calcula os dias entre duas datas
function calculaData (data1l,data2l){
	dia = 1000 * 60 * 60  * 24

	if(pg==2)
	{
		data1 = jQuery(data1l).val();
		data2 = jQuery(data2l).val();
	}
	else
	{
		data1 = jQuery(data1l).text();
		data2 = jQuery(data2l).text();
	}

	var nova1 = data1.toString().split('/');
	Nova1 = nova1[1]+"/"+nova1[0]+"/"+nova1[2];

	var nova2 = data2.toString().split('/');
	Nova2 = nova2[1]+"/"+nova2[0]+"/"+nova2[2];

	d1 = new Date(Nova1)
	d2 = new Date(Nova2)

	dias = Math.round((d2.getTime() - d1.getTime()) / dia)

	return dias;
}

//Atualiza a linha da table
function updateLinha (table, linha, id)
{
	function dothis (table,linha) {
		updateInterna(table, linha);
		updateTable(table);
	};
	
	function updateInterna(table, linha)
	{
		//Linha p/exemplo = #equipamento_row1
		linha2 = linha+"_";
		dias = +(calculaData(linha+' '+linha2+'entrada',linha+' '+linha2+'saida'));
		if(pg==2)
		{
			if(table != 'despesa')
				valor = +jQuery(linha+" "+linha2+"diaria").val();
			else
				valor = +jQuery(linha+" "+linha2+"valor").val();
		}
		else
		{
			if(table != 'despesa')
				valor = +jQuery(linha+" "+linha2+"diaria").text();
			else
				valor = +jQuery(linha+" "+linha2+"valor").text();
		}
		valor = valor + (valor * dias);
		jQuery(linha+" td "+linha2+"final").text(valor);
	}
	linha2 = linha+"_";
	
	jQuery(linha+" "+linha2+id).ready(function () {
		dothis(table, linha);
	}
	);
	jQuery(linha+" "+linha2+id).keyup(function () {
		dothis(table, linha);
	}
	);
	jQuery(linha+" "+linha2+id).change(function () {
		dothis(table, linha);
	}
	);
}

function updateDate (linha) {
	jQuery(linha+" "+linha+"_entrada").datepicker({
		minDate: dataentrada,
		maxDate: datasaida
	});
	jQuery(linha+" "+linha+"_saida").datepicker({
		minDate: dataentrada,
		maxDate: datasaida
	});
	
	jQuery(linha+" "+linha+"_entrada").change(function(){
		var data1 = jQuery(this);
		var data2 = jQuery(linha+" "+linha+"_saida");
		data2.datepicker('destroy');
		data2.datepicker({
			minDate: data1.val(),
			maxDate: datasaida
		});
		if(compare_date(data1.val(),data2.val()))
		{
			data2.val(data1.val());
		};
		
	});
}

function string_to_date(dataEntrada)
{
	var date = dataEntrada.split('/');
	var aux = new Object();
	aux.day = date[0];
	aux.month = date[1];
	aux.year = date[2];
	var dataSaida = new Date (aux.year,aux.month,aux.day);
	return dataSaida;
}

function compare_date(data1,data2)
{
	ndata1 = string_to_date(data1);
	ndata2 = string_to_date(data2);
	
	
	if(ndata1>ndata2)
		return true;
	return false;
}

function updateSelect(table)
{
	jQuery('.'+table+' tr[id^="'+table+'_row"]').each(function(){
		var linha = '#'+jQuery(this).attr('id');
		var valor = linha.split('#'+table+'_row');
		valor = valor[1];
		
		updateDate(linha);
		
		if(table != 'despesa')
			updateLinha(table, linha, 'diaria');
		else
			updateLinha(table, linha, 'valor');
		updateLinha(table, linha, 'entrada');
		updateLinha(table, linha, 'saida');
		
		// Remove do Select
		if(jQuery("#"+table+" option[value='"+valor+"']").length>0)
			jQuery("#"+table+" option[value='"+valor+"']").remove();
		
	});
}


$('#tabelaData').dataTable({
	"sPaginationType": "full_numbers",
	"oLanguage": {
		"sProcessing":   "Processando...",
		"sLengthMenu":   "Mostrar _MENU_ registros",
		"sZeroRecords":  "Não foram encontrados resultados",
		"sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
		"sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
		"sInfoFiltered": "(filtrado de _MAX_ registros no total)",
		"sInfoPostFix":  "",
		"sSearch":       "Buscar:",
		"sUrl":          "",
		"oPaginate": {
			"sFirst":    "Primeiro",
			"sPrevious": "Anterior",
			"sNext":     "Seguinte",
			"sLast":     "Último"
		}
	},
	"bAutoWidth": false,
	"aoColumnDefs": [
		{"aTargets": [ '_all' ], "bSortable": true },       
		{"aTargets": [ -1 ], "bSortable": false }
	]
});

function fnShowHide( iCol )
{
    /* Get the DataTables object again - this is not a recreation, just a get of the object */
    var oTable = jQuery('#tabelaData').dataTable();
     
    var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
    oTable.fnSetColumnVis( iCol, bVis ? false : true );
}

if(hide!=null)
{
	for (var index = 0; index < hide.length; ++index)
	{
    	fnShowHide(hide[index]);
	}
}
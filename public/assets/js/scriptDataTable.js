$(window).load(function(){
	var table = $('table[name=dataTables-example]').DataTable({
		"paging":   false,
		"order": [[ 0, "asc" ]],
		"language": {
			"decimal": ",",
			"thousands": ".",
			"sEmptyTable": "Nenhum registro encontrado",
			"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
			"sInfoFiltered": "(Filtrados de _MAX_ registros)",
			"sInfoPostFix": "",
			"sInfoThousands": ".",
			"sLengthMenu": "_MENU_ resultados por página",
			"sLoadingRecords": "Carregando...",
			"sProcessing": "Processando...",
			"sZeroRecords": "Nenhum registro encontrado",
			"sSearch": "Pesquisar",
			"oPaginate": {
				"sNext": "Próximo",
				"sPrevious": "Anterior",
				"sFirst": "Primeiro",
				"sLast": "Último"
			}/*,
            "select": {
                "rows": {
                    "_": ", %d linhas selecionadas.",
                    "0": ", clique na linha para seleciona-la.",
                    "1": ", somente 1 linha selecionada."
                }
            }*/
        },
        dom: 'Bfrtip'
	});
});
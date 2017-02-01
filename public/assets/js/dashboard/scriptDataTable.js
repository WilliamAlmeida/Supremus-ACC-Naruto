$(document).ready(function(){
	$.fn.dataTable.ext.buttons.button = {
		className: 'buttons-alert',

		action: function ( e, dt, node, config ) {
			table.colReorder.reset();
		}
	};

	var table = $('table[name=dataTables-example]').DataTable({
		"paging":   false,
		"order": [[ 4, "desc" ]],
		"stateSave": true,
		"stateDuration": -1,
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
			},
			"oAria": {
				"sSortAscending": ": Ordenar colunas de forma ascendente",
				"sSortDescending": ": Ordenar colunas de forma descendente"
			}/*,
            "select": {
                "rows": {
                    "_": ", %d linhas selecionadas.",
                    "0": ", clique na linha para seleciona-la.",
                    "1": ", somente 1 linha selecionada."
                }
            }*/
        },
        dom: 'Bfrtip',
        buttons: [
        {
        	extend: 'colvis',
        	text: 'Filtro de Colunas',
        	key: {
        		key: 'f',
        		altkey: true
        	},
        },
        {
        	extend: 'button',
        	text: 'Reseta Colunas'
        }
        /*{
        	extend: 'copy',
        	text: 'Copiar',
        	exportOptions: {
        		columns: ':visible'
        	}
        },
        {
        	extend: 'print',
        	text: 'Imprimir',
        	message: 'This print was produced using the Print button for DataTables',
        	exportOptions: {
        		columns: [ ':visible' ]
        	},
        	key: {
        		key: 'p',
        		altkey: true
        	},
        	customize: function ( win ) {
        		$(win.document.body)
        		.css( 'font-size', '10pt' )
        		.prepend(
        			'<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
        			);

        		$(win.document.body).find( 'table' )
        		.addClass( 'table-condensed' )
        		.css( 'font-size', 'inherit' );
        	}
        },
        {
        	extend: 'csvFlash',
        	text: 'CSV',
        	exportOptions: {
        		columns: ':visible'
        	}
        },
        {
        	extend: 'excelFlash',
        	text: 'Excel',
        	exportOptions: {
        		columns: ':visible'
        	}
        },
        {
        	extend: 'pdfFlash',
        	text: 'PDF',
        	message: 'This print was produced using the Print button for DataTables',
        	exportOptions: {
        		columns: ':visible'
        	},
        	orientation: 'landscape',
        	pageSize: 'LEGAL'
        }*/
        ],
        select: false,
        colReorder: {
        	realtime: false
        }
		/*,responsive: {
			details: {
				type: 'column'
			}
		},
		columnDefs: [ {
			className: 'control',
			orderable: false,
			targets:   0
		} ]*/
	});
});
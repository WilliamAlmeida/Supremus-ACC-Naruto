$(document).ready(function(){
	var rate = $('p[name=stars]').raty({
		score: function(){
			return $(this).attr('data-score');
		},
		cancel: false,
		cancelHint          : 'Remover votação!',
		noRatedMsg          : "Faça o login em sua conta para poder votar!",
		hints               : ['Ruim', 'Regular', 'Bom', 'Muito Bom', 'Excelente'],
		path                : (window.location.origin+'/assets/plugins/rate/images'),
		cancelOff           : 'cancel-custom-off.png',
		cancelOn            : 'cancel-custom-on.png',
		click: function(score, evt) {
			$.ajax({
				type: "GET",
				url: dados.url+"/"+(score ? score : 0)+"/"+dados.user+"/"+$(this).attr('data-objetoId')+"/"+$(this).attr('data-tipo'),
				headers: { "csrftoken" : dados.csrftoken }
			})
			.done(function(data){
				rate.raty('score', data.score);
				var html = data.score; if(parseInt(data.score)>0) { html += " stars"; } else { html += " star"; } $('p[id=star]').html(html);

				html = data.total; if(parseInt(data.total)>1) { html += " reviews"; } else { html += " review"; } $('p[id=reviews]').html(html);
			});
		}
	});
	rate.raty('set', {
		cancel: Boolean(parseInt(rate.attr('data-cancel'))),
		readOnly: Boolean(parseInt(rate.attr('data-readOnly')))
	});
});
var modal = 'div[id=myModal]';
var campo = $('input[name=link]');

$('form').submit(function(e){
	if($('input:checkbox[name="noticias"]').prop('checked') || $('input:checkbox[name="produtos"]').prop('checked')){
		$(campo).val('');
	}
});

$('input:checkbox[name=noticias], input:checkbox[name=produtos]').on('click', function(){
	if($('input:checkbox[name=noticias]').prop('checked')){
		$('form input:checkbox[name=produtos]').prop('disabled', true);
		$('form input:checkbox[name=noticias]').prop('disabled', false);

	}else if($('input:checkbox[name=produtos]').prop('checked')){
		$('form input:checkbox[name=produtos]').prop('disabled', false);
		$('form input:checkbox[name=noticias]').prop('disabled', true);
	}else{
		$('form input:checkbox[name=noticias]').prop('disabled', false);
		$('form input:checkbox[name=produtos]').prop('disabled', false);
	}
});

$('select[name="notice_categories"], select[name="product_categories"], select[name="pages"]').prop("disabled", true);

$(modal+' label').on('click', function(){
	$(modal+' select').prop("disabled", true);
	$(modal+' input').prop("disabled", true);
	$(modal+' input[name='+$(this).attr('for')+']').prop("disabled", false);
	$(modal+' select[name='+$(this).attr('for')+']').prop("disabled", false);
});

$('input[name=link]').on('click', function(){
	if(!$('input:checkbox[name=noticias]').prop('checked') && !$('input:checkbox[name=produtos]').prop('checked')){
		$(modal+' select').prop("disabled", true);
		$(modal+' input').prop("disabled", true);
		$(modal).modal('show')
	}else{
		var html = "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Aviso!</strong> Para selecionar um link precisa desmarca a opção Notícias/Produtos.</div>";
		$('span[id=alert-form]').append(html);
		$('form div[role=alert]').fadeOut(5000,function(){
			$('form div[role=alert]').remove();
		});
	}
});

$(modal+' button[id=btn_select]').on('click', function(){

	if(!$(modal+' select[name="notice_categories"]').prop('disabled')) {
		$(modal).modal('hide');

		$(campo).val(noticia+$(modal+' select[name="notice_categories"]').val());

	}else if(!$(modal+' select[name="product_categories"]').prop('disabled')) {
		$(modal).modal('hide');

		$(campo).val(produto+$(modal+' select[name="product_categories"]').val());

	}else if(!$(modal+' select[name="pages"]').prop('disabled')) {
		$(modal).modal('hide');

		$(campo).val(pagina+$(modal+' select[name="pages"]').val());

	}else if(!$(modal+' input[name="url"]').prop('disabled')) {
		if($(modal+' input[name="url"]').val()!=""){
			$(modal).modal('hide');

			$(campo).val($(modal+' input[name="url"]').val());
		}else{
			var html = "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Aviso!</strong> Desculpe mas você precisa digita algo.</div>";
			$('span[id=alert-url]').append(html);
			$(modal+' div[role=alert]').fadeOut(5000,function(){
				$(modal+' div[role=alert]').remove();
			});
		}
	}else{
		var html = "<div class='alert alert-warning alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Aviso!</strong> Precisa selecionar o tipo do link e qual deles sera usado neste item do menu.</div>";
		$('span[id=alert-url]').append(html);
		$(modal+' div[role=alert]').fadeOut(5000,function(){
			$(modal+' div[role=alert]').remove();
		});
	}
});
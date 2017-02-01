<!DOCTYPE html>
<html>
<head>
	<title>Notificação</title>
</head>
<body>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			@if(isset($siteBanner))
			{{ HTML::image(str_replace('-original', '-banner', $siteBanner), $siteName, array('title' => $siteName, 'class' => 'img-responsive')) }}
			@endif
			<h4>{{ $subject or 'Não informado.' }}</h4>
			<p>{{ $mensagem or 'Sem mensagem.' }}</p>
			<br/>
			<h5>Para se aventura no mundo de {{ $siteName }}, acesse <strong><a href="{{ $siteUrl }}" alt="Acesse nosso website." title="Acesse nosso website." target="_blank">{{ $siteUrl or 'Não informado.' }}</a></strong>.</h5>
		</div>
	</div>
</body>
</html>
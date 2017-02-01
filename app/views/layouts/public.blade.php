<!DOCTYPE html>
<html>
<head>
	<title>@yield('title') @yield('sub_title') - {{ $configuracoes->title or 'App Name' }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="keywords" content="@if(isset($categoria_noticia)){{$categoria_noticia->meta_keywords}}@elseif(isset($noticia)){{$noticia->meta_keywords}}@elseif($configuracoes){{$configuracoes->keywords}}@endif">
	<meta name="description" content="@if(isset($categoria_noticia)){{$categoria_noticia->meta_description}}@elseif(isset($noticia)){{$noticia->meta_description}}@elseif($configuracoes){{$configuracoes->description}}@endif">
	<?php $url = 'http://'.Request::getHost().'/' ?>
	@if(isset($favicon))
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset(str_replace('-original', '-thumbnail', $favicon->path)) }}">
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset(str_replace('-original', '-thumbnail', $favicon->path)) }}">
	@endif
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="theme-color" content="#ffffff">
	<meta name="google-site-verification" content="XbO6sWT5Gg7EFiTZTz8pYjbZDcI1o-WQMl8hrrp19NM" />

	<meta name="author" content="{{{ $configuracoes->title }}}" />
	<base href="{{ $url }}">
	@if($banner!=null)
	<meta name="image" content="{{{ $url.$banner->path }}}">
	@endif

	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:description" content="{{{ $configuracoes->description }}}">
	<meta name="twitter:title" content="{{{ $configuracoes->title }}}">
	<meta name="twitter:site" content="@pokemonbr">
	<meta name="twitter:domain" content="{{{ $configuracoes->title }}}">
	<meta name="twitter:creator" content="@pokemonbr">

	<meta property="fb:app_id"          content="764807800276703" /> 
	<meta property="og:locale"          content="pt_BR" />
	<meta property="og:url"             content="{{ $url }}" />
	<meta property="og:title"           content="{{{ $configuracoes->title }}}" />
	<meta property="og:site_name"       content="{{{ $configuracoes->title }}}" />
	<meta property="og:description"     content="{{{ $configuracoes->description }}}" />
	@if($banner!=null)
	<meta property="og:image"           content="{{{ $url.$banner->path }}}" />
	@endif
	<!-- <meta property="og:image:type"      content="image/jpeg" />
	<meta property="og:image:width"     content="600" />
	<meta property="og:image:height"    content="400" /> -->
	<meta property="og:type"            content="website" />
	<!-- <meta property="article:author"     content="{{{--$configuracoes->title--}}}"> -->
	<!-- <meta property="article:section" content="Seção do artigo">
	<meta property="article:tag" content="Tags do artigo">
	<meta property="article:published_time" content="date_time"> -->

	<link href="{{ $url }}"    rel="canonical" />
	@if($banner!=null)
	<link href="{{{ $url.$banner->path }}}" rel="image_src" />
	@endif

	<style type="text/css"></style>
	{{ HTML::style('assets/plugins/normalize/normalize.min.css', array('async' => 'async')) }}
	{{ HTML::style('assets/plugins/bootstrap/bootstrap.min.css', array('async' => 'async')) }}
	{{ HTML::style('assets/plugins/social-buttons/social-buttons.min.css', array('async' => 'async')) }}
	{{ HTML::style('assets/plugins/animate/animate.min.css', array('async' => 'async')) }}
	{{ HTML::style('assets/css/main-style.css', array('async' => 'async')) }}
	{{ HTML::style('assets/css/style.css', array('async' => 'async')) }}

	@yield('styles')
</head>
@if($background)
<body style="background-image: url({{ asset($background) }})">
	@else<body>@endif
	<!-- Header Content -->
	<header>
		@if($banner!=null)
		{{ HTML::image($banner->path, $configuracoes->title, array('class' => 'img-responsive center-block')) }}
		@else
		<h1 class="foNW foNS m-z p-a m-b text-center">{{ $configuracoes->title }}</h1>
		@endif
	</header>
	<!-- /.Header Content -->

	<!-- Nav Content -->
	@include('layouts.public.navbar-top')
	<!-- /.Nav Content -->

	<!-- Container Content -->
	<section id="body">
		<div class="container">
			@include('layouts.public.side-bar')
			@include('layouts.public.content')
		</div>
	</section>
	<!-- /.Container Content -->

	<!-- Footer Content -->
	<footer class="footer">
		<div class="container">
			@include('layouts.public.footer')
		</div>
	</footer>
	<!-- /.Footer Content -->

	{{ HTML::script('assets/js/jquery.min.js') }}

	{{ HTML::script('assets/plugins/bootstrap/bootstrap.min.js') }}

	{{ HTML::script('assets/plugins/metisMenu/jquery.metisMenu.js', array('async' => 'async')) }}

	{{ HTML::script('assets/js/scriptNotificacao.js') }}

	@yield('scripts')

	{{ HTML::script('assets/js/shop/siminta.js', array('async' => 'async')) }}

	@yield('script-execute')
	<script type="text/javascript" async="async">
		/*execute/clear BS loaders for docs*/
		$(function(){while(window.BS&&window.BS.loader&&window.BS.loader.length){(window.BS.loader.pop())()}})

		$('button[id=btn_login], button[id=btn_register]').on('click', function(){
			/*window.location.assign(window.location.origin+'/'+$(this).attr('rel'));*/
			var btn = $(this);
			var modal = $('div[id=login_registro]');
			modal.modal('show');
			$('ul[id="tabs_formulario"] a[href="#'+btn.attr('rel')+'"]').tab('show');
			modal.on('shown.bs.modal', function () {
			});
		});

		$('button[id=btn_senha], button[id=btn_email], button[id=btn_nickname]').on('click', function(){
			/*window.location.assign(window.location.origin+'/'+$(this).attr('rel'));*/
			var btn = $(this);
			var modal = $('div[id=senha_email]');
			modal.modal('show');
			$('div[id=senha_email] ul[id="tabs_formulario"] a[href="#'+btn.attr('rel')+'T"]').tab('show');
			modal.on('shown.bs.modal', function () {
			});
		});

		$('button[id=btn_criar_personagem], button[id=btn_desbugar_personagem]').on('click', function(){
			window.location.assign($(this).attr('rel'));
		});

		$(window).scroll(function () {
			var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
			var posicao = document.body.scrollTop;
			var nav = $("nav[id='navegacao-principal']");
			if(posicao > $('section#body').offset().top){
				if(!nav.hasClass('navbar-fixed-top')){
					nav.addClass('navbar-fixed-top animated bounceInDown').one(animationEnd, function(){
						$(this).removeClass('animationEnd bounceInDown');
					});
				}
			}else{
				if(nav.hasClass('navbar-fixed-top')){
					nav.removeClass('navbar-fixed-top');
				}
			}
		});

		var noticiacao = "{{ Session::get('notificacoes') }}";
		$(window).load(function(){
			$('[data-toggle="tooltip"]').tooltip();

			if(noticiacao!=""){
				showNotificacao("{{ $configuracoes->title or 'App Name' }}", noticiacao, "{{ @(isset($favicon)) ? asset($favicon->path) : '' }}");
			}
		});

	</script>
</body>
</html>
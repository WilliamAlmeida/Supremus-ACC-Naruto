@extends('layouts.public')

@section('title', Lang::get('menu.home'))
@section('sub_title', '')

@section('styles')

@stop

@section('content')
<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-t p-b titulo">
			<h1 class="foNW foNS m-z p-z h3 hidden-sm hidden-xs">{{ Lang::get('content.news') }}</h1>
			<h5 class="m-z p-z hidden-lg hidden-md"><strong>{{ Lang::get('content.news') }}</strong></h5>
			<img src="{{ asset('assets/img/shuriken.png') }}" class="img-responsive" style="position:absolute; top:10px; right:-10px" />
		</div>
		@if(!$noticias_featured->isEmpty())
		<div class="m-b p-t">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-z">
				<div id="carousel-noticias" class="carousel slide" data-ride="carousel">
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						@foreach($noticias_featured as $key => $noticia)
						<div class="item {{ ($key==0) ? 'active' : null }}">
							@if(!$noticia->midianoticia->isEmpty())
							@foreach($noticia->midianoticia as $imagem)
							@if($imagem->capa)
							<a href="{{{ action('NoticiasController@getNoticia', array('name' => Str::slug($noticia->title) )) }}}" alt="{{{ $noticia->title }}}" title="{{{ $noticia->title }}}">
								{{ HTML::image(str_replace('-original', '-banner', $imagem->path), $imagem->name, array('title' => $imagem->name, 'class' => 'center-block img-responsive')) }}
							</a>
							@endif
							@endforeach
							@else
							<img src="http://placehold.it/760x400/cccccc/ffffff">
							@endif

							<div class="carousel-caption">
								<h4>{{ link_to_action('NoticiasController@getNoticia', $noticia->title, $parameters = array('name' => Str::slug($noticia->title)), $attributes = array()) }}</h4>
								<h5><i class="fa fa-user fa-fw"></i> {{{ $noticia->user->nickname }}} <i class="fa fa-calendar fa-fw"></i> {{ Helpers::formataData($noticia->updated_at, 'data') }}.</h5>
								<p>{{ strip_tags(str_limit($noticia->description, 100)) }}</p>
							</div>
						</div><!-- End Item -->
						@endforeach
					</div><!-- End Carousel Inner -->

					<ul class="list-group col-sm-4 p-z">
						@foreach($noticias_featured as $key2 => $noticia2)
						<li data-target="#carousel-noticias" data-slide-to="{{ ($key2==0) ? ++$key2 : --$key2 }}" class="list-group-item {{ ($key2==0) ? 'active' : null }}">
							<strong>{{{ $noticia2->title }}}</strong>
						</li>
						@endforeach
					</ul>

					<!-- Controls -->
					<div class="carousel-controls">
						<a class="left carousel-control" href="#carousel-noticias" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
						</a>
						<a class="right carousel-control" href="#carousel-noticias" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right"></span>
						</a>
					</div>

				</div><!-- End Carousel -->
			</div>
		</div>
		@endif

		@if(!$noticias->isEmpty())
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h2 class="h3"><strong>{{ Lang::get('content.latest news') }}</strong></h2>
		</div>

		<div class="p-l p-r">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b">
				@foreach($noticias as $noticia_aux)
				@if( !in_array( $noticia_aux->id, $noticias_featured->lists('id', 'id') ) )
				{{ link_to_action('NoticiasController@getNoticia', str_limit($noticia_aux->title, 100), $parameters = array('name' => Str::slug($noticia_aux->title)), $attributes = array('title' => $noticia_aux->title, 'class' => 'h3 m-z link')) }}

				<h5><i class="fa fa-user fa-fw"></i> {{{ $noticia_aux->user->nickname }}} <i class="fa fa-calendar fa-fw"></i> {{ Helpers::formataData($noticia_aux->updated_at, 'data') }}.</h5>

				<span>
					<!-- Comentários - <span class="hidden"><span class="glyphicon glyphicon-comment hidden"></span>&nbsp;<a href="#comments hidden"><strong>3 comments</strong></a>&nbsp;&nbsp;</span> -->
					<!-- Categorias -->
					<span class="glyphicon glyphicon-tags"></span>&nbsp;
					@forelse($noticia_aux->categorianoticia as $categoria)
					{{ link_to_action('NoticiasController@getNoticiaCategoria', $categoria->name, $parameters = array('name' => $categoria->slug), $attributes = array('title' => 'Categoria '.$categoria->name, 'class' => 'badge')) }}
					@empty
					<a href="#" alt="Nenhuma categoria encontrada!" title="Nenhuma categoria encontrada!" class="badge">Nenhuma categoria encontrada!</a>
					@endforelse
				</span>

				@if(!$noticia_aux->midianoticia->isEmpty())
				@foreach($noticia_aux->midianoticia as $imagem)
				@if($imagem->capa)
				<a href="{{{ action('NoticiasController@getNoticia', array('name' => Str::slug($noticia_aux->title) )) }}}" alt="{{{ $noticia_aux->title }}}" title="{{{ $noticia_aux->title }}}">
					{{ HTML::image(str_replace('-original', '-thumbnail', $imagem->path), $imagem->name, array('title' => $imagem->name, 'class' => 'm-t m-b center-block img-responsive')) }}
				</a>
				@endif
				@endforeach
				@endif

				<p class="p-t">{{ strip_tags(str_limit($noticia_aux->description, 400)) }}</p>

				<div name="{{ $noticia_aux->id }}">
					<!-- <p class="pull-right">{{-- $noticia_aux->rate->count() --}} {{-- ($noticia_aux->rate->count()>1) ? 'reviews' : 'review' --}}</p> -->
					<p name="stars"
					data-tipo = "noticias"
					data-objetoId = "{{ $noticia_aux->id }}"
					data-readOnly="1"
					data-cancel="0"
					data-score="{{ ($noticia_aux->rate->count()) ? $noticia_aux->rate->sum('rate')/$noticia_aux->rate->count() : 0 }}"
					class="p-z"></p>
					<!-- <p>{{-- ($noticia_aux->rate->count()>0) ? $noticia_aux->rate->sum('rate')/$noticia_aux->rate->count().' stars' : '0 star' --}}</p> -->
				</div>

				<div class="center-block text-right">
					{{ link_to_action('NoticiasController@getNoticia', Lang::get('content.read more'), $parameters = array('name' => Str::slug($noticia_aux->title)), $attributes = array('title' => Lang::get('content.read more about').' '.$noticia_aux->title, 'class' => 'btn btn-primary btn-xs')) }}
				</div>

				<hr>
				@endif
				@endforeach
			</div>
		</div>
		@else
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b m-t">
			{{ Lang::get('content.no news found') }}
		</div>
		@endif
	</div>
</div>

<div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
</div>

<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	<div class="row m-b conteudo {{ (Auth::check()) ? null : 'hidden' }}">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b p-b p-t titulo">
			<h3 class="foNW foNS m-z p-z hidden-sm hidden-xs">{{ Lang::get('content.server') }}</h3>
			<h5 class="m-z p-z hidden-lg hidden-md"><strong>{{ Lang::get('content.server') }}</strong></h5>
			<img src="{{ asset('assets/img/shuriken.png') }}" class="img-responsive" style="position:absolute; top:10px; right:-10px" />
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 {{ (Auth::check()) ? null : 'hidden' }}">
			<div class="table-responsive">
				<table class="table display table-hover responsive nowrap" width="100%" name="dataTables-example">
					<thead>
						<tr>
							<th>{{ Lang::get('content.information') }}</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{ Lang::get('content.players online') }}: {{ $informacoes['jogadores-online'] }}</td>
						</tr>
						<tr>
							<td>{{ Lang::get('content.registered accounts') }}: {{ $informacoes['jogadores-registrados'] }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b">
			<div class="table-responsive">
				<table class="table display table-hover responsive nowrap" width="100%" name="dataTables-example">
					<thead>
						<tr>
							<th>#</th>
							<th>{{ Lang::choice('content.world', 1) }}</th>
							<th>Online</th>
							<th>{{ Lang::get('content.record') }}</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?>
						@foreach($servidores as $key => $servidor)
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ link_to_action('PlayersController@getOnline', (isset($mundos[$key])) ? $mundos[$key] : Lang::get('content.unknown'), $parameters = array('world_id' => $key), $attributes = array('target' => '_blank')) }}</td>
							<td>{{ $servidor['online'] }}</td>
							<td>{{ $servidor['record'] or '0' }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row m-b conteudo">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b p-b p-t titulo">
			<h3 class="foNW foNS m-z p-z hidden-sm hidden-xs">Top {{ Lang::choice('content.level', 1) }}</h3>
			<h5 class="m-z p-z hidden-lg hidden-md"><strong>Top {{ Lang::choice('content.level', 1) }}</strong></h5>
			<img src="{{ asset('assets/img/shuriken.png') }}" class="img-responsive" style="position:absolute; top:10px; right:-10px" />
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b">
			@if($top_level->count()>0)
			<div class="table-responsive">
				<table class="table display table-hover responsive nowrap" width="100%" name="dataTables-example">
					<thead>
						<tr>
							<th>#</th>
							<th>{{ Lang::choice('content.name', 1) }}</th>
							@if(!$privacy_level)
							<th>{{ Lang::choice('content.level', 1) }}</th>
							@endif
							<th>{{ Lang::choice('content.world', 1) }}</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?>
						@foreach($top_level as $personagem)
						<tr>
							<td>{{ $i++ }}</td>
							<td><a href="{{ action('PlayersController@getPersonagem', array('id' => $personagem->id)) }}" class="{{{ ($personagem->online) ? 'text-success' : 'text-danger' }}}" alt="{{ Lang::get('content.show character').' '.$personagem->name }}" title="{{ Lang::get('content.show character').' '.$personagem->name }}">{{ $personagem->name }}</a></td>
							@if(!$privacy_level)
							<td>{{ $personagem->level }}</td>
							@endif
							<td>{{ $mundos[$personagem->world_id] or 'Desconhecido' }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			@else
			Nenhum personagem foi encontrado!
			@endif
		</div>
	</div>
	@if(!empty($configuracoes->facebook))
	<div class="row m-b conteudo">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b p-b p-t titulo">
			<h3 class="foNW foNS m-z p-z hidden-sm hidden-xs">Facebook</h3>
			<h5 class="m-z p-z hidden-lg hidden-md"><strong>Facebook</strong></h5>
			<img src="{{ asset('assets/img/shuriken.png') }}" class="img-responsive" style="position:absolute; top:10px; right:-10px" />
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b">
			<div id="fb-root"></div>
			<div class="fb-page" data-href="{{{ $configuracoes->facebook }}}" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="{{{ $configuracoes->facebook }}}"><a href="{{{ $configuracoes->facebook }}}">{{{ $configuracoes->title }}}</a></blockquote></div></div>
		</div>
	</div>
	@endif
</div>
@stop

@section('scripts')

@stop

@section('script-execute')
<script type="text/javascript" defer async="async">
	var facebook = "{{ ($configuracoes->facebook) ? true : false }}";
	// var facebook = null;
	if(facebook){
		$(window).load(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.4&appId=556054237775903"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));
	}
</script>
<script type="text/javascript" async="async">
	$(window).load(function(){
		var clickEvent = false;
		$('#carousel-noticias').carousel({
			interval:   4000	
		}).on('click', '#carousel-noticias .list-group li', function() {
			clickEvent = true;
			$('#carousel-noticias .list-group li').removeClass('active');
			$(this).addClass('active');		
		}).on('slid.bs.carousel', function(e) {
			if(!clickEvent) {
				var count = $('.list-group').children().length -1;
				var current = $('.list-group li.active');
				current.removeClass('active').next().addClass('active');
				var id = parseInt(current.data('slide-to'));
				if(count == id) {
					$('#carousel-noticias .list-group li').first().addClass('active');	
				}
			}
			clickEvent = false;
		});

		var boxheight = $('#carousel-noticias .carousel-inner').innerHeight();
		var itemlength = $('#carousel-noticias .item').length;
		var triggerheight = Math.round(boxheight/itemlength+1);
		$('#carousel-noticias .list-group-item').outerHeight(triggerheight);
	});
</script>
@stop
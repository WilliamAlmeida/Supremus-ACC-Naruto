@extends('layouts.public')

@section('title', 'Categoria')
@section('sub_title', (isset($categoria_noticia)) ? $categoria_noticia->name : null)

@section('styles')

@stop

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t titulo">
			<h1 class="foNW foNS m-z p-z hidden-sm hidden-xs">Notícias da Categoria {{{ (isset($categoria_noticia)) ? $categoria_noticia->name : '"'.$categoria.'"' }}}</h1>
			<h5 class="m-z p-z hidden-lg hidden-md">Notícias da Categoria {{{ (isset($categoria_noticia)) ? $categoria_noticia->name : '"'.$categoria.'"' }}}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-t">
			@if(!empty($noticias))
			@foreach($noticias as $noticia)
			{{ link_to_action('NoticiasController@getNoticia', str_limit($noticia->title, 100), $parameters = array('name' => Str::slug($noticia->title)), $attributes = array('title' => $noticia->title, 'class' => 'h3 m-z link')) }}

			<h5><i class="fa fa-user fa-fw"></i> {{{ $noticia->user->nickname }}} <i class="fa fa-calendar fa-fw"></i> {{ Helpers::formataData($noticia->updated_at, 'data') }}.</h5>

			<span>
				<!-- Comentários - <span class="hidden"><span class="glyphicon glyphicon-comment hidden"></span>&nbsp;<a href="#comments hidden"><strong>3 comments</strong></a>&nbsp;&nbsp;</span> -->
				<!-- Categorias -->
				<span class="glyphicon glyphicon-tags"></span>&nbsp;
				@forelse($noticia->categorianoticia as $categoria)
				{{ link_to_action('NoticiasController@getNoticiaCategoria', $categoria->name, $parameters = array('name' => $categoria->name), $attributes = array('title' => 'Categoria '.$categoria->name, 'class' => 'badge')) }}
				@empty
				<a href="#" alt="Nenhuma categoria encontrada!" title="Nenhuma categoria encontrada!" class="badge">Nenhuma categoria encontrada!</a>
				@endforelse
			</span>

			@if(!$noticia->midianoticia->isEmpty())
			@foreach($noticia->midianoticia as $imagem)
			@if($imagem->capa)
			<a href="{{{ action('NoticiasController@getNoticia', array('name' => Str::slug($noticia->title) )) }}}" alt="{{{ $noticia->title }}}" title="{{{ $noticia->title }}}">
				{{ HTML::image(str_replace('-original', '-thumbnail', $imagem->path), $imagem->name, array('title' => $imagem->name, 'class' => 'm-t m-b center-block img-responsive')) }}
			</a>
			@endif
			@endforeach
			@endif

			<p>{{ strip_tags(str_limit($noticia->description, 400)) }}</p>

			<div name="{{ $noticia->id }}">
				<!-- <p class="pull-right">{{-- $noticia->rate->count() --}} {{-- ($noticia->rate->count()>1) ? 'reviews' : 'review' --}}</p> -->
				<p name="stars"
				data-tipo = "noticias"
				data-objetoId = "{{ $noticia->id }}"
				data-readOnly="1"
				data-cancel="0"
				data-score="{{ ($noticia->rate->count()) ? $noticia->rate->sum('rate')/$noticia->rate->count() : 0 }}"
				class="p-z"></p>
				<!-- <p>{{-- ($noticia->rate->count()>0) ? $noticia->rate->sum('rate')/$noticia->rate->count().' stars' : '0 star' --}}</p> -->
			</div>

			<div class="center-block text-right">
				{{ link_to_action('NoticiasController@getNoticia', 'Leia mais', $parameters = array('name' => Str::slug($noticia->title)), $attributes = array('title' => 'Leia mais sobre '.$noticia->title, 'class' => 'btn btn-primary')) }}
			</div>

			<hr>
			@endforeach

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				{{ $noticias->links() }}
			</div>
			@else
			Nenhuma notícia encontrada!
			@endif
		</div>
	</div>
</div>
@stop

@section('scripts')
{{ HTML::script('assets/plugins/rate/jquery.raty.js') }}
{{ HTML::script('assets/js/scriptRate.js') }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	var dados = JSON.parse('{ "csrftoken" : "{{ csrf_token() }}", "url" : "{{ action("RatesController@getRate") }}", "user" : "{{ (@Auth::check()) ? @Auth::user()->id : 0 }}" }');

	$(document).ready(function(){

	});
</script>
@stop
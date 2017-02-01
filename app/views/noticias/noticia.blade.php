@extends('layouts.public')

@section('title', '')
@section('sub_title', (isset($noticia)) ? $noticia->title : null)

@section('styles')
{{ HTML::style('assets/plugins/rate/jquery.raty.css', array('async' => 'async')) }}
@stop

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 conteudo m-b">
	<div class="row m-b">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t titulo">
			<h1 class="foNW foNS m-z p-z hidden-sm hidden-xs">{{ Lang::get('content.news') }}</h1>
			<h5 class="m-z p-z hidden-lg hidden-md">{{ Lang::get('content.news') }}</h5>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-t">
			<h4><strong>{{{ $noticia->title }}}</strong></h4>
			<hr>
			<p class="pull-right"><span class="glyphicon glyphicon-eye-open"></span> {{{ ($noticia->views <= 1) ? $noticia->views.' view' : $noticia->views.' views' }}}</p>
			<p><i class="fa fa-user fa-fw"></i>{{{ $noticia->user->nickname }}} <span class="glyphicon glyphicon-time"></span> {{ Helpers::formataData($noticia->updated_at) }}</p>

			@if(!$capa->isEmpty())
			<hr>
			{{ HTML::image(str_replace('-original', '-banner', $capa->first()->path), $capa->first()->name, array('title' => $capa->first()->name, 'class' => 'center-block img-responsive')) }}
			@endif

			<hr>
			<!-- <p class="lead">{{{-- $noticia->title --}}}</p> -->
			<p>{{ $noticia->description }}</p>

			@if(!$galeria->isEmpty())
			<hr>
			<h4><strong>{{ Lang::get('menu.screenshots') }}</strong></h4>
			<div id="carousel-generic" class="row">
				@foreach($galeria as $key => $imagem)
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					{{ HTML::image(str_replace('-original', '-banner', $imagem->path), $imagem->name, array('title' => $imagem->name, 'class' => 'center-block img-responsive', 'rel' => str_replace('-original', '-banner', $imagem->path))) }}
				</div>
				@endforeach
			</div>
			@endif

			<hr>
			<div>
				<span class="glyphicon glyphicon-tags"></span>&nbsp;
				@forelse($noticia->categorianoticia as $categoria)
				{{ link_to_action('NoticiasController@getNoticiaCategoria', $categoria->name, $parameters = array('name' => $categoria->name), $attributes = array('title' => Lang::get('content.category').' '.$categoria->name, 'class' => 'badge')) }}
				@empty
				<a href="#" alt="{{ Lang::get('content.no category found') }}!" title="{{ Lang::get('content.no category found') }}!" class="badge">{{ Lang::get('content.no category found') }}!</a>
				@endforelse
			</div>

			<hr>
			<div class="m-b">
				<p id="reviews" class="pull-right">{{ $noticia->rate->count() }} {{ Lang::choice('content.review', $noticia->rate->count()) }}</p>
				<p name="stars"
				data-tipo = "noticias"
				data-objetoId = "{{ $noticia->id }}"
				data-readOnly="{{ (@Auth::check()) ? '0' : '1' }}"
				data-cancel="{{ ($votou) ? '1' : '0' }}"
				data-score="{{ ($noticia->rate->count()) ? $noticia->rate->sum('rate')/$noticia->rate->count() : 0 }}"
				class="p-z col-lg-3 col-md-3 col-sm-6 col-xs-6"></p>
				<p id="star" class="">{{ (($noticia->rate->count()) ? $noticia->rate->sum('rate')/$noticia->rate->count() : 0).' '.Lang::choice('content.star', (($noticia->rate->count()) ? $noticia->rate->sum('rate')/$noticia->rate->count() : 0)) }}</p>
			</div>
		</div>
	</div>
</div>

<div id="carousel_modal" class="modal fade bs-carousel-generec-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="background-color: rgba(14,14,14,0.6);">
			<img src="" alt="" title="" class="center-block img-responsive" />
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
		$('select[name=notice_categories]').on('change', function(){
			window.location.assign(window.location.origin+'/categoria/'+$(this).val());
		});
		
		$('div[id="carousel-generic"] img').on('click', function(){
			var modal = $('div[id=carousel_modal]');
			modal.modal('show');
			modal.find('img').attr('alt', $(this).attr('alt'));
			modal.find('img').attr('title', $(this).attr('title'));
			modal.find('img').attr('src', $(this).attr('src').replace("-banner", "-original"));
		});
/*
		$('ul[id=thumbnails-noticias] img').mouseenter(function(){
			var atual_src = $('div[id=view] img').attr('src');
			var nova_src = window.location.origin+'/'+$(this).attr('rel');
			if(atual_src != nova_src){
				$('div[id=view] img').css('opacity', 0);
				$('div[id=view] img').attr('src', nova_src);
				$('div[id=view] img').fadeTo("slow", 1);
			}
		});*/

	});
</script>
@stop
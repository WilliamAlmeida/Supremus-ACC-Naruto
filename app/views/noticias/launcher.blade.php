{{ HTML::style('assets/css/normalize.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/bootstrap/bootstrap.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/social-buttons/social-buttons.css', array('async' => 'async')) }}
{{ HTML::style('assets/plugins/animate/animate.min.css', array('async' => 'async')) }}
{{ HTML::style('assets/css/main-style.css', array('async' => 'async')) }}
{{ HTML::style('assets/css/style.css', array('async' => 'async')) }}

<section id="body">
	<div class="container">
		<div class="hidden-lg hidden-sm col-sm-12 col-xs-12 conteudo m-t m-b">
			<div class="row m-b">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-b p-t titulo">
					<h1 class="foNW foNS m-z p-z hidden-sm hidden-xs">Notícias</h1>
					<h5 class="m-z p-z hidden-lg hidden-md">Notícias</h5>
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
								@foreach($noticias_featured as $key => $noticia)
								<li data-target="#carousel-noticias" data-slide-to="{{ ($key==0) ? $key : --$key }}" class="list-group-item {{ ($key==0) ? 'active' : null }}">
									<strong>{{{ $noticia->title }}}</strong>
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
					<h3><strong>Últimas</strong> Notícias</h3>
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
							{{ link_to_action('NoticiasController@getNoticia', 'Leia mais', $parameters = array('name' => Str::slug($noticia_aux->title)), $attributes = array('title' => 'Leia mais sobre '.$noticia_aux->title, 'class' => 'btn btn-primary btn-xs')) }}
						</div>

						<hr>
						@endif
						@endforeach
					</div>
				</div>
				@else
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b m-t">
					Nenhuma notícia encontrada!
				</div>
				@endif
			</div>
		</div>
	</div>
</section>

{{ HTML::script('assets/js/jquery.min.js') }}
{{ HTML::script('assets/plugins/bootstrap/bootstrap.min.js') }}
{{ HTML::script('assets/plugins/metisMenu/jquery.metisMenu.js', array('async' => 'async')) }}
{{ HTML::script('assets/js/shop/siminta.js', array('async' => 'async')) }}

<script type="text/javascript" async="async">
	/*execute/clear BS loaders for docs*/
	$(function(){while(window.BS&&window.BS.loader&&window.BS.loader.length){(window.BS.loader.pop())()}})

	$(document).ready(function(){
		var clickEvent = false;
		$('#carousel-noticias').carousel({
			interval:   4000	
		}).on('click', '.list-group li', function() {
			clickEvent = true;
			$('.list-group li').removeClass('active');
			$(this).addClass('active');		
		}).on('slid.bs.carousel', function(e) {
			if(!clickEvent) {
				var count = $('.list-group').children().length -1;
				var current = $('.list-group li.active');
				current.removeClass('active').next().addClass('active');
				var id = parseInt(current.data('slide-to'));
				if(count == id) {
					$('.list-group li').first().addClass('active');	
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
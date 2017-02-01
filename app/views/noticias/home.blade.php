@extends('layouts.public-blog')

@section('title', 'Blog')
@section('sub_title', '')

@section('styles')
{{ HTML::style('assets/css/main-style.css', array('async' => 'async')) }}
@stop

@section('content')

@if(!$noticias_featured->isEmpty())
<div class="row m-b slider">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		<!-- Jssor Slider Begin -->
		<!-- To move inline styles to css file/block, please specify a class name for each element. --> 
		<!-- ================================================== -->
		<div id="slider1_container">

			<!-- Loading Screen -->
			<div id="loading" u="loading">
				<div id="first"></div>
				<div id="two"></div>
			</div>

			<!-- Slides Container -->
			<div id="slides" u="slides">
				@foreach($noticias_featured as $key => $noticia_aux)
				@foreach($noticia_aux->midianoticia as $imagem)
				@if($imagem->capa)
				<div>
					<img u="image" class="image" src="{{{ str_replace('-original', '-banner', $imagem->path) }}}" alt="{{{ $imagem->title }}}">
					<div class="carousel-caption">
						<h3>{{ link_to_action('NoticiasController@getNoticia', $noticia_aux->title, $parameters = array('name' => Str::slug($noticia_aux->title)), $attributes = array('class' => '')) }}</h3>
						<p></p>
					</div>
				</div>
				@endif
				@endforeach
				@endforeach
			</div>

			<!--#region Bullet Navigator Skin Begin -->
			<!-- Help: http://www.jssor.com/development/slider-with-bullet-navigator-jquery.html -->
			<style async="async"></style>
			<!-- bullet navigator container -->
			<div u="navigator" class="jssorb05">
				<!-- bullet navigator item prototype -->
				<div u="prototype"></div>
			</div>
			<!--#endregion Bullet Navigator Skin End -->

			<!--#region Arrow Navigator Skin Begin -->
			<!-- Help: http://www.jssor.com/development/slider-with-arrow-navigator-jquery.html -->
			<style async="async"></style>
			<!-- Arrow Left -->
			<span u="arrowleft" class="jssora11l"></span>
			<!-- Arrow Right -->
			<span u="arrowright" class="jssora11r"></span>
			<!--#endregion Arrow Navigator Skin End -->
			<!-- <a style="display: none" href="http://www.jssor.com">Bootstrap Slider</a> -->
		</div>
		<!-- Jssor Slider End -->
	</div>
</div>
@endif

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3><strong>Últimas</strong> Notícias</h3>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		@forelse($noticias as $noticia_aux)
		@if( !in_array( $noticia_aux->id, $noticias_featured->lists('id', 'id') ) )
		{{ link_to_action('NoticiasController@getNoticia', str_limit($noticia_aux->title, 100), $parameters = array('name' => Str::slug($noticia_aux->title)), $attributes = array('title' => $noticia_aux->title, 'class' => 'h3 m-z link')) }}

		<h5><i class="fa fa-user fa-fw"></i> {{{ $noticia_aux->user->perfil->firstname.' '.$noticia_aux->user->perfil->secondname }}} <i class="fa fa-calendar fa-fw"></i> {{ Helpers::formataData($noticia_aux->updated_at, 'data') }}.</h5>

		<span>
			<!-- Comentários - <span class="hidden"><span class="glyphicon glyphicon-comment hidden"></span>&nbsp;<a href="#comments hidden"><strong>3 comments</strong></a>&nbsp;&nbsp;</span> -->
			<!-- Categorias -->
			<span class="glyphicon glyphicon-tags"></span>&nbsp;
			@forelse($noticia_aux->categorianoticia as $categoria)
			{{ link_to_action('NoticiasController@getNoticiaCategoria', $categoria->name, $parameters = array('name' => $categoria->name), $attributes = array('title' => 'Categoria '.$categoria->name, 'class' => 'badge')) }}
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

		<p>{{ strip_tags(str_limit($noticia_aux->description, 400)) }}</p>

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
			{{ link_to_action('NoticiasController@getNoticia', 'Leia mais', $parameters = array('name' => Str::slug($noticia_aux->title)), $attributes = array('title' => 'Leia mais sobre '.$noticia_aux->title, 'class' => 'btn btn-primary')) }}
		</div>

		<hr>
		@endif
		@empty
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			Nenhuma notícia encontrada!
		</div>
		@endforelse
	</div>
</div>
@stop

@section('scripts')
{{ HTML::script('assets/plugins/slider/docs.min.js') }}
{{ HTML::script('assets/plugins/slider/ie10-viewport-bug-workaround.js') }}
{{ HTML::script('assets/plugins/slider/jssor.slider.min.js') }}
{{ HTML::script('assets/plugins/rate/jquery.raty.js') }}
{{ HTML::script('assets/js/scriptRate.js') }}
@stop

@section('script-execute')
<script type="text/javascript" async="async">
	jQuery(document).ready(function ($) {
		var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 2000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideEasing: $JssorEasing$.$EaseOutQuint,          //[Optional] Specifies easing for right to left animation, default value is $JssorEasing$.$EaseOutQuad
                $SlideDuration: 800,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Scale: false                                   //Scales bullets navigator or not while slider scale
                },

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 12,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 4,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1,                                //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                    $Scale: false                                   //Scales bullets navigator or not while slider scale
                }
            };

            //Make the element 'slider1_container' visible before initialize jssor slider.
            $("#slider1_container").css("display", "block");
            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
            	var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
            	if (parentWidth) {
            		jssor_slider1.$ScaleWidth(parentWidth - 30);
            	}
            	else
            		window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
</script>
@stop
@extends('layouts.public')

@section('title', '')
@section('sub_title', (isset($pagina)) ? $pagina->meta_title : Lang::get('content.error 404'))

@section('styles')

@stop

@section('content')
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 conteudo m-b">
    <div class="row m-b">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b p-b p-t titulo">
            <h1 class="foNW foNS m-z p-z p-b hidden-sm hidden-xs">{{{ $pagina->meta_title or Lang::get('content.error 404').'!' }}}</h1>
            <h5 class="m-z p-z hidden-lg hidden-md">{{{ $pagina->meta_title or Lang::get('content.error 404').'!' }}}</h5>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {{ $pagina->body or Lang::get('content.page not found').'!' }}
        </div>
    </div>
    @if($capa != null && !$capa->isEmpty())
    <div class="row m-b">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="carousel-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
<!--                 <ol class="carousel-indicators">
                    <li data-target="#carousel-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-generic" data-slide-to="2"></li>
                </ol> -->

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        {{ HTML::image(str_replace('-original', '-banner', $capa->first()->path), $capa->first()->name, array('title' => $capa->first()->name, 'class' => 'center-block img-responsive')) }}
                        <div class="carousel-caption">
                            {{{ $capa->first()->name }}}
                        </div>
                    </div>
                    @forelse($galeria as $imagem)
                    <div class="item">
                        {{ HTML::image(str_replace('-original', '-banner', $imagem->path), $imagem->name, array('title' => $imagem->name, 'class' => 'center-block img-responsive', 'rel' => str_replace('-original', '-banner', $imagem->path))) }}
                        <div class="carousel-caption">
                            {{{ $imagem->name }}}
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <!-- <li><img src="http://placehold.it/100x100" alt="{{{ $pagina->title }}}" rel="http://placehold.it/500x500" /></li> -->
        </div>
    </div>
    @endif
</div>
<div class="col-lg-1 col-md-1"></div>

<div id="carousel_modal" class="modal fade bs-carousel-generec-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <img src="" alt="" title="" class="center-block img-responsive" />
    </div>
  </div>
</div>
@stop

@section('scripts')

@stop

@section('script-execute')
<script type="text/javascript" async="async">
    $(document).ready(function(){
        $('div[id="carousel-generic"] img').on('click', function(){
            var modal = $('div[id=carousel_modal]');
            modal.modal('show');
            console.log($(this).attr('src'));
            modal.find('img').attr('alt', $(this).attr('alt'));
            modal.find('img').attr('title', $(this).attr('title'));
            modal.find('img').attr('src', $(this).attr('src').replace("-banner", "-original"));
        });
/*        $('ul[id=thumbnails-paginas] img').mouseenter(function(){
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
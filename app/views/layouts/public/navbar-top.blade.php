<!-- Navigation -->
<nav id="navegacao-principal" class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand foNW foNS" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">{{ $configuracoes->title }}</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('home') }}" alt="{{ Lang::get('menu.home') }}" title="{{ Lang::get('menu.home') }}"><i class="fa fa-home fa-fw"></i> {{ Lang::get('menu.home') }}</a></li>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-download fa-fw"></i>{{ Lang::get('menu.download') }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('paginas', array('slug' => 'cliente')) }}" alt="{{ Lang::get('menu.client') }}" title="{{ Lang::get('menu.client') }}">{{ Lang::get('menu.client') }}</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('paginas', array('slug' => 'screenshots')) }}" alt="{{ Lang::get('menu.screenshots') }}" title="{{ Lang::get('menu.screenshots') }}">{{ Lang::get('menu.screenshots') }}</a></li>
                        <li><a href="{{ route('paginas', array('slug' => 'videos')) }}" alt="{{ Lang::get('menu.videos') }}" title="{{ Lang::get('menu.videos') }}">{{ Lang::get('menu.videos') }}</a></li>
                        <li><a href="{{ route('paginas', array('slug' => 'wallpapers')) }}" alt="{{ Lang::get('menu.wallpapers') }}" title="{{ Lang::get('menu.wallpapers') }}">{{ Lang::get('menu.wallpapers') }}</a></li>
                    </ul>
                </li>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-users fa-fw"></i> {{ Lang::get('menu.community') }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('busca-player') }}" alt="{{ Lang::get('menu.search players') }}" title="{{ Lang::get('menu.search players') }}">{{ Lang::get('menu.search players') }}</a></li>
                        <li><a href="{{ route('ranking-player') }}" alt="{{ Lang::get('menu.top players') }}" title="{{ Lang::get('menu.top players') }}">{{ Lang::get('menu.top players') }}</a></li>
                        <li><a href="{{ route('ultimas-mortes') }}" alt="{{ Lang::get('menu.latest deaths in the game') }}" title="{{ Lang::get('menu.latest deaths in the game') }}">{{ Lang::get('menu.latest deaths in the game') }}</a></li>
                        <li><a href="{{ route('online-player') }}" alt="{{ Lang::get('menu.players online') }}" title="{{ Lang::get('menu.players online') }}">{{ Lang::get('menu.players online') }}</a></li>
                        <!-- <li><a href="#" alt="Pokémons Capturados" title="Pokémons Capturados">Pokémons Capturados</a></li> -->
                        <li><a href="{{ route('casas') }}" alt="{{ Lang::choice('menu.house', 2) }}" title="{{ Lang::choice('menu.house', 2) }}">{{ Lang::choice('menu.house', 2) }}</a></li>
                        <li><a href="{{ route('guildas') }}" alt="{{ Lang::choice('menu.guild', 2) }}" title="{{ Lang::choice('menu.guild', 2) }}">{{ Lang::choice('menu.guild', 2) }}</a></li>
                        <li><a href="{{ route('paginas', array('slug' => 'mapa-do-jogo')) }}" alt="{{ Lang::get('menu.game map') }}" title="{{ Lang::get('menu.game map') }}">{{ Lang::get('menu.game map') }}</a></li>
                    </ul>
                </li>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-question fa-fw"></i> {{ Lang::get('menu.suport') }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- <li><a href="#" alt="Entrar em Contato" title="Entrar em Contato">Entrar em Contato</a></li> -->
                        <li><a href="{{ route('paginas', array('slug' => 'problemas-comuns')) }}" alt="{{ Lang::get('menu.common problems') }}" title="{{ Lang::get('menu.common problems') }}">{{ Lang::get('menu.common problems') }}</a></li>
                        <li><a href="{{ route('paginas', array('slug' => 'dicas-de-seguranca')) }}" alt="{{ Lang::get('menu.safety tips') }}" title="{{ Lang::get('menu.safety tips') }}">{{ Lang::get('menu.safety tips') }}</a></li>
                        <li><a href="{{ route('paginas', array('slug' => 'regras')) }}" alt="{{ Lang::get('menu.rules') }}" title="{{ Lang::get('menu.rules') }}">{{ Lang::get('menu.rules') }}</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('tela-recuperar-conta') }}" alt=">{{ Lang::get('menu.recover account') }}" title=">{{ Lang::get('menu.recover account') }}">{{ Lang::get('menu.recover account') }}</a></li>
                        <li><a href="{{ route('tela-resgate-cupom') }}" alt="{{ Lang::get('menu.redeem coupon') }}" title="{{ Lang::get('menu.redeem coupon') }}">{{ Lang::get('menu.redeem coupon') }}</a></li>
                    </ul>
                </li>
                <li><a href="{{{ route('shop') }}}" alt="{{ Lang::get('menu.shop') }}" title="{{ Lang::get('menu.shop') }}"><i class="fa fa-shopping-cart fa-fw"></i> {{ Lang::get('menu.shop') }}</a></li>
            </ul>
            @if(!@Auth::user())
            <ul class="nav navbar-nav pull-right m-r">
                <li>
                    <button type="button" class="btn btn-success navbar-btn" id="btn_login" alt="{{ Lang::get('menu.log in') }}" rel="login">{{ Lang::get('menu.log in') }}</button>
                    <button type="button" class="btn btn-primary navbar-btn" id="btn_register" alt="{{ Lang::get('menu.register') }}" rel="registro">{{ Lang::get('menu.register') }}</button>
                </li>
            </ul>
            @else
            <ul class="nav navbar-nav pull-right hidden-sm hidden-xs">
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> {{ (@Auth::user()->nickname) ? @Auth::user()->nickname : @Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        @if(@Auth::user()->group_id > 3)
                        <li><a href="{{ action('HomeController@getDashboard') }}" alt="{{ Lang::get('menu.panel') }}" title="{{ Lang::get('menu.panel') }}">{{ Lang::get('menu.panel') }}</a></li>
                        <li class="divider"></li>
                        @endif
                        <li><a href="{{ route('tela-registrar-player') }}" alt="{{ Lang::get('menu.create character') }}" title="{{ Lang::get('menu.create character') }}">{{ Lang::get('menu.create character') }}</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('tela-alterar-senha') }}" alt="{{ Lang::get('menu.change password') }}" title="{{ Lang::get('menu.change password') }}">{{ Lang::get('menu.change password') }}</a></li>
                        <li><a href="{{ route('tela-alterar-email') }}" alt="{{ Lang::get('menu.change email') }}" title="{{ Lang::get('menu.change email') }}">{{ Lang::get('menu.change email') }}</a></li>
                        <li><a href="{{ route('minha-conta') }}" alt="{{ Lang::get('menu.account') }}" title="{{ Lang::get('menu.account') }}">{{ Lang::get('menu.account') }}</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('deslogar') }}" alt="{{ Lang::get('menu.log out') }}">{{ Lang::get('menu.log out') }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav hidden-lg hidden-md">
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> {{ (@Auth::user()->nickname) ? @Auth::user()->nickname : @Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        @if(@Auth::user()->group_id > 3)
                        <li><a href="{{ action('HomeController@getDashboard') }}" alt="{{ Lang::get('menu.panel') }}" title="{{ Lang::get('menu.panel') }}">{{ Lang::get('menu.panel') }}</a></li>
                        <li class="divider"></li>
                        @endif
                        <li><a href="{{ route('tela-registrar-player') }}" alt="{{ Lang::get('menu.create character') }}" title="{{ Lang::get('menu.create character') }}">{{ Lang::get('menu.create character') }}</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('tela-alterar-senha') }}" alt="{{ Lang::get('menu.change password') }}" title="{{ Lang::get('menu.change password') }}">{{ Lang::get('menu.change password') }}</a></li>
                        <li><a href="{{ route('tela-alterar-email') }}" alt="{{ Lang::get('menu.change email') }}" title="{{ Lang::get('menu.change email') }}">{{ Lang::get('menu.change email') }}</a></li>
                        <li><a href="{{ route('minha-conta') }}" alt="{{ Lang::get('menu.account') }}" title="{{ Lang::get('menu.account') }}">{{ Lang::get('menu.account') }}</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('deslogar') }}" alt="{{ Lang::get('menu.log out') }}">{{ Lang::get('menu.log out') }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
            @endif
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<div class="modal fade" id="login_registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-justified" role="tablist" id="tabs_formulario">
                    <li role="presentation" class="active"><a href="#login" aria-controls="login" role="tab" data-toggle="tab">{{ Lang::get('content.login') }}</a></li>
                    <li role="presentation" class=""><a href="#registro" aria-controls="registro" role="tab" data-toggle="tab">{{ Lang::get('content.register') }}</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane fade in active" id="login">
                        <div class="panel panel-success">
                            <!-- <div class="panel-heading hidden">
                                Faça login em sua Conta
                            </div> -->
                            <div class="panel-body">
                                {{ Form::open(array('action' => 'HomeController@postLogin', 'class' => 'form', 'name' => 'login')) }}

                                <div class="form-group">
                                    {{ Form::label('name', Lang::choice('content.account', 1)) }}
                                    {{ Form::text('name', null, array('placeholder' => 'Pedro', 'class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('password', Lang::get('content.password')) }}
                                    {{ Form::password('password', array('placeholder' => '******', 'class' => 'form-control')) }}
                                </div>
                                <div class="form-group text-right">
                                    {{ Form::label('remeber_me', Lang::get('content.remember-me')) }}
                                    {{ Form::checkbox('remeber_me', true) }}
                                </div>

                                <div class="form-group">
                                    {{ Form::submit(Lang::get('content.login'), ['class' => 'btn btn-success btn-block']) }}
                                </div>

                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="registro">
                        <div class="panel panel-primary">
                            <!-- <div class="panel-heading hidden">
                                Registre-se e comece sua aventura!
                            </div> -->
                            <div class="panel-body">
                                {{ Form::open(array('action' => 'HomeController@postRegister', 'class' => 'form', 'name' => 'registro')) }}

                                <div class="form-group">
                                    {{ Form::label('name', Lang::choice('content.account', 1)) }}
                                    <i class="fa fa-info-circle" title="{{ Lang::choice('content.required field', 1) }}"></i>
                                    {{ Form::text('name', null, array('placeholder' => 'William.', 'class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('nickname', Lang::get('content.nickname')) }}
                                    <i class="fa fa-info-circle" title="{{ Lang::choice('content.required field', 1) }}"></i>
                                    {{ Form::text('nickname', null, array('placeholder' => 'Dragon Slayer.', 'class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('email', Lang::get('content.email')) }}
                                    <i class="fa fa-info-circle" title="{{ Lang::choice('content.required field', 1) }}"></i>
                                    {{ Form::email('email', null, array('placeholder' => 'exemplo@exemplo.com', 'class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('password', Lang::get('content.password')) }}
                                    <i class="fa fa-info-circle" title="{{ Lang::choice('content.required field', 1) }}"></i>
                                    {{ Form::password('password', array('placeholder' => '******', 'class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('repeat_password', Lang::get('content.repeat password')) }}
                                    <i class="fa fa-info-circle" title="{{ Lang::choice('content.required field', 1) }}"></i>
                                    {{ Form::password('repeat_password', array('placeholder' => '******', 'class' => 'form-control')) }}
                                </div>
                                <div class="form-group hidden">
                                    {{ Form::label('code', Lang::choice('content.coupon', 1)) }}
                                    <i class="fa fa-info-circle" title="{{ Lang::choice('content.field optional', 1) }}"></i>
                                    {{ Form::text('code', null, array('placeholder' => 'AhmZm0W2', 'class' => 'form-control')) }}
                                </div>

                                <div class="form-group">
                                    {{ Form::submit(Lang::get('content.register'), ['class' => 'btn btn-primary btn-block']) }}
                                </div>

                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="regras" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Regras
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="senha_email" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-justified" role="tablist" id="tabs_formulario">
                    <li role="presentation" class="active"><a href="#senhaT" aria-controls="senhaT" role="tab" data-toggle="tab">{{ Lang::get('content.password') }}</a></li>
                    <li role="presentation" class=""><a href="#emailT" aria-controls="emailT" role="tab" data-toggle="tab">{{ Lang::get('content.email') }}</a></li>
                    @if(empty(Auth::user()->nickname))
                    <li role="presentation" class=""><a href="#nicknameT" aria-controls="nicknameT" role="tab" data-toggle="tab">{{ Lang::get('content.nickname') }}</a></li>
                    @endif
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane fade in active" id="senhaT">
                        <div class="panel panel-success">
                            <!-- <div class="panel-heading hidden">
                                Troque sua senha periódicamente para aumentar sua segurança.
                            </div> -->
                            <div class="panel-body">
                                {{ Form::open(array('action' => 'UsersController@postSenha', 'class' => 'form', 'name' => 'senha')) }}

                                <div class="form-group">
                                    {{ Form::label('password', Lang::get('content.password')) }}
                                    {{ Form::password('password', array('placeholder' => '******', 'class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('repeat_password', Lang::get('content.repeat password')) }}
                                    {{ Form::password('repeat_password', array('placeholder' => '******', 'class' => 'form-control')) }}
                                </div>

                                <div class="form-group">
                                    {{ Form::submit(Lang::get('content.change'), ['class' => 'btn btn-primary btn-block']) }}
                                </div>

                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="emailT">
                        <div class="panel panel-primary">
                            <!-- <div class="panel-heading hidden">
                                Para modificar seu e-mail é necessário preencher os campos corretamente.
                            </div> -->
                            <div class="panel-body">
                                {{ Form::open(array('action' => 'UsersController@postEmail', 'class' => 'form', 'name' => 'email')) }}

                                <div class="form-group">
                                    {{ Form::label('email', Lang::get('content.email')) }}
                                    {{ Form::email('email', null, array('placeholder' => 'jack@digimon.com.', 'class' => 'form-control')) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('repeat_email', Lang::get('content.repeat email')) }}
                                    {{ Form::email('repeat_email', null, array('placeholder' => 'jack@digimon.com.', 'class' => 'form-control')) }}
                                </div>

                                <div class="form-group">
                                    {{ Form::submit(Lang::get('content.change'), ['class' => 'btn btn-primary btn-block']) }}
                                </div>

                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>

                    @if(empty(Auth::user()->nickname))
                    <div role="tabpanel" class="tab-pane fade" id="nicknameT">
                        <div class="panel panel-primary">
                            <!-- <div class="panel-heading hidden">
                                Para modificar seu nickname é necessário preencher o campo corretamente.
                            </div> -->
                            <div class="panel-body">
                                {{ Form::open(array('action' => 'UsersController@postNickname', 'class' => 'form', 'name' => 'nickname')) }}

                                <div class="form-group">
                                    {{ Form::label('nickname', Lang::get('content.nickname')) }}
                                    {{ Form::text('nickname', null, array('placeholder' => 'João', 'class' => 'form-control')) }}
                                </div>

                                <div class="form-group">
                                    {{ Form::submit(Lang::get('content.save'), ['class' => 'btn btn-primary btn-block']) }}
                                </div>

                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
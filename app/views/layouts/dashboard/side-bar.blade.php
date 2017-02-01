<!-- navbar side -->
<nav class="navbar-default navbar-static-side" role="navigation">
  <!-- sidebar-collapse -->
  <div class="sidebar-collapse">
    <!-- side-menu -->
    <ul class="nav" id="side-menu">
      <li class="">
        <!-- user image section-->
        <div class="hidden-xs user-section">
          <div class="user-section-inner">
            {{--HTML::image('assets/img/user.png', 'a picture', array('class' => 'img-responsive'))--}}
            <!-- Avatar -->
          </div>
          <div class="user-info">
            <div class="small"><small>{{ @Auth::user()->nickname }} <strong>{{ @Auth::user()->name }}</strong></small></div>
            <!-- <div class="user-text-online">
              <span class="user-circle-online btn btn-success btn-circle "></span>&nbsp;Online
            </div> -->
          </div>
        </div>
        <!--end user image section-->
      </li>
      <li class="sidebar-search">
        <!-- search section-->
        <div class="input-group custom-search-form">
          <input type="text" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button class="btn btn-default" type="button">
              <i class="fa fa-search"></i>
            </button>
          </span>
        </div>
        <!--end search section-->
      </li>
      <li>
        <a href="{{ action('HomeController@getDashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
      </li>
      <li>
        <a href="{{ action('CouponsController@getIndex') }}"><i class="fa fa-tags fa-fw"></i> Cupons</a>
      </li>
      <li>
        <a href="{{ action('CitiesController@getIndex') }}"><i class="fa fa-map fa-fw"></i> Cidades</a>
      </li>
      <li>
        <a href="{{ action('MidiasController@getIndex') }}"><i class="fa fa-picture-o fa-fw"></i> Mídias</a>
      </li>
      <li>
        <a href="#"><i class="fa fa-list fa-fw"></i> Notícias<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          <li>
            <a href="{{ action('CategoriasNoticiasController@getIndex') }}">Categorias</a>
          </li>
          <li>
            <a href="{{ action('NoticiasController@getIndex') }}">Notícias</a>
          </li>
        </ul>
        <!-- second-level-items -->
      </li>
      <li>
        <a href="{{ action('PaginasController@getIndex') }}"><i class="fa fa-file-text fa-fw"></i> Páginas</a>
      </li>
      <li>
        <a href="{{ action('BansController@getIndex') }}"><i class="fa fa-ban fa-fw"></i> Punições</a>
      </li>
      <li>
        <a href="#"><i class="fa fa-users fa-fw"></i> Usuários<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          <li>
            <a href="{{ action('PlayersController@getIndex') }}">Personagens</a>
          </li>
          <li>
            <a href="{{ action('UsersController@getIndex') }}">Usuários</a>
          </li>
        </ul>
        <!-- second-level-items -->
      </li>
      <li>
        <a href="#"><i class="fa fa-shopping-cart fa-fw"></i> Shop<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
          <li>
            <a href="{{ action('ShopsController@getHistoricoCompras') }}">Histórico de Compras</a>
          </li>
          <li>
            <a href="{{ action('ShopsController@getIndex') }}">Itens</a>
          </li>
          <li>
            <a href="{{ action('TransacoesController@getIndex') }}">Transações</a>
          </li>
        </ul>
        <!-- second-level-items -->
      </li>
      <li>
        <a href="{{ action('RegistrosController@getIndex') }}"><i class="fa fa-list-alt fa-fw"></i> Logs</a>
      </li>
      <li>
        <a href="{{ action('ConfiguracoesController@getIndex') }}"><i class="fa fa-wrench fa-fw"></i> Configurações</a>
      </li>
      <li class="divider"></li>
      <li>
        <a href="{{ action('HomeController@index') }}"><i class="fa fa-home fa-fw"></i> Site</a>
      </li>
      <li>
      <a href="{{ action('HomeController@getLogout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
      </li>
    </ul>
    <!-- end side-menu -->
  </div>
  <!-- end sidebar-collapse -->
</nav>
<!-- end navbar side
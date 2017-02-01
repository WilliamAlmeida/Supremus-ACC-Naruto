<div class="row">
	<div class="col-lg-7">
		<p><small>
			Community {{{ $configuracoes->title }}} BRAZIL fan site {{{ Helpers::formataData($configuracoes->founded, 'ano').'-'.date('Y') }}} - Contact: {{ $configuracoes->email or 'contato@hotmail.com' }} - {{ $configuracoes->title or 'App Name' }}
			<br/>
			&copy; Toei Animation, Namco BANDAI. &copy; 2010 If Games Co Ltda. All rights reserveds.
		</small></p>
	</div>
	<div class="col-lg-2">
		<p><strong>{{ Lang::get('footer.languages') }}:</strong></p>
		<ul class="list-unstyled list-inline">
			<li>
				<a href="{{ url('language', $parameters = array('lang' => 'pt-br')) }}" alt="" title=""><img src="{{ asset('assets/plugins/flags/img/blank.gif') }}" class="flag flag-br img-responsive" alt="Portuguese" title="Portuguese" /></a>
			</li>
			<li>
				<a href="{{ url('language', $parameters = array('lang' => 'en')) }}" alt="" title=""><img src="{{ asset('assets/plugins/flags/img/blank.gif') }}" class="flag flag-us img-responsive" alt="English" title="English" /></a>
			</li>
			<li>
				<a href="{{ url('language', $parameters = array('lang' => 'en')) }}" alt="" title=""><img src="{{ asset('assets/plugins/flags/img/blank.gif') }}" class="flag flag-es img-responsive" alt="Spanish" title="Spanish" /></a>
			</li>
		</ul>
	</div>
	<div class="col-lg-2 col-lg-offset-1 hidden">
		<p><strong>{{ Lang::get('footer.contact us using') }}:</strong></p>
		<a href="ts3server://digiwo.bbhost.com.br" target="_blank" rel="nofollow" class="text-muted small">{{ HTML::image('assets/img/teamspeak.ico', 'Team Speak', array('title' => 'Team Speak', 'class' => 'img-responsive', 'style' => 'height:25px')) }}</a>
	</div>
</div>
<div class="row">
	<div class="col-lg-12 text-center">
		<a href="http://williamalmeida.tk" target="_blank" rel="follow" class="text-muted small">{{ Lang::get('footer.system created by') }}</a>
	</div>
</div>
<!DOCTYPE html>
<html>
<head>
	<title>@yield('title') - Admin Painel</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<style type="text/css"></style>
	{{ HTML::style('assets/css/normalize.css', array('async' => 'async')) }}
	{{ HTML::style('assets/plugins/bootstrap/bootstrap.css', array('async' => 'async')) }}
	{{--HTML::style('assets/plugins/morris/morris-0.4.3.min.css')--}}
	{{ HTML::style('assets/plugins/pace/pace-theme-big-counter.css', array('async' => 'async')) }}
	{{ HTML::style('assets/plugins/social-buttons/social-buttons.css', array('async' => 'async')) }}
	{{--HTML::style('assets/plugins/timeline/timeline.css')--}}
	{{ HTML::style('assets/css/dashboard/main-style.css', array('async' => 'async')) }}
	{{ HTML::style('assets/css/dashboard/style.css', array('async' => 'async')) }}

	@yield('styles')

</head>
<body>
	<header>
	</header>
	<section>
		<div id="container">
			<div id="content">
				<!--  wrapper -->
				<div id="wrapper">

					<!-- navbar top -->
					<nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar">
						<!-- navbar-header -->
						<div class="navbar-header">
							<a href="#" class="navbar-brand foNW foNS" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">Sistema Web Tibia</a>
						</div>
					</nav>
					<!-- end navbar top -->

					<!--  page-wrapper -->
					<div id="page-wrapper" style="padding-top:1px; margin-left:0px;">
						<h1 class="p-z m-z">@yield('sub_title')</h1>
						@yield('content')
					</div>
					<!-- end page-wrapper -->

				</div>
				<!-- end wrapper -->
			</div>
		</div>
	</section>
	<footer>

	</footer>


	{{ HTML::script('assets/js/jquery.min.js') }}

	{{ HTML::script('assets/plugins/bootstrap/bootstrap.min.js', array('async' => 'async')) }}

	{{--HTML::script('assets/plugins/flot/excanvas.min.js')--}}
	{{--HTML::script('assets/plugins/flot/jquery.flot.js')--}}
	{{--HTML::script('assets/plugins/flot/jquery.flot.pie.js')--}}
	{{--HTML::script('assets/plugins/flot/jquery.flot.resize.js')--}}
	{{--HTML::script('assets/plugins/flot/jquery.flot.tooltip.min.js')--}}

	{{ HTML::script('assets/plugins/metisMenu/jquery.metisMenu.js', array('async' => 'async')) }}

	{{--HTML::script('assets/plugins/morris/morris.js')--}}
	{{--HTML::script('assets/plugins/morris/raphael-2.1.0.min.js')--}}

	{{ HTML::script('assets/plugins/pace/pace.js', array('async' => 'async')) }}

	@yield('scripts')

	{{ HTML::script('assets/js/dashboard/siminta.js', array('async' => 'async')) }}

	@yield('script-execute')
	<script>
		/*execute/clear BS loaders for docs*/
		$(function(){while(window.BS&&window.BS.loader&&window.BS.loader.length){(window.BS.loader.pop())()}})
		$(window).load(function(){
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>

</body>
</html>
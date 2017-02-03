<!DOCTYPE html>
<html>
	<head>   
	    <title> ManageTicket - @yield('title')</title> 
	    @include('includes.head')       
	</head>

	<!-- Styles -->
	{{ Html::style('css/bootstrap.min.css') }}
	{{ Html::style('css/styles.css') }}

	<!-- Scripts jQueryUI -->
	{{ Html::script('js/jquery.min.js') }}
	{{ Html::script('js/jquery-ui.js') }}
	{{ Html::style('css/jquery-ui.css') }}

	<!-- Script Bootstrap -->
	{{ Html::script('js/tether.min.js') }}
	{{ Html::script('js/bootstrap.min.js') }}

	<!-- Scripts DynaTable -->
	{{ Html::script('js/jquery.dynatable.js') }}
	{{ Html::style('css/jquery.dynatable.css') }}

	<script type="text/javascript">
		$(document).ready(function() {
	  
	  	$('.dropdown-toggle').dropdown();
		});
	</script>

	<body>
		@include('includes.header')

		@yield('content')     
	</body>

	<footer class="footer">
	   @include('includes.footer')	
	</footer>
</html>


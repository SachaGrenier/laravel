<!DOCTYPE html>
<html>
	<head>   
	    <title> ManageTicket - @yield('title')</title> 
	    @include('includes.head')       
	</head>

	<!-- Styles -->

	{{ Html::style('css/bootstrap.min.css') }}
	{{ Html::style('css/font-awesome.min.css') }}	
	{{ Html::style('css/styles.css') }}	

	<!-- Scripts jQueryUI -->
	{{ Html::script('js/jquery.min.js') }}
	{{ Html::script('js/jquery-ui.js') }}
	{{ Html::style('css/jquery-ui.css') }}

	<!-- Script Bootstrap -->

	{{ Html::script('js/tether.min.js') }}
	{{ Html::script('js/bootstrap.min.js') }}

	<!-- Scripts DataTable -->
	<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap4.min.css">



	



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


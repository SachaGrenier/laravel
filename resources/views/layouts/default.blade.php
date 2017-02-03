<!DOCTYPE html>
<html>
<head>   
    <title> ManageTicket - @yield('title')</title> 
    @include('includes.head')       
</head>

<!-- Styles -->
{{ Html::style('css/bootstrap.min.css') }}
{{ Html::style('css/styles.css') }}
{{ Html::script('js/jquery.min.js') }}

<!-- Script Bootstrap -->
{{ Html::script('js/bootstrap.min.js') }}


<!-- Scripts jQueryUI -->
{{ Html::script('js/jquery.min.js') }}
{{ Html::script('js/jquery-ui.js') }}
{{ Html::style('css/jquery-ui.css') }}

<!-- Scripts DynaTable -->
{{ Html::script('js/jquery.dynatable.js') }}
{{ Html::style('css/jquery.dynatable.css') }}



<body>
@include('includes.header')	


@yield('content')     
</body>
<footer>
   @include('includes.footer')	

  </footer>
</html>
<!DOCTYPE html>
<html>
<head>   
    <title> ManageTicket - @yield('title')</title> 
    @include('includes.head')       
</head>

<!-- Bootstrap Css -->
 {{ Html::style('css/bootstrap.min.css') }}
 {{ Html::style('css/bootstrap.css') }}
 {{ Html::style('css/styles.css') }}

<!-- Scripts JS -->
 {{ Html::script('js/jquery.min.js') }}
 {{ Html::script('js/bootstrap.min.js') }}

<body>
@include('includes.header')	

@yield('content')     
</body>
<footer>
   je suis footer
  </footer>
</html>
<?php
//uses home controller
use App\Http\Controllers\HomeController;

$currentuser = HomeController::getUser();

?>

@extends('layouts.default')

@section('title', 'Paramètres')

@section('content')

<div class="container">

      <h1  class="text-center" style=" margin-top: 10px;">{{ $currentuser->first_name}} {{$currentuser->last_name }}</h1>
      <div id="imageprofil" style=" margin-bottom: 10px;"> {{ Html::image($currentuser->picture_path,'', array('class'=>'imageprofil')) }}</div>

      
  <div class="form-group">
	{{ Form::open(array('url' => 'storeimage','method'=>'POST','class' => 'form-group', 'files'=> true)) }}

	    {{ Form::label('Modifier son image de profil : ','') }}
		{{ Form::file('image') }}

  		{{ Form::submit('Modifier',['class' => 'btn btn-primary']) }}

	{{ Form::close() }}

	

  </div>

	<div class="jumbotron" id="jumbo-password" >
	 	<h3>Modifier son mot de passe</h3>

		{{ Form::open(array('url' => 'modifypassword','method'=>'POST','class' => 'form-group', 'files'=> true)) }}
	       
		    {{ Form::label('Ancien mot de passe', '') }}
		    {{ Form::password('old_password',['class' => 'form-control', 'placeholder'=>'Password']) }}

		    <br>

		    {{ Form::label('Nouveau mot de passe', '') }}
		    {{ Form::password('new_password',['class' => 'form-control', 'placeholder'=>'Password']) }}
		    {{ Form::password('new_password_confirm',['class' => 'form-control', 'placeholder'=>'Password']) }}

		    <br>
		    
		    {{ Form::submit('Modifier',['class' => 'btn btn-primary']) }}

		{{ Form::close() }}

		<?php
          if (session('status'))
          {
            echo '<div class="alert alert-danger">';
            echo session('status');
            
        echo '</div>';
         }
          ?>
  	</div>

</div>

@endsection


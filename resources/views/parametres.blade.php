<?php
//uses home controller
use App\Http\Controllers\HomeController;

$currentuser = HomeController::getUser();

?>

@extends('layouts.default')

@section('title', 'Paramètres')

@section('content')

<div class="container">

      <h1  class="text-center" style=" margin-top: 10px;">{{ $currentuser->login}}</h1>
      <div id="imageprofil" style=" margin-bottom: 10px;"> {{ Html::image($currentuser->picture_path,'', array('class'=>'imageprofil')) }}</div>

   <?php
   if (Session::get('status'))
   {
	   echo '<div class="alert '.Session::get('class').'">';
	   echo Session::get('status');
	   echo '</div>';
   }
  ?>    
  <div class="jumbotron">
  	<h3>Modifier mon image de profil</h3>
		{{ Form::open(array('url' => 'storeimage','method'=>'POST','class' => 'form-group', 'files'=> true)) }}		    
			   <label class="custom-file">
    {{Form::file('image',['class' => 'custom-file-input'])}}
    <span class="custom-file-control">Ajouter une image</span>
			<br>
      <br>
	  		{{ Form::submit('Modifier',['class' => 'btn btn-primary']) }}
		{{ Form::close() }}
  </div>

	<div class="jumbotron">
	 	<h3>Modifier mon mot de passe</h3>

		{{ Form::open(array('url' => 'modifypassword','method'=>'POST','class' => 'form-group', 'files'=> true)) }}	       
		    
		    {{ Form::password('old_password',['class' => 'form-control', 'placeholder'=>'Ancien mot de passe']) }}
		    <br>
		    
		    {{ Form::password('new_password',['class' => 'form-control', 'placeholder'=>'Nouveau mot de passe']) }}
		    {{ Form::password('new_password_confirm',['class' => 'form-control', 'placeholder'=>'Confirmation du nouveau mot de passe']) }}
		    <br>	    
		    {{ Form::submit('Modifier',['class' => 'btn btn-primary']) }}
		{{ Form::close()}}
  	</div>

  	<div class="jumbotron">
  		<h3>Modifier mon email</h3>
  		{{ Form::open(array('url' => 'modifyemail','method'=>'POST','class' => 'form-group', 'files'=> true)) }}
  		<br>
  		{{ Form::Text('email',$currentuser->email,['class' => 'form-control','placeholder' => 'Inscrivez votre nouvel email']) }}
  		<br>
  		{{ Form::submit('Modifier',['class' => 'btn btn-primary']) }}
  		{{Form::close()}}


  	</div>

</div>

@endsection


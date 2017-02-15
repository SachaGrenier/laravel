<?php
//uses home controller
use App\Http\Controllers\HomeController;

$currentuser = HomeController::getUser();

?>

@extends('layouts.default')

@section('title', 'Paramètres')

@section('content')

<div class="container">

      <div id="imageprofil"> {{ Html::image($currentuser->picture_path,'', array('class'=>'imageprofil')) }}</div>
      <br>
  <div class="form-group">
	{{ Form::open(array('url' => 'storeimage','method'=>'POST','class' => 'form-group', 'files'=> true)) }}

	    {{ Form::label('Modifier son image de profil : ','') }}
		{{ Form::file('image') }}

  		{{ Form::submit('Modifier',['class' => 'btn btn-primary']) }}

	{{ Form::close() }}

	

  </div>

	<div class="jumbotron" id="password-form" >
	 	<h3>Modifier son mot de passe</h3>

		{{ Form::open(array('url' => 'modifypassword','method'=>'POST','class' => 'form-group', 'files'=> true)) }}
	       
		    {{ Form::label('Ancien mot de passe', '') }}
		    {{ Form::password('oldPassword',['class' => 'form-control', 'placeholder'=>'Password']) }}

		    <br>

		    {{ Form::label('Nouveau mot de passe', '') }}
		    {{ Form::password('newPassword1',['class' => 'form-control', 'placeholder'=>'Password']) }}
		    {{ Form::password('newPassword2',['class' => 'form-control', 'placeholder'=>'Password']) }}

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


<?php 

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\HomeController;

$user = AdminController::getUser($id);
$sectors = TicketController::getSectors();
$titles = HomeController::getTitles();


?>

@extends('layouts.default')

@section('title', 'Utilisateur')

@section('content') 

<div class="container">
		<br>
		<a href="{{route('admin')}}"><button class="btn btn-secondary">< Retour aux utilisateurs</button></a>

	    <h1  class="text-center" style=" margin-top: 10px;">{{ $user->first_name}} {{$user->last_name }}</h1>
	    <div id="imageprofil" style=" margin-bottom: 10px;"> {{ Html::image($user->picture_path,'', array('class'=>'imageprofil')) }}</div>
		{{ Form::open(array('url' => 'updateuser','method'=>'POST','class' => 'form-group'))}}
		<div class="form-group">
			    {{ Form::label('Prénom', '') }}
				{{ Form::Text('first_name',$user->first_name,['class' => 'form-control']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Nom', '') }}
				{{ Form::Text('last_name',$user->last_name,['class' => 'form-control']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Email', '') }}
				{{ Form::Text('email',$user->email,['class' => 'form-control']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Nom d\'utilisateur', '') }}
				{{ Form::Text('login',$user->login,['class' => 'form-control']) }}
		</div>
		<div class="form-check">
		        {{ Form::label('', '',['class' => 'form-check-label'])}}
		        {{ Form::checkbox('admin',true,$user->type,['class' => 'form-check-input']) }}
		        Administrateur
		</div>
		 <div class="form-group">
		     {{ Form::label('Secteur', '') }}
			    <select class="form-control" name="sector_id">
			      <option value="">Aucun</option>
			      <?php
			      	foreach ($sectors as $sector)
			      	 {
			      		echo '<option value="'.$sector->id.'" ';
			      		if(isset($user->sector_id))
			      			echo $user->sector->id == $sector->id ? "selected" : "" ;
				  		
			      		echo '>'.$sector->name.'</option>';
			      	}

			       ?>
			    </select>
		  	</div>
		  	<div class="form-group">
		     {{ Form::label('Rôle', '') }}
			    <select class="form-control" name="title_id">
			      <option value="">Aucun</option>
			      <?php
			      	foreach ($titles as $title)
			      	{
			      		echo '<option value="'.$title->id.'" ';
			      		if(isset($user->title_id))
			      			echo $user->title->id == $title->id ? "selected" : "" ;
				  		
			      		echo '>'.$title->name.'</option>';
			      	}
			       ?>
			    </select>
		  	</div>
				{{ Form::hidden('id',$user->id) }}

		  	{{ Form::submit('Modifier',['class' => 'btn btn-primary']) }}
		{{ Form::close() }}

		  	{{ Form::submit('Réinitialiser le mot de passe',['class' => 'btn btn-danger']) }}


</div>
@endsection

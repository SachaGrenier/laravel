<?php

use App\Http\Controllers\HomeController;

$sectors =  HomeController::getSectors();

$titles =  HomeController::getTitles();

?>

@extends('layouts.default')

@section('title', 'Administration')
 
@section('content')  

<div class="container">

<br>
<h1>Ajouter un utilisateur</h1>

{{ Form::open(array('url' => 'storeuser','method'=>'POST','class' => 'form-group')) }}

    <div class="form-group">
	    {{ Form::label('Nom*', '') }}
	    {{ Form::Text('first_name','',['class' => 'form-control form-control']) }}
	</div>

	<div class="form-group">
	    {{ Form::label('Prénom*', '') }}
	    {{ Form::Text('last_name','',['class' => 'form-control form-control']) }}
	</div>

	<div class="form-group">
	    {{ Form::label('Username*', '') }}
	    {{ Form::Text('username','',['class' => 'form-control form-control']) }}
	</div>


	<div class="form-group">
	    {{ Form::label('Email', '') }}
	    {{ Form::Text('email','',['class' => 'form-control form-control']) }}
	</div>
 	
 	<div class="form-check">
        {{ Form::label('', '',['class' => 'form-check-label'])}}
        {{ Form::checkbox('admin',true,false,['class' => 'form-check-input']) }}
          Administrateur
    </div>

    <div class="form-group">
     {{ Form::label('Secteur', '') }}
	    <select class="form-control" name="sector_id">
	      <option value="">Aucun</option>
	      <?php
	      	foreach ($sectors as $sector)
	      	 {
	      		echo '<option value="'.$sector->id.'">'.$sector->name.'</option>';
	      	}

	       ?>
	    </select>
  	</div>

  	    <div class="form-group">
     {{ Form::label('Fonction', '') }}
	    <select class="form-control" name="title_id">
	      <option value="">Aucun</option>
	      <?php
	      	foreach ($titles as $title)
	      	 {
	      		echo '<option value="'.$title->id.'">'.$title->name.'</option>';
	      	}

	       ?>
	    </select>
  	</div>

  	{{ Form::submit('Créer',['class' => 'btn btn-primary']) }}

{{ Form::close() }}
</div>
@endsection
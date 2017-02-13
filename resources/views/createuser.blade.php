<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

$sectors =  HomeController::getSectors();

$titles =  HomeController::getTitles();

$users = AdminController::getUsers();

?>

@extends('layouts.default')

@section('title', 'Administration')
 
@section('content')  



<div class="container">

<table class="table table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Username</th>
      <th>Rôle</th>
      <th>Poubelle !</th>
    </tr>
  </thead>
  <tbody>
  <?php

  	foreach ($users as $user) 
  	{
		echo '<tr>';
	    echo '<th scope="row">'.$user->id.'</th>';
	    echo '<td>'.$user->first_name.'</td>';
	    echo '<td>'.$user->last_name.'</td>';
	    echo '<td>'.$user->login.'</td>';
	    echo '<td>';
	    echo  $user->type ? "Administrateur" : "Utilisateur" ;
	    echo '</td>';
	    echo '<td>';
	    echo Form::open(array('url' => 'deleteuser','method'=>'POST'));
	    echo '<button type="submit"><img style="width:40px;" src="'. asset('img/trashbin.jpg') .'"></button>';
	    echo Form::close();
	    echo '</td>';
	    echo '</tr>';
	}
    ?>
  </tbody>
</table>

<br>
<h1>Ajouter un utilisateur</h1>

{{ Form::open(array('url' => 'storeuser','method'=>'POST','class' => 'form-group')) }}
	<div class="form-group">
	    {{ Form::label('Prénom*', '') }}
	    {{ Form::Text('last_name','',['class' => 'form-control form-control','id' => 'first_name']) }}
	</div>

    <div class="form-group">
	    {{ Form::label('Nom*', '') }}
	    {{ Form::Text('first_name','',['class' => 'form-control form-control','id' => 'last_name']) }}
	</div>

	<div class="form-group">
	    {{ Form::label('Username*', '') }}
	    <p id="username"></p>
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
<script>
	$('#first_name').change(function() {
		$('#username').text($('#first_name').val()+ '_'+$('#last_name').val());
	});	

	$('#last_name').change(function() {
		$('#username').text($('#first_name').val()+ '_'+$('#last_name').val());
	});	
</script>
@endsection
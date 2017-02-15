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
<br>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="#div-user" data-toggle="tab" role="tab">Utilisateurs</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#div-sector" data-toggle="tab" role="tab">Secteurs</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#div-title" data-toggle="tab" role="tab">Rôles</a>
  </li>

</ul>
  

<div class="tab-content">
	<div id="div-user" class="tab-pane active" role="tabpanel">
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th>#</th>
		      <th>Prénom</th>
		      <th>Nom</th>
		      <th>Login</th>
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

		
		<button id="show-jumbo-user" class="btn btn-primary">Ajoutey un utilisateur mamène</button>
		<br>
		<div class="jumbotron" id="jumbo-user">
		<h3>Ajouter un utilisateur</h3>

		{{ Form::open(array('url' => 'storeuser','method'=>'POST','class' => 'form-group')) }}
			<div class="form-group">
			    {{ Form::label('Prénom*', '') }}
			    {{ Form::Text('first_name','',['class' => 'form-control form-control','id' => 'first_name']) }}
			</div>

		    <div class="form-group">
			    {{ Form::label('Nom*', '') }}
			    {{ Form::Text('last_name','',['class' => 'form-control form-control','id' => 'last_name']) }}
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
		     {{ Form::label('Rôle', '') }}
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

		<br>
		<br>

	</div>
	
	  
	<div id="div-sector" class="tab-pane" role="tabpanel">
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th>#</th>
		      <th>Secteur</th>
		      <th>Poubelle !</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php

		  	foreach ($sectors as $sector) 
		  	{
				echo '<tr>';
			    echo '<th scope="row">'.$sector->id.'</th>';
			    echo '<td>'.$sector->name.'</td>';
			    echo '<td>';
			    echo Form::open(array('url' => 'deletesector','method'=>'POST'));
			    echo '<button type="submit"><img style="width:40px;" src="'. asset('img/trashbin.jpg') .'"></button>';
			    echo Form::close();
			    echo '</td>';
			    echo '</tr>';
			}
		    ?>
		  </tbody>
		</table>
		<button id="show-jumbo-sector" class="btn btn-primary">Ajoutey un secteur mamène</button>
		<div class="jumbotron" id="jumbo-sector">

			<h3>Ajouter un secteur</h3>
			{{ Form::open(array('url' => 'storeuser','method'=>'POST','class' => 'form-group')) }}
				<div class="form-group">
				    {{ Form::label('Nom', '') }}
				    {{ Form::Text('name','',['class' => 'form-control form-control']) }}
				</div>
		  	{{ Form::submit('Créer',['class' => 'btn btn-primary']) }}

			{{ Form::close() }}


		</div>
		
		
	  	</div>
	  	<div id="div-title" class="tab-pane" role="tabpanel">
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th>#</th>
		      <th>Rôles</th>
		      <th>Poubelle !</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php

		  	foreach ($titles as $title) 
		  	{
				echo '<tr>';
			    echo '<th scope="row">'.$title->id.'</th>';
			    echo '<td>'.$title->name.'</td>';
			    echo '<td>';
			    echo Form::open(array('url' => 'deletesector','method'=>'POST'));
			    echo '<button type="submit"><img style="width:40px;" src="'. asset('img/trashbin.jpg') .'"></button>';
			    echo Form::close();
			    echo '</td>';
			    echo '</tr>';
			}
		    ?>
		  </tbody>
		</table>
		<button id="show-jumbo-title" class="btn btn-primary">Ajoutey un rôle mamène</button>
		<div class="jumbotron" id="jumbo-title">

			<h3>Ajouter un secteur</h3>
			{{ Form::open(array('url' => 'storeuser','method'=>'POST','class' => 'form-group')) }}
				<div class="form-group">
				    {{ Form::label('Nom', '') }}
				    {{ Form::Text('name','',['class' => 'form-control form-control']) }}
				</div>
		  	{{ Form::submit('Créer',['class' => 'btn btn-primary']) }}

			{{ Form::close() }}


		</div>
	</div>
</div>
<script>
$(document ).ready(function() {
	$('#jumbo-user').hide();
	$('#jumbo-sector').hide();
	$('#jumbo-title').hide();

});


	$('#first_name').change(function() {
		$('#username').text($('#first_name').val()+ '_'+$('#last_name').val());
	});	

	$('#last_name').change(function() {
		$('#username').text($('#first_name').val()+ '_'+$('#last_name').val());
	});	

	$('#show-jumbo-user').click(function() {
		$('#jumbo-user').toggle(200);
	});
	$('#show-jumbo-sector').click(function() {
		$('#jumbo-sector').toggle(200);
	});
	$('#show-jumbo-title').click(function() {
		$('#jumbo-title').toggle(200);
	});
</script>
@endsection
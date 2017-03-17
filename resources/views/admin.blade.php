<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

$currentuser = HomeController::getUser();

//check if logged user is admin
if(!$currentuser->type)
	return redirect('/');

$sectors  =   HomeController::getSectors();
$titles   =   HomeController::getTitles();
$users 	  =   AdminController::getUsers(); 

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
  <br>
  <?php
  	   	//bar to show information if needed
	   	if (Session::get('status'))
	   	{
		   echo '<div class="alert '.Session::get('class').'">';
		   echo Session::get('status');
		   echo '</div>';
	   	}
  ?>  

<div class="tab-content">
	<div id="div-user" class="tab-pane active" role="tabpanel">
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th>#</th>
		      <th></th>
		      <th>Prénom</th>
		      <th>Nom</th>
		      <th>Login</th>
		      <th>Droits</th>
		      <th>Rôle</th>
		      <th>Secteur</th>
		      <th>Modifier</th>
		      <th>Supprimer !</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php
		  	//put all the users into the table
		  	foreach ($users as $user) 
		  	{

				echo '<tr>';
			    echo '<th scope="row">'.$user->id.'</th>';
			    echo '<td><img class="table-profile-picture" src="'.$user->picture_path.'"></td>';
			    echo '<td>'.$user->first_name.'</td>';
			    echo '<td>'.$user->last_name.'</td>';
			    echo '<td>'.$user->login.'</td>';
			    echo '<td>';
			    echo  $user->type ? "Administrateur" : "Utilisateur" ;
			    echo '</td>';
			    echo '<td>'.$user->title->name.'</td>';
			    echo '<td>';
			    echo  isset($user->sector) ? $user->sector->name : "Aucun" ;
			    echo '</td>';		
			    echo '<td><a href="edituser/'.$user->id.'">Modifier</a></td>';	    
			    echo '<td>';
			    //used to prevent self destruct
			    if($user->id != session('id'))
			    {
				    echo Form::open(array('url' => 'deleteuser','method'=>'POST', 'class' => 'delete_user'));
				    echo Form::hidden('id', $user->id);
				    echo '<button class="btn btn-secondary" type="submit"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
				    echo Form::close();
				}
			    echo '</td>';
			    echo '</tr>';
			}

		    ?>
		  	</tbody>
			</table>

		
			<button id="show-jumbo-user" class="btn btn-primary">Ajouter un utilisateur</button>
			
			<div class="jumbotron jumbotron-form" id="jumbo-user">
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
			     {{ Form::label('Rôle*', '') }}
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
		      <th>Supprimer !</th>
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
			    echo Form::open(array('url' => 'deletesector','method'=>'POST', 'class' => 'delete_sector'));
			    echo Form::hidden('id', $sector->id);
			    echo '<button type="submit" class="btn btn-secondary"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
			    echo Form::close();
			    echo '</td>';
			    echo '</tr>';
			}
		    ?>
		  </tbody>
		</table>
		<button id="show-jumbo-sector" class="btn btn-primary">Ajouter un secteur</button>
		<div class="jumbotron jumbotron-form" id="jumbo-sector">

			<h3>Ajouter un secteur</h3>
			{{ Form::open(array('url' => 'storesector','method'=>'POST','class' => 'form-group')) }}
				<div class="form-group">
				    {{ Form::label('Nom', '') }}
				    {{ Form::Text('name','',['class' => 'form-control form-control','id' => 'sector_name']) }}
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
		      <th>Supprimer !</th>
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
			    echo Form::open(array('url' => 'deletetitle','method'=>'POST', 'class' => 'delete_title'));
			    echo Form::hidden('id', $title->id);
			    echo '<button type="submit" class="btn btn-secondary"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
			    echo Form::close();
			    echo '</td>';
			    echo '</tr>';
			}
		    ?>
		  </tbody>
		</table>
		<button id="show-jumbo-title" class="btn btn-primary">Ajouter un rôle</button>
		<div class="jumbotron jumbotron-form" id="jumbo-title">

			<h3>Ajouter un rôle</h3>
			{{ Form::open(array('url' => 'storetitle','method'=>'POST','class' => 'form-group')) }}
				<div class="form-group">
				    {{ Form::label('Nom', '') }}
				    {{ Form::Text('name','',['class' => 'form-control form-control','id' => 'title_name']) }}
				</div>
		  	{{ Form::submit('Créer',['class' => 'btn btn-primary']) }}

			{{ Form::close() }}
			
		</div>
	</div>
</div>
</div>


<script>
$(document ).ready(function() {
	$('#jumbo-user').hide();
	$('#jumbo-sector').hide();
	$('#jumbo-title').hide();

});

//show login with firstname_lastname 
$('#first_name').change(function() {
	$('#username').text($('#first_name').val().toLowerCase() + '_'+ $('#last_name').val().toLowerCase());
});	

$('#last_name').change(function() {
	$('#username').text($('#first_name').val().toLowerCase() + '_'+ $('#last_name').val().toLowerCase());
});	

$('#show-jumbo-user').click(function() {
	$('#jumbo-user').toggle(200);
	$('#first_name').focus();
});
$('#show-jumbo-sector').click(function() {
	$('#jumbo-sector').toggle(200);
	$('#sector_name').focus();

});
$('#show-jumbo-title').click(function() {
	$('#jumbo-title').toggle(200);
	$('#title_name').focus();

});
//check if user really wants to delete the user 
$('.delete_user').submit(function() {
	var result = prompt("Ecrire 'OK' si vous êtes sur ");
	if(result == "OK")
	{
		return confirm('Attention ! Cet utilisateur va être supprimé');
	}
	else
	{
		return false;
	}
});
$('.delete_sector').submit(function() {
		return confirm('Attention ! Ce secteur va être supprimé');
});
$('.delete_title').submit(function() {
		return confirm('Attention ! Ce rôle va être supprimé');
});

</script>
@endsection
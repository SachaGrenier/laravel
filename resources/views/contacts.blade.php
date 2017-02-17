<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

$sectors =  HomeController::getSectors();

$titles =  HomeController::getTitles();

$users = AdminController::getUsers();

$contacts = HomeController::getContacts();

$compagnies = HomeController::getCompanies();

?>

@extends('layouts.default')

@section('title', 'Prestataires')

@section('content')

<div class="container">
<br>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="#div-contact" data-toggle="tab" role="tab">Contacts</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#div-enterprise" data-toggle="tab" role="tab">Enteprises</a>
  </li>
</ul>
  

<div class="tab-content">
	<div id="div-contact" class="tab-pane active" role="tabpanel">
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th>#</th>
		      
		      <th>Prénom</th>
		      <th>Nom</th>
		      <th>Téléphone</th>
		      <th>Email</th>
		      <th>Entreprise</th>
		      <th>Poubelle !</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php

		  	foreach ($contacts as $contact) 
		  	{
				echo '<tr>';
			    echo '<th scope="row">'.$contact->id.'</th>';			    
			    echo '<td>'.$contact->first_name.'</td>';
			    echo '<td>'.$contact->last_name.'</td>';
			    echo '<td>'.$contact->phone_number.'</td>';
			    echo '<td>'.$contact->email.'</td>'; 
			    echo '<td>'.$contact->email.'</td>';
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
		      <th>Entreprise</th>
		      <th>Poubelle !</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php

		  	foreach ($compagnies as $compagny) 
		  	{
				echo '<tr>';
			    echo '<th scope="row">'.$compagny->id.'</th>';
			    echo '<td>'.$compagny->name.'</td>';
			    echo '<td>';
			    echo Form::open(array('url' => 'deletesector','method'=>'POST'));
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
				    {{ Form::Text('name','',['class' => 'form-control form-control']) }}
				</div>
		  	{{ Form::submit('Créer',['class' => 'btn btn-primary']) }}

			{{ Form::close() }}

		</div>
	</div>
	</div>
</div>

@endsection
  
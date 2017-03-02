<?php

use App\Http\Controllers\ContactController;

$contacts = ContactController::getContacts();

$companies = ContactController::getCompanies();

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
  <br>
    <?php
		   if (Session::get('status'))
		   {
			   echo '<div class="alert '.Session::get('class').'">';
			   echo Session::get('status');
			   echo '</div>';
		   }
		  ?>
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
		      <th>Modifier</th>      
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
			    echo '<td>'.$contact->company->name.'</td>';
			    echo '<td><a href="/editcontact/'.$contact->id.'">Modifier</a></td>';
			   	echo '<td>';
			    echo Form::open(array('url' => 'deletecontact','method'=>'POST'));
			    echo Form::hidden('id', $contact->id);
			    echo '<button type="submit" class="btn btn-secondary"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
			    echo Form::close();
			    echo '</td>';
			    echo '</tr>';
			}

		    ?>
		  </tbody>
		</table>

		<button id="show-jumbo-contact" class="btn btn-primary">Ajouter un contact</button>
		<div class="jumbotron jumbotron-form" id="jumbo-contact">
		<h3>Ajouter un contact</h3>
		{{ Form::open(array('url'=>'storecontact' , 'method'=>'POST' , 'class'=>'form-group', 'files'=> true))}}

		<div class="form-group">
			    {{ Form::label('Nom*', '') }}
			    {{ Form::Text('last_name','',['class' => 'form-control form-control','id' => 'last_name']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Prénom*', '') }}
			    {{ Form::Text('first_name','',['class' => 'form-control form-control','id' => 'First_name']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Téléphone*', '') }}
			    {{ Form::Text('phone_number','',['class' => 'form-control form-control','id' => 'Phone_number' , 'placeholder' => 'Ex: 0217918384']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Email*', '') }}
			    {{ Form::Text('email','',['class' => 'form-control form-control','id' => 'Email']) }}
		</div>
		<div class="form-group">
		     {{ Form::label('Entreprise', '') }}
			    <select class="form-control" name="company_id">
			      <option value="">Aucun</option>
			      <?php
			      	foreach ($companies as $company)
			      	 {
			      		echo '<option value="'.$company->id.'">'.$company->name.'</option>';
			      	}

			       ?>
			    </select>
		 </div>


		{{ Form::submit('Créer',['class' => 'btn btn-primary']) }}
		{{Form::close()}}
		</div>
</div>
		  
<div id="div-enterprise" class="tab-pane" role="tabpanel">
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th>#</th>
		      <th>Logo</th>
		      <th>Entreprise</th>
		      <th>Téléphone</th>
		      <th>Poubelle !</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php
		  	foreach ($companies as $company) 
		  	{
				echo '<tr>';
			    echo '<th scope="row">'.$company->id.'</th>';
			    echo '<td><img class="table-profile-picture" src="'.$company->logo_path.'"></td>';
			    echo '<td>'.$company->name.'</td>';
			    echo '<td>'.$company->phone_number.'</td>';
			    echo '<td>';
	     	    echo Form::open(array('url' => 'deletecompany','method'=>'POST'));
			    echo Form::hidden('id', $company->id);
			    echo '<button type="submit" class="btn btn-secondary"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
			    echo Form::close();
			    echo '</td>';
			    echo '</tr>';
			}
		    ?>
		  </tbody>
		</table>

		<button id="show-jumbo-enterprise" class="btn btn-primary">Ajouter une entreprise</button>
		<div class="jumbotron jumbotron-form" id="jumbo-enterprise">
		<h3>Ajouter une entreprise</h3>
		{{ Form::open(array('url'=>'storecompany' , 'method'=>'POST' , 'class'=>'form-group', 'files'=> true))}}

		<div class="form-group">
			    {{ Form::label('Nom*', '') }}
			    {{ Form::Text('name','',['class' => 'form-control form-control','id' => 'last_name']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Site web*', '') }}
			    {{ Form::Text('website','',['class' => 'form-control form-control','id' => 'last_name' , 'placeholder' => 'Ex: www.exemple.com']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Téléphone*', '') }}
			    {{ Form::Text('phone_number','',['class' => 'form-control form-control','id' => 'Phone_number' , 'placeholder' => 'Ex: 0217918384']) }}
		</div>
		<div class="form-group">
			<label class="custom-file">
    		{{Form::file('image',['class' => 'custom-file-input'])}}
    		<span class="custom-file-control">Ajouter le logo de l'entreprise</span>
		</div>
		{{ Form::submit('Créer',['class' => 'btn btn-primary']) }}
		{{Form::close()}}
		</div>
</div>	
</div>
</div>
<script>
$(document ).ready(function() {
	$('#jumbo-enterprise').hide();
	$('#jumbo-contact').hide();
});
	$('#show-jumbo-enterprise').click(function() {
		$('#jumbo-enterprise').toggle(200);
	});
	$('#show-jumbo-contact').click(function() {
		$('#jumbo-contact').toggle(200);
	});
</script>
@endsection
  
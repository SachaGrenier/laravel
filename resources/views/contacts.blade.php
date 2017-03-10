<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\TicketController;


$contacts 	= 	ContactController::getContacts();
$companies 	= 	ContactController::getCompanies();
$applicants = 	ContactController::getApplicants();

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
  <li class="nav-item">
    <a class="nav-link" href="#div-applicant" data-toggle="tab" role="tab">Demandeurs</a>
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
		      <th>Supprimer !</th>
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
			    echo Form::open(array('url' => 'deletecontact','method'=>'POST','class' => 'delete_contact'));
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
			    {{ Form::Text('last_name','',['class' => 'form-control form-control', 'id' => 'last_name']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Prénom*', '') }}
			    {{ Form::Text('first_name','',['class' => 'form-control form-control']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Téléphone*', '') }}
			    {{ Form::Text('phone_number','',['class' => 'form-control form-control', 'placeholder' => 'Ex: 0217918384']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Email*', '') }}
			    {{ Form::Text('email','',['class' => 'form-control form-control']) }}
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
		      <th>Site web</th>
		       <th>Modifier</th>  
		      <th>Supprimer !</th>
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
			    echo '<td>'.$company->website.'</td>';
			    echo '<td><a href="/editcompany/'.$company->id.'">Modifier</a></td>';
			    echo '<td>';
	     	    echo Form::open(array('url' => 'deletecompany','method'=>'POST','class' => 'delete_company'));
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
			    {{ Form::Text('name','',['class' => 'form-control form-control','id' => 'company_name']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Site web*', '') }}
			    {{ Form::Text('website','',['class' => 'form-control form-control', 'placeholder' => 'Ex: www.exemple.com']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Téléphone*', '') }}
			    {{ Form::Text('phone_number','',['class' => 'form-control form-control', 'placeholder' => 'Ex: 0217918384']) }}
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
	<div id="div-applicant" class="tab-pane" role="tabpanel">
			<table class="table table-hover">
			  <thead>
			    <tr>
			      <th>#</th>		      
			      <th>Prénom</th>
			      <th>Nom</th>
			      <th>Email</th>
			      <th>Téléphone</th>
			      <th>Tickets ouverts</th>
			      <th>Modifier</th>
			    </tr>
			  </thead>
			  <tbody>
			  <?php

			  	foreach ($applicants as $applicant) 
			  	{
			  		$tickets = TicketController::getTicketsFromApplicant($applicant->id);
					echo '<tr>';
				    echo '<th scope="row">'.$applicant->id.'</th>';
				    echo '<td>'.$applicant->first_name.'</td>';
				    echo '<td>'.$applicant->last_name.'</td>';
				    echo '<td>'.$applicant->email.'</td>';
				    echo '<td>'.$applicant->phone_number.'</td>';
				    echo '<td>';
				    foreach ($tickets as $key => $value) 
				    {    	
					    echo '<a href="ticket/'.$value->id.'" title="'.$value->title.'">'.$value->id.'</a>';
					    echo count($tickets) == $key+1 ? "" : ",";
				    }
				    echo '</td>';

				    echo '<td><a href="editapplicant/'.$applicant->id.'">Modifier</a></td>';  

				    echo '</tr>';
				}
			    ?>
			  </tbody>
			</table>
		<button id="show-jumbo-applicant" class="btn btn-primary">Ajouter un demandeur</button>
		<div class="jumbotron jumbotron-form" id="jumbo-applicant">
		<h3>Ajouter un demandeur</h3>
		{{ Form::open(array('url'=>'storeapplicant' , 'method'=>'POST' , 'class'=>'form-group', 'files'=> true))}}

		<div class="form-group">
			    {{ Form::label('Nom*', '') }}
			    {{ Form::Text('last_name','',['class' => 'form-control form-control','id' => 'applicant_last_name']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Prénom', '') }}
			    {{ Form::Text('first_name','',['class' => 'form-control form-control']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Téléphone*', '') }}
			    {{ Form::Text('phone_number','',['class' => 'form-control form-control', 'placeholder' => 'Ex: 0217918384']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Email*', '') }}
			    {{ Form::Text('email','',['class' => 'form-control form-control']) }}
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
	$('#jumbo-applicant').hide();
});
	$('#show-jumbo-enterprise').click(function() {
		$('#jumbo-enterprise').toggle(200);
		$('#company_name').focus();

	});
	$('#show-jumbo-contact').click(function() {
		$('#jumbo-contact').toggle(200);
		$('#last_name').focus();
	});
	$('#show-jumbo-applicant').click(function() {
		$('#jumbo-applicant').toggle(200);
		$('#applicant_last_name').focus();

	});
	$('.delete_contact').submit(function() {
			return confirm('Attention ! Ce contact va être supprimé');
	});
	$('.delete_company').submit(function() {
			return confirm('Attention ! Cette entreprise va être supprimé');
	});
</script>
@endsection
  
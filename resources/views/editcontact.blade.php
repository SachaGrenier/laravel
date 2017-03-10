<?php 

use App\Http\Controllers\ContactController;

$contact 	= ContactController::getContact($id);
$companies 	= ContactController::getCompanies();



?>

@extends('layouts.default')

@section('title', 'Contact')

@section('content') 

<div class="container">
		<br>
		<a href="{{route('contact')}}"><button class="btn btn-secondary">< Retour aux contacts</button></a>

	    <h1  class="text-center" style=" margin-top: 10px;">{{ $contact->first_name}} {{$contact->last_name }}</h1>
		<?php
		   if (Session::get('status'))
		   {
			   echo '<div class="alert '.Session::get('class').'">';
			   echo Session::get('status');
			   echo '</div>';
		   }
		  ?>  
		{{ Form::open(array('url' => 'updatecontact','method'=>'POST','class' => 'form-group'))}}
		<div class="form-group">
			    {{ Form::label('Prénom', '') }}
				{{ Form::Text('first_name',$contact->first_name,['class' => 'form-control']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Nom', '') }}
				{{ Form::Text('last_name',$contact->last_name,['class' => 'form-control']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Téléphone', '') }}
				{{ Form::Text('phone_number',$contact->phone_number,['class' => 'form-control','placeholder'=>'Ex : 0798654321']) }}
		</div>
		<div class="form-group">
			    {{ Form::label('Email', '') }}
				{{ Form::Text('email',$contact->email,['class' => 'form-control']) }}
		</div>
		<div class="form-group">
		     {{ Form::label('Entreprise', '') }}
			    <select class="form-control" name="company_id">
			      <option value="">Aucun</option>
			      <?php
			      	foreach ($companies as $company)
			      	 {
			      		echo '<option value="'.$company->id.'" ';
			      		if(isset($contact->company))
			      			echo $contact->company->id == $company->id ? "selected" : "" ;
				  		
			      		echo '>'.$company->name.'</option>';
			      	}

			       ?>
			    </select>
		  </div>
		  	
				{{ Form::hidden('id',$contact->id) }}

		  	{{ Form::submit('Modifier',['class' => 'btn btn-primary']) }}
		{{ Form::close() }}
</div>
@endsection
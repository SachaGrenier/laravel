<?php 

use App\Http\Controllers\ContactController;

$applicant = ContactController::getApplicant($id);

?>

@extends('layouts.default')

@section('title', 'Applicant')

@section('content') 

<div class="container">
		<br>
		<a href="{{route('admin')}}"><button class="btn btn-secondary">< Retour aux demandeurs</button></a>

	    <h1  class="text-center" style=" margin-top: 10px;">{{$applicant->name}}</h1>
	    
		<?php
		   if (Session::get('status'))
		   {
			   echo '<div class="alert '.Session::get('class').'">';
			   echo Session::get('status');
			   echo '</div>';
		   }
		  ?>  
		{{ Form::open(array('url' => 'updateapplicant','method'=>'POST','class' => 'form-group'))}}
		<div class="form-group">
			    {{ Form::label('Prénom', '') }}
				{{ Form::Text('first_name',$applicant->first_name,['class' => 'form-control']) }}
		</div>

		<div class="form-group">
			    {{ Form::label('Nom', '') }}
				{{ Form::Text('last_name',$applicant->last_name,['class' => 'form-control']) }}
		</div>

		<div class="form-group">
			    {{ Form::label('Téléphone', '') }}
				{{ Form::Text('phone_number',$applicant->phone_number,['class' => 'form-control','placeholder'=>'Ex : 0798654321']) }}
		</div>

		<div class="form-group">
			    {{ Form::label('Email', '') }}
				{{ Form::Text('website',$applicant->email,['class' => 'form-control']) }}
		</div>
		  	
				{{ Form::hidden('id',$applicant->id) }}

		  	{{ Form::submit('Modifier',['class' => 'btn btn-primary']) }}
		{{ Form::close() }}
</div>
@endsection
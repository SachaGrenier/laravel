<?php 

use App\Http\Controllers\ContactController;

$company = ContactController::getCompany($id);
?>

@extends('layouts.default')

@section('title', 'Contact')

@section('content') 

<div class="container">
	<br>
	<a href="{{route('contact')}}"><button class="btn btn-secondary">< Retour aux contacts</button></a>

    <h1  class="text-center" style=" margin-top: 10px;">{{$company->name}}</h1>
    <div id="imageprofil" style=" margin-bottom: 10px;"> {{ Html::image($company->logo_path,'', array('class'=>'imageprofil')) }}</div>
	<?php
	   if (Session::get('status'))
	   {
		   echo '<div class="alert '.Session::get('class').'">';
		   echo Session::get('status');
		   echo '</div>';
	   }
	  ?>  
	<div class="jumbotron">
			<h3>Modifier le logo</h3>
		{{ Form::open(array('url' => 'updatelogo','method'=>'POST','class' => 'form-group', 'files'=> true)) }}		    
		<label class="custom-file">
		{{Form::file('image',['class' => 'custom-file-input'])}}
		<span class="custom-file-control">Ajouter une image</span>
		<br>
  		<br>
		{{ Form::hidden('id',$company->id) }}

  		{{ Form::submit('Modifier',['class' => 'btn btn-primary']) }}

		{{ Form::close() }}
	</div>
	{{ Form::open(array('url' => 'updatecompany','method'=>'POST','class' => 'form-group'))}}
	<div class="form-group">
		    {{ Form::label('Nom', '') }}
			{{ Form::Text('name',$company->name,['class' => 'form-control']) }}
	</div>

	<div class="form-group">
		    {{ Form::label('Téléphone', '') }}
			{{ Form::Text('phone_number',$company->phone_number,['class' => 'form-control','placeholder'=>'Ex : 0798654321']) }}
	</div>

	<div class="form-group">
		    {{ Form::label('Site web', '') }}
			{{ Form::Text('website',$company->website,['class' => 'form-control']) }}
	</div>
	  	
			{{ Form::hidden('id',$company->id) }}

	  	{{ Form::submit('Modifier',['class' => 'btn btn-primary']) }}
	{{ Form::close() }}
</div>
@endsection
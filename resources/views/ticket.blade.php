<?php 

use App\Http\Controllers\TicketController;

$sectors =  TicketController::getSectors();
$users =  TicketController::getUsersFromSector();
$applicants = TicketController::getApplicants();

$applicantsarray = array();
foreach ($applicants as $applicant) 
{
	array_push($applicantsarray, $applicant->first_name." ".$applicant->last_name);
}
$js_array = json_encode($applicantsarray);
?>



@extends('layouts.default')

@section('title', 'ManageTicket - Ticket')
 
@section('content')  

<div class="container">

<h1>Ajouter un ticket</h1>
<ul>
    @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</ul>
<br>
{{ Form::open(array('url' => 'storeticket','method'=>'POST','class' => 'form-group')) }}
	<div class="form-group">
	    {{ Form::label('Demandeur', '')}}

	    {{ Form::Text('applicant','',['class' => 'form-control','placeholder' => 'Inscrivez le nom de votre demandeur','id' => 'autocomplete']) }}
	    <br><small>Pas dans la liste ?</small>
 		 {{ Form::button('Ajouter un demandeur',['class' => 'btn btn-primary','id' => 'show-applicant-form']) }}
    </div>
	  
	 <div class="jumbotron" id="applicant-form" style="display: none">
	 <h3>Ajouter un demandeur</h3>
	       <div class="form-group">
	    	{{ Form::label('Prénom*', '') }}
		    {{ Form::Text('first_name','',['class' => 'form-control']) }}
	    </div>
	    <div class="form-group">
	    	{{ Form::label('Nom*', '') }}
		    {{ Form::Text('last_name','',['class' => 'form-control']) }}
	    </div>
	    <div class="form-group">
	    	{{ Form::label('Email', '') }}
		    {{ Form::Text('email','',['class' => 'form-control']) }}
	    </div>
	    <div class="form-group">
	    	{{ Form::label('Numéro de téléphone', '') }}
		    {{ Form::Text('phone_number','',['class' => 'form-control']) }}
	    </div>
		{{ Form::button('Annuler',['class' => 'btn btn-secondary','id' => 'hide-applicant-form']) }}    
      </div>

    <div class="form-group">
	    {{ Form::label('Titre de la demande*', '') }}
	    {{ Form::Text('title','',['class' => 'form-control form-control-lg']) }}
    </div>
  	<div class="form-group">
        {{ Form::label('Contenu*', '')}}
	    {{ Form::textarea('content','',['class' => 'form-control']) }}
  	</div>
  	<div class="form-group">
        {{ Form::label('Ajouter des notes', '')}}
	    {{ Form::textarea('notes','',['class' => 'form-control']) }}
  	</div>
  	<div class="form-check">
	      {{ Form::label('', '',['class' => 'form-check-label'])}}
	      {{ Form::checkbox('projet',null,false,['class' => 'form-check-input']) }}
      	  Projet
  	</div>
  	<div class="form-group">
     {{ Form::label('Secteur', '') }}
    <select class="form-control" id="exampleSelect2">
      <option value="none">Aucun</option>
      <?php
      	foreach ($sectors as $sector)
      	 {
      		echo '<option value="'.$sector->id.'">'.$sector->name.'</option>';
      	}

       ?>
    </select>
  </div>
  <div class="form-group">
     {{ Form::label('Assigner un utilisateur', '') }}
    <select class="form-control" id="exampleSelect2">
    <option value="none">Aucun</option>
      <?php
      	foreach ($users as $user)
      	 {
      		echo '<option value="'.$user->id.'">'.$user->first_name.' '.$user->last_name.'</option>';
      	}

       ?>
    </select>
  </div>
  <div class="form-check">
	      {{ Form::label('', '',['class' => 'form-check-label'])}}
	      {{ Form::checkbox('projet',null,false,['class' => 'form-check-input','id' => 'toggle-time-limit']) }}
      	  Délai
  	</div>
  <div class="form-group" id="select-timelimit" style="display: none">
   	{{ Form::label('Définir un délai', '')}}
    {{ Form::text('time_limit','',['id' => 'datepicker', 'class' => 'form-control']) }}
  </div>
   <div class="form-group">
	  <label class="custom-file">
	  <input type="file" id="file" class="custom-file-input">
	  <span class="custom-file-control">Ajouter un fichier</span>
  	  </label>
  </div>
  
 
  {{ Form::submit('Créer',['class' => 'btn btn-primary']) }}

{{ Form::close() }}
</div>

<script type="text/javascript">

$( "#datepicker" ).datepicker();
$( "#datepicker" ).datepicker( "option", "dateFormat", "dd/mm/yy" );


<?php echo "var javascript_array = ". $js_array . ";\n"; ?>



$('#autocomplete').autocomplete({ source: javascript_array});

$("#show-applicant-form").click(function(){ $("#applicant-form").show(200); });
$("#hide-applicant-form").click(function(){ $("#applicant-form").hide(200); });

$("#toggle-time-limit").click(function(){ $("#select-timelimit").toggle(200); });

</script>
@endsection

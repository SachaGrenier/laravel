<?php 

use App\Http\Controllers\TicketController;

$sectors =  TicketController::getSectors();
$users =  TicketController::getUsersFromSector();
$applicants = TicketController::getApplicants();

$output_array = array();

foreach ($applicants as $row) {
     $output_array[] = array( 
        'id' => $row['id'],
        'value' => $row['first_name'].' '.$row['last_name']
    );
}

// Print out JSON response
$output_array = json_encode( $output_array );




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
	<div class="form-group" id="applicant_box">
	    {{ Form::label('Demandeur', '')}}

	    {{ Form::Text('applicant','',['class' => 'form-control','placeholder' => 'Inscrivez le nom de votre demandeur','id' => 'autocomplete']) }}

      <input type="text" id="applicant_id" name="applicant_id" hidden/>
      <p id="applicant_selected" style="display: none;">Séléctionné : <span id="applicant_name"></span><span id="applicant_rem" style="text-decoration: underline;cursor: pointer" > </span></p>
	    <br><small>Pas dans la liste ?</small>
 		 {{ Form::button('Ajouter un demandeur',['class' => 'btn btn-primary','id' => 'show-applicant-form']) }}
    </div>
	  
	 <div class="jumbotron" id="applicant-form" style="display: none;">
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
    {{ Form::button('Ajouter des notes',['class' => 'btn btn-secondary','id' => 'show-note-box']) }}
  	<div class="form-group" id="note_box" style="display: none">
      {{ Form::label('Notes', '')}} 
	    <br>
      {{ Form::textarea('note','',['class' => 'form-control']) }}
  	</div>
 
  	<div class="form-group">
     {{ Form::label('Secteur', '') }}
    <select class="form-control" name="sector">
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
     {{ Form::label('Assigner un utilisateur', '') }}
    <select class="form-control" name="user_id">
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
	      {{ Form::checkbox('time_limit',true,false,['class' => 'form-check-input','id' => 'toggle-time-limit']) }}
      	  Délai
  	</div>
  <div class="form-group" id="select-timelimit" style="display: none">
   	{{ Form::label('Définir une date', '')}}
    {{ Form::text('time_limit_value','',['id' => 'datepicker', 'class' => 'form-control']) }}
  </div>
    <div class="form-check">
        {{ Form::label('', '',['class' => 'form-check-label'])}}
        {{ Form::checkbox('project',true,false,['class' => 'form-check-input']) }}
          Projet
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

//initialize date picker
$( "#datepicker" ).datepicker();
//change date picker date format
$( "#datepicker" ).datepicker( "option", "dateFormat", "dd/mm/yy" );

//set json array for autocomplete function
<?php echo "var javascript_array = ". $output_array . ";\n"; ?>

//generates autocomplete input
//set and show info bar
//set value to hidden input
$('#autocomplete').autocomplete({
   source: javascript_array,
   select: function (event, ui) {

        $("#applicant_id").val(ui.item.id);
        $("#applicant_name").text(ui.item.value+" ");
        $("#applicant_selected").show(200);
        $("#applicant_rem").text('Déséléctionner');
    },
});

$("#show-applicant-form").click(function(){
  //show add applicant form
  $("#applicant-form").show(200);
  $("#autocomplete").val('');
  $( "#applicant_rem" ).trigger( "click" );
  $("#applicant_box").hide(200);

});

$("#hide-applicant-form").click(function(){ 
  
  $("#applicant-form").hide(200);
  $("#applicant_box").show(200);
});

$("#toggle-time-limit").click(function(){

  $("#select-timelimit").toggle(200);
});

$('#applicant_rem').on('click', () => {

  //empty selected applicant name shown
 $("#applicant_name").text('');
  //empty "Déséléctionner" text
 $("#applicant_rem").text('');
  //remove applicant's id value
 $("#applicant_id").val('');
  //remove applicant's firstname and name
 $("#autocomplete").val('');
 //hide information line
 $("#applicant_selected").hide(200);
});

$("#show-note-box").click(function(){ 
   $("#note_box").toggle(200);
  });
</script>
@endsection
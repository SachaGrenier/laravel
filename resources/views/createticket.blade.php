<?php 

use App\Http\Controllers\TicketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;

$sectors    =   HomeController::getSectors();
$users      =   TicketController::getUsersFromSector();
$applicants =   TicketController::getApplicants();
$contacts   =   ContactController::getContacts();

$output_array = array();

foreach ($applicants as $row) 
{
     $output_array[] = array( 
        'id' => $row['id'],
        'value' => $row['first_name'].' '.$row['last_name']
    );
}

$output_array = json_encode( $output_array );
?>

@extends('layouts.default')

@section('title', 'ManageTicket - Ticket')
 
@section('content')  
<div class="container">

<h1>Ajouter un ticket</h1>
 <?php
   if (Session::get('status'))
   {
     echo '<div class="alert '.Session::get('class').'">';
     echo Session::get('status');
     echo '</div>';
   }

  ?>
  <div id="truc"></div>  
<br>
{{ Form::open(array('url' => 'storeticket','method'=>'POST','class' => 'form-group', 'files' => true , 'id' => 'ticket-form')) }}
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
		    {{ Form::Text('first_name','',['class' => 'form-control','id' => 'applicant_first_name']) }}
	    </div>
	    <div class="form-group">
	    	{{ Form::label('Nom*', '') }}
		    {{ Form::Text('last_name','',['class' => 'form-control','id' => 'applicant_last_name']) }}
	    </div>
	    <div class="form-group">
	    	{{ Form::label('Email', '') }}
		    {{ Form::Text('email','',['class' => 'form-control','id' => 'applicant_email']) }}
	    </div>
	    <div class="form-group">
	    	{{ Form::label('Numéro de téléphone', '') }}
		    {{ Form::Text('phone_number','',['class' => 'form-control', 'placeholder' => 'Ex: 0217918384']) }}
	    </div>
		{{ Form::button('Annuler',['class' => 'btn btn-secondary','id' => 'hide-applicant-form']) }}    
      </div>

    <div class="form-group">
	    {{ Form::label('Titre de la demande*', '') }}
	    {{ Form::Text('title','',['class' => 'form-control form-control-lg', 'id' => 'title-input']) }}
    </div>
  	<div class="form-group">
        {{ Form::label('Contenu*', '')}}
	    {{ Form::textarea('content','',['class' => 'form-control','id' => 'content']) }}
  	</div>
    {{ Form::button('Ajouter des notes',['class' => 'btn btn-secondary','id' => 'show-note-box']) }}
  	<div class="form-group" id="note_box" style="display: none">
      {{ Form::label('Notes', '')}} 
	    <br>
      {{ Form::textarea('note','',['class' => 'form-control']) }}
  	</div>
 
  	<div class="form-group">
     {{ Form::label('Secteur', '') }}
    <select class="form-control" name="sector_id" id="sector_id">
      <option value="null">Aucun</option>
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
    <select class="form-control" name="user_id" id="user_id">
    <option value="">Aucun</option>
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
    {{ Form::checkbox('project',true,false,['class' => 'form-check-input', 'id' => 'check-project']) }}
      Projet
  </div>
  <h3>Ajouter contacts prestataires </h3>
  <div class="form-group" >
  <select multiple="multiple" id="my-select" name="contacts[]">
    <?php
        foreach ($contacts as $contact)
        {
          echo '<option value="'.$contact->id.'">'.$contact->first_name.' '.$contact->last_name.' ('.$contact->company->name.')</option>';
        }
    ?>
    </select>
  </div>
  <h3>Ajouter des fichiers </h3>
  <div class="form-group" >
  	<input type='file' class="multiple-files" name="file[]" multiple>
  </div>
  
  {{Form::submit('Créer',['class' => 'btn btn-primary'])}}

{{ Form::close() }}
</div>

<script type="text/javascript">
$('#my-select').multiSelect({
    selectableHeader: "<div class='custom-header'>Liste des contacts</div>",
  selectionHeader: "<div class='custom-header'>Contacts séléctionnés</div>",
});
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
var applicant_using_form = false;
$("#show-applicant-form").click(function(){
  //show add applicant form
  $("#applicant-form").show(200);
  $("#autocomplete").val('');
  $( "#applicant_rem" ).trigger( "click" );
  $("#applicant_box").hide(200);
  applicant_using_form = true;
});

$("#hide-applicant-form").click(function(){ 
  
  $("#applicant-form").hide(200);
  $("#applicant_box").show(200);
  applicant_using_form = false;
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
  var title;

$("#check-project").change(function(){

  if ($(this).is(":checked")) {  
    title =  $("#title-input").val();
    $("#title-input").val("[PROJET] "+ title);
  }
  else{
    $("#title-input").val(title);
  }
});


var type="all";

$('#sector_id').change(function() {
  if($('#sector_id').val() == "null")
  {
      $('#user_id')
            .find('option')
            .remove()
            .end()
            .append('<option value="null">Aucun</option>');
  }
  else
  {
    type = $('#sector_id').val();    
    $.ajax({
            url: '/getusers/'+type,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                setSelect(data);
            }
        });
        function setSelect(data) 
        {
          $('#user_id')
            .find('option')
            .remove()
            .end();
            $('#user_id').append('<option value="">Aucun</option>');
            for (var i = data.length - 1; i >= 0; i--) 
            {
              $('#user_id').append($('<option>', {
                  value: data[i]['id'],
                  text: data[i]['first_name'] + ' ' + data[i]['last_name'] 
              }));
          }
        }
      }
});

$("#ticket-form").submit(function( event){
  if(title != null)
  {
      $("#title-input").val(title);
  }

  //TODO check form before submit, and cancel submit with inforamtion if there are errors
  var errors = [];
  if(!$("#title-input").val())
  {
    errors.push('Le champ "Titre de la demande" est vide.');
  }
  if(!$("#content").val())
  {
    errors.push('Le champ "Contenu" est vide.');
  }
  if(applicant_using_form)
  {
      if(!$('#applicant_first_name').val() || !$('#applicant_last_name').val())
    {
      errors.push('Formulaire demandeur non complété.');
    }
  }
  else
  {
    if(!$("#applicant_id").val())
    {
       errors.push("Demandeur non choisi.");
    }
  }
  if(errors.length > 0)
  {
    var html = '<div class="alert alert-danger">';
    for (var i =  errors.length - 1; i >= 0; i--) 
    {
        html+= errors[i]+'<br>';
    }
    html += '</div>';
    $('#truc').html(html);
    window.scrollTo(0,0);
    event.preventDefault();     
  }
  

});
</script>
@endsection

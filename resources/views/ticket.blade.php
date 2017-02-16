<?php 

use App\Http\Controllers\TicketController;


$ticket = TicketController::getTicket($id);

$applicants = TicketController::getApplicants();

$output_array = array();

foreach ($applicants as $row) {
     $output_array[] = array( 
        'id' => $row['id'],
        'value' => $row['first_name'].' '.$row['last_name']
    );
}

$output_array = json_encode( $output_array );

?>


@extends('layouts.default')

@section('title', 'Apercu')

@section('content')   

<div class="container">
<br>
<a href="{{route('index')}}"><button class="btn btn-secondary">< Retour aux tickets</button></a>
<button class="btn btn-primary" style="float:right;" id="edit-ticket">Modifier ticket</button>
<br>
<br>
	<h1 id="title">{{ $ticket->project ? "[PROJET] " : "" }}{{ $ticket->title }}</h1>
	<div class="form-group">

	{{ Form::Text('title', $ticket->title,['class' => 'form-control form-control-lg','placeholder' => 'Titre de la demande','id' => 'title-input','hidden']) }}
	</div>
	<div class="alert alert-info" id="info-applicant">
	Demandeur : {{ $ticket->applicant->first_name }} {{ $ticket->applicant->last_name }}
	
	</div>
	<div class="form-group">
	{{ Form::Text('applicant', $ticket->applicant->first_name . ' ' . $ticket->applicant->last_name,['class' => 'form-control','placeholder' => 'Inscrivez le nom de votre demandeur','id' => 'autocomplete','hidden']) }}
	</div>
	<h4>Contenu</h4>
	<div class="form-group">
	{{ Form::textarea('content',$ticket->content,['class' => 'form-control','readonly', 'id' =>'content' ]) }}
	</div>
	<h4>Notes ajoutées</h4>
	<div class="form-group">
	{{ Form::textarea('note',$ticket->note,['class' => 'form-control','readonly', 'id' =>'note' ]) }}
	</div>
	<ul class="list-group">
  <li class="list-group-item">Délai : <span id="time_limit-text">{{ Carbon\Carbon::parse($ticket->time_limit)->format('d M Y')  ?: "Aucun" }} </span>
	      <span id="time_limit-checkbox">{{ Form::checkbox('time_limit',true,false,['id' => 'toggle-time-limit']) }}</span>
      	  
  	
  
  	<span id="time_limit-input">{{ Form::text('time_limit_value','',['id' => 'datepicker', 'class' => 'form-control']) }}</span>
  </li>
  <li class="list-group-item">Projet : <span id="project-text"> {{ $ticket->project  ? "Oui" : "Non" }}</span>{{ Form::checkbox('project',true,$ticket->project,['id' => 'project']) }}</li>
  <li class="list-group-item">Crée le : {{ $ticket->created_at->format('d M Y') }}</li>
  <li class="list-group-item">Modifié le : {{ $ticket->updated_at->format('d M Y') }}</li>
  <li class="list-group-item">Archivé : {{ $ticket->archived  ? "Oui" : "Non" }}</li>
  <li class="list-group-item">Secteur : {{ $ticket->sector_id  ?  $ticket->sector->name : "Aucun" }}</li>
  <li class="list-group-item">Utilisateur assigné : {{ $ticket->user_id  ? $ticket->user->first_name . " " . $ticket->user->last_name : "Aucun" }}</li>
</ul>
<br>
  <button type="button" class="btn btn-primary" id="apply-modifications">Appliquer les modifications</button>
  <button type="button" class="btn btn-danger">Archiver</button>
  <button type="button" class="btn btn-secondary" id="cancel-modifications">Annuler les modifications</button>

</div>
<script>
//initialize date picker
$( "#datepicker" ).datepicker();
//change date picker date format
$( "#datepicker" ).datepicker( "option", "dateFormat", "dd/mm/yy" );

$(document ).ready(function() {
	$('#apply-modifications').hide();
	$('#cancel-modifications').hide();
	$('#project').hide();
	$('#time_limit-input').hide();
	$('#time_limit-checkbox').hide();
});
$('#edit-ticket').click(function(){
	$('#content').removeAttr( "readonly");
	$('#note').removeAttr( "readonly");
	$('#apply-modifications').show(100);
	$('#cancel-modifications').show(100);
	$('#autocomplete').removeAttr( "hidden");
	$('#title-input').removeAttr( "hidden");
	$('#info-applicant').hide();
	$('#title').hide();
	$('#edit-ticket').hide();
	$('#project').show(100);
	$('#project-text').hide();
	$('#toggle-time-limit').show(100);
	$('#time_limit-checkbox').show(100);
	$('#time_limit-text').hide();



});
$('#cancel-modifications').click(function() {
    location.reload();
});
$('#toggle-time-limit').click(function () {
$('#time_limit-input').toggle();
});
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
    },
});

</script>
@endsection
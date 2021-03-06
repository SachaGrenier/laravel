<?php 

use App\Http\Controllers\TicketController;
//getting all the data we need on this page
$ticket  	=	TicketController::getTicket($id);
$applicants =   TicketController::getApplicants();
$sectors 	=	TicketController::getSectors();
$users 		=	TicketController::getUsers();
$contacts 	=	TicketController::getContacts();
$files 	    =	TicketController::getFiles($id);

setLocale(LC_TIME,config('app.locale'));

//creating an empty array
$output_array = array();
//fills this empty array with applicant's names and encodes it
foreach ($applicants as $row) 
{
	 $output_array[] = array( 
    'id' => $row['id'],
    'value' => $row['first_name'].' '.$row['last_name']);
}

$output_array = json_encode($output_array);
?>

@extends('layouts.default')

@section('title', 'Apercu')

@section('content')   

<div class="container">
<br>

<a href="{{route('index')}}"><button class="btn btn-secondary">< Retour aux tickets</button></a>

<?php 
	if(!$ticket->archived)
	{
		echo '<button class="btn btn-primary" style="float:right;display:inline-block;" id="edit-ticket">Modifier ticket</button>';
	}

     echo Form::open(array('url' => 'pdfview','method'=>'POST'));
  	 echo Form::hidden('id', $ticket->id);
  	 echo '<button type="submit" class="btn btn-secondary" style="float:right;display:inline-block; margin-top:5px;"><i class="fa fa-print" aria-hidden="true"></i></button>';
  	 echo Form::close();

	if (Session::get('status'))
	{
	   echo '<br><br><div class="alert '.Session::get('class').'">';
	   echo Session::get('status');
	   echo '</div>';
	}
?>
<br>
<br>
 {{ Form::open(array('url' => 'updateticket','method'=>'POST','class' => 'form-group', 'files' => true )) }}
	<h1 id="title">{{ $ticket->archived ? "[ARCHIVE] " : "" }} {{ $ticket->project ? "[PROJET] " : "" }}{{ $ticket->title }}</h1>
	<div class="form-group">

	{{ Form::Text('title', $ticket->title,['class' => 'form-control form-control-lg','placeholder' => 'Titre de la demande','id' => 'title-input','hidden']) }}
	</div>
	<div class="alert alert-info" id="info-applicant">
	Demandeur : {{ $ticket->applicant->first_name }} {{ $ticket->applicant->last_name }}
	
	</div>
	<div class="form-group">
	{{ Form::Text('applicant', $ticket->applicant->first_name . ' ' . $ticket->applicant->last_name,['class' => 'form-control','placeholder' => 'Inscrivez le nom de votre demandeur','id' => 'autocomplete','hidden']) }}
	{{ Form::Text('applicant_id', $ticket->applicant_id,['id' => 'applicant_id','hidden']) }}

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
	  	<li class="list-group-item">Délai : <span id="time_limit-text">{{ $ticket->time_limit  ? Carbon\Carbon::parse($ticket->time_limit)->formatLocalized('%d %B %Y') : "Aucun" }} </span>
	  	<span id="time_limit-input">{{ Form::text('time_limit_value',$ticket->time_limit,['id' => 'datepicker', 'class' => 'form-control']) }}</span>
	  	</li>
	  	<li class="list-group-item">Projet : <span id="project-text"> {{ $ticket->project  ? "Oui" : "Non" }}</span>{{ Form::checkbox('project',true,$ticket->project,['id' => 'project']) }}</li> 
	  	<li class="list-group-item">Crée le : {{ $ticket->created_at->formatLocalized('%d %B %Y') }}</li>
	  	<li class="list-group-item">Modifié le : {{ $ticket->updated_at->formatLocalized('%d %B %Y') }}</li>
	  	<li class="list-group-item">Archivé :  {{ $ticket->archived  ? "Oui" : "Non" }}</li>
	  	<li class="list-group-item">Secteur : <span id="sector-text">{{ $ticket->sector_id  ?  $ticket->sector->name : "Aucun" }}</span> 
	  	<select class="form-control" name="sector_id" id="sector">
	   	<?php
	  
	  	echo '<option value="null">Aucun</option>';
	  	foreach ($sectors as $sector)
	  	{
	  		echo '<option value="'.$sector->id.'" ';
	  		if(isset($ticket->sector_id))
	  			echo $ticket->sector->id == $sector->id ? "selected" : "";
	  		
	  		echo '>'.$sector->name.'</option>';
	  	}
	   	?>
	    </select></li>
	  	<li class="list-group-item">Utilisateur assigné : <span id="user-text">{{ $ticket->user_id  ? $ticket->user->first_name . " " . $ticket->user->last_name : "Aucun" }}</span>
	  	<input id="user_id" value="{{ $ticket->user_id }}" hidden>
	  	<select class="form-control" name="user_id" id="user">
	      <option value="">Aucun</option>
	    </select></li>

	  	<?php
	
	  	
	  		echo '<li class="list-group-item">Fichiers : ';
	  		if(count($files) > 0)
	  		{
			  	echo '<div id="show-files">';

			  	foreach ($files as $key => $value) 
			  	{
				  	echo '<a class="btn btn-secondary file-list" href="../'.$value->path.'" target="_blank">Fichier' .($key+1).' .'.$value->ext.' </a></i>';
			  	}	
			  	echo '</div>';
			  	echo '<div id="delete-files">';
			  	foreach ($files as $key => $value) 
			  	{
				  	echo '<button class="btn btn-secondary" type="button" onclick="deletefile(this)" value="'.$value->id.'">Fichier' .($key+1).' .'.$value->ext.' <i class="fa fa-times-circle" aria-hidden="true"></button></i>';
			  	}
			  		  	echo '</div>';	
		  	}
		  	else
		  	{
		  		echo 'Aucun';
		  	}
		  	echo '<div class="form-group" id="add-files">
		    	  <label>Ajouter des fichiers</label><br>';
		  	echo '<input type="file" name="files[]" multiple>';
		  	echo '</div>';
		  	echo '</li>';
	  	  	 
  	 		echo '<li class="list-group-item">Contacts :  ';
 			if(count($ticket->contact) > 0)
  	 		{
	  			echo '<div id="show-contact">';

  	 			foreach ($ticket->contact as $key => $contact) 
  	 			{
					echo '<a href="../editcontact/'.$contact->id.'" target="_blank" >'.$contact->first_name.' '.$contact->last_name.'('.$contact->company->name.')</a>';
					echo count($ticket->contact ) == ++$key ? "" : ",";
				}
		  		echo '</div>';
		  		echo '<div id="delete-contact">';

				foreach ($ticket->contact as $key => $contact) 
  	 			{
					echo '<button class="btn btn-secondary" type="button" onclick="deletecontact(this)" value="'.$contact->id.'">'.$contact->first_name.' '.$contact->last_name.'('.$contact->company->name.') <i class="fa fa-times-circle" aria-hidden="true"></button></i></button>';
				}
				echo '</div>';
				
			}
			else
			{
				echo 'Aucun';
			}
			echo '<div class="form-group" id="add-contact">
		    		<label>Ajouter des contacts</label>
		    		<select multiple class="form-control" name="contacts[]">';
	      	foreach ($contacts as $contact) 
	      	{
				$useit = true;

	      		foreach ($ticket->contact as $ticketcontact) 
					{
						if($contact->id == $ticketcontact->id)
							$useit = false;
					}
					if($useit)
						echo '<option value="'.$contact->id.'">'.$contact->first_name.' '.$contact->last_name.' ('.$contact->company->name.')</option>';	
	    	}
		    echo '</select>
				 </div>';
			echo '</li>';
	  	 ?>
</ul>
	
	<br>
	<div class="row">
    <div class="col">
	  	{{ Form::hidden('id', $ticket->id)}}

	    <button type="submit" class="btn btn-primary" id="apply-modifications" >Appliquer les modifications</button>

	
    </div>
    <div class="col">
        <button type="submit" class="btn btn-danger" style="display:block;margin:auto" id="archiveupdateticket" name="archive" value="1" >Enregistrer & archiver</button>
  	{{ Form::close() }}
  	<?php

  	if(!$ticket->archived)
  	{
	  	echo Form::open(array('url' => 'archiveticket','method'=>'POST','class' => 'form-group', 'id' => 'archiveticket'));
	  	echo Form::hidden('id', $ticket->id);	
	  	echo '<button type="submit" class="btn btn-danger" style="display:block;margin:auto">Archiver</button>';
	  	echo Form::close();
	  	
  	}
  	?>
    </div>
    <div class="col">
    	<button type="button" class="btn btn-secondary" id="cancel-modifications" style="float:right">Annuler les modifications</button>
    </div>
</div>
 
</div>
<?php $timelimit = $ticket->time_limit ? Carbon\Carbon::parse($ticket->time_limit)->format('d/m/Y') :'' ?>

<script>
var time_limit_value = "{{ $timelimit }}"
var id_ticket = "{{ $ticket->id }}";

//initialize date picker
$( "#datepicker" ).datepicker();
//change date picker date format
$( "#datepicker" ).datepicker( "option", "dateFormat", "dd/mm/yy" );

$("#datepicker").datepicker("setDate", time_limit_value );

//when page loads, hide many inputs used to edit the ticket
$(document ).ready(function() {
	$('#apply-modifications').hide();
	$('#cancel-modifications').hide();
	$('#project').hide();
	$('#sector').hide();
	$('#user').hide();
	$('#time_limit-input').hide();

	$('#sector').trigger('change');
	$('#delete-files').hide();
	$('#delete-contact').hide();
	$('#add-contact').hide();
	$('#add-files').hide();
	$('#archiveupdateticket').hide();

});
//when edit ticket button is clicked, show all inputs and unhide some of them 
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
	$('#sector-text').hide();
	$('#sector').show(100);
	$('#user-text').hide();
	$('#user').show(100);
	$('#project-text').hide();
	$('#toggle-time-limit').show(100);
	$('#time_limit-text').hide();
	$('#time_limit-input').show(100);
	$('#delete-files').show(100);
	$('#delete-contact').show(100);
	$('#show-files').hide();
	$('#show-contact').hide();
	$('#add-contact').show(100);
	$('#add-files').show(100);
	$('#archiveupdateticket').show(100);
	$('#archiveticket').hide();

});

$('#cancel-modifications').click(function() {
    location.reload();
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
$('#archiveupdateticket').submit(function() {
	return confirm('Attention ! Ce ticket va être archivé');

});
$('#archiveticket').submit(function() {
	return confirm('Attention ! Ce ticket va être archivé');
});

var type="all";

$('#sector').change(function() {
  if($('#sector').val() == "null")
  {
      $('#user')
            .find('option')
            .remove()
            .end()
            .append('<option value="">Aucun</option>');
  }
  else
  {
    type = $('#sector').val();    
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
          $('#user')
            .find('option')
            .remove()
            .end();
            $('#user').append('<option value="">Aucun</option>');
            for (var i = data.length - 1; i >= 0; i--) 
            {
              $('#user').append($('<option>', {
                  value: data[i]['id'],
                  text: data[i]['first_name'] + ' ' + data[i]['last_name'] 
              }));
            }
            if($('#user_id').val())
            {
            	$('#user').val($('#user_id').val());
            }
        }
      }
});

function deletefile(file)
{
	if(confirm('Etes-vous sûr ?'))
	{
		$.ajax({
            url: '/deletefile/'+file.value,
            type: 'GET',
            dataType: 'json',
            success: function () {
                file.remove();;
            }
        });
	}
	else
	{
		return;
	}
}
function deletecontact(contact)
{
	if(confirm('Etes-vous sûr ?'))
	{
		$.ajax({
            url: '/deletecontact/'+contact.value+'&'+id_ticket,
            type: 'GET',
            dataType: 'json',
            success: function () {
                contact.remove();;
            }
        });
	}
	else
	{
		return;
	}
}
</script>
@endsection
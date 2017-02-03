<?php 

//uses home controller
use App\Http\Controllers\HomeController;

//get all tickets in function of sector
$tickets =  HomeController::getTickets();

//used to show data in $ticket
$DEBUG = false;

?>

@extends('layouts.default')

@section('title', 'Manage Tickets')

@section('content')   

  
<div class="container">
  <div class="filters">
    <a href="ticket"><button class="btn btn-secondary">Créer un ticket</button></a>

    {{ Form::label('','',['class' =>'form-check-label']) }}
    Afficher :

    {{ Form::label('','',['class' =>'form-check-label']) }}
     {{ Form::checkbox('archived',true,false) }}
    Archives

    {{ Form::label('','',['class' =>'form-check-label']) }}
    {{ Form::checkbox('project',true,false) }}
    Projets
  </div>
<table id="my-table" class="table table-hover">
  <thead class="thead-inverse">
    <tr>
      <th>ID</th>
      <th>Titre</th>
      <th>Secteur</th>
      <th>Utilisateur</th>
      <th>Demandeur</th>
      <th>Crée le</th>
      <th>Modifié le</th>
      <th>Modifier</th>

    </tr>
  </thead>
  <tbody>
  <?php

  if($DEBUG)
  {
    echo '<pre>';
    print_r($tickets);
    echo '</pre>';
  }
   foreach ($tickets as $ticket)
  {
        echo '<tr>';
  echo '<td>'.$ticket->id.'</td>';
  echo '<td>'.$ticket->title.'</td>';
  if (isset($ticket->sector))
  echo '<td>'.$ticket->sector->name.'</td>';
  else
  echo '<td>Non attribué</td>';

  if (isset($ticket->user))
  echo '<td>'.$ticket->user->first_name.'</td>';
  else
  echo '<td>Non attribué</td>';

  if (isset($ticket->applicant))
  echo '<td>'.$ticket->applicant->name.'</td>';
  else
  echo '<td>Non attribué</td>';

  
  echo '<td>'.$ticket->created_at->format('d M Y').'</td>';
  echo '<td>'.$ticket->updated_at->format('d M Y').'</td>';
  echo '<td><a href="ticket">Modifier</a></td>';
    echo '</tr>';
  }
   
?>


  </tbody>

</table>


<script>
$(document ).ready(function() {

    $('#my-table').dynatable();
});
</script>

</div>
@endsection

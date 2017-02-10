<?php 

//uses home controller
use App\Http\Controllers\HomeController;


//get all tickets in function of sector
$tickets =  HomeController::getTickets("all");

//used to show data in $ticket
$DEBUG = false;

?>

@extends('layouts.default')

@section('title', 'Tickets')

@section('content')   

  <br>
<div class="container">
  <div class="btn-group" data-toggle="buttons">
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option1" autocomplete="off" value="all"> Tout
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option2" autocomplete="off" value="archived"> Archives
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option3" autocomplete="off" value="project"> Projets
  </label>
</div>

<br>

  
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
  echo '<td><a href="'.route('ticket', ['id' => $ticket->id]).'">'.$ticket->title.'</a></td>';
  if (isset($ticket->sector))
  echo '<td>'.$ticket->sector->name.'</td>';
  else
  echo '<td>Non attribué</td>';

  if (isset($ticket->user))
  echo '<td>'.$ticket->user->first_name.'</td>';
  else
  echo '<td>Non attribué</td>';

  if (isset($ticket->applicant))
  echo '<td>'.$ticket->applicant->first_name.' '.$ticket->applicant->last_name.'</td>';
  else
  echo '<td>Non attribué</td>';

  
  echo '<td>'.$ticket->created_at->format('d M Y').'</td>';
  echo '<td>'.$ticket->updated_at->format('d M Y').'</td>';
  echo '<td><a href="'.route('ticket', ['id' => $ticket->id]).'">Modifier</a></td>';
  echo '</tr>';
  }
   
?>


  </tbody>

</table>

<script>
$(document ).ready(function() {

      function getTickets($type)
      {

        $.ajax({
        url: '/gettickets/'+ $type,

        success: function(data){
          $('#my-table').dynatable({
            dataset: { records: data }
          });
        }
        });

      }
    

    $('input[type=radio][name=options]').change(function(){
      var type = $('input[type=radio][name=options]:checked').val();
              console.log(getTickets(type));
    
    });
});
</script>

</div>
@endsection

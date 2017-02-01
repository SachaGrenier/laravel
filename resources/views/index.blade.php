<?php 

use App\Http\Controllers\HomeController;
  
$tickets =  HomeController::getTickets();


$DEBUG = false;



?>
<table id="my-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Titre</th>
      <th>Secteur</th>
      <th>Utilisateur</th>
      <th>Prestataire</th>
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

 	
 	echo '<td>'.$ticket->created_at.'</td>';
 	echo '<td>'.$ticket->updated_at.'</td>';
 	echo '<td><a href="ticket">Modifier</a></td>';
    echo '</tr>';
  }
    

   
    ?>
  </tbody>
</table>
<script src="https://raw.githubusercontent.com/alfajango/jquery-dynatable/master/jquery.dynatable.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>



<script>
$( document ).ready(function() {
    console.log( "ready!" );
    $('#my-table').dynatable();
});
</script>
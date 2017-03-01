<?php

use App\Http\Controllers\ContactController;

$contacts = ContactController::getContacts();

$companies = ContactController::getCompanies();

?>

@extends('layouts.default')

@section('title', 'Prestataires')

@section('content')

<div class="container">
<br>

<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="#div-contact" data-toggle="tab" role="tab">Contacts</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#div-enterprise" data-toggle="tab" role="tab">Enteprises</a>
  </li>

</ul>
  
<div class="tab-content">
	<div id="div-contact" class="tab-pane active" role="tabpanel">
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th>#</th>		      
		      <th>Prénom</th>
		      <th>Nom</th>
		      <th>Téléphone</th>
		      <th>Email</th>
		      <th>Entreprise</th>
		      <th>Poubelle !</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php
		  	foreach ($contacts as $contact) 
		  	{
				echo '<tr>';
			    echo '<th scope="row">'.$contact->id.'</th>';			    
			    echo '<td>'.$contact->first_name.'</td>';
			    echo '<td>'.$contact->last_name.'</td>';
			    echo '<td>'.$contact->phone_number.'</td>';
			    echo '<td>'.$contact->email.'</td>'; 
			    echo '<td>'.$contact->company.'</td>';
			   	echo '<td>';
			    echo Form::open(array('url' => 'deletesector','method'=>'POST'));
			    echo '<button type="submit" class="btn btn-secondary"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
			    echo Form::close();
			    echo '</td>';
			    echo '</tr>';
			}

		    ?>
		  </tbody>
		</table>	
</div>
		  
<div id="div-enterprise" class="tab-pane" role="tabpanel">
		<table class="table table-hover">
		  <thead>
		    <tr>
		      <th>#</th>
		      <th>Logo</th>
		      <th>Entreprise</th>
		      <th>Poubelle !</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php
		  	foreach ($companies as $company) 
		  	{
				echo '<tr>';
			    echo '<th scope="row">'.$company->id.'</th>';
			    echo '<td>'.$company->name.'</td>';
			    echo '<td>'.$company->name.'</td>';
			    echo '<td>';
			    echo Form::open(array('url' => 'deletesector','method'=>'POST'));
			    echo '<button type="submit" class="btn btn-secondary"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
			    echo Form::close();
			    echo '</td>';
			    echo '</tr>';
			}
		    ?>
		  </tbody>
		</table>
	</div>	
</div>
@endsection
  
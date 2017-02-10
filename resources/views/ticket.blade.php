<?php 

use App\Http\Controllers\TicketController;


$ticket = TicketController::getTicket($id);

//echo $ticket->id;
//echo $ticket->time_limit->format('d/m/Y');

?>

@extends('layouts.default')

@section('title', 'Apercu')

@section('content')   

<div class="container">
<br>
<a href="{{route('index')}}"><button class="btn btn-secondary">< Retour aux tickets</button></a>
<br>
	<h1>{{ $ticket->title }}</h1>
	<div class="alert alert-info">
	Demandeur : {{ $ticket->applicant->first_name }} {{ $ticket->applicant->last_name }}
	</div>
	<h4>Contenu</h4>
	<div class="form-group">
	{{ Form::textarea('content',$ticket->content,['class' => 'form-control']) }}
	</div>
	<h4>Notes ajoutées</h4>
	<div class="form-group">
	{{ Form::textarea('note',$ticket->note,['class' => 'form-control']) }}
	</div>
	<ul class="list-group">
  <li class="list-group-item">Délai : {{ Carbon\Carbon::parse($ticket->time_limit)->format('d M Y')  ?: "Aucun" }}</li>
  <li class="list-group-item">Projet : {{ $ticket->project  ? "Oui" : "Non" }}</li>
  <li class="list-group-item">Crée le : {{ $ticket->created_at->format('d M Y') }}</li>
  <li class="list-group-item">Modifié le : {{ $ticket->updated_at->format('d M Y') }}</li>
  <li class="list-group-item">Archivé : {{ $ticket->archived  ? "Oui" : "Non" }}</li>
  <li class="list-group-item">Secteur : {{ $ticket->sector_id  ?  $ticket->sector->name : "Aucun" }}</li>
  <li class="list-group-item">Utilisateur assigné : {{ $ticket->user_id  ? $ticket->user->first_name . " " . $ticket->user->last_name : "Aucun" }}</li>
</ul>
<br>
  <button type="button" class="btn btn-primary">Modifier</button>
  <button type="button" class="btn btn-danger">Archiver</button>

</div>
@endsection
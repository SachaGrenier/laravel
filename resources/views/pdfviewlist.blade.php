<link rel="stylesheet" type="text/css" href="{{ ltrim(elixir('css/bootstrap.min.css'), '/') }}" />
<div class="">

    {{ Html::image('img/logoMT.png','', array('class'=>'','width' => '100')) }}
    <span style="font-size: 25px;">ManageTicket</span>

	

	<?php
		setLocale(LC_TIME,config('app.locale'));
	?>
	<table class="table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Titre</th>
			<th>Secteur</th>
			<th>Utilisateur assigné</th>
			<th>Demandeur</th>
			<th>Date de création</th>
			<th>Délai</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach ($tickets as $ticket) 
		{
			$isProject = $ticket->project ? "[PROJET]" : ""; 
			 $timeLimit = $ticket->time_limit ? Carbon\Carbon::parse($ticket->time_limit)->formatLocalized('%d %B %Y') : "Aucun";
			echo '<tr>';
			echo '<td>'.$ticket->id.'</td>';
			echo '<td>'.$isProject.$ticket->title.'</td>';
			echo $ticket->sector ? '<td>'.$ticket->sector->name.'</td>' : "<td>Aucun secteur</td>";
			echo $ticket->user ? '<td>'.$ticket->user->first_name.' '.$ticket->user->last_name.'</td>' : "<td>Aucun utilisateur</td>";
			echo $ticket->applicant ? '<td>'.$ticket->applicant->first_name.' '.$ticket->applicant->last_name.'</td>' : "<td>Aucun demandeur</td>";
			echo '<td>'.$ticket->created_at->formatLocalized('%d %B %Y').'</td>';
			echo '<td>'. $timeLimit.'</td>';
			echo '</tr>';
		}
	?>
	</tbody>

	</table>

<div id="links">
	<a href="{{ route('pdfviewlist',['download'=>'pdf']) }}"><button type="button" class="btn btn-info">Télécharger PDF</button></a>
	<a href="javascript:window.print()"><button type="button" class="btn btn-info" ">Imprimer</button> </a>
	</div>
</div>


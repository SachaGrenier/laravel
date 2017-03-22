<link rel="stylesheet" type="text/css" href="{{ ltrim(elixir('css/bootstrap.min.css'), '/') }}" />
<div class="container">

    {{ Html::image('img/logoMT.png','', array('class'=>'','width' => '100')) }}
    <span style="font-size: 25px;">ManageTicket</span>

	

		<?php

		setLocale(LC_TIME,config('app.locale'));

		?>
		<table class="table">
		<tbody>
	
			<tr>
				<th>Numéro de ticket</th>
				<td>{{ $ticket->id }}</td>
			</tr>
			<tr>
				<th>Demandeur</th>
				<td>{{ $ticket->applicant->first_name.' '.$ticket->applicant->last_name }}</td>
			</tr>
			<tr>
				<th>Titre</th>
				<td>{{ $ticket->title }}</td>
			</tr>
			<tr>
				<th>Contenu</th>
				<td>{{ $ticket->content }}</td>
			</tr>
			<tr>
				<th>Notes</th>
				<td>{{ $ticket->note }}</td>
			</tr>
			<tr>
				<th>Délai</th>
				<td>{{ $ticket->time_limit ? Carbon\Carbon::parse($ticket->time_limit)->formatLocalized('%d %B %Y') : "Aucun" }}</td>
			</tr>
			<tr>
				<th>Projet</th>
				<?php
				echo $ticket->project ? '<td>oui</td>' : '<td>non</td>';
				?>
			</tr>
			<tr>
				<th>Date création</th>
				<td>{{ Carbon\Carbon::parse($ticket->created_at)->formatLocalized('%d %B %Y') }}</td>
			</tr>
			<tr>
				<th>Date modification</th>
				<td>{{ Carbon\Carbon::parse($ticket->updated_at)->formatLocalized('%d %B %Y') }}</td>
			</tr>
			<tr>
				<th>Secteur</th>
				<?php 
				
					echo $ticket->sector ? '<td>'.$ticket->sector->name.'</td>' : "<td>Aucun secteur</td>";
				?>
				
			
			</tr>
			<tr>
				<th>Utilisateur assigné</th>
				<?php 
				
					echo $ticket->user ? '<td>'.$ticket->user->first_name.' '.$ticket->user->last_name.'</td>' : "<td>Aucun utilisateur assigné</td>";

					
				?>
				
			</tr>
			<tr>
				<th>Contacts</th>
				<td>
					<?php
					if(count($ticket->contact) > 0)
					{
						foreach ($ticket->contact as $key => $contact) 
						{
							echo $contact->first_name.' '.$contact->last_name.'('.$contact->company->name.')';
							echo count($ticket->contact) == ++$key ? "": ",";
						}
					}
					?>

				</td>
			</tr>
			
	</tbody>
	</table>
	<div id="links">
	<a href="{{ route('pdfview',['download'=>'pdf','id' => $ticket->id]) }}"><button type="button" class="btn btn-info" style="margin-top: 5px;">Télécharger PDF</button></a>
	<a href="javascript:window.print()"><button type="button" class="btn btn-info" ">Imprimer</button> </a>
	</div>

</div>

	
<?php 

use App\Http\Controllers\TicketController;

$sectors =  TicketController::getSectors();

?>
<body>
<div class="container">
<h1>Ajouter un ticket</h1>
{{ Form::open(array('action' => 'Ticket@add','class' => 'form-group')) }}
	<div class="form-group">
	    {{ Form::label('', 'Demandeur')}}
	    {{ Form::Text('applicant','',['class' => 'form-control','placeholder' => 'autocomplete incoming']) }}
	    
 		 {{ Form::button('Ajouter',['class' => 'btn btn-primary', 'onclick' => 'document.getElementById(\'addapplicant\').style.display = \'block\'']) }}

    </div>
    <fieldset class="form-group" id="addapplicant" style="display:none">
    	<legend>Ajouter un demandeur</legend><span style="float:right;font-size: 30px;" onclick="document.getElementById('addapplicant').style.display = 'none' ">X</span>

    	<div class="form-group">
	    	{{ Form::label('', 'Prénom') }}
		    {{ Form::Text('first_name','',['class' => 'form-control']) }}
	    </div>
	    <div class="form-group">
	    	{{ Form::label('', 'Nom') }}
		    {{ Form::Text('last_name','',['class' => 'form-control']) }}
	    </div>
	    <div class="form-group">
	    	{{ Form::label('', 'Email') }}
		    {{ Form::Text('email','',['class' => 'form-control']) }}
	    </div>
	    <div class="form-group">
	    	{{ Form::label('', 'Numéro de téléphone') }}
		    {{ Form::Text('phone_number','',['class' => 'form-control']) }}
	    </div>
    </fieldset>
    <div class="form-group">
	    {{ Form::label('', 'Titre de la demande') }}
	    {{ Form::Text('title','',['class' => 'form-control']) }}
    </div>
  	<div class="form-group">
        {{ Form::label('', 'Contenu')}}
	    {{ Form::textarea('content','',['class' => 'form-control']) }}
  	</div>
  	<div class="form-group">
        {{ Form::label('', 'Ajouter des notes')}}
	    {{ Form::textarea('notes','',['class' => 'form-control']) }}
  	</div>
  	<div class="form-check">
	      {{ Form::label('', '',['class' => 'form-check-label'])}}
	      {{ Form::checkbox('projet',null,false,['class' => 'form-check-input']) }}
      	  Projet
    </label>
  </div>
  <div class="form-group">
     {{ Form::label('', 'Secteur') }}
    <select class="form-control" id="exampleSelect2">
      <?php
      	foreach ($sectors as $sector)
      	 {
      		echo '<option>'.$sector->name.'</option>';
      	}

       ?>
    </select>
  </div>
  <div class="form-group">
   	{{ Form::label('', 'Délai')}}
    {{ Form::date('time_limit', \Carbon\Carbon::now(),['class' => 'form-control']) }}
  </div>
   <div class="form-group">
	  <label class="custom-file">
	  <input type="file" id="file" class="custom-file-input">
	  <span class="custom-file-control">Ajouter un fichier</span>
  	  </label>
  </div>
  
 
  {{ Form::submit('Envoyéz (#tomablop)!',['class' => 'btn btn-primary']) }}

</form>
</div>
</body>

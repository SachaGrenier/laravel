<?php
//uses home controller
use App\Http\Controllers\HomeController;

$currentuser = HomeController::getUser();


?>


<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a href="/" id="logonavbar"> {{ Html::image('img/logoMT.png','', array('class'=>'logonavbar')) }}</a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      
      <li class="nav-item">
        <a class="nav-link" href="/">Tickets</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="/applicant">Prestataires</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="/admin">Administrateur</a>
      </li>
        
      <li class="nav-item">
        <a class="nav-link" href="/createticket">Créer un ticket</a>       
      </li>

    </ul>

<ul class="navbar-nav mr-right">
      
<a class="nav-link"> <?php echo $currentuser->first_name. " " ,$currentuser->last_name;?> </a> 

<a id="logonavbar"> {{ Html::image($currentuser->picture_path,'', array('class'=>'logonavbar')) }}</a>


<div  class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Pramètres
  </button>
  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="settings">Editer le profil</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="logout">Log out</a>
    
  </div>
</div>
      
</ul>
  </div>
</nav>

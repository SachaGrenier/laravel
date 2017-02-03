

<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a href="/" id="logonavbar"> {{ Html::image('img/logoMT.png','', array('class'=>'logonavbar')) }}</a>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/">Tickets <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/applicant">Prestataire</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin">Administrateur</a>
      </li>
    </ul>

<ul class="navbar-nav mr-right">
      <li class="nav-item">
        <a class="nav-link" href="/parametres">Paramètres</a>
      </li>
</ul>
  </div>
</nav>

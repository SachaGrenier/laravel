{{ Html::style('css/bootstrap.min.css') }}
{{ Html::style('css/styles.css') }}


	

<body>
    <div class="container">
      <form class="form-signin">
      <a  id="imagelogo"> {{ Html::image('img/logoMT.png','', array('class'=>'imagelogo')) }}</a>
        <div id="logincontainer">
	        <h1 class="appname">Manage Tickets</h1>	        
	        {{ Form::Text('login','',['class' => 'form-control','placeholder' => 'Login']) }}       
	        {{ Form::password('password',['class' => 'form-control', 'placeholder'=>'Password']) }}
	        <br>
	        {{ Form::submit('Se connecter',['class' => 'btn btn-primary btn-lg btn-block']) }}
	        
        </div>
  		
        
      </form>

    </div> <!-- /container -->
</body>
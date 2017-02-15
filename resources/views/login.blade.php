{{ Html::style('css/bootstrap.min.css') }}
{{ Html::style('css/styles.css') }}



<body>
    <div class="container">
      
      <a  id="imagelogo"> {{ Html::image('img/logoMT.png','', array('class'=>'imagelogo')) }}</a>
        <div id="logincontainer">
	        <h1 class="appname">Manage Tickets</h1>
          {{ Form::open(array('url' => 'login','method'=>'POST','class' => 'form-signin')) }}	        
	        {{ Form::Text('login','',['class' => 'form-control','placeholder' => 'Login', 'autofocus']) }}       
	        {{ Form::password('password',['class' => 'form-control', 'placeholder'=>'Password']) }}
	        <br>
	        {{ Form::submit('Se connecter',['class' => 'btn btn-primary btn-lg btn-block']) }}
	        {{ Form::close() }}

          <?php
          if (session('status'))
          {
            echo '<div class="alert alert-danger">';
            echo session('status');
            echo '<img style="width:100%;" id="denis" src="https://media.tenor.co/images/dfd5671e5d4847a48be0d024abd03e72/tenor.gif">';
        echo '</div>';
         }
          ?>
        </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  		<script type="text/javascript">$("#denis").delay(50000).hide(20)</script>
        
      

    </div> <!-- /container -->
</body>
hello


<?php 

use App\Http\Controllers\Home;


 $sectors =  Home::index();

 foreach ($sectors as $sector)
  {
 	echo $sector->seName; }

?>
<?php 

//uses home controller
use App\Http\Controllers\HomeController;


//get all tickets in function of sector
$tickets =  HomeController::getTickets("all");

//used to show data in $ticket
$DEBUG = false;

?>

@extends('layouts.default')

@section('title', 'Tickets')

@section('content')   

  <br>
<div class="container">
  <div class="btn-group" data-toggle="buttons">
  <label class="btn btn-primary active">
    <input type="radio" name="options" id="option1" checked autocomplete="off" value="all"> Tout
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option2" autocomplete="off" value="archived"> Archives
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option3" autocomplete="off" value="project"> Projets
  </label>
</div>

<br>

  
<table id="my-table" class="table table-striped table-bordered">
  <thead class="thead-inverse">
    <tr>
      <th>ID</th>
      <th>Titre</th>
      <th>Secteur</th>
      <th>Utilisateur assigné</th>
      <th>Demandeur</th>
      <th>Crée le</th>
      <th>Modifié le</th>
      <th>Modifier</th>

    </tr>
  </thead>
  <tbody>
  </tbody>

</table>

<script>
$(document ).ready(function() {
      
      getTickets('all');

      function getTickets(type)
      {

        $.ajax({
            url: '/gettickets/'+type,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                assignToEventsColumns(data);
            }
        });

        function assignToEventsColumns(data) 
        {
            
            var table = $('#my-table').dataTable({
            "dom": 'C<"clear">lfrtip',
            "bAutoWidth": true,
            "aaData": data,
            "aaSorting": [],
            "aoColumnDefs": [
               {
                   "aTargets": [0],
                   "mData": "id",
                   
               },
               {
                   "aTargets": [1], 
                   "mData": "title",
                   "mRender": function (event) {
                    
                        return '<a href="ticket/'+ data[0].id +'">'+event+'</a> ';
                   }
               },
                {
                   "aTargets": [2], 
                   "mData": "sector"
               },
                 {
                   "aTargets": [3], 
                   "mData": "user"
               },
                 {
                   "aTargets": [4], 
                   "mData": "applicant"
               },
                 {
                   "aTargets": [5], 
                   "mData": "created_at"
               },
                 {
                   "aTargets": [6], 
                   "mData": "updated_at"
               },
                {
                     "aTargets": [7],
                     "bSearchable": false,
                     "bSortable": false,
                     "bSort": false,
                     "mData": "id",
                     "mRender": function (event) {
                         return '<a href="editticket/'+ event+'">Modifier</a> ';
                     }
                 }
                ]});
           

          }

       }

      $('input[type=radio][name=options]').change(function(){
      var type = $('input[type=radio][name=options]:checked').val();
      $('#my-table').dataTable().fnDestroy();
      getTickets(type);
      });
});
</script>

</div>
@endsection

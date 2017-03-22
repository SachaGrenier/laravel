<?php 

//uses home controller
use App\Http\Controllers\HomeController;

$sector = HomeController::index();

?>

@extends('layouts.default')

@section('title', 'Tickets')

@section('content')   

<br>
<div class="container">
  <div class="btn-group" data-toggle="buttons">
  <label class="btn btn-primary active">
    <input type="radio" name="options" id="option1" checked autocomplete="off" value="sector">Tickets {{ $sector->name }}
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option2" autocomplete="off" value="mine"> Mes tickets
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option3" autocomplete="off" value="archived"> Archives
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option4" autocomplete="off" value="project"> Projets
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option5" autocomplete="off" value="all"> Tous les tickets
  </label>

</div>
<div style="float:right;">
  
  <?php
     echo Form::open(array('url' => 'pdfviewlist','method'=>'POST'));
     echo '<button type="submit" class="btn btn-secondary" style="float:right;display:inline-block; margin-top:0px;" title="Imprimer tous les tickets"><i class="fa fa-print" aria-hidden="true"></i></button>';
     echo Form::close();
?>
</div>

<br>

<table id="my-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead class="thead-inverse">
    <tr>
      <th>ID</th>
      <th>Titre</th>
      <th>Secteur</th>
      <th>Utilisateur assigné</th>
      <th>Demandeur</th>
      <th>Crée le</th>
      <th>Délai</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<script>
$(document ).ready(function() {
      getTickets('sector');

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
            "order": [[ 5, "desc" ]],
            "bAutoWidth": true,
            "aaData": data,
            "oLanguage": 
            {
              "sInfo": "_TOTAL_ résultats (Affiche de _START_ à _END_)",
              "sInfoEmpty": "Aucun résultat",
              "sInfoFiltered": " - filtré de _MAX_ entrées",
               "sLengthMenu": "Afficher _MENU_ résultats",
              "sEmptyTable": "La table est vide",
              "sSearchPlaceholder" : "Rechercher",
              "sSearch": "_INPUT_ ",
               "oPaginate": 
                {
                  "sNext": "Page suivante",
                  "sPrevious": "Page précédente"
                }
            },
            "aaSorting": [],
            "aoColumnDefs": [
               {
                   "aTargets": [0],
                   "mData": "id",
               },
               {
                   "aTargets": [1], 
                   "mData": "title"
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
                   "mData": "time_limit"
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
/**
 * show chart on stat page
 */
$(document).ready(function() {

  $('#total').hide();

  $(function(event, ui) {
        $('table.highchart').highchartTable();
        $('#total').show();


  });

});
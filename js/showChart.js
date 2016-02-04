/**
 * show chart on stat page
 */
$(document).ready(function() {
  // var total_time = 1000;
  // var current_time = 0;
  // var refresh_interval = 50;
  // var timer;

  $('#total').hide();

  $(function(event, ui) {
        $('table.highchart').highchartTable();
        $('#total').show();
        // $('#progressbar1').hide();

  // function refresh_bar() {
  //   $( "#progressbar1" ).progressbar({ value: current_time });
  //   current_time += refresh_interval;
  //   if(current_time > total_time) clearInterval( timer );
  // }

  // $(function() {
  //   $( "#progressbar1" ).progressbar({
  //     max: total_time,
  //     value: current_time,
  //     complete: function(event, ui) {
  //       $('table.highchart').highchartTable();
  //       $('#total').show();
  //       $('#progressbar1').hide();
  //     }
  //   });

    // timer = setInterval( refresh_bar, refresh_interval );

  });

});
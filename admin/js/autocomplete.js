$(function() {
 
    $("#key_value").autocomplete({
        source: "autocomplete.php",
        minLength: 2,
        select: function(event, ui) {
            var url = ui.item.id;
            if(url != '#') {
                location.href = 'top_order_list.php?mode=search&key_value=' + url;
            }
        },
 
        html: true, // optional (jquery.ui.autocomplete.html.js required)
 
      // optional (if other layers overlap autocomplete list)
        open: function(event, ui) {
            $(".ui-autocomplete").css("z-index", 1000);
        }
    });
 
});

// $(function() {
//   $("#key_value").autocomplete({
//    minLength: 2,
//    source: function( request, response ) {
//     $.ajax({
//      url: "search.php",
//      dataType: "json",
//      data: { term: request.term },
//      success: function( data ) {
//         response( $.map( data, function( item ) {
//             return {
//                 label: item.label,
//                 value: item.value
//             }
//       }));
//      }
//     });
//    },
//    focus: function( event, ui )
//    {
//     $("#key_value").val( ui.item.label );
//     return false;
//    },
//   });
//  });
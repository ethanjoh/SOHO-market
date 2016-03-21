	$(document).ready(function() {
	    $(".addCart_submit").click(function() {
	        var element = $(this);
	        var Id = element.attr("id");
	        // var opt = "#selected_opt_"+Id;
	        var qty = $("#products_count_" + Id).val();

	        if ('' == qty || 0 == qty) {
	            alert("주문수량을 1개 이상 넣어주세요.");
	        } else {

	            if ($("#selected_opt_" + Id).val()) {

	                $.ajax({
	                    type: "POST",
	                    url: "/shop/cart-update.php",
	                    data: {
	                        pnum: $("#pnum_" + Id).val(),
	                        products_count: qty,
	                        from: $("#from").val(),
	                        selected_opt: $("#selected_opt_" + Id).val(),
	                        amount: $("#amount_" + Id).val()
	                    },
	                    dataType: "json",
	                    cache: false,
	                    success: function(data) {
	                        console.log(data);
	                        $("#loadplace" + Id).html(data.msg);
	                        $("#cartInfo").html(data.qty);
	                    }
	                });

	            } else {
	                $.ajax({
	                    type: "POST",
	                    url: "/shop/cart-update.php",
	                    data: {
	                        pnum: $("#pnum_" + Id).val(),
	                        products_count: qty,
	                        from: $("#from").val(),
	                        amount: $("#amount_" + Id).val()
	                    },
	                    dataType: "json",
	                    cache: false,
	                    success: function(data) {
	                        // console.log(data);
	                        $("#loadplace" + Id).html(data.msg);
	                        $("#cartInfo").html(data.qty);

	                    }
	                });
	            }
	        }
	        return false;
	    });
	});
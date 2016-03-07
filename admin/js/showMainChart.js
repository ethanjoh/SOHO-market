$.ajax({
        url: "/admin/main/mainChartProcess.php",
        cache: false,
        type: "POST",
        data: {anyVar: 'specialValue4PHPScriptAndDataBaseFilter'},
        dataType: "json",
        timeout:3000,
        success : function (data) {
        console.log(data.monthly);
        // console.log((data.item).length);

        var params = {};
        var params2 = {};
        var arr = [];
        var arr2 = [];

        if((data.item)) {
            for($i=0;$i < (data.item).length;$i++)
            {
                params = data.item[$i];
                arr.push(params);
            }
            // console.log(params);
        }

        // console.log(data.monthly);
        for($j=0;$j < (data.monthly).length;$j++)
        {
            params2 = data.monthly[$j];
            arr2.push(params2);
        }
        // console.log(params2);

        Morris.Bar({
            element: 'hero-bar',
            data: arr,
            xkey: 'item',
            ykeys: ['quantity'],
            labels: ['quantity'],
            barRatio: 0.4,
            xLabelAngle: 35,
            hideHover: 'auto',
            barColors: ['#6883a3']
        });

        Morris.Line({
            element: 'hero-graph',
            data: arr2,
            xkey: 'period',
            ykeys: ['amount'],
            labels: ['Amount'],
            lineColors:['#8075c4']
        });

    },
    error : function (xmlHttpRequest, textStatus, errorThrown) {
         alert("Error " + errorThrown);
         if(textStatus==='timeout')
             alert("request timed out");
    }
});
var Script = function () {

    //morris chart

    $(function () {
      // data stolen from http://howmanyleft.co.uk/vehicle/jaguar_'e'_type
      var tax_data = [
           {"period": "2011 Q3", "licensed": 3407, "sorned": 660},
           {"period": "2011 Q2", "licensed": 3351, "sorned": 629},
           {"period": "2011 Q1", "licensed": 3269, "sorned": 618},
           {"period": "2010 Q4", "licensed": 3246, "sorned": 661},
           {"period": "2009 Q4", "licensed": 3171, "sorned": 676},
           {"period": "2008 Q4", "licensed": 3155, "sorned": 681},
           {"period": "2007 Q4", "licensed": 3226, "sorned": 620},
           {"period": "2006 Q4", "licensed": 3245, "sorned": null},
           {"period": "2005 Q4", "licensed": 3289, "sorned": null}
      ];
      Morris.Line({
        element: 'hero-graph',
        data: tax_data,
        xkey: 'period',
        ykeys: ['licensed', 'sorned'],
        labels: ['Licensed', 'Off the road'],
        lineColors:['#8075c4','#6883a3']
      });


      Morris.Bar({
        element: 'hero-bar',
        data: [
          {device: 'iPhone', geekbench: 136},
          {device: 'iPhone 3G', geekbench: 137},
          {device: 'iPhone 3GS', geekbench: 275},
          {device: 'iPhone 4', geekbench: 380},
          {device: 'iPhone 4S', geekbench: 655},
          {device: 'iPhone 5', geekbench: 1571}
        ],
        xkey: 'device',
        ykeys: ['geekbench'],
        labels: ['Geekbench'],
        barRatio: 0.4,
        xLabelAngle: 35,
        hideHover: 'auto',
        barColors: ['#6883a3']
      });

      // new Morris.Line({
      //   element: 'examplefirst',
      //   xkey: 'year',
      //   ykeys: ['value'],
      //   labels: ['Value'],
      //   data: [
      //     {year: '2008', value: 20},
      //     {year: '2009', value: 10},
      //     {year: '2010', value: 5},
      //     {year: '2011', value: 5},
      //     {year: '2012', value: 20}
      //   ]
      // });

      $('.code-example').each(function (index, el) {
        eval($(el).text());
      });
    });

}();





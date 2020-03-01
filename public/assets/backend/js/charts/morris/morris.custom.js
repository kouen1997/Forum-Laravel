(function () {
    "use strict";

    new Morris.Line({
        // ID of the element in which to draw the chart.
        element: 'myfirstchart',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        data: [
            {
                year: '2013',
                value: 435
        },
            {
                year: '2014',
                value: 639
        },
            {
                year: '2015',
                value: 1630
        },
            {
                year: '2016',
                value: 987
        },
            {
                year: '2017',
                value: 786
        },
            {
                year: '2018',
                value: 1239
        },
            {
                year: '2019',
                value: 1752
        }
  ],
        // The name of the data record attribute that contains x-values.
        xkey: 'year',
        // A list of names of data record attributes that contain y-values.
        ykeys: ['value'],
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: ['Order']
    });

    new Morris.Line({
        element: 'line-example',
        data: [
            {
                y: '2006',
                a: 100,
                b: 90
        },
            {
                y: '2007',
                a: 75,
                b: 65
        },
            {
                y: '2008',
                a: 50,
                b: 40
        },
            {
                y: '2009',
                a: 75,
                b: 65
        },
            {
                y: '2010',
                a: 50,
                b: 40
        },
            {
                y: '2011',
                a: 75,
                b: 65
        },
            {
                y: '2012',
                a: 100,
                b: 90
        }
  ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B']
    });

    new Morris.Area({
        element: 'area-example',
        data: [
            {
                y: '2006',
                a: 100,
                b: 90
        },
            {
                y: '2007',
                a: 75,
                b: 65
        },
            {
                y: '2008',
                a: 50,
                b: 40
        },
            {
                y: '2009',
                a: 75,
                b: 65
        },
            {
                y: '2010',
                a: 50,
                b: 40
        },
            {
                y: '2011',
                a: 75,
                b: 65
        },
            {
                y: '2012',
                a: 100,
                b: 90
        }
  ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B']
    });

    new Morris.Bar({
        element: 'bar-example',
        data: [
            {
                y: '2006',
                a: 100,
                b: 90
        },
            {
                y: '2007',
                a: 75,
                b: 65
        },
            {
                y: '2008',
                a: 50,
                b: 40
        },
            {
                y: '2009',
                a: 75,
                b: 65
        },
            {
                y: '2010',
                a: 50,
                b: 40
        },
            {
                y: '2011',
                a: 75,
                b: 65
        },
            {
                y: '2012',
                a: 100,
                b: 90
        }
  ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B']
    });

    new Morris.Donut({
        element: 'donut-example',
        data: [
            {
                label: "Download Sales",
                value: 12
        },
            {
                label: "In-Store Sales",
                value: 30
        },
            {
                label: "Mail-Order Sales",
                value: 20
        }
  ]
    });

})();
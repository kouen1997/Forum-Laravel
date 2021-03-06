'use strict';
$(document).ready(function () {
    
    $('#lineChart2').sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: 'line',
        height: '200',
        width: '100%',
        lineWidth: '5',
        lineColor: '#feca57',
        fillColor: '#ff9f43'
    });

    $('#lineChart3').sparkline([10, 8, 7, 9, 12, 11, 7], {
        type: 'line',
        height: '200',
        width: '100%',
        lineWidth: '5',
        lineColor: '#5f27cd',
        fillColor: '#341f97'
    });
    
});
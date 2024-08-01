<script>
    /*=========================================================================================
    File Name: chart-chartjs.js
    Description: Chartjs Examples
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(window).on('load', function () {
  'use strict';

  var lineChartEx = $('.line-chart-ex'),chartWrapper = $('.chartjs')
  var primaryColorShade = '#836AF9',
    yellowColor = '#ffe800',
    successColorShade = '#28dac6',
    warningColorShade = '#ffe802',
    warningLightColor = '#FDAC34',
    infoColorShade = '#299AFF',
    greyColor = '#4F5D70',
    blueColor = '#2c9aff',
    blueLightColor = '#84D0FF',
    greyLightColor = '#EDF1F4',
    tooltipShadow = 'rgba(0, 0, 0, 0.25)',
    lineChartPrimary = '#666ee8',
    lineChartDanger = '#ff4961',
    labelColor = '#6e6b7b',
    grid_line_color = 'rgba(200, 200, 200, 0.2)'; // RGBA color helps in dark layout

  // Detect Dark Layout
  if ($('html').hasClass('dark-layout')) {
    labelColor = '#b4b7bd';
  }

  if (chartWrapper.length) {
    chartWrapper.each(function () {
      $(this).wrap($('<div style="height:' + this.getAttribute('data-height') + 'px"></div>'));
    });
  }



  //Draw rectangle Bar charts with rounded border
  Chart.elements.Rectangle.prototype.draw = function () {
    var ctx = this._chart.ctx;
    var viewVar = this._view;
    var left, right, top, bottom, signX, signY, borderSkipped, radius;
    var borderWidth = viewVar.borderWidth;
    var cornerRadius = 20;
    if (!viewVar.horizontal) {
      left = viewVar.x - viewVar.width / 2;
      right = viewVar.x + viewVar.width / 2;
      top = viewVar.y;
      bottom = viewVar.base;
      signX = 1;
      signY = top > bottom ? 1 : -1;
      borderSkipped = viewVar.borderSkipped || 'bottom';
    } else {
      left = viewVar.base;
      right = viewVar.x;
      top = viewVar.y - viewVar.height / 2;
      bottom = viewVar.y + viewVar.height / 2;
      signX = right > left ? 1 : -1;
      signY = 1;
      borderSkipped = viewVar.borderSkipped || 'left';
    }

    if (borderWidth) {
      var barSize = Math.min(Math.abs(left - right), Math.abs(top - bottom));
      borderWidth = borderWidth > barSize ? barSize : borderWidth;
      var halfStroke = borderWidth / 2;
      var borderLeft = left + (borderSkipped !== 'left' ? halfStroke * signX : 0);
      var borderRight = right + (borderSkipped !== 'right' ? -halfStroke * signX : 0);
      var borderTop = top + (borderSkipped !== 'top' ? halfStroke * signY : 0);
      var borderBottom = bottom + (borderSkipped !== 'bottom' ? -halfStroke * signY : 0);
      if (borderLeft !== borderRight) {
        top = borderTop;
        bottom = borderBottom;
      }
      if (borderTop !== borderBottom) {
        left = borderLeft;
        right = borderRight;
      }
    }

    ctx.beginPath();
    ctx.fillStyle = viewVar.backgroundColor;
    ctx.strokeStyle = viewVar.borderColor;
    ctx.lineWidth = borderWidth;
    var corners = [
      [left, bottom],
      [left, top],
      [right, top],
      [right, bottom]
    ];

    var borders = ['bottom', 'left', 'top', 'right'];
    var startCorner = borders.indexOf(borderSkipped, 0);
    if (startCorner === -1) {
      startCorner = 0;
    }

    function cornerAt(index) {
      return corners[(startCorner + index) % 4];
    }

    var corner = cornerAt(0);
    ctx.moveTo(corner[0], corner[1]);

    for (var i = 1; i < 4; i++) {
      corner = cornerAt(i);
      var nextCornerId = i + 1;
      if (nextCornerId == 4) {
        nextCornerId = 0;
      }

      var nextCorner = cornerAt(nextCornerId);

      var width = corners[2][0] - corners[1][0],
        height = corners[0][1] - corners[1][1],
        x = corners[1][0],
        y = corners[1][1];

      var radius = cornerRadius;

      if (radius > height / 2) {
        radius = height / 2;
      }
      if (radius > width / 2) {
        radius = width / 2;
      }

        ctx.moveTo(x + radius, y);
        ctx.lineTo(x + width - radius, y);
        ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
        ctx.lineTo(x + width, y + height - radius);
        ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
        ctx.lineTo(x + radius, y + height);
        ctx.quadraticCurveTo(x, y + height, x, y + height);
        ctx.lineTo(x, y + radius);
        ctx.quadraticCurveTo(x, y, x, y);

    }

    ctx.fill();
    if (borderWidth) {
      ctx.stroke();
    }
  };


  if (lineChartEx.length) {
    var lineExample = new Chart(lineChartEx, {
      type: 'line',
      plugins: [
        // to add spacing between legends and chart
        {
          beforeInit: function (chart) {
            chart.legend.afterFit = function () {
              this.height += 0;
            };
          }
        }
      ],
      options: {
        responsive: true,
        maintainAspectRatio: false,
        backgroundColor: false,
        hover: {
          mode: 'label'
        },
        tooltips: {
          // Updated default tooltip UI
          shadowOffsetX: 1,
          shadowOffsetY: 1,
          shadowBlur: 8,
          shadowColor: tooltipShadow,
          backgroundColor: window.colors.solid.white,
          titleFontColor: window.colors.solid.black,
          bodyFontColor: window.colors.solid.black
        },
        layout: {
          padding: {
            top: -15,
            bottom: -25,
            left: -15
          }
        },
        scales: {
          xAxes: [
            {
              display: true,
              scaleLabel: {
                display: true
              },
              gridLines: {
                display: true,
                color: grid_line_color,
                zeroLineColor: grid_line_color
              },
              ticks: {
                fontColor: labelColor
              }
            }
          ],
          yAxes: [
            {
              display: true,
              scaleLabel: {
                display: true
              },
              ticks: {
                stepSize: {{ max(max($targets,$collected_targets))/8 }},
                min: 0,
                max: {{ max(max($targets,$collected_targets)) }},
                fontColor: labelColor
              },
              gridLines: {
                display: true,
                color: grid_line_color,
                zeroLineColor: grid_line_color
              }
            }
          ]
        },
        legend: {
          position: 'top',
          align: 'start',
          labels: {
            usePointStyle: true,
            padding: 25,
            boxWidth: 9
          }
        }
      },
      data: {
        labels: [ '23/3', '24/3', '25/3',' 26/3', '27/3', '28/3', '29/3', '30/3', '31/3', '1/4', '2/4', '3/4', '5/4', '6/4','7/4','8/4','9/4','10/4','11/4','12/4','13/4','14/4','15/4','16/4','17/4','18/4','19/4','20/4','21/4','22/4'],
        datasets: [
          {
            data: @json($targets),
            label: 'المستهدفات اليومية',
            borderColor: lineChartDanger,
            lineTension: 0.5,
            pointStyle: 'circle',
            backgroundColor: lineChartDanger,
            fill: false,
            pointRadius: 1,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 5,
            pointBorderColor: 'transparent',
            pointHoverBorderColor: window.colors.solid.white,
            pointHoverBackgroundColor: lineChartDanger,
            pointShadowOffsetX: 1,
            pointShadowOffsetY: 1,
            pointShadowBlur: 5,
            pointShadowColor: tooltipShadow
          },
          {
            data: @json($collected_targets),
            label: 'المبالغ المحصلة اليومية',
            borderColor: lineChartPrimary,
            lineTension: 0.5,
            pointStyle: 'circle',
            backgroundColor: lineChartPrimary,
            fill: false,
            pointRadius: 1,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 5,
            pointBorderColor: 'transparent',
            pointHoverBorderColor: window.colors.solid.white,
            pointHoverBackgroundColor: lineChartPrimary,
            pointShadowOffsetX: 1,
            pointShadowOffsetY: 1,
            pointShadowBlur: 5,
            pointShadowColor: tooltipShadow
          }
        ]
      }
    });
  }





  //--------------- Earnings Chart ---------------
  //----------------------------------------------

var pathss=@json($paths);
for (let index = 0; index < pathss.length; index++) {
     var collected=Math.round(pathss[index].collected);
     var target=Math.round(pathss[index].target);
     var percent=Math.round(pathss[index].percent);
     var nedded=Math.round(pathss[index].nededd);

     pathchart(pathss[index].id,collected,target,nedded,percent);

}

  //------------ Revenue Report Chart ------------
  //----------------------------------------------

});

function pathchart(id, collected,target,nedded,percent){
    var $earningsChart = document.querySelector('#earnings-chart_'+id);
  var earningsChartOptions;
  var $earningsStrokeColor2 = '#28c76f66';
  var earningsChart;
  var $earningsStrokeColor3 = '#4472C4';

  earningsChartOptions = {
    chart: {
      type: 'donut',
      height: 120,
      toolbar: {
        show: false
      }
    },
    dataLabels: {
      enabled: true
    },
    series: [nedded, target,collected],
    legend: { show: true },
    comparedResult: [2, -3, 8],
    labels: [ 'المتبقى','المستهدفات اليومية','المبالغ المحصلة اليومية'],
    stroke: { width: 0 },
    colors: [$earningsStrokeColor2, $earningsStrokeColor3, window.colors.solid.success],
    grid: {
      padding: {
        right: -20,
        bottom: -8,
        left: -20
      }
    },
    plotOptions: {
      pie: {
        startAngle: -10,
        donut: {
          labels: {
            show: true,
            name: {
              offsetY: 15
            },
            value: {
              offsetY: -15,
              formatter: function (val) {
                return parseInt(val) ;
              }
            },
            total: {
              show: true,
              offsetY: 15,
              label:  'المبالغ المحصلة اليومية',
              formatter: function (w) {
                return percent+'%';
              }
            }
          }
        }
      }
    },
    responsive: [
      {
        breakpoint: 1325,
        options: {
          chart: {
            height: 100
          }
        }
      },
      {
        breakpoint: 1200,
        options: {
          chart: {
            height: 120
          }
        }
      },
      {
        breakpoint: 1045,
        options: {
          chart: {
            height: 100
          }
        }
      },
      {
        breakpoint: 992,
        options: {
          chart: {
            height: 120
          }
        }
      }
    ]
  };
  earningsChart = new ApexCharts($earningsChart, earningsChartOptions);
  earningsChart.render();

}
</script>

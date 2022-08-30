const url = 'chartData.inc.php';

window.onload = () => {
  showYearlyCoursework();
  showYearlyActivities();
};

function showYearlyActivities() {
  $.ajax({
    url: url,
    method: 'POST',
    data: {
      action: 'getYearlyActivities',
    },
    success: function (result) {
      const responseData = JSON.parse(result);
      if (responseData.length === 0) {
        document.querySelector(
          '#yearlyActivityDiv'
        ).innerHTML = `<div class="alert alert-warning" role="alert">
    <i class="fas fa-calendar fa-2x"></i>
    No Personal Events added yet. Why not add a activity by visiting your  <a href="../calendar/calendar.php?calendar=personal" class="alert-link">personal calendar</a>
</div>`;
        return;
      }
      google.charts.load('current', {
        packages: ['corechart'],
      });
      google.charts.setOnLoadCallback(function () {
        drawYearlyActivities(responseData);
      });
    },
  });

  function drawYearlyActivities(result) {
    let chartDataActivities = [
      ['', 'Incomplete', 'in progress', 'Completed']
    ];

    for (let i = 0; i < result.length; i++) {
      chartDataActivities.push([
        result[i].month,
        parseInt(result[i].total_not_completed),
        parseInt(result[i].total_in_progress),
        parseInt(result[i].total_completed),
      ]);
    }

    let data = google.visualization.arrayToDataTable(chartDataActivities);

    let options = {

      width: 600,
      height: 400,
      legend: {
        position: 'top',
        maxLines: 3,
      },
      bar: {
        groupWidth: '75%',
      },
      series: {
        0: {
          color: '#dc3545',
        },
        1: {
          color: '#ffc107',
        },
        2: {
          color: '#28a745',
        },
      },
      isStacked: true,
    };
    // Instantiate and draw our chart, passing in some options.
    let chart = new google.visualization.ColumnChart(document.getElementById('yearlyActivityDiv'));
    chart.draw(data, options);
  }
}
$(document).ready(function () {
  $('.btnViewChecklist').click(function (e) {
    e.preventDefault();
    let courseworkID = $(this).data('coursework-id');
    let courseworkTitle = $(this).data('cw-title');
    $('#coursework-title').text(courseworkTitle);
    createChart(courseworkID);
    $('#viewChecklistData').modal('show');
  });

  function createChart(coursework_id) {
    $.ajax({
      url: url,
      method: 'POST',
      data: {
        action: 'getCWChecklist',
        coursework_id: coursework_id,
      },
      dataType: 'JSON',
      success: function (data) {
        let status_level = [];
        let status_total = [];
        let color = [];

        for (let count = 0; count < data.length; count++) {
          status_level.push(data[count].status_level);
          status_total.push(data[count].status_total);
          color.push(data[count].color);
        }

        let checklist_chart_data = {
          labels: status_level,
          datasets: [{
            backgroundColor: color,
            color: '#fff',
            data: status_total,
          },],
        };

        new Chart($('#checkListPieChart'), {
          type: 'pie',
          data: checklist_chart_data,
          responsive: true,
        });
      },
      error: (e) => console.error(`error fetching checklist results ${e}`),
    });
  }
});

function showYearlyCoursework() {
  $.ajax({
    url: url,
    method: 'POST',
    data: {
      action: 'getCWChartData',
    },
    success: function (response) {
      const responseData = JSON.parse(response);
      if (responseData.length === 0) {
        document.querySelector(
          '#coursework-bar'
        ).innerHTML = `<div class="alert alert-warning" role="alert">
    <i class="fa-solid fa-thumbs-down fa-2x"></i>
    No coursework added yet. why not add a coursework <a href="../coursework/add_coursework.php" class="alert-link">here</a>
</div>`;
        return;
      }

      drawYearlyCoursework(responseData);
    },
    error: (e) => console.error(`error fetching coursework results ${e}`),
  });
}

function drawYearlyCoursework(response) {
  const colours = [
    '#29abe2',
    '#ffc142',
    '#1ab394',
    '#9F33FF',
    '#FF3377',
    '33FF90',
    '#030911',
    '#EAA72E',
    '#31EA2E',
  ];

  Morris.Bar({

    element: 'coursework-bar',
    data: response,
    xkey: 'month',
    ykeys: ['total'],
    labels: ['Total'],


    barColors: (row) => colours[row.x],
    colours: (row) => colours[row.x],
    hoverCallback: function (index, options, content, row) {

      let data = options.data[index];
      let dataStr = data.month;
      const myArray = dataStr.split(' ');

      let courseworkDetails = `${data.month} <br> <strong>Total</strong>: ${row.total} <br>`;
      $.ajax({
        url: url,
        data: {

          month: myArray[0],
          year: myArray[1],
          action: 'getCourseworkDetails',

        },
        method: 'POST',
        async: false,
        success: function (response) {
          let responseData = JSON.parse(response);
          responseData.forEach(i => courseworkDetails += `${i.module}: ${i.total} <br>`);

        }
      });


      return (courseworkDetails);
    }


  });
}

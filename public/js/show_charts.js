var dataPoints = [
    { label: "Iraq", y: 10.09 },
    { label: "Turks & Caicos Islands", y: 9.40 },
    { label: "Nauru", y: 8.50 },
    { label: "Ethiopia", y: 7.96 },
    { label: "Uzbekistan", y: 7.80 },
    { label: "Nepal", y: 7.56 },
    { label: "Iceland", y: 7.20 },
    { label: "India", y: 7.1 }

];

var options = {
    animationEnabled: true,
    title: {
        text: "GDP Growth Rate - " + (new Date().getFullYear())
    },
    axisY: {
        title: "Growth Rate (in %)",
        suffix: "%"
    },
    axisX: {
        title: "Countries"
    },
    data: [{
        type: "column",
        yValueFormatString: "#,##0.0#"%"",
        dataPoints: dataPoints
    }]
};

function showCharts() {
    $("#chart_static").CanvasJSChart(options);

    $("#chart_dynamic").CanvasJSChart(options);
    setTimeout(updateChartDynamicData, 1500);
}

function renderData(data) {
    dataPoints.splice(0, dataPoints.length)
    $.each(data.data, function(key, value) {
        dataPoints.push({label: value.label, y: parseInt(value.y)});
    });
    $("#chart_dynamic").CanvasJSChart().render();

    setTimeout(function() {
        updateChartDynamicData(data.page + 1);
    }, 1500);
}

function updateChartDynamicData(page) {
    $.getJSON("/?page=" + (parseInt(page) || 0), renderData);
}



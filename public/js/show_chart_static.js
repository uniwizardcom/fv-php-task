
function showChartStatic() {
    $("#chart_static").CanvasJSChart({
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
            dataPoints: [
                { label: "Iraq", y: 10.09 },
                { label: "Turks & Caicos Islands", y: 9.40 },
                { label: "Nauru", y: 8.50 },
                { label: "Ethiopia", y: 7.96 },
                { label: "Uzbekistan", y: 7.80 },
                { label: "Nepal", y: 7.56 },
                { label: "Iceland", y: 7.20 },
                { label: "India", y: 7.1 }

            ]
        }]
    });
}

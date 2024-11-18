function showChartDates(conf) {
    var privateObject = {
        datePickerFrom: $('#' + conf.date_picker_from_id),
        datePickerTo: $('#' + conf.date_picker_to_id),
        chartContainer: $('#' + conf.chart_id),

        dataPoints: [],

        setupDatePickerFrom: function() {
            this.datePickerFrom.datepicker({
                dateFormat: 'yy-mm-dd',
                defaultDate: (new Date()).getDate()
            });

            var prv = this;
            this.datePickerFrom.change(function() {
                let startDate = $(this).datepicker('getDate');
                prv.datePickerTo.datepicker("option", "minDate", startDate);

                publicObject.updateChart();
            });
        },

        setupDatePickerTo: function() {
            this.datePickerTo.datepicker({
                dateFormat: 'yy-mm-dd',
                defaultDate: (new Date()).getDate()
            });

            var prv = this;
            this.datePickerTo.change(function() {
                let endDate = $(this).datepicker('getDate');
                prv.datePickerFrom.datepicker("option", "maxDate", endDate);

                publicObject.updateChart();
            });
        },

        setupChart: function() {
            this.chartContainer.CanvasJSChart({
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
                    dataPoints: privateObject.dataPoints
                }]
            });

            publicObject.updateChart();
        },

        runRequestForData: function(data, callback) {
            let urlParams = ['filter=true'], url = '/';
            if('timestampFrom' in data) urlParams.push('datefrom=' + data.timestampFrom);
            if('timestampTo' in data) urlParams.push('dateto=' + data.timestampTo);

            if(urlParams.length > 0) {
                url += '?' + urlParams.join('&');
            }

            $.getJSON(url, callback);
        }
    };

    var publicObject = {
        run: function() {
            privateObject.setupDatePickerFrom();
            privateObject.setupDatePickerTo();
            privateObject.setupChart();
        },

        updateChart: function() {
            let dateFrom = privateObject.datePickerFrom.datepicker('getDate'),
                dateTo = privateObject.datePickerTo.datepicker('getDate'),
                data = {};
            if(dateFrom) data.timestampFrom = dateFrom / 1000;
            if(dateTo) data.timestampTo = dateTo / 1000;

            privateObject.runRequestForData(data, function(data) {
                privateObject.dataPoints.splice(0, privateObject.dataPoints.length)
                $.each(data.data, function(key, value) {
                    privateObject.dataPoints.push({label: value.label, y: parseInt(value.y)});
                });

                privateObject.chartContainer.CanvasJSChart().render();
                console.log(data);
            });
        }
    };

    return publicObject;
}

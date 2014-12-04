/**
 * @author Andrei-Robert Rusu
 * @type {{options: {xAxis: {type: string, tickInterval: number, tickWidth: number, gridLineWidth: number, labels: {align: string, x: number, y: number}}, yAxis: Array, legend: {align: string, verticalAlign: string, y: number, floating: boolean, borderWidth: number}, tooltip: {shared: boolean, crosshairs: boolean}, plotOptions: {series: {cursor: string, point: {events: {click: Function}}, marker: {lineWidth: number}}}, chart: {}, title: {}, subtitle: {}, series: Array}, _seriesTotal: number, SetInformation: Function, SetInformationLines: Function}}
 */
LayoutHelperEasyChart = {
    options : {
        xAxis: {
            type: 'datetime',
            tickInterval: 24 * 3600 * 1000, // one week
            tickWidth: 0,
            gridLineWidth: 1,
            labels: {align: 'left', x: 3, y: -3}
        },

        yAxis: [{ // left y axis
            title: { text: null },
            labels: {
                align: 'left',
                x: 3,
                y: 16,
                formatter: function() {
                    return Highcharts.numberFormat(this.value, 0);
                }
            },
            showFirstLabel: false
        }, { // right y axis
            linkedTo: 0,
            gridLineWidth: 0,
            opposite: true,
            title: {
                text: null
            },
            labels: {
                align: 'right',
                x: -3,
                y: 16,
                formatter: function() {
                    return Highcharts.numberFormat(this.value, 0);
                }
            },
            showFirstLabel: false
        }],

        legend: {
            align: 'left',
            verticalAlign: 'top',
            y: 20,
            floating: true,
            borderWidth: 0
        },

        tooltip: {
            shared: true,
            crosshairs: true
        },

        plotOptions: {
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function() {
                            console.log('To be finished');
                            return false;
                            hs.htmlExpand(null, {
                                pageOrigin: {
                                    x: this.pageX,
                                    y: this.pageY
                                },
                                headingText: this.series.name,
                                maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) +':<br/> '+
                                    this.y +' visits',
                                width: 200
                            });
                        }
                    }
                },
                marker: {
                    lineWidth: 1
                }
            }
        },
        chart : {},
        title : {},
        subtitle : {},
        series : []
    },

    _seriesTotal : 0,

    SetInformation : function(targetIdentifier, title, subtitle, series){
        this.options.chart = { renderTo: targetIdentifier };
        this.options.title = { text: title };
        this.options.subtitle = { text: subtitle };
        this.options.series = [];


        for(var i = 0; i< series.length ; i++) {
            var current_name = series[i];

            this.options.series[i] = {name: current_name};
        }

        this._seriesTotal = this.options.series.length;
    },

    /**
     * Check out the full documentation on the information text
     * @param information_text
     * @constructor
     */
    SetInformationLines : function(information_text){
        var lines = [],
            date,
            information = [],
            i,
            object = this;

        for(i=1; i<= object._seriesTotal;i++)
            information[i]  =  [];

        var tsv = information_text.split(/\n/g);

        jQuery.each(tsv, function(i, line) {
            if(jQuery.trim(line) != '') {
                line = line.split(/\t/);

                date = Date.parse(line[0] +' UTC');

                for(i=1; i<= object._seriesTotal;i++)
                    information[i].push([date, parseInt(line[i].replace(',', ''), 10)]);
            }
        });

        for(i=1; i<= object._seriesTotal;i++)
            object.options.series[(i-1)].data = information[i];

        new Highcharts.Chart(object.options);
    }
};
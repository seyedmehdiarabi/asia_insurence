<template>

    <div>
        <div v-if="send_request" class="progress_box">

            <v-progress-circular indeterminate color="red"></v-progress-circular>

        </div>

        <div v-else class="mr-6">

            <highcharts :options="chartOptions"></highcharts>

        </div>
    </div>

</template>

<script>
import {Chart} from "highcharts-vue";

export default {
    name: "UserStatistics",
    data() {
        const self = this;
        return {
            send_request: false,
            chartOptions: {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    style: {
                        fontFamily: 'IRANSansWeb',
                    }
                },
                title: {
                    text: ''
                },
                tooltip: {
                    useHTML: true,
                    formatter: function () {
                        return '<span style="font-size: 12px;float: right">'+this.key+'</span>' + '<br>' +'<div style="padding:5px;">' + this.series.name + ' : ' + self.replaceNumber(self.number_format(this.y)) + ' نفر'+  '</div>';
                    },
                    style: {
                        fontSize: "15px",
                        fontFamily: "IRANYekanWeb"
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            connectorColor: 'silver',
                        },
                    }
                },
                series: [{
                    name: 'تعداد',
                    data: [10,20,30]
                }],
                credits: {
                    enabled: false,
                },
            },
        }
    },
    components: {
        highcharts: Chart
    },
    mounted() {
            this.getData();
    },
    methods: {
        getData: function () {
            this.send_request = true;
            let url = this.$siteUrl + '/statistics/user';
            this.axios.get(url).then(response => {
                this.send_request = false;
                this.chartOptions['series'][0]['data'] = response.data['count'];
            }).catch((error) => {
                this.send_request = false;
            });
        },
        replaceNumber: function (n) {
            if (n !== undefined) {
                n = n.toString();
                const find = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                const replace = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
                for (let i = 0; i < find.length; i++) {
                    n = n.replace(new RegExp(find[i], 'g'), replace[i]);
                }
                return n;
            }
        },
        number_format: function (num) {
            num = num.toString();
            let format = '';
            let counter = 0;
            for (let i = num.length - 1; i >= 0; i--) {
                format += num[i];
                counter++;
                if (counter === 3) {
                    format += ",";
                    counter = 0;
                }
            }
            return format.split('').reverse().join('');
        }
    }
}
</script>

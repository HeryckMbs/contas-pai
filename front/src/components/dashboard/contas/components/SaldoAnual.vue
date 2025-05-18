<template>
    <v-card>
        <highcharts :options="chartOptions2"></highcharts>
    </v-card>
</template>
<script lang="ts">
import DashboardService from '@/service/DashboardService';

export default {
    props:{
    
        yearFilter:{
            required:true
        }
    },
    data() {
        return {
            saldoAnual: [],

        }
    },
    mounted() {
        this.getSaldoAnual();

    },
    watch: {

        yearFilter() {
            this.getSaldoAnual();
        }
    },
    methods: {

        getSaldoAnual() {
            DashboardService.getSaldoAnual(this.yearFilter).then((response) => {
                this.saldoAnual = response.data;
            })
        },
    },
    computed: {
        chartOptions2() {
            return {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: 'Saldo Anual'
                },
                subtitle: {
                    text: 'Veja seu saldo durante o ano!'
                },
                xAxis: {
                    categories: [
                        'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
                        'Out', 'Nov', 'Dez'
                    ]
                },
                yAxis: {
                    title: {
                        text: 'Saldo (R$)'
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    name: 'Saldo',
                    data: this.saldoAnual,
                    color: '#6fa744' // Substitua pelo código da cor desejada
                }]
            }
        },
    }
}
</script>
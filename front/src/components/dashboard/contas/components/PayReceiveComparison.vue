<template>
    <v-card>
        <highcharts :options="chartOptions"></highcharts>
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
            saldoPagarReceber: {
                pagar: [],
                receber: []
            },

        }
    },
    mounted() {
        this.getPagarReceber();

    },
    watch: {

        yearFilter() {
            this.getPagarReceber();
        }
    },
    methods: {

        getPagarReceber() {
            DashboardService.getPagarReceber(this.yearFilter).then((response) => {
                this.saldoPagarReceber = response.data;
            })
        },
    },
    computed: {
        chartOptions() {
            return {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Contas a pagar vs Contas a receber'
                },
                subtitle: {
                    text: 'Compare quanto você gastou vs quanto recebeu'
                },
                xAxis: {
                    categories: [
                        'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
                        'Oct', 'Nov', 'Dez'
                    ]
                },
                yAxis: {
                    title: {
                        text: 'Valor (R$)'
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
                    name: 'Saldo pago',
                    data: this.saldoPagarReceber.pagar,
                    color: '#C81E37'
                }, {
                    name: 'Saldo Recebido',
                    data: this.saldoPagarReceber.receber,
                    color: '#349441'

                }]
            }
        },
    }
}
</script>
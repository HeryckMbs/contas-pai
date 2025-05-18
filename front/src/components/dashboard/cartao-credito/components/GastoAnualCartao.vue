<template>
    <v-card rounded>
        <highcharts :options="options"></highcharts>
    </v-card>
</template>

<script lang="ts">
import DashboardCartaoCredito from '@/service/DashboardCartaoCredito';

export default{
    props: {
        monthFilter: {
            required: true,
        },
        yearFilter: {
            required: true
        }
    },
    data() {
        return {

            cardsComparisonData: [],
   
        }
    },
    mounted() {
        this.getData();
    },
    watch: {
        monthFilter() {
            this.getData()
        },
        yearFilter() {
            this.getData()
        }
    },
    methods: {
        getData() {


            this.fetchCardsComparison();
 
        },
        async fetchCardsComparison(mes = '', ano = '') {
            const response = await DashboardCartaoCredito.getCardsComparison(this.monthFilter, this.yearFilter);
            this.cardsComparisonData = response.data; // Armazena os dados recebidos

        },
    },
    computed:{
        options() {
            return {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: 'Gasto Anual Com Cartões',
                    align: 'left'

                },
                xAxis: {
                    categories: [
                        'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set',
                        'Out', 'Nov', 'Dez'
                    ],
                    accessibility: {
                        description: 'Meses do ano'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Valor (R$)'
                    },
                    labels: {
                        format: 'R$ {value}'
                    }
                },
                tooltip: {
                    crosshairs: true,
                    shared: true
                },
                plotOptions: {
                    spline: {
                        marker: {
                            radius: 4,
                            lineColor: '#666666',
                            lineWidth: 1
                        }
                    }
                },
                series: this.cardsComparisonData

            }
        },
    }
}
</script>
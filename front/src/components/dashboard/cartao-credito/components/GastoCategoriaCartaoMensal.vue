<template>
    <v-card rounded>
        <highcharts :options="categoriaCartao"></highcharts>
    </v-card>
</template>

<script lang="ts">
import DashboardCartaoCredito from '@/service/DashboardCartaoCredito';

export default {

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

            cardsComparisonCategoryData: [],

        }
    },
    watch: {
        monthFilter() {
            this.getData()
        },
        yearFilter() {
            this.getData()
        }
    },
    mounted() {
        this.getData()
    },
    methods: {
        getData() {


            this.fetchCardsComparisonCategory();

        },



        async fetchCardsComparisonCategory(mes = '', ano = '') {
            const response = await DashboardCartaoCredito.getCardsComparisonCategory(this.monthFilter, this.yearFilter);
            this.cardsComparisonCategoryData = response; // Armazena os dados recebidos

        },
    },
    computed: {
        categoriaCartao() {
            return {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Gastos por categoria Cartões Mensal',
                    align: 'left'
                },
                xAxis: {
                    categories: this.cardsComparisonCategoryData.categories, // Acessa a lista de categorias
                    title: {
                        text: 'Categorias'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total Gasto'
                    },
                    stackLabels: {
                        enabled: true
                    }
                },
                legend: {
                    align: 'left',
                    x: 70,
                    verticalAlign: 'top',
                    y: 70,
                    floating: true,
                    backgroundColor: 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: this.cardsComparisonCategoryData.data // Acessa os dados de séries
            };
        }

    }
}
</script>
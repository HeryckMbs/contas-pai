<template>
    <v-card rounded>
        <highcharts :options="gastosPorCategoria"></highcharts>

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


            categorySpentData: [],
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
        this.getData();
    },
    methods: {
        getData() {


            this.fetchCategorySpent();
        },




        async fetchCategorySpent() {
            const response = await DashboardCartaoCredito.getCategorySpent(this.monthFilter, this.yearFilter);
            this.categorySpentData = response.data; // Armazena os dados recebidos

        },
    },
    computed:{
        gastosPorCategoria() {
            return {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Gastos por categoria mensal',
                    align: 'left'
                },
                tooltip: {
                    valueSuffix: '%'
                },
                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        showInLegend: true,
                        dataLabels: [{
                            enabled: true,
                            distance: 20
                        }, {
                            enabled: true,
                            distance: -40,
                            format: ' {point.percentage:.1f}%',
                            style: {
                                fontSize: '1.2em',
                                textOutline: 'none',
                                opacity: 0.7
                            },
                            filter: {
                                operator: '>',
                                property: 'percentage',
                                value: 10
                            }
                        }]
                    }
                },
                series: [
                    {
                        name: 'Valor',
                        colorByPoint: true,
                        data: this.categorySpentData.map((element) => {
                            return { name: element.category_name, y: element.total_spent }
                        })

                    }
                ]


            }
        },
    }
}
</script>
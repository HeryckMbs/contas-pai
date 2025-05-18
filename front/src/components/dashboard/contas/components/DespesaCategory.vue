<template>
    <v-card>
        <highcharts :options="pieChart"></highcharts>
    </v-card>
</template>
<script lang="ts">
import DashboardService from '@/service/DashboardService';

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
            categoryDespesas: []

        }
    },
    mounted() {
        this.getTotalDespesasCategory();
    },
    watch: {
        monthFilter() {
            this.getTotalDespesasCategory();
        },
        yearFilter() {
            this.getTotalDespesasCategory();
        }
    },
    methods: {

        getTotalDespesasCategory() {
            DashboardService.getTotalDespesasCategory(this.monthFilter, this.yearFilter).then((response) => {
                this.categoryDespesas = response.data;
            })
        },
    },
    computed: {
        pieChart() {
            return {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Despesas por Categoria'
                },

                plotOptions: {
                    series: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        showInLegend: true,
                        dataLabels: [{
                            enabled: true,
                            distance: 0
                        }, {
                            enabled: true,
                            distance: -30,
                            format: '{point.percentage:.1f}%',
                            style: {
                                fontSize: '0.8em',
                                textOutline: 'none',
                                opacity: 0.7
                            },
                            filter: {
                                operator: '>',
                                property: 'y',
                                value: 10
                            }
                        }]
                    }
                },
                series: [
                    {
                        colorByPoint: true,

                        name: 'Valor',
                        data:
                            this.categoryDespesas.map((element) => { return { name: element.categoria, y: element.total } })

                    }
                ]
            }
        },
    }
}
</script>
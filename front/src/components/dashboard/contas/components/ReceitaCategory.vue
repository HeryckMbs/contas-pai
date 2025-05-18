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
            categoryReceitas: [],

        }
    },
    mounted() {
        this.getReceitasCategoria();
    },
    watch: {
        monthFilter() {
            this.getReceitasCategoria();
        },
        yearFilter() {
            this.getReceitasCategoria();
        }
    },
    methods: {

        getReceitasCategoria() {
            DashboardService.getReceitasCategoria(this.monthFilter,this.yearFilter).then((response) => {
                this.categoryReceitas = response.data;
            })
        }
    },
    computed: {
        pieChart() {
            return {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Receitas por Categoria'
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
                            format: '{point.percentage:.1f}%',
                            style: {
                                fontSize: '0.8em',
                                textOutline: 'none',
                                opacity: 0.7
                            },
                        
                        }]
                    }
                },

                series: [
                    {
                        name: 'Valor',
                        colorByPoint: true,
                        data:this.categoryReceitas.map((element) => { return { name: element.categoria, y: element.total } })

                    }
                ]
            }
        },
    }
}
</script>
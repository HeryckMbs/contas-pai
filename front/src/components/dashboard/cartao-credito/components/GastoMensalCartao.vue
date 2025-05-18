<template>
    <v-card rounded>
        <highcharts :options="gastoPorCartao"></highcharts>
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

            monthlySpentCard: []
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


            this.getMonthlySpentCard();
        },

        async getMonthlySpentCard() {
            const response = await DashboardCartaoCredito.getMonthlySpentCard(this.monthFilter, this.yearFilter);
            this.monthlySpentCard = response.data; 

        }


    },
    computed: {
        gastoPorCartao() {
            return {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Gasto Mensal por cartão',
                    align: 'left'
                },

                xAxis: {
                    categories: this.monthlySpentCard.map((element) => element.name),
                    crosshair: true,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'R$'
                    }
                },

                plotOptions: {
                    column: {
                        pointPadding: 0.1,
                        pointWidth: 90,
                        borderWidth: 3,
                        dataLabels: [
                            {
                                enabled: true,
                                formatter: function () {
                                    let number = this.y;
                                    return 'R$ ' + number.toFixed(2);
                                },
                                y: -20,
                                inside: false,
                                verticalAlign: 'top',
                                align: 'center',
                                style: {
                                    color: '#000000',
                                    textOutline: 'none',
                                    fontSize: '15px',
                                    fontWeight: 'bolder'
                                }
                            },
                        ]
                    },

                },
                series: [
                    {
                        name: 'Total',
                        data: this.monthlySpentCard.map((element) => element.data)
                    }


                ]
            }
        },





    },



}
</script>
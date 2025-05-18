<template>
    <div>
        <v-card class="elevation-small-2 mb-3 px-4 py-3">
            <v-row align="center">
                <v-col cols="12" xs="12" sm="12" md="12" lg="4" xl="7">
                    <div class="item-card-title-container ">
                        <v-icon color="white" class="bg-primary item-card-title" size="40px"
                            icon="mdi-view-dashboard"></v-icon>
                        <h2 class="main-title">Dashboard </h2>
                    </div>
                </v-col>
                <v-col cols="12" xs="12" sm="12" md="12" lg="8" xl="5">
                    <v-row align="center">

                        <v-col cols="12" xs="12" sm="12" md="3" lg="3" xl="3">
                            <v-select class="data-card-field" :items="months" variant="outlined"
                                :label="$t('cardForm.month')" v-model="monthSelected" item-title="text"
                                item-value="value" dense hide-details outlined data-card-field></v-select>


                        </v-col>
                        <v-col cols="12" xs="12" sm="12" md="3" lg="3" xl="3">
                            <v-select class="data-card-field" :items="years" variant="outlined" hide-details
                                :label="$t('cardForm.year')" v-model="yearSelected" dense outlined
                                data-card-field></v-select>
                        </v-col>
                        <v-col cols="12" xs="12" sm="12" md="6" lg="6" xl="6">
                            <v-select clearable hide-details v-model="dashboardType" item-title="name"
                                label="Tipo do Dashboard" :items="[
                                    { name: 'Comparativo: Contas a Pagar vs Contas a Receber', value: 'pay_receive' },
                                    { name: 'Cartão de Crédito', value: 'credit_card' },
                                ]" variant="outlined"></v-select>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-card>

        <div v-if="dashboardType == 'pay_receive'">
            <dashboard-contas :month-filter="monthSelected" :year-filter="yearSelected" />
        </div>
        <div v-if="dashboardType == 'credit_card'">
            <dashboard-cartao-credito :month-filter="monthSelected" :year-filter="yearSelected" />
        </div>


    </div>
</template>

<script lang="ts">
import DashboardCartaoCredito from '@/components/dashboard/cartao-credito/DashboardCartaoCredito.vue';
import DashboardContas from '@/components/dashboard/contas/DashboardContas.vue';
export default {
    components: { DashboardContas, DashboardCartaoCredito },
    data() {
        return {
            dashboardType: 'pay_receive',
            years: [0],
            months: [0],
            monthSelected: new Date().getMonth() + 1,
            yearSelected: (new Date()).getFullYear(),
          }
    },
    mounted() {
        const dateInfo = this.$getDateInfo(); // Chamando a função global
        this.years = dateInfo.years;
        this.months = dateInfo.months;
        this.monthSelected = dateInfo.monthSelected.value;


    },



}
</script>

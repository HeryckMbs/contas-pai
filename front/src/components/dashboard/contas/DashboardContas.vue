<template>
    <div>

        <metric-cards
        :month-filter="typeof monthFilter == 'object' ? monthFilter.value: monthFilter"
        :yearFilter="yearFilter"
        />
        <v-row>
            <v-col cols="12" sm="12" md="12" lg="6" xl="6">
                <v-card rounded>

                <saldo-anual :yearFilter="yearFilter" ></saldo-anual>
                </v-card>
            </v-col>
            <v-col cols="12" sm="12" md="12" lg="6" xl="6">
                <v-card rounded>
                    <pay-receive-comparison :yearFilter="yearFilter" ></pay-receive-comparison>
                </v-card>
            </v-col>
        </v-row>
        <v-row style="height:90%">
            <v-col cols="12" sm="12" md="12" lg="6" xl="6">
                <v-card rounded>
                    <despesa-category    :month-filter="typeof monthFilter == 'object' ? monthFilter.value: monthFilter"
                    :yearFilter="yearFilter"  />

                </v-card>
            </v-col>
            <v-col cols="12" sm="12" md="12" lg="6" xl="6">
                <v-card rounded>
                    <receita-category    :month-filter="typeof monthFilter == 'object' ? monthFilter.value: monthFilter"
                    :yearFilter="yearFilter"  />

                </v-card>
            </v-col>
        </v-row>
    </div>
</template>

<script lang="ts">
import MetricCards from './components/MetricCards.vue';
import SaldoAnual from './components/SaldoAnual.vue';
import PayReceiveComparison from './components/PayReceiveComparison.vue';
import DespesaCategory from './components/DespesaCategory.vue';
import ReceitaCategory from './components/ReceitaCategory.vue';

export default {
    components: {
        MetricCards,
        SaldoAnual,
        PayReceiveComparison,
        DespesaCategory,
        ReceitaCategory
    },
    props:{
        monthFilter:{
            required:true,
        },
        yearFilter:{
            required:true
        }
    },
    data() {
        return {


        }
    },

}
</script>

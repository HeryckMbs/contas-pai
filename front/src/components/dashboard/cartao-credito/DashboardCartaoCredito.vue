<template>
    <div>
        <metrics-cards-credit :month-filter="typeof monthFilter == 'object' ? monthFilter.value : monthFilter"
            :yearFilter="yearFilter" />
        <v-row>
            <v-col cols="12" sm="12" md="12" lg="6" xl="6">
                <gasto-anual-cartao :month-filter="typeof monthFilter == 'object' ? monthFilter.value : monthFilter"
                    :yearFilter="yearFilter" />
            </v-col>
            <v-col cols="12" sm="12" md="12" lg="6" xl="6">
                <gasto-categoria-cartao-mensal
                    :month-filter="typeof monthFilter == 'object' ? monthFilter.value : monthFilter"
                    :yearFilter="yearFilter" />
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" sm="12" md="12" lg="6" xl="6">
                <gasto-categoria-mensal :month-filter="typeof monthFilter == 'object' ? monthFilter.value : monthFilter"
                    :yearFilter="yearFilter" />
            </v-col>
            <v-col cols="12" sm="12" md="12" lg="6" xl="6">
                <gasto-mensal-cartao :month-filter="typeof monthFilter == 'object' ? monthFilter.value : monthFilter"
                    :yearFilter="yearFilter" />
            </v-col>
        </v-row>
    </div>
</template>

<script lang="ts">

import MetricsCardsCredit from './components/MetricsCardsCredit.vue';
import GastoAnualCartao from './components/GastoAnualCartao.vue';
import GastoCategoriaCartaoMensal from './components/GastoCategoriaCartaoMensal.vue';
import GastoCategoriaMensal from './components/GastoCategoriaMensal.vue';
import GastoMensalCartao from './components/GastoMensalCartao.vue';

export default {
    components:{
        MetricsCardsCredit,
        GastoAnualCartao,
        GastoCategoriaCartaoMensal,
        GastoCategoriaMensal,
        GastoMensalCartao
    },
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

        }
    },







}
</script>

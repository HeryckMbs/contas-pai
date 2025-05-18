<template>
    <v-card rounded="lg" style="height:100%" class="px-3 py-3">
        <template v-slot:title>
            <h4 class="font-weight-black">Detalhes do Cartão de Crédito #{{ creditCard.id }}</h4>
        </template>

        <v-card-text>
            <v-row class="d-flex align-center">
                <v-col md="6" sm="12"  cols="12" >
                    <v-card elevation="10" class="">

                        <v-tabs v-model="tab" bg-color="deep-purple accent-4" dark>
                            <v-tab>
                                Detalhes
                            </v-tab>
                            <v-tab>
                                Compras
                            </v-tab>
                        
                        </v-tabs>

                        <v-tabs-items v-model="tab">
                            <v-tab-item>
                                <v-container v-if="tab == 0">
                                    <v-row class="">
                                        <v-col class="py-3" style="font-size: 15px !important;">Limite Total:
                                            {{ creditCard.cardLimit }}</v-col>
                                        <v-col class="justify-end d-flex py-3"
                                            style="font-size: 15px !important;">Limite
                                            Utilizado: {{ creditCard.cardLimit - creditCard.cardLimitAvaliable
                                            }}</v-col>
                                    </v-row>
                                    <v-progress-linear rounded
                                        :model-value="((creditCard.cardLimit - creditCard.cardLimitAvaliable) / creditCard.cardLimit) * 100"
                                        color="primary" bg-color="#6E39E3" bg-opacity="0.5" height="50"
                                        class=" mb-4">
                                        <template v-slot:default="{ value }">
                                            <div class="mr-2 w-100 text-end">
                                                <strong style="color: white;font-size: 15px !important;">{{
                                                    value.toFixed(2)
                                                    }}%</strong>
                                            </div>
                                        </template>
                                    </v-progress-linear>
                                    <v-row>
                                        <v-col cols="4">
                                            <v-card elevation="10" title="Compras  (Total)" color="primary py-1 "
                                                variant="flat">
                                                <template v-slot:prepend>
                                                    <v-avatar color="error">
                                                        <v-icon icon="mdi-cart"></v-icon>
                                                    </v-avatar>
                                                </template>
                                                <v-card-item>
                                                    <div>

                                                        <div class="text-h6 mb-1 d-gle">
                                                            {{ creditCard.shoppings.qtd }}
                                                        </div>

                                                    </div>
                                                </v-card-item>

                                            </v-card>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-card elevation="10" title="Mais comprado" color="primary py-1 "
                                                variant="flat">
                                                <template v-slot:prepend>
                                                    <v-avatar color="success">
                                                        <v-icon icon="mdi-trophy"></v-icon>
                                                    </v-avatar>
                                                </template>
                                                <v-card-item>
                                                    <div>
                                                        {{
                                                            creditCard.shoppings.most_bought }}
                                                        <div class="text-h2 mb-1 d-gle">



                                                        </div>

                                                    </div>
                                                </v-card-item>

                                            </v-card>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-card elevation="10" title="Compras Mês" color="primary py-1 "
                                                variant="flat">
                                                <template v-slot:prepend>
                                                    <v-avatar color="blue-darken-2">
                                                        <v-icon icon="mdi-calendar-month"></v-icon>
                                                    </v-avatar>
                                                </template>
                                                <v-card-item>
                                                    <div>
                                                        {{
                                                            creditCard.shoppings.shoppingsThisMonthQtd }}
                                                        <div class="text-h2 mb-1 d-gle">



                                                        </div>

                                                    </div>
                                                </v-card-item>

                                            </v-card>
                                        </v-col>


                                    </v-row>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-card title="Produtos comprados " color=" py-1 " elevation="10">
                                                <template v-slot:prepend>
                                                    <v-avatar color="secondary">
                                                        <v-icon icon="mdi-cash-multiple"></v-icon>
                                                    </v-avatar>
                                                </template>
                                                <v-card-item>
                                                    <div>
                                                        <v-chip :key="category"
                                                            v-for="category in creditCard.shoppings.categories"
                                                            class="mb-3 mr-3" color="primary">
                                                            {{ category }} </v-chip>


                                                    </div>
                                                </v-card-item>

                                            </v-card>
                                        </v-col>
                                    </v-row>

                                </v-container>

                                <v-container v-if="tab == 1">
                                    <v-chip variant="tonal" class="mb-3" color="secondary">
                                        Atenção! Esta aba carrega apenas os 100 primeiros itens.
                                    </v-chip>

                                    <v-data-table style="border-radius: 14px; border: 0.2px solid #DEDEDE;"
                                        :items="items">
                                        <template v-slot:[`headers`]="{ item }">
                                            <tr>
                                                <th>Nome</th>
                                                <th>Data de Compra</th>
                                                <th>Valor</th>
                                                <th>Categoria</th>
                                                <th>Parcelas</th>
                                            </tr>
                                        </template>

                                    </v-data-table>

                                </v-container>
                       
                            </v-tab-item>
                        </v-tabs-items>
                    </v-card>
                </v-col>
                <v-col md="6" sm="12" cols="12" >
                    <Card :fields="fields" :labels="creditCard" :isCardNumberMasked="false" />
                </v-col>
            </v-row>

        </v-card-text>


    </v-card>

</template>
<style>
thead {
    background-color: #533495 !important;
    color: white;
}
</style>

<script setup lang="ts">
import { toast } from 'vuetify-sonner';

</script>

<style lang="scss">
@import '@/assets/style.scss';
</style>
<script lang="ts">
import CardForm from '@/components/CardForm.vue';



import CartaoCreditoService from '@/service/CartaoCreditoService';
import Card from '@/components/Card.vue';
export default {
    components: { Card },
    data: () => ({
        categories: [],
        creditCard: {
            id: '',
            cardName: '',
            cardNumber: '',
            cardNumberNotMask: '',
            cardMonth: '',
            cardYear: '',
            cardCvv: '',
            cardNameTitle: '',
            cardLimit: 0,
            cardLimitAvaliable: 0,
            shoppings: {
                qtd: 1,
                most_bought: '',
                categories: []
            }
        },
        fields: {
            cardNumber: 'v-card-number',
            cardName: 'v-card-name',
            cardMonth: 'v-card-month',
            cardYear: 'v-card-year',
            cardCvv: 'v-card-cvv',
            cardLimit: 'v-card-limit'
        },
        tab: 0,
        tabs: [
            { name: 'Aba 1', content: 'Conteúdo da Aba 1' },
            { name: 'Aba 2', content: 'Conteúdo da Aba 2' },
            { name: 'Aba 3', content: 'Conteúdo da Aba 3' },
        ],
        itemsPerPage: 10,
        items: [

        ],

    }),
    async mounted() {
        const id: number = parseInt(this.$route.params.id);
        if (id) await this.findById(id);
    },
    methods: {
        async findById(id: number) {
            CartaoCreditoService.getDetails(id).then((response) => {
                this.creditCard = response.data;
                this.items = response.data.shoppings.shoppings
            })
        },
        getAll() {
            this.loading = false;
        }
    }
}
</script>
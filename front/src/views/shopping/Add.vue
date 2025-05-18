<template>
    <v-card rounded="lg" style="height:100%" class="px-3 py-3">
        <template v-slot:title>
            <h4 class="font-weight-black">Cadastro de Compra</h4>
        </template>

        <v-card-text>
            <v-row>
                <v-col xs="12" sm="12" md="3" cols="3">
                    <v-text-field prepend-icon="mdi-cash" rounded class="mb-5" variant="outlined" type="text"
                        v-model="billToPay.name" label="Nome"></v-text-field>
                </v-col>
                <v-col xs="12" sm="12" md="3" cols="3">
                    <v-text-field prepend-icon="mdi-cash" rounded class="mb-5" variant="outlined" type="number"
                        v-model="billToPay.amount" label="Valor"></v-text-field>
                </v-col>
                <v-col xs="12" sm="12" md="3" cols="3">
                    <v-text-field prepend-icon="mdi-cash" rounded class="mb-5" variant="outlined" type="number"
                        v-model="billToPay.installments" label="Número de parcelas"></v-text-field>
                </v-col>
                <v-col xs="12" sm="12" md="3" cols="3">
                    <v-date-input ok-text="CONFIRMAR" cancel-text="CANCELAR" v-model="billToPay.purchase_date"
                        color="primary" label="Data de Compra" variant="outlined"></v-date-input>

                </v-col>
                <v-col cols="6">
                    <v-select item-title="name" v-model="billToPay.category" prepend-icon="mdi-tag" label="Categoria"
                        :items="shoppingCategories" item-value="id"  variant="outlined"></v-select>

                </v-col>
                <v-col cols="6">
                    <v-select item-title="title_name" v-model="billToPay.credit_card" prepend-icon="mdi-card" label="Cartão de Crédito"
                        :items="creditCards" item-value="id"  variant="outlined"></v-select>

                </v-col>
            </v-row>
            <v-row>

            </v-row>
            <v-row>

                <v-col cols="12">
                    <v-textarea clearable v-model="billToPay.description" rounded="" label="Descrição"
                        prepend-icon="mdi-comment-text" variant="outlined"></v-textarea>
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions>
            <v-btn @click="create" variant="flat" size="large" rounded="lg" color="primary" class="mx-4 ">

                Adicionar Compra
            </v-btn>

        </v-card-actions>
 
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

<script lang="ts">

import ContasPagarService from '@/service/ContasPagarService';
import CartaoCreditoService from '@/service/CartaoCreditoService';
import ShoppingService from '@/service/ShoppingService';
export default {
    data: () => ({
        billToPay: {
            name:'',
            amount: 0,
            purchase_date: new Date(),
            credit_card: '',
            installments:1,
            description: '',
            category:''
        },
        shoppingCategories: [],
        creditCards:[],

    }),
    mounted() {
        this.getCreditCards();
        this.getAllShoppingCategories()
    },
    methods: {
        create() {
            ShoppingService.create(this.billToPay).then((response) => {
                let title = ''
                let messages = [];
                const erros = Object.keys(response);
                if (erros.includes('original')) {
                    const errorIndex = Object.keys(response.original.errors);
                    title = 'Erro!';
                    for(let idx of errorIndex){
                        messages.push(response.original.errors[idx].join('<br>'))
                    }
                } else {

                    title = 'Sucesso!',
                    messages= [response.message];
                }
                toast(title, {

                    description: messages.join('<br>'), // subtitle of the snackbar

                    prependIcon: 'mdi-check-circle',
                    progressBar: true, // show or hide countdown progress bar


                })
            })
            this.$router.push({name:'Histórico de Compras'})
        },
        getCreditCards(){
            CartaoCreditoService.getAll().then((response)=>{
                this.creditCards = response.data
            })
        },
        getAllShoppingCategories(){
            ShoppingService.getAllShoppingCategories().then((response)=>{
                this.shoppingCategories = response.data;
            })
        }
    }
}
</script>
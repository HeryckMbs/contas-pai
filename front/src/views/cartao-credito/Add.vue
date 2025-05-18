<template>
    <v-card rounded="lg" style="height:100%" class="px-3 py-3">
        <template v-slot:title>
            <h4 class="font-weight-black">Cadastro de Cartão de Crédito</h4>
        </template>

        <v-card-text>
            <v-row>
                <v-col cols="12">
                    <CardForm :form-data="formData"  />
                </v-col>
            </v-row>

        </v-card-text>
        <v-card-actions>
            <v-btn @click="create" variant="flat" size="large" rounded="lg" color="primary" class="mx-4 ">

                Adicionar Cartão de Crédito
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

<style lang="scss">
@import '@/assets/style.scss';
</style>
<script lang="ts">
import CardForm from '@/components/CardForm.vue';

import CategoriaService from '@/service/CategoriaService';
import CartaoCreditoService from '@/service/CartaoCreditoService';
export default {
    components: { CardForm },
    data: () => ({
        formData: {
            id: '',
            cardName: '',
            cardNumber: '',
            cardNumberNotMask: '',
            cardMonth: '',
            cardYear: '',
            cardCvv: '',
            cardNameTitle: '',

            cardLimit: 0,
        },
        categories: []
    }),
    mounted() {
        this.getCategories();
    },
    methods: {
        create() {
            CartaoCreditoService.create(this.formData).then((response) => {
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
            this.$router.push('/cartao-credito')
        },
        getCategories() {

            CategoriaService.getAll('income').then((response) => {
                this.categories = response.data;
            })
        },
        updateCardNumber(val) {
            return val;
        },
        updateCardName(val) {
        },
        updateCardMonth(val) {
        },
        updateCardYear(val) {
        },
        updateCardCvv(val) {
        }
    }
}
</script>
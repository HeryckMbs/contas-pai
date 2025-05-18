<template>
    <v-card rounded="lg" style="height:100%" class="px-3 py-3">
        <template v-slot:title>
            <h4 class="font-weight-black">Edição de Cartão de crédito</h4>
        </template>

        <v-card-text>
            <v-row>
                <v-col cols="12">
                    <CardForm :form-data="formData" @input-card-number="updateCardNumber"
                        @input-card-name="updateCardName" @input-card-month="updateCardMonth"
                        @input-card-year="updateCardYear" @input-card-cvv="updateCardCvv" />
                </v-col>
            </v-row>

        </v-card-text>
        <v-card-actions>
            <v-btn @click="update" variant="flat" size="large" rounded="lg" color="primary" class="mx-4 ">

                Editar Cartão de Crédito
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
    async mounted() {
        const id: number = parseInt(this.$route.params.id);
        if (id) await this.findById(id);
    },
    methods: {
        update() {
            CartaoCreditoService.update(this.formData).then((response) => {
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
        async findById(id: number) {
            CartaoCreditoService.findById(id).then((response) => {
                this.formData = response.data;
            })
        },
        updateCardNumber(val) {
            // return val;
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
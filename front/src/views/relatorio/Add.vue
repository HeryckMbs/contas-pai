<template>
    <v-card rounded="lg" style="height:100%" class="px-3 py-3">
        <template v-slot:title>
            <h4 class="font-weight-black">Emissão de relatório</h4>
        </template>

        <v-card-text>
            <v-row>
                <v-col cols="3">
                    <v-text-field prepend-icon="mdi-cash" rounded class="mb-5" variant="outlined" type="text"
                        v-model="category.name" label="Nome"></v-text-field>
                </v-col>
                <v-col  cols="3" >
                    <v-select clearable hide-details v-model="category.type" item-title="name"
                    label="Tipo do Dashboard" :items="[
                        { name: 'Faturas Cartão de crédito', value: 'credit_card' },
                        { name: 'Entradas e Saídas', value: 'contas' },
                    ]" variant="outlined"></v-select>
                </v-col>
                <v-col cols="3">
                    <v-select class="data-card-field" :items="months" variant="outlined"
                        :label="$t('cardForm.month')" v-model="category.monthSelected" item-title="text"
                        item-value="value" dense hide-details outlined data-card-field></v-select>


                </v-col>
                <v-col cols="3">
                    <v-select class="data-card-field" :items="years" variant="outlined" hide-details
                        :label="$t('cardForm.year')" v-model="category.yearSelected" dense outlined
                        data-card-field></v-select>
                </v-col>
           
            </v-row>
   
        </v-card-text>
        <v-card-actions>
            <v-btn @click="create" variant="flat" size="large" rounded="lg" color="primary" class="mx-4 ">

                Gerar relatório
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

import RelatorioService from '@/service/RelatorioService';
export default {
    data: () => ({
        category: {
            name: '',
            type: '',
            month: new Date().getMonth() + 1,
            year: 2024
        },
        years: [0],
            months: [0],
       
    }),
    mounted() {
        const dateInfo = this.$getDateInfo(); // Chamando a função global
        this.years = dateInfo.years;
        this.months = dateInfo.months;
        this.monthSelected = dateInfo.monthSelected.value;


    },
    methods: {
        create() {
            RelatorioService.create(this.category).then((response) => {
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
                this.$router.push({ name: 'Histórico de Relatórios' })
            })
        }
    }
}
</script>
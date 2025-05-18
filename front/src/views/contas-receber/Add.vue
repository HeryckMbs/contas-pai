<template>
    <v-card rounded="lg" style="height:100%" class="px-3 py-3">
        <template v-slot:title>
            <h4 class="font-weight-black">Cadastro de conta a receber</h4>
        </template>

        <v-card-text>
            <v-row>
                <v-col xs="12" sm="12" md="3" cols="3">
                    <v-text-field prepend-icon="mdi-cash" rounded class="mb-5" variant="outlined" type="number"
                        v-model="billToRecieve.amount" label="Valor"></v-text-field>
                </v-col>
                <v-col xs="12" sm="12" md="3" cols="3">
                    <v-date-input ok-text="CONFIRMAR" cancel-text="CANCELAR" v-model="billToRecieve.received_date"
                        color="primary" label="Data de Pagamentop" variant="outlined"></v-date-input>

                </v-col>
                <v-col xs="12" sm="12" md="3" cols="3">
                    <v-select hide-details v-model="billToRecieve.status" item-title="name" prepend-icon="mdi-clock" label="Status" :items="[
                        { name: 'Recebido', value: 'received' },
                        { name: 'Pendente', value: 'pending' },
                    ]" variant="outlined"></v-select>
                </v-col>
                <v-col cols="3">
                    <v-select item-title="name" v-model="billToRecieve.category" prepend-icon="mdi-tag" label="Categoria"
                        :items="categories" item-value="id" variant="outlined"></v-select>

                </v-col>
            </v-row>
            <v-row>
                <v-col  cols="12">
                    <v-select v-model="billToRecieve.recurrence" item-title="name" item-value="value"
                        prepend-icon="mdi-clock" label="Recorrência" :items="[
                            { name: 'Única', value: 'UNICA' },
                            { name: 'Semanal', value: 'SEMANAL' },
                            { name: 'Mensal', value: 'MENSAL' },
                            { name: 'Trimestral', value: 'TRIMESTRAL' },
                            { name: 'Semestral', value: 'SEMESTRAL' },
                            { name: 'Anual', value: 'ANUAL' }
                        ]" variant="outlined" />
                </v-col>
            </v-row>
            <v-row>

                <v-col cols="12">
                    <v-textarea clearable v-model="billToRecieve.description" rounded="" label="Descrição"
                        prepend-icon="mdi-comment-text" variant="outlined"></v-textarea>
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions>
            <v-btn @click="create" variant="flat" size="large" rounded="lg" color="primary" class="mx-4 ">

                Adicionar Recebimento
            </v-btn>

        </v-card-actions>
        <pre>
    
</pre>
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

import CategoriaService from '@/service/CategoriaService';
import ContasReceberService from '@/service/ContasReceberService';
export default {
    data: () => ({
        billToRecieve: {
            amount: 0,
            received_date: new Date(),
            status: '',
            category: '',
            description: '',
            recurrence:''
        },
        categories: []
    }),
    mounted() {
        this.getCategories();
    },
    methods: {
        create() {
            ContasReceberService.create(this.billToRecieve).then((response) => {
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
            this.$router.push('/contas-receber')
        },
        getCategories() {

            CategoriaService.getAll('income').then((response) => {
                this.categories = response.data;
            })
        }
    }
}
</script>
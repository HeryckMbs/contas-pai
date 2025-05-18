<template>
    <v-card rounded="lg" style="height:100%" class="px-3 py-3">
        <template v-slot:title>
            <h4 class="font-weight-black">Cadastro de Conta a pagar</h4>
        </template>

        <v-card-text>
            <v-row>
                <v-col xs="12" sm="12" md="3" cols="3">
                    <v-text-field prepend-icon="mdi-cash" rounded class="mb-5" variant="outlined" type="number"
                        v-model="billToPay.amount" label="Valor"></v-text-field>
                </v-col>
                <v-col xs="12" sm="12" md="3" cols="3">
                    <v-date-input ok-text="CONFIRMAR" cancel-text="CANCELAR" v-model="billToPay.due_date"
                        color="primary" label="Data de Vencimento" variant="outlined"></v-date-input>

                </v-col>
                <v-col xs="12" sm="12" md="3" cols="3">
                    <v-select v-model="billToPay.status" item-title="name" prepend-icon="mdi-clock" label="Status" :items="[
                        { name: 'Pago', value: 'paid' },
                        { name: 'Pendente', value: 'pending' },
                    ]" variant="outlined"></v-select>
                </v-col>
                <v-col cols="3">
                    <v-select item-title="name" v-model="billToPay.category" prepend-icon="mdi-tag" label="Categoria"
                        :items="categories" item-value="id" variant="outlined"></v-select>

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
            <v-btn @click="update" variant="flat" size="large" rounded="lg" color="primary" class="mx-4 ">

                Adicionar Conta a Pagar
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

import ContasPagarService from '@/service/ContasPagarService';
import CategoriaService from '@/service/CategoriaService';
export default {
    data: () => ({
        billToPay: {
            amount: 0,
            due_date: new Date(),
            status: '',
            category: '',
            description: ''
        },
        categories: []
    }),
    mounted() {
        this.getCategories();
        const id: number  = parseInt(this.$route.params.id);
        if (id) this.findById(id);
    },
    computed:{
        id(){
            return  parseInt(this.$route.params.id)
        }
    },
    watch:{
        id(){
            this.findById(this.id);
        }
    },
    methods: {
        update() {
            ContasPagarService.update(this.billToPay).then((response) => {
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
                this.$router.push({ name: 'Histórico de Contas Pagar' })
            })
        },
        getCategories() {

            CategoriaService.getAll().then((response) => {
                this.categories = response.data;
            })
        },
        findById(id: number) {
            ContasPagarService.findById(id).then((response) => {
                this.billToPay = response.data
            })
        }
    }
}
</script>
<template>
    <v-card rounded="lg" style="height:100%" class="px-3 py-3">
        <template v-slot:title>
            <h4 class="font-weight-black">Cadastro de Categorias Receita/Desepesa</h4>
        </template>

        <v-card-text>
            <v-row>
                <v-col xs="12" sm="12" md="6" cols="6">
                    <v-text-field prepend-icon="mdi-cash" rounded class="mb-5" variant="outlined" type="text"
                        v-model="category.name" label="Nome"></v-text-field>
                </v-col>
                <v-col xs="12" sm="12" md="6" cols="6" >
            <v-select
  v-model="category.type"
  prepend-icon="mdi-tag"
  label="Tipo"
  :items="[
    { text: 'Despesa', value: 'expense' },
    { text: 'Receita', value: 'income' }
  ]"
  item-title="text"
  item-value="value"
  variant="outlined"
/>
                </v-col>
           
            </v-row>
   
        </v-card-text>
        <v-card-actions>
            <v-btn @click="create" variant="flat" size="large" rounded="lg" color="primary" class="mx-4 ">

                Adicionar categoria
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

import CategoriaService from '@/service/CategoriaService';
export default {
    data: () => ({
        category: {
            name: '',
            type: '',

        }
    }),
    methods: {
        create() {
            CategoriaService.create(this.category).then((response) => {
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
                this.$router.push({ name: 'Histórico de Categoria' })
            })
        }
    }
}
</script>
<template>
    <v-card rounded="lg" style="height:100%" class="px-3 py-3">
        <template v-slot:title>
            <h4 class="font-weight-black">Edição de relatório</h4>
        </template>

        <v-card-text>
            <v-row>
                <v-col xs="12" sm="12" md="6" cols="6">
                    <v-text-field prepend-icon="mdi-cash" rounded class="mb-5" variant="outlined" type="text"
                        v-model="category.name" label="Nome"></v-text-field>
                </v-col>
                <v-col xs="12" sm="12" md="6" cols="6" >
                    <v-select v-model="category.type" prepend-icon="mdi-tag" label="Tipo"
                        :items="['expense', 'income',]" variant="outlined"></v-select>
                </v-col>
           
            </v-row>
   
        </v-card-text>
        <v-card-actions>
            <v-btn @click="update" variant="flat" size="large" rounded="lg" color="primary" class="mx-4 ">

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
            id: ''

        }
    }),
    mounted() {
        const id: number  = parseInt(this.$route.params.id);
        if (id) this.findById(id);
    },
    methods: {
        update() {
            CategoriaService.update(this.category).then((response) => {
                toast('Sucesso', {

                    description: 'Some more context of the notification', // subtitle of the snackbar
                    progressBarProps: {

                    },
                    prependIcon: 'mdi-check-circle',
                    progressBar: true, // show or hide countdown progress bar


                })
                this.$router.push({ name: 'Histórico de Categoria' })
            })
        },
        findById(id: number) {
            CategoriaService.findById(id).then((response) => {
                this.category = response.data
            })
        }
        
    }
}
</script>
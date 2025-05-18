<template>
    <v-card rounded="lg" style="height:100%" class="px-3 py-3">
        <template v-slot:title>
            <h4 class="font-weight-black">Listagem de Usuários</h4>
        </template>
        <v-row class="d-flex justify-end">
            <v-btn :to="{ name: 'Adicionar Permissão' }" rounded="lg" color="primary" class="mx-4 ">
                <v-icon size="20px" color="hite" class="icon-status  ">
                    mdi-plus
                </v-icon>
                <span class="ml-2">Adicionar Permissão</span>
            </v-btn>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-data-table-server style="border-radius: 14px; border: 0.2px solid #DEDEDE;" :items-per-page="itemsPerPage" :headers="headers" :items="items"
                    :items-length="totalItems" :loading="loading" :search="search" item-value="name"
                    @update:options="getAll">
                    <template v-slot:[`item.actions`]="{ item }">
                        <!-- <pre>{{item}}</pre> -->
                        <v-col cols="auto">
                         <v-btn @click="deletePermission(item.id)" color="error" density="comfortable" icon="mdi-delete"></v-btn>
                       </v-col>
                     </template>
                </v-data-table-server>
             
            </v-col>
        </v-row>
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
import UserService from '@/service/UserService';

export default {
    data: () => ({
        itemsPerPage: 10,
        items: [

        ],
        headers: [
            { title: 'Nome', value: 'nome', sortable: true },
            { title: 'Código', value: 'slug', sortable: true },
            { title: 'Criado em', value: 'created_at', sortable: true },
            { title: 'Ações', value: 'actions', sortable: true }

        ],
        search: '',
        serverItems: [],
        loading: true,
        totalItems: 0,
    }),
    mounted() {
        this.getAll()
    },

    methods: {
        getAll() {
            UserService.getPermission().then((response) => {
                this.items = response.data;
                this.loading = false;
            })
        },
        deletePermission(id: number) {
            this.loading = true;

            UserService.deletePermission(id).then((response) => {
                this.loading = false;
                toast('Sucesso', {

                    description: 'Some more context of the notification', // subtitle of the snackbar
                    progressBarProps: {

                    },
                    prependIcon: 'mdi-check-circle',
                    progressBar: true, // show or hide countdown progress bar

                })
                this.getAll();
            })
        }
    }
}
</script>
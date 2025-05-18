<template>
    <v-card rounded="lg" style="height:100%" class="px-3 py-3">
        <template v-slot:title>
            <h4 class="font-weight-black">Listagem de Usuários</h4>
        </template>
        <v-row class="d-flex justify-end">
            <v-btn :to="{ name: 'Adicionar Usuário' }" rounded="lg" color="primary" class="mx-4 ">
                <v-icon size="20px" color="hite" class="icon-status  ">
                    mdi-plus
                </v-icon>
                <span class="ml-2">Adicionar Usuário</span>
            </v-btn>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-data-table-server style="border-radius: 14px; border: 0.2px solid #DEDEDE;" :items-per-page="itemsPerPage" :headers="headers" :items="items"
                    :items-length="totalItems" :loading="loading" :search="search" item-value="name"
                    @update:options="getAll"></v-data-table-server>
             
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

<script lang="ts">
import UserService from '@/service/UserService';

export default {
    data: () => ({
        itemsPerPage: 10,
        items: [

        ],
        headers: [
            { title: 'Id', value: 'id', sortable: true },
            { title: 'Nome', value: 'name', sortable: true },
            { title: 'Email', value: 'email', sortable: true },
            { title: 'Criado em', value: 'created_at', sortable: true }
        ],
        search: '',
        serverItems: [],
        loading: true,
        totalItems: 0,
    }),

    methods: {
        getAll() {
            UserService.getAll().then((response) => {
                this.items = response.data;
                this.loading = false;
            })
        }
    }
}
</script>
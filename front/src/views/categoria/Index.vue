<template>
    <div>
        <v-card rounded="lg" style="height:100%" class="px-3 py-3">
            <template v-slot:title>
                <div class="d-flex align-center">
                    <v-icon color="white" class="bg-primary item-card-title mr-3" size="40px"
                        icon="mdi-shape-outline"></v-icon>
                    <h3 class="font-weight-black">Listagem de Categorias</h3>
                </div>
            </template>
            <v-row class="d-flex justify-end">
                <v-btn :to="{ name: 'Adicionar Categoria' }" rounded="lg" color="primary" class="mx-4 ">
                    <v-icon size="20px" color="hite" class="icon-status  ">
                        mdi-plus
                    </v-icon>
                    <span class="ml-2">Adicionar Nova categoria</span>
                </v-btn>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-data-table-server style="border-radius: 14px; border: 0.2px solid #DEDEDE;"
                        v-model:items-per-page="itemsPerPage" :headers="headers" :items="items"
                        v-model:items-length="totalItems" :loading="loading" :search="search" v-model:page="page">
                        <template v-slot:[`item.actions`]="{ item }">
                            <v-row>
                                <v-col cols="auto">
                                    <v-btn @click="deleteCategory(item.id)" color="error" density="comfortable"
                                        icon="mdi-delete"></v-btn>
                                </v-col>
                                <v-col cols="auto">
                                    <v-btn @click="editCategory(item.id)" color="warning" density="comfortable"
                                        icon="mdi-pencil"></v-btn>
                                </v-col>
                            </v-row>
                        </template>
                    </v-data-table-server>
                </v-col>
            </v-row>

        </v-card>
    </div>

</template>
<style>
thead {
    background-color: #533495 !important;
    color: white;
}
</style>

<script lang="ts">
import CategoriaService from '@/service/CategoriaService';
export default {
    data: () => ({
        itemsPerPage: 10,
        items: [

        ],
        headers: [
            { title: 'Nome', value: 'name', sortable: true },
            { title: 'Tipo', value: 'type', sortable: true },
            { title: 'Criado em', value: 'created_at', sortable: true },
            { title: 'Ações', value: 'actions', sortable: true }

        ],
        search: '',
        serverItems: [],
        loading: true,
        totalItems: 0,
        page: 1,

    }),
    watch: {
        page() {
            this.getAll();
        },
        itemsPerPage() {
            this.getAll();
        },
    },
    mounted(){
        this.getAll();
    },
    methods: {
        getAll() {
            this.loading = true;
            CategoriaService.getAll('', this.itemsPerPage, this.page).then((response) => {
                this.items = response.data
                this.totalItems = response.meta?.total;

                this.loading = false;
            })
        },
        deleteCategory(id: number) {
            this.loading = true;
            CategoriaService.delete(id).then((response) => {
                this.getAll();
            })
        },
        editCategory(id: number) {
            this.$router.push({ name: 'Editar Categoria', params: { id } })
        }
    }
}
</script>
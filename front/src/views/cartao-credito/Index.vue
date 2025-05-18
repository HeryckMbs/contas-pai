<template>
    <div>
        <v-card rounded="lg" style="height:100%" class="px-3 py-3">
            <template v-slot:title>
                <div class="d-flex align-center">
                    <v-icon color="white" class="bg-primary item-card-title mr-3" size="40px"
                        icon="mdi-cards-outline"></v-icon>
                    <h3 class="font-weight-black">Listagem de Cartões de Crédito</h3>
                </div>
            </template>
            <v-row class="d-flex justify-end">

                <v-btn :to="{ name: 'Adicionar Cartão de Crédito' }" rounded="lg" color="primary" class="mx-4 ">
                    <v-icon size="20px" color="hite" class="icon-status  ">
                        mdi-plus
                    </v-icon>
                    <span class="ml-2">Adicionar Novo Cartão</span>
                </v-btn>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-data-table-server style="border-radius: 14px; border: 0.2px solid #DEDEDE;"
                    v-model:items-per-page="itemsPerPage"  :headers="headers" :items="items"   v-model:items-length="totalItems"
                        :loading="loading" :search="search" item-value="name"                         v-model:page="page"
                        >
                        <template v-slot:[`item.status`]="{ item }">
                            <v-chip :color="item.status_code == 'received' ? 'green' : 'error'">
                                {{ item.status }}
                            </v-chip>
                        </template>
                        <template v-slot:[`item.actions`]="{ item }">
                            <!-- <pre>{{item}}</pre> -->
                            <v-row>
                                <v-col cols="auto">
                                    <v-btn @click="deleteConta(item.id)" color="error" density="comfortable"
                                        icon="mdi-delete"></v-btn>
                                </v-col>
                                <v-col cols="auto">
                                    <v-btn @click="editConta(item.id)" color="warning" density="comfortable"
                                        icon="mdi-pencil"></v-btn>
                                </v-col>
                                <v-col cols="auto">
                                    <v-btn @click="details(item.id)" color="info" density="comfortable"
                                        icon="mdi-information"></v-btn>
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
import CartaoCreditoService from '@/service/CartaoCreditoService';
export default {
    data: () => ({
        itemsPerPage: 10,
        items: [

        ],
        headers: [

            { title: 'Nome', value: 'name', sortable: true },
            { title: 'Proprietário', value: 'owner_name', sortable: true },
            { title: 'Número', value: 'number', sortable: true },
            { title: 'Limite', value: 'limit', sortable: true },
            { title: 'Limite Disponível', value: 'avaliable_limit', sortable: true },
            { title: 'Ações', value: 'actions', sortable: true }

        ],
        search: '',
        serverItems: [],
        loading: true,
        totalItems: 0,
        page:1
    }),
    watch: {
        page() {
            this.getAll();
        
        },
        itemsPerPage(){
            this.getAll();
        },
    },
    mounted(){
this.getAll();
    },
    methods: {
        getAll() {
            this.loading = true;
            CartaoCreditoService.getAll(this.page,this.itemsPerPage).then((response) => {
                this.items = response.data
                this.totalItems = response.meta?.total;
                this.loading = false;
            })
        },
        deleteConta(id: number) {
            this.loading = true;
            CartaoCreditoService.delete(id).then((response) => {
                this.getAll();
            })
        },
        editConta(id: number) {
            this.$router.push({ name: 'Editar Cartão de Crédito', params: { id } })
        },
        details(id: number) {
            this.$router.push({ name: 'Detalhes Cartão de Crédito', params: { id } })
        }

    }
}
</script>
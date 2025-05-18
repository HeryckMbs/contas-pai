<template>
    <div>
        <v-card rounded="lg" style="height:100%" class="px-3 py-3">
            <template v-slot:title>
                <div class="d-flex align-center">
                    <v-icon color="white" class="bg-primary item-card-title mr-3" size="40px"
                        icon="mdi-cart-outline"></v-icon>
                    <h3 class="font-weight-black">Listagem de Compras</h3>
                </div>
            </template>
            <v-row class="d-flex justify-space-between mt-3 mx-3">
                <v-row align="center">

                    <v-col cols="4">
                        <v-select class="data-card-field" :items="months" variant="outlined"
                            :label="$t('cardForm.month')" v-model="monthSelected" item-title="text" item-value="value"
                            dense hide-details outlined data-card-field></v-select>


                    </v-col>
                    <v-col cols="3">
                        <v-select class="data-card-field" :items="years" variant="outlined" hide-details
                            :label="$t('cardForm.year')" v-model="yearSelected" dense outlined
                            data-card-field></v-select>
                    </v-col>

                </v-row>
                <v-row>
                    <v-col class="d-flex justify-end">
                        <v-btn :to="{ name: 'Adicionar Compras' }" rounded="lg" color="primary" class="mx-4 ">
                            <v-icon size="20px" color="hite" class="icon-status  ">
                                mdi-plus
                            </v-icon>
                            <span class="ml-2">Adicionar Nova Compra</span>
                        </v-btn>
                    </v-col>
                </v-row>
            </v-row>

            <v-row>
                <v-col cols="12">
                    <v-data-table-server style="border-radius: 14px; border: 0.2px solid #DEDEDE;"
                        v-model:items-per-page="itemsPerPage" :headers="headers" :items="items" v-model:page="page"
                        v-model:items-length="totalItems" :loading="loading" :search="search">
                        <template v-slot:[`item.status`]="{ item }">
                            <v-chip :color="item.status_code == 'paid' ? 'green' : 'error'">
                                {{ item.status }}
                            </v-chip>
                        </template>
                        <template v-slot:[`item.payed`]="{ item }">
                            <v-chip :color="item.payed ? 'green' : 'error'">
                                {{ item.payed ? 'Pago' : 'Pendente' }}
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
                                    <v-btn @click="pay(item)" color="success" density="comfortable"
                                        icon="mdi-cash"></v-btn>
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
import ShoppingService from '@/service/ShoppingService';
export default {
    data: () => ({
        itemsPerPage: 10,
        items: [

        ],
        headers: [

            { title: 'Nome', value: 'name', sortable: true },
            { title: 'Valor (R$)', value: 'amount', sortable: true },
            { title: 'Data de Compra', value: 'purchase_date', sortable: true },
            { title: 'Parcela', value: 'installment', sortable: true },
            { title: 'Cartão', value: 'credit_card', sortable: true },

            { title: 'Pago', value: 'payed', sortable: true },
            { title: 'Ações', value: 'actions', sortable: true }

        ],
        search: '',
        serverItems: [],
        loading: true,
        totalItems: 0,
        page: 1,
        years: [0],
        months: [0],
        monthSelected: {},
        yearSelected: (new Date()).getFullYear(),
    }),
    watch: {
        page() {
            this.getAll();
        },
        itemsPerPage() {
            this.getAll();
        },
        monthSelected() {
            this.getAll();
        },
        yearSelected() {
            this.getAll();
        }
    },
    mounted() {
        const dateInfo = this.$getDateInfo(); // Chamando a função global
        this.years = dateInfo.years;
        this.months = dateInfo.months;
        this.monthSelected = dateInfo.monthSelected.value;
    },
    methods: {
        getAll() {
            this.loading = true;
            ShoppingService.getAll(this.monthSelected, this.yearSelected, this.itemsPerPage,this.page).then((response) => {
                this.items = response.data
                this.totalItems = response.meta?.total;

                this.loading = false;
            })
        },

        deleteConta(id: number) {
            this.loading = true;
            ShoppingService.delete(id).then((response) => {
                this.getAll();
            })
        },
        editConta(id: number) {
            this.$router.push({ name: 'Editar Compras', params: { id } })
        },
        pay(item: any) {
            this.loading = true;
            ShoppingService.pay({
                id: item.id,
                payed: !item.payed
            }).then((response) => {
                this.getAll();
            })
        }

    }
}
</script>

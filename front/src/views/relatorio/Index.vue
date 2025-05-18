<template>
    <div>
        <v-card rounded="lg" style="height:100%" class="px-3 py-3">
            <template v-slot:title>
                <div class="d-flex align-center">
                    <v-icon color="white" class="bg-primary item-card-title mr-3" size="40px"
                        icon="mdi-file-chart-outline"></v-icon>
                    <h3 class="font-weight-black">Listagem de Relatórios</h3>
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
                        <v-btn :to="{ name: 'Adicionar Relatório' }" rounded="lg" color="primary" class="mx-4 ">
                            <v-icon size="20px" color="hite" class="icon-status  ">
                                mdi-plus
                            </v-icon>
                            <span class="ml-2">Adicionar Novo Relatório</span>
                        </v-btn>
                    </v-col>
                </v-row>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-data-table-server style="border-radius: 14px; border: 0.2px solid #DEDEDE;"
                    v-model:items-per-page="itemsPerPage"
                    :headers="headers"
                    :items="items"
                    v-model:items-length="totalItems"
                    :loading="loading"
                    :search="search"
                    v-model:page="page" >
                        <template v-slot:[`item.actions`]="{ item }">
                            <v-row>
                                <v-col cols="auto">
                                    <v-btn @click="deleteReport(item.id)" color="warning" density="comfortable"
                                        icon="mdi-delete"></v-btn>
                                </v-col>

                                <v-col cols="auto">
                                    <v-btn @click="downloadReport(item.url_report)" :disabled="item.url_report == null"
                                        :color="item.url_report != null ? 'error' : 'grey'" density="comfortable"
                                        icon="mdi-file-pdf-box"></v-btn>
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
import RelatorioService from '@/service/RelatorioService';
export default {
    data: () => ({
        itemsPerPage: 10,
        items: [

        ],
        headers: [
            { title: 'Nome', value: 'name', sortable: true },
            { title: 'Tipo', value: 'type', sortable: true },
            { title: 'Status', value: 'status', sortable: true },
            { title: 'Criado em', value: 'created_at', sortable: true },
            { title: 'Ações', value: 'actions', sortable: true }

        ],
        search: '',
        serverItems: [],
        loading: true,
        totalItems: 0,
        years: [0],
        months: [0],
        page:1,
        monthSelected: {},
        yearSelected: (new Date()).getFullYear(),
    }),
    mounted() {
        const dateInfo = this.$getDateInfo(); // Chamando a função global
        this.years = dateInfo.years;
        this.months = dateInfo.months;
        this.monthSelected = dateInfo.monthSelected.value;

    },
    watch: {
        monthSelected() {
            this.getAll();
        },
        yearSelected() {
            this.getAll();
        }
    },
    methods: {
        getAll() {
            this.loading = true;
            console.log(this.monthSelected)

            RelatorioService.getAll(this.monthSelected,this.yearSelected).then((response) => {
                this.items = response.data
                this.totalItems = response.meta?.total;

                this.loading = false;
            })
        },
        deleteReport(id: number) {
            this.loading = true;
            RelatorioService.delete(id).then((response) => {
                this.getAll();
            })
        },
        editReport(id: number) {
            this.$router.push({ name: 'Editar Categoria', params: { id } })
        },
        downloadReport(url) {
            const link = document.createElement("a");
            link.href = url;
            link.target = "_blank";
            link.download = "arquivo.pdf";

            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}
</script>

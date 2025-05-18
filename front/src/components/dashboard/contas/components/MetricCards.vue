<template>
    <v-row>

        <v-col cols="12" xs="12" sm="6" md="4" lg="3"  >
            <v-card title="Saldo" color="primary py-1 " variant="flat">
                <template v-slot:prepend>
                    <v-avatar color="blue-darken-2">
                        <v-icon icon="mdi-cash-multiple"></v-icon>
                    </v-avatar>
                </template>
                <v-card-item>
                    <div>

                        <div class="text-h2 mb-1 d-gle">
                            {{ saldo }}


                        </div>

                    </div>
                </v-card-item>

            </v-card>

        </v-col>
        <v-col  cols="12" xs="12" sm="6" md="4" lg="3"  >
            <v-card title="Pago" color="primary py-1" variant="flat">
                <template v-slot:prepend>
                    <v-avatar color="error">
                        <v-icon icon="mdi-check-circle-outline"></v-icon>
                    </v-avatar>
                </template>
                <v-card-item>
                    <div>

                        <div class="text-h2 mb-1 d-gle">
                             {{ totalPago }}
                        </div>

                    </div>
                </v-card-item>

            </v-card>

        </v-col>
        <v-col  cols="12" xs="12" sm="6" md="4" lg="3"  >
            <v-card title="Recebido" color="primary py-1" variant="flat">
                <template v-slot:prepend>
                    <v-avatar color="success">
                        <v-icon icon="mdi-cash-check"></v-icon>
                    </v-avatar>
                </template>
                <v-card-item>
                    <div>

                        <div class="text-h2 mb-1 d-gle">
                             {{ totalRecebido }}
                        </div>

                    </div>
                </v-card-item>

            </v-card>

        </v-col>
        <v-col  cols="12" xs="12" sm="6" md="4" lg="3"  >
            <v-card title="A pagar" color="primary py-1" variant="flat">
                <template v-slot:prepend>
                    <v-avatar color="error">
                        <v-icon icon="mdi-cash-minus"></v-icon>
                    </v-avatar>
                </template>
                <v-card-item>
                    <div>

                        <div class="text-h2 mb-1 d-gle">
                            {{ totalPagar }}
                        </div>

                    </div>
                </v-card-item>

            </v-card>

        </v-col>
        <v-col  cols="12" xs="12" sm="6" md="4" lg="3"  >
            <v-card title="A receber" color="primary py-1" variant="flat">
                <template v-slot:prepend>
                    <v-avatar color="success">
                        <v-icon icon=" mdi-cash-plus"></v-icon>
                    </v-avatar>
                </template>
                <v-card-item>
                    <div>

                        <div class="text-h2 mb-1 d-gle">
                            {{ totalReceber }}
                        </div>

                    </div>
                </v-card-item>

            </v-card>

        </v-col>
        <v-col  cols="12" xs="12" sm="6" md="4" lg="3"   >
            <v-card title="Previsão de Saldo" color="primary py-1" variant="flat">
                <template v-slot:prepend>
                    <v-avatar :color="saldoPrevisao > -0.01 ? 'info' : 'error'">
                        <v-icon icon="mdi-chart-line-variant"></v-icon>
                    </v-avatar>
                </template>
                <v-card-item>
                    <div>

                        <div class="text-h2 mb-1 d-gle">
                             {{ saldoPrevisao }}
                        </div>

                    </div>
                </v-card-item>

            </v-card>

        </v-col>

    </v-row>
</template>

<script lang="ts">
import DashboardService from '@/service/DashboardService';

export default {
    props: {
        monthFilter: {
            required: true,
        },
        yearFilter: {
            required: true
        }
    },
    data() {
        return {
            saldo: 0,
            saldoPrevisao: 0,
            totalPago: 0,
            totalRecebido: 0,
            totalPagar: 0,
            totalReceber: 0,
        }
    },
    mounted() {
        this.getAllData();
    },
    watch: {
        monthFilter() {
            this.getAllData();
        },
        yearFilter() {
            this.getAllData();
        }
    },
    methods: {
        getAllData() {
            this.getSaldo();
            this.getTotalPagoMes();
            this.getRecebidoMes();
            this.getTotalPagarMes();
            this.getReceberMes();
            this.getSaldoPrevisao();
        },
        generateMonthValue(n) {
            return n < 10 ? `0${n}` : n
        },
        getSaldo() {
            DashboardService.getSaldo(this.monthFilter,this.yearFilter).then((response) => {
                this.saldo = response.data;
            })
        },
        getTotalPagoMes() {
            DashboardService.getTotalPagoMes('',this.monthFilter,this.yearFilter).then((response) => {
                this.totalPago = response.data;
            })
        },
        getRecebidoMes() {
            DashboardService.getRecebidoMes('',this.monthFilter,this.yearFilter).then((response) => {
                this.totalRecebido = response.data;
            })
        },
        getTotalPagarMes() {
            DashboardService.getTotalPagoMes('pending',this.monthFilter,this.yearFilter).then((response) => {
                this.totalPagar = response.data;
            })
        },
        getReceberMes() {
            DashboardService.getRecebidoMes('pending',this.monthFilter,this.yearFilter).then((response) => {
                this.totalReceber = response.data;
            })
        },
        getSaldoPrevisao() {
            DashboardService.getSaldoPrevisao(this.monthFilter,this.yearFilter).then((response) => {
                this.saldoPrevisao = response.data;
            })
        },
    }
}
</script>

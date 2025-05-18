<template>
    <v-row>
        <v-col cols="12" sm="6" md="4" lg="3" >
            <v-card title="Total Cartões" color="primary py-1 " variant="flat">
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
        <v-col cols="12" sm="6" md="4" lg="3" >
            <v-card title="Cartão Favorito" color="primary py-1" variant="flat">
                <template v-slot:prepend>
                    <v-avatar color="error">
                        <v-icon icon="mdi-check-circle-outline"></v-icon>
                    </v-avatar>
                </template>
                <v-card-item>
                    <div>

                        <div class="text-h2 mb-1 d-gle">
                            {{ favoriteCard }}
                        </div>

                    </div>
                </v-card-item>

            </v-card>

        </v-col>
        <v-col cols="12" sm="6" md="4" lg="3" >
            <v-card title="Compra Rara" color="primary py-1" variant="flat">
                <template v-slot:prepend>
                    <v-avatar color="success">
                        <v-icon icon="mdi-cash-check"></v-icon>
                    </v-avatar>
                </template>
                <v-card-item>
                    <div>

                        <div class="text-h2 mb-1 d-gle">
                            {{ rareShopping }}
                        </div>

                    </div>
                </v-card-item>

            </v-card>

        </v-col>
        <v-col cols="12" sm="6" md="4" lg="3" >
            <v-card title="Compra Favorita" color="primary py-1" variant="flat">
                <template v-slot:prepend>
                    <v-avatar color="error">
                        <v-icon icon="mdi-cash-minus"></v-icon>
                    </v-avatar>
                </template>
                <v-card-item>
                    <div>

                        <div class="text-h2 mb-1 d-gle">
                            {{ favoriteShopping }}
                        </div>

                    </div>
                </v-card-item>

            </v-card>

        </v-col>
        <v-col cols="12" sm="12" md="8" lg="12" >
            <v-card title="Dia com mais compras" color="primary py-1" variant="flat">
                <template v-slot:prepend>
                    <v-avatar color="success">
                        <v-icon icon=" mdi-cash-plus"></v-icon>
                    </v-avatar>
                </template>
                <v-card-item>
                    <div>

                        <div class="text-h2 mb-1 d-gle">
                            {{ mostShoppingDay }}
                        </div>

                    </div>
                </v-card-item>

            </v-card>

        </v-col>


    </v-row>
</template>

<script lang="ts">
import DashboardCartaoCredito from '@/service/DashboardCartaoCredito';

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
            favoriteShopping: '',
            rareShopping: '',
            mostShoppingDay: '',
            favoriteCard: '',
        }
    },
    watch: {
        monthFilter() {
            this.getData()
        },
        yearFilter() {
            this.getData()
        }
    },
    mounted(){
        this.getData();
    },
    methods: {
        getData() {
            this.getSaldo();
            this.getFavoriteShopping();
            this.getRareShopping();
            this.getMostShoppingDay();
            this.getFavoriteCard();
        },
        async getSaldo(mes = '', ano = '') {
            const response = await DashboardCartaoCredito.getSaldo(this.monthFilter, this.yearFilter);
            this.saldo = response.data;
        },

        async getFavoriteShopping(mes = '', ano = '') {
            const response = await DashboardCartaoCredito.getFavoriteShopping(this.monthFilter, this.yearFilter);
            this.favoriteShopping = response.data; // Altere 'favoriteShopping' para a propriedade desejada
        },

        async getRareShopping(mes = '', ano = '') {
            const response = await DashboardCartaoCredito.getRareShopping(this.monthFilter, this.yearFilter);
            this.rareShopping = response.data; // Altere 'rareShopping' para a propriedade desejada
        },

        async getMostShoppingDay(mes = '', ano = '') {
            const response = await DashboardCartaoCredito.getMostShoppingDay(this.monthFilter, this.yearFilter);
            this.mostShoppingDay = response.data; // Altere 'mostShoppingDay' para a propriedade desejada
        },

        async getFavoriteCard(mes = '', ano = '') {
            const response = await DashboardCartaoCredito.getFavoriteCreditCard(this.monthFilter, this.yearFilter);
            this.favoriteCard = response.data; // Armazena o cartão favorito
        },
    }
}
</script>

<template>
    <v-card rounded="lg" style="height:100%" class="px-3 py-3">
        <template v-slot:title>
            <h4 class="font-weight-black">Cadastro de usuário</h4>
        </template>

        <v-card-text>
            <v-row>
                <v-col cols="3">
                    <v-text-field rounded class="mb-5" variant="outlined" type="text" v-model="user.name"
                        label="Nome"></v-text-field>
                </v-col>
                <v-col cols="3">
                    <v-text-field class="mb-5" type="text" v-model="user.email" label="E-mail"></v-text-field>

                </v-col>
                <v-col cols="3">
                    <v-text-field rounded class="mb-5" variant="outlined" type="password" v-model="user.password"
                        label="Senha"></v-text-field>
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions>
            <v-btn @click="create" variant="flat" size="large" rounded="lg" color="primary" class="mx-4 ">

                Adicionar Usuário
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

import UserService from '@/service/UserService';
export default {
    data: () => ({
        user: {
            password: '',
            email: '',
            name: ''
        }
    }),
    methods: {
        create() {
            UserService.createUser(this.user).then((response) => {
                toast('Sucesso', {

                    description: 'Some more context of the notification', // subtitle of the snackbar
                    progressBarProps: {

                    },
                    prependIcon: 'mdi-check-circle',
                    progressBar: true, // show or hide countdown progress bar


                })
                this.$router.push({ name: 'Histórico de Usuários' })
            })
        }
    }
}
</script>
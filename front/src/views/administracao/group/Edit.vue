<template>
    <v-card rounded="lg" style="height:100%" class="px-3 py-3">
        <template v-slot:title>
            <h4 class="font-weight-black">Cadastro de grupo de permissão</h4>
        </template>

        <v-card-text>
            <v-row>
                <v-col cols="3">
                    <v-text-field rounded class="" variant="outlined" type="text" v-model="group.name"
                        label="Nome"></v-text-field>
                </v-col>

            </v-row>
            <v-card>
                <v-card-text>
                    <v-row>
                        <v-col cols="12">
                            <label for="">Permissões</label>

                        </v-col>
                        <v-col cols="2" :key="permissao.id" v-for="permissao in permissions">
                            <v-checkbox color="primary" v-model="group.permissions" :label="permissao.nome"
                                :value="permissao.id"></v-checkbox>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-card-text>
        <v-card-actions>
            <v-btn @click="create" variant="flat" size="large" rounded="lg" color="primary" class="mx-4 ">

                Adicionar Grupo
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
        group: {
            name: '',
            permissions: []
        },
        permissions: []
    }),
    mounted() {
        const id: number  = parseInt(this.$route.params.id);
        if (id) this.findById(id);
    },
    methods: {
        create() {
            UserService.createGroup(this.group).then((response) => {
                toast('Sucesso', {

                    description: 'Some more context of the notification', // subtitle of the snackbar
                    progressBarProps: {

                    },
                    prependIcon: 'mdi-check-circle',
                    progressBar: true, // show or hide countdown progress bar


                })
                this.$router.push({ name: 'Histórico de Grupos' })
            })
        },
        getPermissions() {
            UserService.getPermission().then((response) => {
                this.permissions = response.data
            })
        },
        findById(id: number) {
            UserService.findGroupById().then((response) => {
                this.permissions = response.data
            })
        }
    }
}
</script>
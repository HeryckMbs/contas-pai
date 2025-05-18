<template>
    <div>
        <v-card rounded="lg" style="height:100%" class="px-3 py-3">
            <template v-slot:title>
                <div class="d-flex align-center">
                    <v-icon color="white" class="bg-primary item-card-title mr-3" size="40px"
                        icon="mdi-cog-outline"></v-icon>
                    <h4 class="font-weight-black">Administração</h4>
                </div>
            </template>
            <v-row>
                <v-col class=" y-0" v-for="(tool, _key) in items" :key="_key" xs="12" md="4" sm="6" xl="3">
                    <a style="text-decoration: none">
                        <v-hover open-delay="100" close-delay="100" v-slot:default="{ isHovering, props }">
                            <v-card rounded="lg" elevation="7" v-bind="props" :to="tool.to" :disabled="tool.disabled"
                                :id="_key" :color="isHovering ? 'primary' : 'white'" :class="[
                                    isHovering ? 'card-tool-white' : 'card-tool',
                                    'px-5', 'py-5', 'd-flex', 'justify-center', 'align-center', 'flex-column']">

                                <v-icon :color="isHovering ? 'white' : 'primary'" class="d-flex justify-center my-5"
                                    size="60">
                                    {{ tool.icon }}
                                </v-icon>
                                <div class="font-weight-bold text-body-1" style="word-break: normal">
                                    <h2>{{ tool.name }}</h2>
                                </div>
                                <div class="">
                                    <p>{{ tool.description }}</p>
                                </div>
                            </v-card>

                        </v-hover>
                    </a>
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
export default {
    data: () => ({
        items: [
            {
                to: '/administracao/users',
                disabled: false,
                icon: 'mdi-account-outline',
                name: 'Usuários',
                description: 'Controle de usuários',
            },
            {
                to: '/administracao/group',
                disabled: false,
                icon: 'mdi-account-group',
                name: 'Grupos de Usuário',
                description: 'Controle de grupos de usuários',
            },
            {
                to: '/administracao/permission',
                disabled: false,
                icon: 'mdi-lock',
                name: 'Grupos de Permissão',
                description: 'Controle de grupos de permissão de acesso',
            },


            // ... more items
        ]
    })
}
</script>
<template>
    <v-card rounded="lg"  style="height:100%" class="px-3 py-3">
        <template v-slot:title>
            <h4 class="font-weight-black">Listagem de template</h4>
        </template>
        <v-row class="d-flex justify-end">
            <v-btn rounded="lg" color="primary" class="mx-4 ">
                <v-icon size="20px" color="hite" class="icon-status  ">
                    mdi-plus
                </v-icon>
                <span class="ml-2">Adicionar Template</span>
            </v-btn>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-data-table style="border-radius: 14px; border: 0.2px solid #DEDEDE;"
                    color="success" :items="items">
                 
                </v-data-table>
            </v-col>
        </v-row>

    </v-card>

</template>
<style>
thead{
    background-color: #533495 !important;
    color: white;
}
</style>

<script lang="ts">
export default {
    data: () => ({
        items: [
            ]
    })
}
</script>
<template>
  <v-app>
    <VSonner :duration="4000" expand position="top-right" />

    <v-main class="ma-0 ">
      <div class="d-flex justify-center align-center " style="height: 100%; width:100%">
        <router-view id="content-wrap" />
      </div>
    </v-main>
  </v-app>
</template>

<script lang="ts">
import { RouterView } from 'vue-router';
import { VSonner } from 'vuetify-sonner';
import 'vuetify-sonner/style.css';
export default {
  components: { RouterView,VSonner },
};
</script>
<style>
@font-face {
  font-family: "Gilroy";
  src: url("@/assets/Gilroy Rounded Medium.otf") format("opentype");
  font-weight: normal;
  font-style: normal;
}

@font-face {
  font-family: "Gilroy";
  src: url("@/assets/Gilroy Rounded Medium Italic.otf") format("opentype");
  font-weight: normal;
  font-style: italic;
}

@font-face {
  font-family: "Gilroy";
  src: url("@/assets/Gilroy Rounded Bold.otf") format("opentype");
  font-weight: bold;
  font-style: normal;
}

@font-face {
  font-family: "Gilroy";
  src: url("@/assets/Gilroy Rounded Medium Italic.otf") format("opentype");
  font-weight: bold;
  font-style: italic;
}

.v-application {
  font-family: "Gilroy", sans-serif !important;
  .title {
    font-family: "Gilroy", sans-serif !important;
  }
}
body {
  font-family: "Gilroy", sans-serif !important;
}
.highcharts-contextbutton{
  font-family: "Gilroy", sans-serif !important;
}
.highcharts-menu-item{
  font-family: "Gilroy", sans-serif !important;
}
.highcharts-legend-item {
  font-family: "Gilroy", sans-serif !important;
}
.highcharts-label{
  font-family: "Gilroy", sans-serif !important;
}
.highcharts-no-data{
  font-family: "Gilroy", sans-serif !important;
}

.highcharts-axis-labels {
  font-family: "Gilroy", sans-serif !important;
}

.highcharts-subtitle{
  font-family: "Gilroy", sans-serif !important;

}
.highcharts-title{
  font-family: "Gilroy", sans-serif !important;

}
</style>

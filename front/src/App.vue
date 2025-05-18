
<template>
  <!-- #14121E -->
  <v-app >
    <v-main  >
      <router-view />
    </v-main>
  </v-app>
</template>

<script lang="ts" setup>
  //
</script>

<style>
@font-face {
  font-family: "Gilroy";
  src: url("@/assets/Gilroy-Medium.ttf") format("opentype");
  font-weight: normal;
  font-style: normal;
}

@font-face {
  font-family: "Gilroy";
  src: url("@/assets/Gilroy-MediumItalic.ttf") format("opentype");
  font-weight: normal;
  font-style: italic;
}

@font-face {
  font-family: "Gilroy";
  src: url("@/assets/Gilroy-SemiBold.ttf") format("opentype");
  font-weight: bold;
  font-style: normal;
}

@font-face {
  font-family: "Gilroy";
  src: url("@/assets/Gilroy-SemiBoldItalic.ttf") format("opentype");
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
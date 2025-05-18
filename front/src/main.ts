/**
 * main.ts
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Plugins
import { registerPlugins } from '@/plugins'
import HighchartsVue from 'highcharts-vue';
import exporting from 'highcharts/modules/exporting';
import exportData from 'highcharts/modules/export-data';
import Highcharts, { Options } from 'highcharts';
import '@/scss/style.scss';
import i18n from './i18n'; // Corrigido aqui

exporting(Highcharts);
exportData(Highcharts);

Highcharts.setOptions({
    lang: {
        contextButtonTitle: "Menu de contexto",
        downloadJPEG: "Baixar imagem JPEG",
        printChart: "Imprimir gráfico",
        noData: 'Não há dados para exibir no gráfico.',
        thousandsSep: ".",
        decimalPoint: ",",
    },
    credits: {
        enabled: false,
    },

    noData: {
        style: {
            fontWeight: 'bold',
            fontSize: '15px',
            color: '#303030',
            background: '#000',
        }
    },

});

// Components
import App from './App.vue'

// Composables
import { createApp } from 'vue'

// const i18n = createI18n({
//     locale: 'pt',
//     silentTranslationWarn: true,
//     silentFallbackWarn: true
//   });
const app = createApp(App)
app.use(HighchartsVue).use(i18n);
registerPlugins(app)

app.mount('#app')

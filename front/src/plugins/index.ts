/**
 * plugins/index.ts
 *
 * Automatically included in `./src/main.ts`
 */

// Plugins
import vuetify from './vuetify'
import router from '../router'
import dateUtils from './dateUtils';

// Types
import type { App } from 'vue'
import HighchartsVue from 'highcharts-vue';
import exporting from 'highcharts/modules/exporting';
import exportData from 'highcharts/modules/export-data';
import Highcharts, { Options } from 'highcharts';

exporting(Highcharts);
exportData(Highcharts);

Highcharts.setOptions({
  lang: {
    contextButtonTitle: "Menu de contexto",
    downloadJPEG: "Baixar imagem JPEG",
    printChart: "Imprimir gráfico",
    noData: 'Não há dados para exibir no gráfico.',
  },
  noData: {
    style: {
      fontWeight: 'bold',
      fontSize: '15px',
      color: '#303030',
      background: '#000',
    }
  },
  exporting: {
    filename: 'meu-grafico',
    csv: {
      itemDelimiter: ';',
      decimalPoint: '.',
    },
    buttons: {
      contextButton: {
        align: 'right',
        verticalAlign: 'top',
        x: -10,
        y: 0,
        menuItems: [
          {
            text: 'Imprimir Gráfico',
            onclick: function (this: Options) {
              this.print();
            }
          },
         
          {
            text: 'Baixar PNG',
            onclick: function () {
              this.exportChart();
            }
          },
          {
            text: 'Baixar JPEG',
            onclick: function () {
              this.exportChart({ type: 'image/jpeg' });
            }
          },
          {
            text: 'Baixar PDF',
            onclick: function () {
              this.exportChart({ type: 'application/pdf' });
            }
          },
          {
            text: 'Baixar SVG',
            onclick: function () {
              this.exportChart({ type: 'image/svg+xml' });
            }
          },
         
          {
            text: 'Baixar CSV',
            onclick: function () {
              this.downloadCSV();
            }
          },
          {
            text: 'Baixar XLS',
            onclick: function () {
              this.downloadXLS();
            }
          },
          
          {
            text: 'Tela Cheia',
            onclick: function () {
              this.fullscreen.toggle();
            }
          }
        ]
      }
    },
    scale: 1,
    fallbackToExportServer: false,
  },
});

export function registerPlugins (app: App) {
  app
    .use(vuetify)
    .use(router)
    .use(HighchartsVue)
    .use(dateUtils);
}

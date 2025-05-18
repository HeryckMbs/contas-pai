/**
 * plugins/vuetify.ts
 *
 * Framework documentation: https://vuetifyjs.com`
 */
import { light } from '@/theme/LightTheme';

import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'

import { createVuetify } from 'vuetify'
import { pt } from 'vuetify/locale';
import * as directives from 'vuetify/directives'
import { VDateInput } from 'vuetify/labs/components';

export default createVuetify({
  components: {
    VDateInput
  },
  defaults: {
    VTextField: {
      color: 'primary',
      variant: 'outlined',
      rounded: true,
    },
 
    // Você pode adicionar outros componentes de input aqui
  }, directives,
  locale: {
    locale: 'pt',
    fallback: 'pt',
    messages: { pt }
  },
  theme: {
    defaultTheme: 'light',
    themes: {
      light
    }
  },

})

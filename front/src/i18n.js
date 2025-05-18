// i18n.ts

import { createI18n } from 'vue-i18n';



// Criação do i18n
const i18n = createI18n({
  locale: 'pt', // Define o idioma padrão
  fallbackLocale: 'pt', // Define o idioma de fallback
  messages: {
    pt: await import('./locales/pt.json'),

  }, // Carrega as mensagens
  silentTranslationWarn: true,
  silentFallbackWarn: true
});

export default i18n;

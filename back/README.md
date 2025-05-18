💼 # Bem-vindo ao Projeto!
Olá, querida pessoa avaliadora! Espero que este projeto lhe encontre bem. Confesso que, ansioso para essa avaliação, comecei o projeto no mesmo dia em que a prática foi disponibilizada. Desde o último ano, quando não passei por este processo seletivo, decidi dar o meu melhor neste! 🥇

Sei que há diversas possibilidades de melhoria, mas o tempo não foi suficiente. Mesmo assim, espero que goste do resultado. (P.S.: Foram 24 horas de dedicação contínua desde sexta-feira!)

🚀 Tecnologias Utilizadas
Docker
Vue.js
PHP
Laravel
📦 Bibliotecas Adicionais
Vuetify - Para o Material Design Vuetify
Highcharts - Gráficos interativos Highcharts
Cartão Interativo - Animação do cartão adaptada deste repositório Interactive Card
Geração de PDFs - Gerado com Laravel DomPDF
Toasts - Toasts de notificação com Vuetify Sonner
📂 Como Instalar o Projeto
Usuário Padrão: usuario@exemplo.com
Senha Padrão: senha_secreta

• Ambiente de Desenvolvimento:
Copiar o arquivo .env de exemplo:

bash
Copiar código
$ cp back/.env.example back/.env
Subir os containers com Docker:

bash
Copiar código
$ docker compose up
Gerar JWT:

Após o comando, pressione Enter em todas as etapas.

bash
 php artisan passport:keys 
Copiar código
php artisan passport:client --password
Configurar o .env.development no front-end: Preencha o arquivo /front/.env.development com:

bash
Copiar código
VITE_HOST=192.168.1.103:8080
VITE_CLIENT_ID=9d6582f8-e8f9-4dd5-8966-08e220b59112
VITE_CLIENT_SECRET=c19n0VbDh6pvN56wGWC6zwLmN8OSLmZGo0TpXeFD
URL de Acesso: A aplicação estará disponível em http://localhost:8021/


Client ID: 9d67920a-1cb6-4be1-a75d-72a6e09972ae
Client secret: YWCGMlsj7U3WIH0ap3Dch6m0hz3itK5kA227Pki7
# 💼 Bem-vindo ao Projeto Violet Wallet!

Olá, querida pessoa avaliadora! Espero que este projeto lhe encontre bem. Confesso que, ansioso para essa avaliação, comecei o projeto no mesmo dia em que a prática teórica foi disponibilizada. Desde o último ano, quando não passei por este processo seletivo, decidi dar o meu melhor neste! 🥇

Sei que há diversas possibilidades de melhoria, mas o tempo não foi suficiente. Mesmo assim, espero que goste do resultado. (P.S.: Foram 24 horas de dedicação contínua desde sexta-feira!)

## 🚀 Tecnologias Utilizadas

- **Docker**
- **Vue.js**
- **PHP**
- **Laravel**
<img src="https://skillicons.dev/icons?i=php,laravel,vue,postgres,docker" />

### 📦 Bibliotecas Adicionais
- **Vuetify** - Para o Material Design [Vuetify](https://vuetifyjs.com/en/)
- **Highcharts** - Gráficos interativos [Highcharts](https://www.highcharts.com/)
- **Cartão Interativo** - Animação do cartão adaptada deste repositório [Interactive Card](https://github.com/muhammed/interactive-card)
- **Geração de PDFs** - Gerado com [Laravel DomPDF](https://github.com/barryvdh/laravel-dompdf)
- **Toasts** - Toasts de notificação com [Vuetify Sonner](https://github.com/wobsoriano/vuetify-sonner)

## 📂 Como Instalar o Projeto

> **Usuário Padrão:** `usuario@exemplo.com`  
> **Senha Padrão:** `senha_secreta`

### • Ambiente de Desenvolvimento:

1. **Copiar o arquivo `.env` de exemplo:**
   ```bash
   $ cp back/.env.example back/.env
   ```

2. **Subir os containers com Docker:**
   ```bash
   $ docker compose up -d
   ```
   ou
      ```bash
   $ docker-compose up -d
   ```
4. **Pegar id do container backend:**
     ```bash
   docker ps
   ```
     
4. **Entrar no container com id do backend encontrado acima:**
     ```bash
   docker exec -it {ID_CONTAINER} sh
   ```
5. **Gerar chaves de encrypt do Laravel:**


   ```bash
       php artisan passport:keys 
   ```
6. **Gerar chaves de acesso do cliente (front-end)**

   > Após o comando, pressione Enter em todas as etapas.
   ```bash
      php artisan passport:client --password
   ```
6. **Rodar comando de notificações**

   ```bash
       php artisan notification:run 
   ```
6. **Gerar link simbólico para acessar relatórios**

   ```bash
      php artisan storage:link
   ```
 
7. **Configurar o `.env.development` no front-end:**
   >    Essas variáveis serão obtidas através do comando 6 <br>
   > Lembre-se de obter o seu IP local para preencher VITE_HOST<br>
   > Preencha o arquivo `/front/.env.development` com:
   ```bash
   VITE_HOST=192.168.1.103:8080
   VITE_CLIENT_ID=9d6582f8-e8f9-4dd5-8966-08e220b59112
   VITE_CLIENT_SECRET=c19n0VbDh6pvN56wGWC6zwLmN8OSLmZGo0TpXeFD
   ```

> **URL de Acesso:** A aplicação estará disponível em [http://localhost:8021/](http://localhost:8021/)<br>
> **URL de Acesso AWS** Aplicaçãõ na aws http://3.131.20.171:8021/
#   c o n t a s - p a i  
 #   c o n t a s - p a i  
 #   c o n t a s - p a i  
 #   c o n t a s - p a i  
 
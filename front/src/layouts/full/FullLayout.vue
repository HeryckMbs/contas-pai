<template>

  <v-app style="" :class="[

  ]">


    <VSonner :duration="4000" expand position="top-right" />

    <v-navigation-drawer  @update:rail="railMenu($event)" expand-on-hover style="background-color: #14121E; height:100%"
      v-model="drawer" :rail="rail" permanent @click="rail = false">



      <div v-if="!rail || hover" class="logo">
        <router-link :to="{ name: 'Home'}">
          <img
            src="@/assets/logo.png"
            alt="home"
            height="auto"
            width="144"
          >
        </router-link>
      </div>



      <div v-else  style="height: 5%; margin-top:10%; color:#A15FE9;" class=" logo">
        <router-link style="text-decoration:none" class="logo" :to="{ name: 'Home'}">
          VW
        </router-link>
      </div>
      <div class="pa-2">
        <v-btn variant="tonal" color="primary" block @click="logout()">
          <v-icon size="large" color="white" class="icon-status pb-1 ">
            mdi-logout
          </v-icon>
          <p class="ml-3 text-white" v-show="!rail || hover">Logout</p>
        </v-btn>
      </div>
      <v-divider></v-divider>

      <v-list  title="dsadsa" style="color: white !important;" nav>
        <v-list-item style="height: 50px !important;"    v-for="item in items" color="primary" :to="item.to" :key="item.name">
          <template v-slot:prepend>
            <v-icon class="icon-status pb-1">
              {{ item.icon }}
            </v-icon>

          </template>
          <span>{{ item.name }}</span>

        </v-list-item>

      </v-list>
      <template v-slot:append>

      </template>
    </v-navigation-drawer>

    <v-app-bar style="background-color: #F5F5F5 !important; color:black !important" :elevation="0">
      <template v-slot:prepend>
        <v-app-bar-nav-icon @click.stop="rail = !rail"></v-app-bar-nav-icon>
      </template>

      <v-app-bar-title>Violet Wallet</v-app-bar-title>
      <template v-slot:append>

      </template>
      <v-menu width="20%" transition="slide-y-transition">
        <template v-slot:activator="{ props }">

          <v-btn @click="toggleNotifications" v-bind="props" class="text-none" stacked>
            <v-badge color="error" :content="notifications.length">
              <v-icon>mdi-bell-outline</v-icon>
            </v-badge>
          </v-btn>
        </template>
        <v-list>
          <v-list-item v-if="notifications.length > 0"  :to="`/${notification.url}`" @click="readNotifications(notification.id)" v-for="notification in notifications" :key="notification.title"
            :subtitle="notification.message" :title="notification.title">
            <template v-slot:prepend>
              <v-avatar :color="notification.type">
                <v-icon color="white">mdi-information</v-icon>
              </v-avatar>
            </template>
          </v-list-item>
          <v-list-item v-else>
            <v-alert
            text="Você já leu todas as suas notificações! Pode ficar tranquilo, não tem nada próximo ao vencimento."
            title="Opa!"
            type="success"
          ></v-alert>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
    <v-main>
      <v-breadcrumbs density="compact" :items="breadcrumbs"></v-breadcrumbs>
      <v-container class="page-wrapper  w-100" style="max-width: 100%  !important; min-height:90%;   " fluid fill>


        <router-view v-slot="{ Component }">
          <transition name="slide-fade">
            <component :is="Component" />
          </transition>
        </router-view>
      </v-container>



    </v-main>
  </v-app>
</template>

<script setup lang="ts">
import { VSonner } from 'vuetify-sonner';
import 'vuetify-sonner/style.css';

</script>

<script lang="ts">
import NotificationService from '@/service/NotificationService';
export default {

  data() {
    return {
      drawer: true,
      rail: true,
      hover: false,
      showNotifications: false,
      notifications: [
        {
          subtitle: 'Jan 9, 2014',
          title: 'Photosadfasdfasdfasds',
        },
        {
          subtitle: 'Jan 17, 2014',
          title: 'Recipes',
        },
        {
          subtitle: 'Jan 28, 2014',
          title: 'Work',
        },
      ],

    };
  },
  mounted() {
    this.getNotifications();
  },
  methods: {
    logout() {
      sessionStorage.clear();
      this.$router.push({ name: 'Login' })
    },
    railMenu(evento: any) {
      this.hover = !evento
    },
    toggleNotifications() {
      this.showNotifications = !this.showNotifications;
    },
    getNotifications() {
      NotificationService.getAll().then((response) => {
        this.notifications = response.data
      })
    },
    readNotifications(id:number) {

      NotificationService.readNotifications([id]).then((response) => {
      });
    }
  },
  watch:{
    showNotifications(){
      if(this.showNotifications == true ){
        this.readNotifications()
      }
}
  },
  computed: {
    items() {
      return [
        {
          to: '/',
          icon: 'mdi-home',
          name: 'Home'
        },
        {
          to: '/contas-pagar',
          icon: 'mdi-calendar-alert',
          name: 'Contas a Pagar'
        },
        {
          to: '/contas-receber',
          icon: 'mdi-currency-usd',
          name: 'Contas a Receber'
        },
        {
          to: '/cartao-credito',
          icon: 'mdi-cards-outline',
          name: 'Cartão de Crédito'
        },
        {
          to: '/compras',
          icon: 'mdi-cart-outline',
          name: 'Compras'
        },
        {
          to: '/categoria',
          icon: 'mdi-shape-outline',
          name: 'Categorias Financeiras'
        },
        {
          to: '/relatorio',
          icon: 'mdi-file-chart-outline',
          name: 'Relatórios Financeiros'
        },
        {
          to: '/administracao',
          icon: 'mdi-cog-outline',
          name: 'Configurações'
        },

      ]
    },
    breadcrumbs() {
      const metaBreadcrumb = this.$route.meta.breadcrumb as { name: string; path?: string }[];
      return (metaBreadcrumb).map(breadCrumb => {
        if ('path' in breadCrumb) {
          return { title: breadCrumb.name, to: breadCrumb.path, exact: true };
        } else {
          return { title: breadCrumb.name, to: '/', exact: false };
        }
      });
    }
  }
};
</script>
<style>
.logo{
  display:flex;
  justify-content: center;
  align-items: center;
}
.notification-card {
  position: absolute;
  top: 90%;
  /* ajuste conforme necessário */

  right: 1%;
  width: 25%;
  /* ajuste conforme necessário */
  z-index: 9999;
}

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


body {
  font-family: "Gilroy", sans-serif !important;
}

.highcharts-contextbutton {
  font-family: "Gilroy", sans-serif !important;
}

.highcharts-menu-item {
  font-family: "Gilroy", sans-serif !important;
}

.highcharts-legend-item {
  font-family: "Gilroy", sans-serif !important;
}

.highcharts-label {
  font-family: "Gilroy", sans-serif !important;
}

.highcharts-no-data {
  font-family: "Gilroy", sans-serif !important;
}

.highcharts-axis-labels {
  font-family: "Gilroy", sans-serif !important;
}

.highcharts-subtitle {
  font-family: "Gilroy", sans-serif !important;

}

.highcharts-title {
  font-family: "Gilroy", sans-serif !important;

}
</style>

<template>
  <v-card elevation="20" rounded
  :class="{'w-50': $vuetify.display.xlAndUp, 'w-100': $vuetify.display.lgAndDown}"
  class="mx-10"
  >

    <v-row>
      <v-col cols="6" sm="12" md="4" lg="4" xl="6" class="px-0">
        <div class=" py-15 px-9 d-flex flex-column">
          <p class="mb-10 text-h1	">
            Login
          </p>
          <div class="form">

            <v-form>

              <v-text-field rounded class="mb-5" variant="outlined" type="text" v-model="user.email"
                label="E-mail"></v-text-field>
              <v-text-field rounded class="mb-5" variant="outlined" type="password" v-model="user.password"
                label="Senha"></v-text-field>
              <v-btn @click="login()" class="w-100 mb-4 text-body-1	" color="primary" rounded>
                Entrar

              </v-btn>



            </v-form>
            <v-alert type="error" v-if="errorLogin">
              Usuário ou senha inválidos
            </v-alert>
          </div>
        </div>
      </v-col>
      <v-col cols="6" sm="12" md="8" lg="8" xl="6">
        <div class=" bg-black d-flex flex-column py-2 justify-center align-center">
          <!-- <h1 class="mb-3"><b>Bem vindo ao ...</b></h1> -->
           <div class="logo">

           </div>
           <img src="@/assets/logo.png"  alt="Logo" style="  ">

          <!-- <div style="position:relative; display:flex; flex-direction:column; justify-content:center; align-items:center">
            <p class="mb-4">Ainda não possui conta?</p>
            <v-btn variant="outlined" rounded> Criar conta</v-btn>
          </div> -->
        </div>
      </v-col>
    </v-row>


  </v-card>
  <!-- <v-flex xs12 sm8 md3 style="background-color:red">
    <v-card >
      a
    </v-card>
  </v-flex> -->
</template>

<script lang="ts">
import AuthService from "@/service/AuthService.ts";
import { toast } from "vuetify-sonner";
export default {
  name: "Login",
  data() {
    return {
      errorLogin: false,
      user: {
        password: '',
        email: ''
      },
      check:''
    };
  },
  computed:{

  },
  methods: {

    async login() {
      this.errorLogin = false
      const result = await AuthService.login(this.user.email,this.user.password)
      if(result){
          this.$router.push({ name: 'Home' });
        }
      // this.loading = false
    }
  }
};
</script>

import APIService from "@/service/APIService";
import axios from "axios";
import { toast } from "vuetify-sonner";

export default {
     async login(user:string,password:string): Promise<boolean>{
        try {
            const instanceAPI = APIService.getApiCall();

            const response = await instanceAPI.post(`/oauth/token`,
              {
                "grant_type": "password",
                "client_id": import.meta.env.VITE_CLIENT_ID,
                "client_secret": import.meta.env.VITE_CLIENT_SECRET,
                "username": user,
                "password": password,
                "scope": ""
              }
            )
            const data = response.data;
            const dataAtual = new Date();

            sessionStorage.setItem('access-token',data.access_token)
            sessionStorage.setItem('refresh-token',data.refresh_token)
            sessionStorage.setItem('expire-at',(new Date(dataAtual.getTime() + data.expires_in)).toString())
            return true;
          } catch (error: any) {
            if(axios.isAxiosError(error)){
              toast('Deu ruim !', {
                description: 'Manda um zap pro Heryck ver o que é',
                prependIcon: 'mdi-close-octagon',
                progressBar: true,
              })
            }else{
               toast('Deu ruim !', {
                description: error.data.message,
                prependIcon: 'mdi-close-octagon',
                progressBar: true,
              })
              console.log('oi')
            }
            return false;
          }
    }
}

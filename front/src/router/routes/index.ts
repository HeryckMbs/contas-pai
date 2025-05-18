import type { RoutesType } from '@/types/RouteTypes';

import home from '@/router/routes/home';
import login from '@/router/routes/login';
import template from "@/router/routes/template"
import administracao from '@/router/routes/administracao/index'
import cartaoCredito from '@/router/routes/cartao-credito'
import contasPagar from '@/router/routes/contas-pagar'
import contasReceber from '@/router/routes/contas-receber'
import relatorio from '@/router/routes/relatorio'
import categoria from '@/router/routes/category'
import shopping from '@/router/routes/shopping'

let routes: RoutesType[] = [];

const route404: RoutesType[] = [{
  path: '/:pathMatch(.*)*',
  component: () => import('@/layouts/default/View.vue'),
  children: [
    {
      path: '',
      name: 'NotFound',
      component: () => import('@/views/Error.vue'),
      meta: {
        requiresAuth: false,
        breadcrumb: [
          { name: '404 ERROR' }
        ]
      }
    }
  ]
}];

routes = routes.concat(
  route404,
  home,
  login,
  template,
  administracao,
  cartaoCredito,
  contasPagar,
  contasReceber,
  relatorio,
  categoria,
  shopping


);

export default routes;

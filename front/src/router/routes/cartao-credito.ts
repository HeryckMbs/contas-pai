import type { RoutesType } from '@/types/RouteTypes';

const routes: RoutesType[] = [
    {
  path: '/cartao-credito',
  component: () => import('@/layouts/full/FullLayout.vue'),
  children: [
    {
        name: 'Histórico de Cartão de Crédito',
        path: '',
        component: () => import('@/views/cartao-credito/Index.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Cartão de Crédito' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      },
      {
        name: 'Adicionar Cartão de Crédito',
        path: 'add',
        component: () => import('@/views/cartao-credito/Add.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Cartão de Crédito' , path: '/cartao-credito' },
            { name: 'Cadastro' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      },
      {
        name: 'Editar Cartão de Crédito',
        path: 'edit/:id',
        component: () => import('@/views/cartao-credito/Edit.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Cartão de Crédito' , path: '/cartao-credito' },
            { name: 'Edição' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      },
      {
        name: 'Detalhes Cartão de Crédito',
        path: 'details/:id',
        component: () => import('@/views/cartao-credito/Details.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Cartão de Crédito' , path: '/cartao-credito' },
            { name: 'Detalhes' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      }
  ]
}
];

export default routes;

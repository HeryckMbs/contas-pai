import type { RoutesType } from '@/types/RouteTypes';

const routes: RoutesType[] = [
    {
  path: '/contas-pagar',
  component: () => import('@/layouts/full/FullLayout.vue'),
  children: [
    {
        name: 'Histórico de Contas Pagar',
        path: '',
        component: () => import('@/views/contas-pagar/Index.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Contas a Pagar',path:'/contas-pagar' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      },
      {
        name: 'Adicionar Contas Pagar',
        path: 'add',
        component: () => import('@/views/contas-pagar/Add.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Contas a Pagar',path:'/contas-pagar' },
            { name: 'Cadastro' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      },
      {
        name: 'Editar Contas Pagar',
        path: 'edit/:id',
        component: () => import('@/views/contas-pagar/Edit.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Contas a Pagar',path:'/contas-pagar' },
            { name: 'Edição' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      }
  ]
}
];

export default routes;

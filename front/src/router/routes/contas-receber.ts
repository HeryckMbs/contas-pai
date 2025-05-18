import type { RoutesType } from '@/types/RouteTypes';

const routes: RoutesType[] = [
    {
  path: '/contas-receber',
  component: () => import('@/layouts/full/FullLayout.vue'),
  children: [
    {
        name: 'Histórico de Contas Receber',
        path: '',
        component: () => import('@/views/contas-receber/Index.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Contas a Receber' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      },
      {
        name: 'Adicionar Contas Receber',
        path: 'add',
        component: () => import('@/views/contas-receber/Add.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Contas a Receber' , path: '/contas-receber' },
            { name: 'Cadastro' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      },
      {
        name: 'Editar Contas Receber',
        path: 'edit/:id',
        component: () => import('@/views/contas-receber/Edit.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Contas a Receber' , path: '/contas-receber' },
            { name: 'Edição' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      }
  ]
}
];

export default routes;

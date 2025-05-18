import type { RoutesType } from '@/types/RouteTypes';

const routes: RoutesType[] = [
    {
  path: '/relatorio',
  component: () => import('@/layouts/full/FullLayout.vue'),
  children: [
    {
        name: 'Histórico de Relatórios',
        path: '',
        component: () => import('@/views/relatorio/Index.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Relatórios' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      },
      {
        name: 'Adicionar Relatório',
        path: 'add',
        component: () => import('@/views/relatorio/Add.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Relatórios' , path: '/relatorio' },
            { name: 'Cadastro' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      },
      {
        name: 'Editar Relatório',
        path: 'edit/:id',
        component: () => import('@/views/relatorio/Edit.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Relatórios' , path: '/relatorio' },
            { name: 'Edição' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      }
  ]
}
];

export default routes;

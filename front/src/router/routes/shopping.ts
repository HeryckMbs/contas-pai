import type { RoutesType } from '@/types/RouteTypes';

const routes: RoutesType[] = [
    {
  path: '/compras',
  component: () => import('@/layouts/full/FullLayout.vue'),
  children: [
    {
        name: 'Histórico de Compras',
        path: '',
        component: () => import('@/views/shopping/Index.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Compras',path:'/compras' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      },
      {
        name: 'Adicionar Compras',
        path: 'add',
        component: () => import('@/views/shopping/Add.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Compras',path:'/compras' },
            { name: 'Cadastro' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      },
      {
        name: 'Editar Compras',
        path: 'edit/:id',
        component: () => import('@/views/shopping/Edit.vue'),
        meta: {
          requiresAuth: true,
          breadcrumb: [
            { name: 'Home', path: '/' },
            { name: 'Compras',path:'/compras' },
            { name: 'Edição' }
          ]
        },
        // beforeEnter: onlyAdmingroup
      }
  ]
}
];

export default routes;

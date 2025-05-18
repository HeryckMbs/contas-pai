import type { ChildRouteType } from '@/types/RouteTypes';
// import { onlyAdminUsers } from '@/router/guards';

const children: ChildRouteType[] = [
  {
    name: 'Controle de Permissão',
    path: 'permission',
    component: () => import('@/views/administracao/permission/Index.vue'),
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { name: 'Administração', path: '/administracao' },
        { name: 'Permissões' }
      ]
    },
    // beforeEnter: onlyAdminUsers
  },
  {
    name: 'Adicionar Permissão',
    path: 'permission/add',
    component: () => import('@/views/administracao/permission/Add.vue'),
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { name: 'Administração', path: '/administracao' },
        { name: 'Permissões', path: '/administracao/permission' },
        { name: 'Cadastro' }
      ]
    },
    // beforeEnter: onlyAdminUsers
  },
  // {
  //   name: 'Empresas Adicionar',
  //   path: 'empresas/edit',
  //   component: () => import('@/views/administracao/company/Edit.vue'),
  //   meta: {
  //     requiresAuth: true,
  //     breadcrumb: [
  //       { name: 'Administração', path: '/#/administracao'},
  //       { name: 'Empresas Histórico', path: '/#/administracao/empresas'},
  //       { name: 'Adicionar' }
  //     ]
  //   },
  //   // beforeEnter: onlyAdminUsers
  // }
];

export default children;

import type { ChildRouteType } from '@/types/RouteTypes';
// import { onlyAdminUsers } from '@/router/guards';

const children: ChildRouteType[] = [
  {
    name: 'Histórico de Usuários',
    path: 'users',
    component: () => import('@/views/administracao/user/Index.vue'),
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { name: 'Administração', path: '/administracao' },
        { name: 'Usuários' }
      ]
    },
    // beforeEnter: onlyAdminUsers
  },
  {
    name: 'Adicionar Usuário',
    path: 'users/add',
    component: () => import('@/views/administracao/user/Add.vue'),
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { name: 'Administração', path: '/administracao' },
        { name: 'Usuários', path: '/administracao/users' },
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

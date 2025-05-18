import type { ChildRouteType } from '@/types/RouteTypes';
// import { onlyAdmingroup } from '@/router/guards';

const children: ChildRouteType[] = [
  {
    name: 'Histórico de Grupos',
    path: 'group',
    component: () => import('@/views/administracao/group/Index.vue'),
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { name: 'Administração', path: '/administracao' },
        { name: 'Grupos de Usuário' }
      ]
    },
    // beforeEnter: onlyAdmingroup
  },
  {
    name: 'Adicionar Grupo',
    path: 'group/add',
    component: () => import('@/views/administracao/group/Add.vue'),
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { name: 'Administração', path: '/administracao' },
        { name: 'Grupos de Usuário' , path: '/administracao/group' },
        { name: 'Cadastro' }
      ]
    },
    // beforeEnter: onlyAdmingroup
  },
  {
    name: 'Editar grupo',
    path: 'group/edit/:id',
    component: () => import('@/views/administracao/group/Edit.vue'),
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { name: 'Administração', path: '/administracao' },
        { name: 'Grupos de Usuário' , path: '/administracao/group' },
        { name: 'Edição' }
      ]
    },
    // beforeEnter: onlyAdmingroup
  }
];

export default children;

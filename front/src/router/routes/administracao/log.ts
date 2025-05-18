import type { ChildRouteType } from '@/types/RouteTypes';

const children: ChildRouteType[] = [
  {
    name: 'Logs de Acessos de Usuários Historico',
    path: 'logs-acessos-usuarios',
    component: () => import('@/views/administracao/log/Index.vue'),
    meta: {
      requiresAuth: true,
      breadcrumb: [
        { name: 'Administração', path: '/administracao'},
        { name: 'Logs de Acessos' }
      ]
    }
  }
];

export default children;

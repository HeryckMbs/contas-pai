

import type { RoutesType, ChildRouteType } from '@/types/RouteTypes';
import user from '@/router/routes/administracao/user'
import group from '@/router/routes/administracao/group'
import permission from '@/router/routes/administracao/permission'
const child: ChildRouteType = {
  name: 'Administração',
  path: '/administracao',
  component: () => import('@/views/administracao/Index.vue'),
  meta: {
    requiresAuth: true,
    breadcrumb: [
      { name: 'Administração' }
    ]
  }
};

const routes: RoutesType[] = [{
  path: '/administracao',
  component: () => import('@/layouts/full/FullLayout.vue'),
  children: [child].concat(
    user,
    group,
    permission
  )
}];

export default routes;
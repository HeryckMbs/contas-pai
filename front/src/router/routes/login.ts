import type { RoutesType } from '@/types/RouteTypes';

const routes: RoutesType[] = [{
  path: '/login',
  component: () => import('@/layouts/default/View.vue'),
  children: [
    {
      name: 'Login',
      path: '',
      component: () => import('@/views/auth/Login.vue')
    }
  ]
}];

export default routes;
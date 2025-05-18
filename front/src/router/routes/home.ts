import type { RoutesType } from '@/types/RouteTypes';

const routes: RoutesType[] = [{
  path: '/',
  component: () => import('@/layouts/full/FullLayout.vue'),
  children: [
    {
      name: 'Home',
      path: '',
      component: () => import('@/views/home/Index.vue'),
      meta: {
        requiresAuth: true,
        breadcrumb: [
          { name: 'Home'}
        ]
      }
    }
  ]
}];

export default routes;

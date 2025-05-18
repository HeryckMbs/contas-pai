import type { RoutesType } from '@/types/RouteTypes';

const routes: RoutesType[] = [{
  path: '/template',
  component: () => import('@/layouts/full/FullLayout.vue'),
  children: [
    {
      name: 'Template',
      path: '',
      component: () => import('@/views/template/Index.vue'),
      meta: {
        requiresAuth: true,
        breadcrumb: [
          { name: 'Template'},
          { name: 'Template2'},
          { name: 'Template4'},
        ]
      }
    }
  ]
}];

export default routes;

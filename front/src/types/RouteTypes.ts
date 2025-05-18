import { ComponentOptions } from 'vue';
import { NavigationGuard } from 'vue-router';

type RoutesType = {
  module?: string; /* nome do murilo no back-end, essa string deve corresponder os valores da tabela tools */
  path: string;
  component: () => Promise<ComponentOptions>;
  children?: ChildRouteType[];
};

type ChildRouteType = {
  name: string;
  path: string;
  component: () => Promise<ComponentOptions>;
  meta?: {
    requiresAuth: boolean;
    breadcrumb: { name: string, path?: string }[];
    actionPermission?: string /* nome da ação ligada a rota, essa string deve corresponder os valores da tabela tools_profile */
  };
  beforeEnter?: NavigationGuard
};

export type { RoutesType, ChildRouteType };
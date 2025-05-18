/**
 * router/index.ts
 *
 * Automatic routes for `./src/pages/*.vue`
 */

// Composables
import { createRouter, createWebHistory, NavigationGuardNext, RouteLocationNormalized } from 'vue-router/auto'
import routes from '@/router/routes/index';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

// Workaround for https://github.com/vitejs/vite/issues/11804
router.onError((err, to) => {
  if (err?.message?.includes?.('Failed to fetch dynamically imported module')) {
    if (!localStorage.getItem('vuetify:dynamic-reload')) {
      console.log('Reloading page to fix dynamic import error')
      localStorage.setItem('vuetify:dynamic-reload', 'true')
      location.assign(to.fullPath)
    } else {
      console.error('Dynamic import error, reloading page did not fix it', err)
    }
  } else {
    console.error(err)
  }
})
const userIsAuthenticated = () => {
  
  const token = sessionStorage.getItem('access-token');
  return  token;
};

const verifyAuth = async (to: RouteLocationNormalized, from: RouteLocationNormalized, next: NavigationGuardNext) => {


  const requiresAuth = to.matched.some((record) => record.meta.requiresAuth);
  const isAuthenticated = userIsAuthenticated();
  if(isAuthenticated && to.path === '/login'){
    return next({name: 'Home'})
  }
  if (requiresAuth && !isAuthenticated) {
    return next({ name: 'Login' });
  }

  return next();
};
router.beforeEach(verifyAuth);

router.isReady().then(() => {
  localStorage.removeItem('vuetify:dynamic-reload')
})

export default router

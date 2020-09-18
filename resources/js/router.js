import VueRouter from 'vue-router'
// Pages
import App from './views/App'
import Show from './views/Show'
import Home from './views/Home'
import NotFound from './views/errors/NotFound'
import Register from './views/Register'
import Login from './views/Login'
import Favorites from './views/Favorites'
// import Dashboard from './views/user/Dashboard'
// import AdminDashboard from './views/admin/Dashboard'

const routes = [

    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            auth: undefined
        }
    },
    {
        path: '/show/:id',
        name: 'show',
        component: Show,
        meta: {
            auth: undefined
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    {
        path: '/favorites',
        name: 'favorites',
        component: Favorites,
        meta: {
            auth: true
        }
    },
    // USER ROUTES
    /*{
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            auth: true
        }
    },*/
    // ADMIN ROUTES
    /*{
        path: '/admin',
        name: 'admin.dashboard',
        component: AdminDashboard,
        meta: {
            auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/403'}
        }
    },*/
   /* {
        path: '/404',
        name: '404',
        component: NotFound,
    },
    {
        path: '*',
        redirect: '/404'
    },*/
];
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
});
export default router

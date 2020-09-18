import bearer from '@websanova/vue-auth/drivers/auth/bearer'
import axios from '@websanova/vue-auth/drivers/http/axios.1.x'
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x'
// Auth base configuration some of this options
// can be override in method calls
const config = {
    auth: bearer,
    http: axios,
    router: router,
    tokenDefaultName: 'laravel-vue-spa',
    tokenStore: ['localStorage'],
    rolesKey: 'role',
    registerData: {url: 'auth/register', method: 'POST', redirect: '/login', autoLogin: true, fetchUser: true, staySignedIn: true},
    loginData: {url: 'auth/login', method: 'POST', redirect: '/', fetchUser: true, staySignedIn: true},
    logoutData: {url: 'auth/logout', method: 'POST', redirect: '/', makeRequest: true},
    fetchData: {url: 'auth/user', method: 'GET', enabled: true, fetchUser: true},
    refreshData: {url: 'auth/refresh', method: 'GET', enabled: true, interval: 30},
    notFoundRedirect: {path: '/'}
};
export default config

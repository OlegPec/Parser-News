<template>
    <div class="nav-auth">
        <ul>
            <!--LOGGED USER-->
            <li v-if="$auth.check(1)" v-for="(route, key) in routes.user" v-bind:key="route.path">
                <router-link  :to="{ name : route.path }" :key="key">
                    {{route.name}}
                </router-link>
            </li>
            <!--UNLOGGED-->
            <li v-if="!$auth.check()" v-for="(route, key) in routes.unlogged" v-bind:key="route.path">
                <router-link  :to="{ name : route.path }" :key="key">
                    {{route.name}}
                </router-link>
            </li>
            <!--LOGGED ADMIN-->
            <!--<li v-if="$auth.check(2)" v-for="(route, key) in routes.admin" v-bind:key="route.path">
                <router-link  :to="{ name : route.path }" :key="key">
                    {{route.name}}
                </router-link>
            </li>-->
            <!--LOGOUT-->
            <li v-if="$auth.check()">
                <span>Привет {{ $auth.user().name }}</span>
                <a href="#" @click.prevent="$auth.logout()">Выйти</a>
            </li>
        </ul>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                routes: {
                    // UNLOGGED
                    unlogged: [
                        {
                            name: 'Авторизация',
                            path: 'login'
                        },
                        {
                            name: 'Регистрация',
                            path: 'register'
                        },
                    ],
                    /*// LOGGED USER
                    user: [
                        {
                            name: 'Dashboard',
                            path: 'dashboard'
                        }
                    ],
                    // LOGGED ADMIN
                    admin: [
                        {
                            name: 'Admin Dashboard',
                            path: 'admin.dashboard'
                        }
                    ]*/
                }
            }
        },
        mounted() {
            //
        }
    }
</script>


<style scoped>

</style>

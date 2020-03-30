<template>
    <div class="container mt-5">
        <div class="card card-default">
            <div class="card-header">Регистрация</div>
            <div class="card-body">
                <div class="alert alert-danger" v-if="has_error && !success">
                    <p v-if="error == 'registration_validation_error'">Ошибка(и) проверки, пожалуйста, смотрите сообщение(я) ниже.</p>
                    <p v-else>Ошибка, невозможно зарегистрироваться в это время. Если проблема не устранена, обратитесь к администратору.</p>
                </div>
                <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post">
                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.email }">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email">
                        <span class="help-block" v-if="has_error && errors.email">{{ errors.email[0] }}</span>
                    </div>
                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.email }">
                        <label for="name">Имя</label>
                        <input type="text" id="name" class="form-control" v-model="name">
                        <span class="help-block" v-if="has_error && errors.name">{{ errors.name[0] }}</span>
                    </div>
                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.password }">
                        <label for="password">Пароль</label>
                        <input type="password" id="password" class="form-control" v-model="password">
                        <span class="help-block" v-if="has_error && errors.password">{{ errors.password[0] }}</span>
                    </div>
                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.password }">
                        <label for="password_confirmation">Подтверждение пароля</label>
                        <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-default">Зарегестрироваться</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                has_error: false,
                error: '',
                errors: {},
                success: false
            }
        },
        methods: {
            register() {
                var app = this;
                this.$auth.register({
                    data: {
                        name: app.name,
                        email: app.email,
                        password: app.password,
                        password_confirmation: app.password_confirmation
                    },
                    success: function () {
                        app.success = true;
                        this.$router.push({name: 'login', params: {successRegistrationRedirect: true}})
                    },
                    error: function (res) {
                        console.log(res.response.data.errors);
                        app.has_error = true;
                        // console.log(res.response.data.status);
                        app.error = res.response.data.status;
                        app.errors = res.response.data.errors || {}
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>

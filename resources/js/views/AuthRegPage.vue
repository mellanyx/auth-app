<template>
    <div class="d-block mt-5">
        <div class="col-md-4 mx-auto">
            <div class="alert alert-danger mt-3 mb-3" v-if="error">{{ error }}</div>

            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="auth-tab" data-bs-toggle="tab" data-bs-target="#auth" type="button" role="tab" aria-controls="auth" aria-selected="true">
                        <h3>Авторизация</h3>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">
                        <h3>Регистрация</h3>
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="auth" role="tabpanel" aria-labelledby="auth-tab">
                    <form class="mt-8 space-y-6" @submit.prevent="submit('auth')">
                        <div class="mb-4">
                            <label class="form-label">Email</label>
                            <input
                                name="email"
                                type="email"
                                autocomplete="email"
                                class="form-control"
                                required
                                v-model="form.auth.email"
                            >
                        </div>
                        <div>
                            <label class="form-label">Пароль</label>
                            <input
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                class="form-control"
                                required
                                v-model="form.auth.password"
                            >
                        </div>

                        <div class="form-check mb-3 mt-3">
                            <input
                                id="remember-me-register"
                                name="remember-me"
                                type="checkbox"
                                class="form-check-input"
                                v-model="form.auth.remember"
                            >
                            <label
                                for="remember-me-register"
                                class="form-check-label"
                            >
                                запомнить меня
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-full" :disabled="loading">
                            Авторизоваться
                        </button>
                    </form>
                </div>
                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                    <form class="mt-8 space-y-6" @submit.prevent="submit('register')">
                        <div class="mb-4">
                            <label class="form-label">ФИО</label>
                            <input
                                name="name"
                                type="text"
                                autocomplete="name"
                                class="form-control"
                                required
                                v-model="form.register.name"
                            >
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Дата рождения</label>
                            <input
                                name="birthdate"
                                type="date"
                                autocomplete="name"
                                class="form-control"
                                required
                                v-model="form.register.birthdate"
                            >
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Телефон</label>
                            <input
                                name="phone"
                                type="tel"
                                autocomplete="name"
                                class="form-control"
                                required
                                v-model="form.register.phone"
                            >
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Адрес проживания</label>
                            <input
                                name="address"
                                type="text"
                                autocomplete="name"
                                class="form-control"
                                v-model="form.register.address"
                            >
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Email</label>
                            <input
                                name="email"
                                type="email"
                                autocomplete="email"
                                class="form-control"
                                required
                                v-model="form.register.email"
                            >
                        </div>
                        <div>
                            <label class="form-label">Пароль</label>
                            <input
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                class="form-control"
                                required
                                v-model="form.register.password"
                            >
                        </div>

                        <div class="form-check mb-3 mt-3">
                            <input
                                id="remember-me-auth"
                                name="remember-me"
                                type="checkbox"
                                class="form-check-input"
                                v-model="form.register.remember"
                            >
                            <label
                                for="remember-me-auth"
                                class="form-check-label"
                            >
                                запомнить меня
                            </label>
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-full"
                            :disabled="loading"
                        >
                            Зарегистрироваться
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import {authStore} from "../stores/authStore";
import {toasts} from "../scripts/toasts";

export default {
    name: "AuthRegPage",
    data() {
        return {
            form: {
                auth: {
                    email: '',
                    password: '',
                    remember: true,
                },
                register: {
                    name: '',
                    birthdate: '',
                    phone: '',
                    address: '',
                    email: '',
                    password: '',
                    remember: true,
                }
            },
            loading: false,
            error: null,
        }
    },
    methods: {
        submit(type) {
            this.loading = true;

            axios.post(`/api/user/${type}`, this.form[type])
                .then(() => {
                    // Check auth and redirect to homepage
                    authStore()
                        .checkAuth()
                        .then(() => {
                            this.$router.push({name: 'PersonalProfilePage'});
                        })
                        .catch(() => {
                            alert('line 207 :: AuthRegPage');
                        });
                })
                .catch((error) => {
                    if (error.response.status === 401) {
                        toasts.showToast(error.response.data.msg.error,
                            'toastAlertDanger',
                            ['text-white', 'bg-danger']);
                    } else {
                        alert('line 216 :: AuthRegPage');
                    }

                })
                .finally(() => {
                    this.loading = false;
                })
        }
    }
}
</script>

<style scoped>
</style>

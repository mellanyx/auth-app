<template>
    <div>
    <div class="row">
        <div class="col-md-12">
            <div class="header">
                <div class="left-side">
                    <router-link
                        class="btn btn-sm btn-panel nav-link me-3"
                        :to="{name: 'HomePage'}"
                    >
                        <span class="icon text-primary pe-2">
                            <i class="fa-solid fa-house"></i>
                        </span>
                        Главная
                    </router-link>

                    <router-link
                        class="btn btn-sm btn-panel nav-link"
                        :to="{name: 'PersonalProfilePage'}"
                    >
                        <span class="icon text-primary pe-2">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        Профиль
                    </router-link>
                </div>

                <div class="right-side" v-if="userData">
                    <div class="username-panel me-5">
                        <span class="icon text-primary pe-2">
                            <i class="fas fa-user-tie"></i>
                        </span>
                        Здравствуйте, {{ userData.name }}
                    </div>

                    <a href="/user/logout" class="btn btn-sm btn-panel">
                        <span class="icon text-primary pe-2">
                            <i class="fas fa-sign-out-alt"></i>
                        </span>
                        Выйти
                    </a>
                </div>

                <div class="right-side" v-else-if="!userData">
                    <router-link
                        class="btn btn-sm btn-panel nav-link"
                        :to="{name: 'AuthRegPage'}"
                    >
                        <span class="icon text-primary pe-2">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                        </span>
                        Войти
                    </router-link>
                </div>
            </div>
        </div>


    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-4">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ФИО</th>
                            <th scope="col">Дата рождения</th>
                            <th scope="col">Телефон</th>
                            <th scope="col">Email</th>
                            <th scope="col">Адрес</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, i) in users" :key="user.id">
                                <th scope="row">{{ parseInt(i) + 1 }}</th>
                                <td>
                                    {{ user.name }}
                                </td>
                                <td>
                                    {{ user.birthdate }}
                                </td>
                                <td>
                                    {{ user.phone }}
                                </td>
                                <td>
                                    {{ user.email }}
                                </td>
                                <td>
                                    {{ user.address }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
import {authStore} from "../stores/authStore";
import axios from "axios";

export default {
    name: "HomePage",
    data() {
        return {
            userData: authStore().userData,
            users: null,
            loading: true
        }
    },
    mounted() {
        axios.get(`/api/users`)
            .then((response) => {
                this.users = response.data.users;
            })
            .catch((error) => {
                alert('Ошибка при получении списка пользователей');
            })
            .finally(() => {
                this.loading = false;
            })
    }
}
</script>

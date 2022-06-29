<template>
    <admin-panel>
        <div class="row">
            <div class="col-md-12">
                <h2 class="page_title"> {{ page_title }} </h2>
            </div>

            <div class="col-md-8">
                <form class="mt-4" @submit.prevent="profileEdit">
                    <input type="hidden" name="user_id" :value="userData.id">

                    <div class="row">
                        <div class="col-md-8" data-block="name">
                            <label
                                for="profileEditName"
                                class="form-label"
                            >
                                ФИО
                            </label>
                            <input
                                class="form-control form-control-sm"
                                id="profileEditName"
                                type="text"
                                v-model="userData.name"
                            >
                        </div>
                        <div class="col-md-8 mt-3" data-block="birthdate">
                            <label
                                for="profileEditName"
                                class="form-label"
                            >
                                Дата рождения
                            </label>
                            <input
                                class="form-control form-control-sm"
                                id="profileEditBirthDate"
                                type="date"
                                v-model="userData.birthdate"
                            >
                        </div>
                        <div class="col-md-8 mt-3" data-block="phone">
                            <label
                                for="profileEditName"
                                class="form-label"
                            >
                                Телефон
                            </label>
                            <input
                                class="form-control form-control-sm"
                                id="profileEditPhone"
                                type="tel"
                                v-model="userData.phone"
                            >
                        </div>
                        <div class="col-md-8 mt-3" data-block="address">
                            <label
                                for="profileEditName"
                                class="form-label"
                            >
                                Адрес проживания
                            </label>
                            <input
                                class="form-control form-control-sm"
                                id="profileEditAddress"
                                type="text"
                                v-model="userData.address"
                            >
                        </div>
                        <div class="col-md-8 mt-3" data-block="email">
                            <label
                                for="profileEditEmail"
                                class="form-label"
                            >
                                Email
                            </label>
                            <input
                                class="form-control form-control-sm"
                                id="profileEditEmail"
                                type="email"
                                v-model="userData.email"
                            >
                        </div>
                        <div class="col-md-8 mt-3" data-block="password">
                            <label
                                for="profileEditPassword"
                                class="form-label"
                            >
                                Новый пароль
                            </label>
                            <input
                                class="form-control form-control-sm"
                                id="profileEditPassword"
                                type="password"
                                v-model="userData.password"
                            >
                        </div>

                        <div class="col-md-8 mt-4">
                            <button
                                class="btn btn-sm btn-primary"
                                type="submit"
                            >
                                Сохранить изменения
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </admin-panel>
</template>

<script>
import AdminPanel from './PersonalLayout'
import {authStore} from "../../stores/authStore";
import { toasts } from "../../scripts/toasts.js";
import axios from "axios";

export default {
    components: {AdminPanel},
    name: "PersonalProfilePage",
    data() {
        return {
            page_title: 'Профиль',
            userData: authStore().userData
        }
    },
    methods: {
        profileEdit() {
            if (!this.userData.password) {
                delete this.userData.password;
            }

            axios.post(`/api/user/profile/edit`, this.userData)
                .then((response) => {
                    console.log(response);

                    toasts.showToast(response.data.msg.success,
                        'toastAlertSuccess',
                        ['text-white', 'bg-success']);
                })
                .catch((error) => {
                    if (error.response.status === 401) {
                        this.showErrorFields(error.response.data.msg.errors);
                        // console.log(error.response.data.msg.errors);
                        // this.error = error.response.data.message;
                    } else {
                        alert('line 148 :: PersonalProfilePage');
                    }
                })
                .finally(() => {
                    this.loading = false;
                })
        },
        showErrorFields(errors) {
            _.forOwn(errors, (error, key) => {
                let block = document.querySelector(`[data-block="${key}"]`),
                    label = block.querySelector('label'),
                    input = block.querySelector('input');

                label.classList.add('text-danger');
                input.classList.add('border', 'border-danger');

                setTimeout (function(){
                    label.classList.remove('text-danger');
                    input.classList.remove('border', 'border-danger');
                }.bind(this), 5000);

                toasts.showToast(error,
                    'toastAlertDanger',
                    ['text-white', 'bg-danger']);
            })

        }
    }
}
</script>

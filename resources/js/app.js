import {createApp} from 'vue';
import {createPinia} from 'pinia';
import router from './router';
import AppComponent from "./App.vue";
import {authStore} from "./stores/authStore";
import Slideout from "slideout";

require('./bootstrap');

const app = createApp(AppComponent);
app.use(createPinia());

window.Slideout = Slideout;

// Проверка аутентификации
router.beforeEach((to) => {
    const auth = authStore();
    if (to.meta.requiresAuth && !auth.userData) {
        return '/auth'
    }

    // Redirect authorized users from guest pages
    if (to.meta.onlyGuests && auth.userData) {
        return '/'
    }
})

// Инициализация tosts
let toastElList = [].slice.call(document.querySelectorAll('.toast'))
let toastList = toastElList.map(function (toastEl) {
    return new bs.Toast(toastEl, {
        delay: 5000
    })
})

const auth = authStore();

auth.checkAuth()
    .finally(() => {
        app.use(router)
        app.mount('#app')
    });

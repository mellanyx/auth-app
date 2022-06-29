<template>
    <div class="admin-wrapper">
        <div class="container-fluid p-0">
            <div class="bd-body">
                <div class="bd-sidebar slideout-menu slideout-menu-left" id="bd_sidebar">
                    <a href="#" class="close-menu d-lg-none"><i aria-hidden="true" class="fa fa-times"></i></a>
                    <div class="bd-logo">
                        <a href="" class="logo">Auth<br />App</a>
                    </div>
                    <div class="bd-login">
                        <div class="dropdown">
                            <div class="name">
                                {{ userData.name }}
<!--                                <div class="role mt-2 small">{{ userData.email }}</div>-->
                            </div>
                        </div>
                    </div>
                    <div class="scrollbar-outer">
                        <div class="bd-menu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <router-link
                                        class="nav-link"
                                        :class="[this.$route.name === 'HomePage' ? 'active' : '']"
                                        :to="{name: 'HomePage'}"
                                    >
                                        <span class="icon text-primary">
                                            <i class="fa-solid fa-house"></i>
                                        </span>Главная
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <router-link
                                        class="nav-link"
                                        :class="[this.$route.name === 'PersonalProfilePage' ? 'active' : '']"
                                        :to="{name: 'PersonalProfilePage'}"
                                    >
                                        <span class="icon text-primary">
                                            <i class="fa-solid fa-user"></i>
                                        </span>Профиль
                                    </router-link>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="/user/logout">
                                        <span class="icon text-primary">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </span>Выйти
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <main class="bd-content 1" id="bd_content">
                    <div class="bd-head-mobile">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="brand">
                                        <div class="logo">
                                            <a href="" class="logo">Auth App</a>
                                        </div>
                                        <button type="button" class="navbar-toggler d-lg-none open-menu">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-content">
                        <slot></slot>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<script>
import {authStore} from "../../stores/authStore";

export default {
    name: "PersonalLayout",
    props: {
        // page: {},
    },
    data() {
        return {
            userData: authStore().userData
        }
    },
    mounted() {
        let slideout = new window.Slideout({
            'panel': document.getElementById('bd_content'),
            'menu': document.getElementById('bd_sidebar'),
            'padding': 220,
            'tolerance': 70,
            touch: false
        }).on('beforeopen', function () {
            let height = $(window).outerHeight() > $(window).height() ? $(window).outerHeight() : $(window).height();
            $('#bd_sidebar').height(height);
            $('html, body').css({
                height: height + 'px',
                width: '100%',
                overflow: 'hidden'
            });
        }).on('close', function () {
            $('html, body').removeAttr('style');
        });

        $('.open-menu, .close-menu').on('click', function (e) {
            e.preventDefault();
            slideout.toggle();
        });

        $(window).resize(function () {
            if (window.innerWidth >= 768 && $('html').hasClass('slideout-open')) {
                slideout.toggle();
            }
        });
    }
}
</script>

<template>
    <nav class="nav">
        <nav-button/>
        <ul class="nav_list">
            <li class="nav_list-item nav_list-item-active" @click.prevent="changePage()" id="couriers-table">
                <router-link :to="{ name : 'couriers-table'}" tag="a">добавить курьеров</router-link>
            </li>
            <li class="nav_list-item" @click.prevent="changePage()" id="orders-table">
                <router-link :to="{ name : 'orders-table'}" tag="a">добавить заказы</router-link>
            </li>
            <li class="nav_list-item" id="help"><a href="">гайд</a></li>
            <li class="nav_list-item">
                <a href="/logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Выйти</a>
                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                    <slot></slot>
                </form>
            </li>
        </ul>
    </nav>
</template>

<script>
    import {eventBus} from '../../app';
    import NavButton from './NavButton';
    export default {
        mounted() {
            this.changePage();
        },
        methods: {
            changePage() {
                this.updateComponentData();
                this.changeNavActiveLi();
                this.setGoogleTable();
                eventBus.$emit('changePage');
            },

            changeNavActiveLi() {
                this.activeItem.classList.remove('nav_list-item-active');
                this.currentPage.classList.add('nav_list-item-active');
            },

            updateComponentData() {
                    this.currentRoute = this.$route.name;
                    this.activeItem = document.querySelector('.nav_list-item-active');
                    this.currentPage = document.getElementById(this.liIds[this.currentRoute]);
            },

            setGoogleTable() {
                let apiRoute = this.apiTableRoutes[this.currentRoute];
                if(apiRoute){
                    axios.get(apiRoute).then((response) => {
                        console.log(response);
                    });
                }
            },
        },

        data: function () {
            return {
                currentRoute: "",
                activeItem: "",
                currentPage: "",

                apiTableRoutes: {
                    'orders-table' : '/api/table/orders',
                    'couriers-table' : '/api/table/couriers',
                },

                liIds: {
                    'orders-table' : 'orders-table',
                    'orders-form' : 'orders-table',
                    'couriers-table' : 'couriers-table',
                    'couriers-form' : 'couriers-table',
                },

                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },

        components: {
            NavButton,
        },
    }
</script>

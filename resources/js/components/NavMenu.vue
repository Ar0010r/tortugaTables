<template>
    <nav class="nav">

        <div id="container" class="button-wrapp">
            <router-link class="button" id="readData"
                         :to="{ name: 'couriers-form'}"

            >загрузить</router-link>
            <!--<a class="button" id="readData"
                         @click.prevent="readData()"

            >загрузить</a>-->
        </div>
        <ul class="nav_list">
            <li class="nav_list-item nav_list-item-active"
                @click.prevent="changePage()"
                id="couriers-table">
                <router-link :to="{ name: 'couriers-table'}" tag="a">добавить курьеров</router-link>
            </li>
            <li class="nav_list-item"
                @click.prevent="changePage()"
                id="orders-table">
                <router-link :to="{ name: 'orders-table'}" tag="a">добавить заказы</router-link>
            </li>
            <li class="nav_list-item" id="help"><a href="">помощь</a></li>
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
    import {eventBus} from '../app';
    export default {
        mounted() {
            this.changePage();
        },
        methods: {
            changePage() {
                this.updateComponentData();
                this.changeNavActiveLi();


                let apiRoute = this.apiRoutes[this.$route.name];

                if(apiRoute){
                    axios.get(apiRoute).then((response) => {
                        //console.log(response);
                    })
                }
            },

            readData: function () {

                axios.get('/api/table/read').then((response) => {
                    //this.googleTableData = response.data;
                    //this.$emit('clicked', response.data);
                    //this.$root.$emit('clicked', response.data);
                    //this.$root.$emit('update');
                    //eventBus.$emit('googleTableData', response.data);
                    //console.log(response);
                    this.$router.push('/form/couriers');
                    eventBus.$emit('googleTableData', response.data);




                })
            },

            changeNavActiveLi() {
                this.activeItem.classList.remove('nav_list-item-active');
                this.currentPage.classList.add('nav_list-item-active');
                this.readDataButton.textContent = this.buttonTexts[this.$route.name];
            },

            updateComponentData() {
                    this.currentRoute = this.$route.name;
                    this.activeItem = document.querySelector('.nav_list-item-active');
                    this.currentPage = document.getElementById(this.liIds[this.currentRoute]);
                    this.readDataButton = document.getElementById('readData');
            },

        },

        data: function () {
            return {
                currentRoute: "",
                activeItem: "",
                currentPage: "",
                readDataButton: "",
                buttonTexts: {
                    'orders-table': 'Считать заказы',
                    'orders-form': 'Добавить заказы',
                    'couriers-table': 'Считать курьеров',
                    'couriers-form': 'Добавить курьеров',
                },
                apiRoutes: {
                    'orders-table': '/api/table/orders',
                    'couriers-table': '/api/table/couriers',
                },
                liIds: {
                    'orders-table': 'orders-table',
                    'orders-form': 'orders-table',
                    'couriers-table': 'couriers-table',
                    'couriers-form': 'couriers-table',
                },
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

                googleTableData: "",
            }
        },

        props: [
            'currentRouteName',
        ],
    }
</script>

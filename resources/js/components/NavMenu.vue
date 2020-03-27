<template>
    <nav class="nav">
        <div id="container" class="button-wrapp">
            <a class="button" id="readData"
               @click.prevent="readData()"
            >загрузить</a>
        </div>
        <ul class="nav_list">
            <li class="nav_list-item nav_list-item-active"
                @click.prevent="changePage()"
                id="couriers-table">
                <router-link :to="{ name: 'couriers-table'}">добавить курьеров</router-link>
            </li>
            <li class="nav_list-item"
                @click.prevent="changePage()"
                id="orders-table">
                <router-link :to="{ name: 'orders-table'}">добавить заказы</router-link>
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
    export default {
        mounted() {
            this.changePage();
        },
        methods: {
            changePage() {
                this.updateComponentData();
                this.changeNavActiveLi();

                let apiRoute = this.apiRoutes[this.$route.name];

                axios.get(apiRoute).then((response) => {
                    console.log(response);
                })
            },

            readData: function () {

                axios.get('/api/table/read').then((response) => {
                    this.googleTableData = response.data;
                    console.log(this.googleTableData);
                    //console.log(response);
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
                    this.currentPage = document.getElementById(this.currentRoute);
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
                    'couriers-table': 'Считать курьеров'
                },
                apiRoutes: {
                    'orders-table': '/api/table/orders',
                    'couriers-table': '/api/table/couriers'
                },
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

                googleTableData: "",
            }
        }
    }
</script>

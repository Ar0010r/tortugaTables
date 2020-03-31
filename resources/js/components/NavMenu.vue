<template>
    <nav class="nav">
        <div  @click.prevent="changePage()" id="container" class="button-wrapp">
            <router-link class="button" id="readData" :to="{ name : readDataButtonDirection}">загрузить</router-link>
        </div>
        <ul class="nav_list">
            <li class="nav_list-item nav_list-item-active" @click.prevent="changePage()" id="couriers-table">
                <router-link :to="{ name : 'couriers-table'}" tag="a">добавить курьеров</router-link>
            </li>
            <li class="nav_list-item" @click.prevent="changePage()" id="orders-table">
                <router-link :to="{ name : 'orders-table'}" tag="a">добавить заказы</router-link>
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
                if(apiRoute){
                    axios.get(apiRoute).then((response) => {
                        console.log(response);
                    })
                }
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
                    this.readDataButtonDirection = this.buttonDirections[this.currentRoute];
            }
        },

        data: function () {
            return {
                currentRoute: "",
                activeItem: "",
                currentPage: "",
                readDataButton: "",
                readDataButtonDirection: "",
                buttonTexts: {
                    'orders-table' : 'Считать заказы',
                    'orders-form' : 'Добавить заказы',
                    'couriers-table' : 'Считать курьеров',
                    'couriers-form' : 'Добавить курьеров',
                },
                apiRoutes: {
                    'orders-table' : '/api/table/orders',
                    'couriers-table' : '/api/table/couriers',
                },
                liIds: {
                    'orders-table' : 'orders-table',
                    'orders-form' : 'orders-table',
                    'couriers-table' : 'couriers-table',
                    'couriers-form' : 'couriers-table',
                },

                buttonDirections : {
                    'orders-table' : 'orders-form',
                    'orders-form' : '',
                    'couriers-table' : 'couriers-form',
                    'couriers-form' : '',
                },
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        }
    }
</script>

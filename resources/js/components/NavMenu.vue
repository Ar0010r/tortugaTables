<template>
    <nav class="nav">
        <div  @click.prevent="navButtonFunction()" id="container" class="button-wrapp">
            <router-link class="button" id="navButton" :to="{ name : navButtonDirection}">загрузить</router-link>
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
                this.setGoogleTable();
            },
            changeNavActiveLi() {
                this.activeItem.classList.remove('nav_list-item-active');
                this.currentPage.classList.add('nav_list-item-active');
                this.navButton.textContent = this.buttonTexts[this.$route.name];
            },
            updateComponentData() {
                    this.currentRoute = this.$route.name;
                    this.activeItem = document.querySelector('.nav_list-item-active');
                    this.currentPage = document.getElementById(this.liIds[this.currentRoute]);
                    this.navButton = document.getElementById('navButton');
                    this.navButtonDirection = this.buttonDirections[this.currentRoute];
            },

            setGoogleTable() {
                let apiRoute = this.apiTableRoutes[this.$route.name];
                if(apiRoute){
                    axios.get(apiRoute).then((response) => {
                        console.log(response);
                    });
                }
            },

            navButtonFunction() {
                if(this.$route.name === 'orders-table' || this.$route.name === 'couriers-table'){
                    this.changePage();
                } else if (this.$route.name === 'orders-form' || this.$route.name === 'couriers-form') {
                    this.storeData();
                }
            },

            storeData() {
                let apiRoute = this.apiStoreRoutes[this.$route.name];
                if(apiRoute){
                    axios.post(apiRoute, $('#form').serialize())
                        .then((response) => {
                            console.log(response);
                        }).catch(e => {
                        that.errors = e
                    });
                }
            }
        },

        data: function () {
            return {
                currentRoute: "",
                activeItem: "",
                currentPage: "",
                navButton: "",
                navButtonDirection: "",
                buttonTexts: {
                    'orders-table' : 'Считать заказы',
                    'orders-form' : 'Добавить заказы',
                    'couriers-table' : 'Считать курьеров',
                    'couriers-form' : 'Добавить курьеров',
                },
                apiTableRoutes: {
                    'orders-table' : '/api/table/orders',
                    'couriers-table' : '/api/table/couriers',
                },
                apiStoreRoutes: {
                    'orders-form' : '/api/orders/store',
                    'couriers-form' : '/api/couriers/store',
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

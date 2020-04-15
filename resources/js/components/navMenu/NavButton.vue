<template>
        <div id="container" class="button-wrapp">
            <div class="button" id="navButton"
                         @click.prevent="navButtonFunction()"
                         >{{navButtonText}}
            </div>
        </div>
</template>

<script>
    import {eventBus} from '../../app';
    export default {
        mounted() {
            this.updateButtonProperties();
            eventBus.$on('changePage', this.updateButtonProperties)
        },
       
        methods: {
            navButtonFunction() {
                if(this.$route.name === 'orders-table' || this.$route.name === 'couriers-table'){
                    this.updateButtonProperties();
                    this.$router.push({name : this.navButtonDirection});
                } else if (this.$route.name === 'orders-form' || this.$route.name === 'couriers-form') {
                    this.storeData();
                }
            },

            storeData() {
                let apiRoute = this.apiStoreRoutes[this.$route.name];
                if(apiRoute){
                    eventBus.$emit('storeData', apiRoute);
                }
            },

            updateButtonProperties() {
                this.currentRoute = this.$route.name;
                this.navButtonDirection = this.buttonDirections[this.currentRoute];
                this.navButtonText = this.buttonTexts[this.currentRoute];
            }
        },

        data: function () {
            return {
                navButton: document.getElementById('navButton'),
                currentRoute: "",
                navButtonDirection: "",
                navButtonText: "",
                
                buttonTexts: {
                    'orders-table' : 'Считать заказы',
                    'orders-form' : 'Добавить заказы',
                    'couriers-table' : 'Считать курьеров',
                    'couriers-form' : 'Добавить курьеров',
                },

                apiStoreRoutes: {
                    'orders-form' : '/api/orders/store',
                    'couriers-form' : '/api/couriers/store',
                },

                buttonDirections : {
                    'orders-table' : 'orders-form',
                    'orders-form' : 'orders-form',
                    'couriers-table' : 'couriers-form',
                    'couriers-form' : 'couriers-form',
                },
            }
        }
    }
</script>

<template>
    <div class="form-wrap">
        <form class="form_table" id="form">
            <component :is = 'currentFormRow'
                       v-for="(dataRow, index) in googleTableData"
                       :dataRow = "dataRow"
                       :index="index"
                       :key="index"></component>
        </form>
    </div>
</template>

<script>
    import CouriersFormRow from './CouriersFormRow';
    import OrdersFormRow from './OrdersFormRow';
    import {eventBus} from '../../app';
    export default {
        mounted() {
            console.log('componenent form mounted');
            eventBus.$emit('changePage');
            this.currentFormRow = this.formRows[this.$route.name];
            this.readData();

            eventBus.$on('deleteRow', data => {
                this.deleteRow(data);
            });

            eventBus.$on('storeData', data => {
                let invalid = document.getElementsByClassName('invalid').length;
                if(invalid > 0){
                    console.log('invalid');
                    return
                }
                this.storeData(data);
            });
        },

        data: function () {
            return {
                googleTableData: "",
                currentFormRow: "",
                formRows: {
                    'orders-form' : 'OrdersFormRow',
                    'couriers-form' : 'CouriersFormRow',
                },
            }
        },

        components: {
            CouriersFormRow,
            OrdersFormRow
        },

        methods: {
            readData: function () {
                axios.get('/api/table/read').then((response) => {
                    this.googleTableData = Object.values(response.data);
                }).catch(error => {
                    this.$router.go(-1);
                    console.log(error.response);
                    eventBus.$emit('showModal', error.response.data);
                });
            },

            deleteRow: function (index) {
                this.googleTableData.splice(index, 1);
            },

            storeData(apiRoute) {
                axios.post(apiRoute, $('#form').serialize())
                    .then((response) => {
                        console.log(response);
                        //this.$router.push({ name: '/success', title: 'test title' })
                    }).catch(e => {
                    that.errors = e;
                    console.log(e);
                    eventBus.$emit('showModal', e);
                });
            },
        }
    }
</script>

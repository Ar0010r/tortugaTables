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
                    return
                }
                this.storeData(data);
            });
        },

        beforeDestroy () {
            eventBus.$off('storeData')
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
                        this.$router.go(-1);

                        eventBus.$emit('showModal', 'данные успешно добавлены. ' +
                            'вы будете перенаправлены на главную страницу');
                    }).catch(error => {

                        let data = error.response.data;
                        let errors = 'error';

                        if (data.errors) {
                             errors = Object.values(error.response.data.errors).join("\n");
                        } else if (data) {
                             errors = data;
                        }
                    eventBus.$emit('showModal', errors);
                });
            },
        }
    }
</script>

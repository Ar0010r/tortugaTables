<template>
    <div class="form-wrap">
        <form class="form_table" id="submit">
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
            this.currentFormRow = this.formRows[this.$route.name];
            this.readData();
        },

        created() {
            eventBus.$on('deleteRow', data => {
                console.log(data);
                this.deleteRow(data);
            })
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
                });
            },

            deleteRow: function (index) {
                this.googleTableData.splice(index, 1);
            }
        }
    }
</script>

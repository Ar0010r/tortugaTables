<template>
    <div class="form-wrap">
        <form class="form_table" id="submit">
            <couriers-form-row v-for="(dataItem, index) in googleTableData" :dataItem = "dataItem" :key="index"></couriers-form-row>
        </form>
    </div>
</template>

<script>
    import CouriersFormRow from './CouriersFormRow';
    import {eventBus} from '../app';
    export default {
        mounted() {

            console.log('componenent form mounted');
            this.readData();
            //console.log(this.googleTableData);

        },
        data: function () {
            return {
                googleTableData: "",
            }
        },
        created(){

            eventBus.$on('googleTableData', data => {
                this.googleTableData = data;
                console.log(this.googleTableData);
            })

        },
        components: {
            CouriersFormRow,
        },
        methods: {
            readData: function () {

                axios.get('/api/table/read').then((response) => {

                    console.log(response.data);

                    this.googleTableData = response.data;
                })
            },
        }
    }
</script>

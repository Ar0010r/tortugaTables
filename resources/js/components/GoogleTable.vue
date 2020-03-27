<template class="table">
        <iframe v-if="this.$route.name === 'orders-table'"
                class="table_iframe"
                src="https://docs.google.com/spreadsheets/d/1Hj4x_QRGoDotJNAFYm1hjKI7YZLHbjAwe2vsuUdMWv0/edit?usp=sharing"
                frameborder="0">
        </iframe>
        <iframe v-else-if = "this.$route.name === 'couriers-table'"
                class="table_iframe"
                src="https://docs.google.com/spreadsheets/d/1PhmQ1_MZHCE8zKrVhG6bvg0DAWtAD4M0U_Db8dDHjOY/edit?usp=sharing"
                frameborder="0">
        </iframe>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

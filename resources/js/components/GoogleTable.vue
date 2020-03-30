<template class="table">
    <iframe
            class="table_iframe"
            :src="this.googleTableLinks[this.$route.name]"
            frameborder="0">
    </iframe>
</template>

<script>
    export default {
        data: () => ({
            googleTableLinks: {
                'orders-table': 'https://docs.google.com/spreadsheets/d/1Hj4x_QRGoDotJNAFYm1hjKI7YZLHbjAwe2vsuUdMWv0',
                'couriers-table': 'https://docs.google.com/spreadsheets/d/1PhmQ1_MZHCE8zKrVhG6bvg0DAWtAD4M0U_Db8dDHjOY',
            },
        }),
    }
</script>

<template>
    <div class="button-wrapper">
        <div class="close-container" @click.prevent="deleteRow()">
            <div class="leftright"></div>
            <div class="rightleft"></div>
        </div>
    </div>
</template>

<script>
    import {eventBus} from '../../app';
    export default {
        mounted() {
        },
        props: ['index'],

        methods: {
            deleteRow: function () {
                eventBus.$emit('deleteRow', this.index)
            }
        }
    }
</script>

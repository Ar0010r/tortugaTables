<template>
    <div class="main_content container">
        <NavMenu><slot></slot></NavMenu>
        <router-view></router-view>
    </div>
</template>

<script>
    import NavMenu from './navMenu/NavMenu';
    export default {
        mounted() {
            console.log('Component App mounted.');
        },
        components: {
            NavMenu,
        },
    }
</script>

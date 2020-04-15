<template>
    <div class="main_content container">
        <NavMenu><slot></slot></NavMenu>
        <router-view></router-view>
        <modal-window></modal-window>
    </div>
</template>

<script>
    import NavMenu from './navMenu/NavMenu';
    import ModalWindow from './ModalWindow';
    export default {
        mounted() {
            console.log('Component App mounted.');
        },
        components: {
            NavMenu,
            ModalWindow
        },
    }
</script>

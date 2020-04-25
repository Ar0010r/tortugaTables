<template class="table">
<div class="modal-wrapper">
    <transition name="fade" appear>
        <div class="modal-overlay" v-if="show" @click="showModal"></div>
    </transition>

    <transition name="slide" appear>
        <div class="modal success-message_wrap" v-if="show">
            <h3 class = "success-message_head">СООБЩЕНИЕ</h3>
            <hr>
            <div class="success-message">
                <p class="success-message_text" v-if="(typeof messages === 'string')">{{"- " + messages}}</p>
                <p class="success-message_text" v-else v-for="(message, index) in messages">{{"- " + message}}</p>
            </div>
        </div>
    </transition>
</div>
</template>

<script>
    import {eventBus} from '../app';
    export default {
        mounted() {
            console.log('Component ModalWindow mounted.');
            eventBus.$on('showModal', data => {
                this.messages = data || "";
                this.showModal();
            });
        },

        methods: {
            showModal() {
                if(this.show === true){
                    this.show = false;
                    return
                }
                this.show = true;
            }
        },
        data: () => ({
            show: false,
            messages: ""
        }),
    }
</script>

<style>
    .modal-overlay {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        z-index: 98;
        min-height: 100vh;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .modal {
        position: fixed;
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        min-height: 130px;
        z-index: 100;

    }

    .success-message_wrap {
        padding: 30px;
        min-height: fit-content;
        max-width: 30%;

        background-color: #C4E0FF;

    }

    .success-message {

        padding: 0;
        align-items: flex-start;

        height: 100%;
        width: 100%;

    }

    .sucess-message_img-wrap {
        min-width: 50px;
        min-height: 25px;
    }

    .success-message_text {

        padding: 5px;

    }

    .success-message_head {
        align-self: flex-end;
        margin: 0;
    }

    .modal hr {
        color: black;
        width: 100%;
        border-top: 1px solid black;
    }

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .7s;
    }

    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }

    .slide-enter-active,
    .slide-leave-active {
        transition: transform .7s;
    }

    .slide-enter,
    .slide-leave-to {
        transform: translateY(-50%) translateX(100vw);
    }
</style>

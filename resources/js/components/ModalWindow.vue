<template class="table">
<div class="modal-wrapper">
    <transition name="fade" appear>
        <div class="modal-overlay" v-if="show" @click="showModal"></div>
    </transition>

    <transition name="modal" appear>
        <div class="modal success-message_wrap" v-if="show">
            <div class="success-message">
                <div class="success-message_text">
                    {{message}}
                </div>
                <div class="sucess-message_img-wrap">
                    <img  class="success-message-img" src="/images/success.png">
                </div>
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
                this.message = data || "";
                document.getElementsByClassName('success-message_text').textContent = this.message;
                console.log(this.message);
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
            message: ""
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
        height: fit-content;
        max-width: 30%;
    }

    .success-message {
        height: 100%;
        width: 100%;
    }

    .sucess-message_img-wrap {
        min-width: 50px;
        min-height: 25px;
    }

    .success-message_text {
        white-space: pre;
    }
</style>

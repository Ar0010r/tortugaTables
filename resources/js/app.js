import Vue from 'vue';
import router from './router'
import vuelidate from 'vuelidate'
import axios from 'axios';
import VueAxios from 'vue-axios' ;

import App from './components/App'
import GoogleTable from './components/GoogleTable'
import ModalWindow from './components/ModalWindow'
import NavMenu from './components/navMenu/NavMenu'
import NavButton from './components/navMenu/NavButton'
import Form from './components/form/Form'
import CouriersFormRow from './components/form/CouriersFormRow'
import CouriersFormErrors from './components/form/CouriersFormErrors'
import OrdersFormRow from './components/form/OrdersFormRow'
import OrdersFormErrors from './components/form/OrdersFormErrors'
import DeleteButton from './components/form/DeleteButton'

require('./bootstrap');

Vue.use(vuelidate);
Vue.use(VueAxios, axios);

export const eventBus = new Vue();


const app = new Vue({
    el: '#app',
    components: {
        App : App,
        GoogleTable : GoogleTable,
        ModalWindow : ModalWindow,
        NavMenu: NavMenu,
        NavButton: NavButton,
        Form: Form,
        CouriersFormRow: CouriersFormRow,
        CouriersFormErrors: CouriersFormErrors,
        OrdersFormRow: OrdersFormRow,
        OrdersFormErrors: OrdersFormErrors,
        DeleteButton: DeleteButton
    },
    router
});

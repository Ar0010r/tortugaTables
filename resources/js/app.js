import Vue from 'vue';
import router from './router'
import vuelidate from 'vuelidate'
import axios from 'axios';
import VueAxios from 'vue-axios' ;

import App from './components/App'
import GoogleTable from './components/GoogleTable'
import NavMenu from './components/navMenu/NavMenu'
import NavButton from './components/navMenu/NavButton'
import Form from './components/form/Form'
import CouriersFormRow from './components/form/CouriersFormRow'
import OrdersFormRow from './components/form/OrdersFormRow'
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
        NavMenu: NavMenu,
        NavButton: NavButton,
        Form: Form,
        CouriersFormRow: CouriersFormRow,
        OrdersFormRow: OrdersFormRow,
        DeleteButton: DeleteButton
    },
    router
});

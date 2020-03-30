import Vue from 'vue';
import router from './router'
import vuelidate from 'vuelidate'
import axios from 'axios';
import VueAxios from 'vue-axios' ;

import App from './components/App'
import GoogleTable from './components/GoogleTable'
import NavMenu from './components/NavMenu'
import Form from './components/Form'
import CouriersFormRow from './components/CouriersFormRow'


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
        Form: Form,
        CouriersFormRow: CouriersFormRow
    },
    router
});

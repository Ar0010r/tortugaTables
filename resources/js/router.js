import Vue from 'vue';
import VueRouter from 'vue-router'
import GoogleTable from './components/GoogleTable'
import Form from './components/form/Form';

Vue.use(VueRouter);

export default new VueRouter({

    routes: [
        {path: '/table/couriers', name: 'couriers-table', component: GoogleTable, props: true},
        {path: '/table/orders', name: 'orders-table', component: GoogleTable, props: true},
        {path: '/form/couriers', name: 'couriers-form', component: Form, props: true},
        {path: '/form/orders', name: 'orders-form', component: Form, props: true},
        { path: '*', redirect: { name: 'couriers-table' }},
    ],
    mode: 'history'

});
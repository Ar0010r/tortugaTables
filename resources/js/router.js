import Vue from 'vue';
import VueRouter from 'vue-router'
import GoogleTable from './components/GoogleTable'
/*import Main from './components/Main'
import Crew from './components/Crew'
import Review from './components/Review'*/

Vue.use(VueRouter);

export default new VueRouter({

    routes: [
        {path: '/table/couriers', name: 'couriers-table', component: GoogleTable, props: true},
        {path: '/table/orders', name: 'orders-table', component: GoogleTable, props: true},
       /* {path: '/form/couriers', name: 'form-couriers', component: FormCouriers, props: true},
        {path: '/form/orders', name: 'form-orders', component: FormOrders, props: true},*/
    ],
    mode: 'history'

});
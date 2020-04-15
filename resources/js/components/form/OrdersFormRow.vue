<template>
    <div class="form_table-row">
        <div class="form_table-inputs">
            <div class="form_table-data">
                <input type="text" class="form_input form_input-name"
                       :name=inputNames.name
                       v-model="name"
                       :class="{invalid: ($v.name.$dirty && !$v.name.required || $v.name.$dirty && !$v.name.validName)}">

                <input type="text" class="form_input form_input-content"
                       :name=inputNames.content
                       v-model="content"
                       :class="{invalid: ($v.content.$dirty && !$v.content.required)}">

                <div class="form_table-div">
                    <input type="text" class="form_input form_input-quantity"
                           :name=inputNames.quantity
                           v-model="quantity"
                           :class="{invalid: ($v.quantity.$dirty && !$v.quantity.required || $v.quantity.$dirty && !$v.quantity.integer)}">

                    <input type="text" class="form_input form_input-price"
                           :name=inputNames.price
                           v-model="price"
                           :class="{invalid: ($v.price.$dirty && !$v.price.required || $v.price.$dirty && !$v.price.integer)}">

                    <select class="form_input form_input-condition"
                            :name=inputNames.condition
                            v-model="condition"
                            :class="{invalid: ($v.condition.$dirty && !$v.condition.required || $v.condition.$dirty && !$v.condition.integer)}">
                        <option value="0">new</option>
                        <option value="1">ref</option>
                        <option value="2">used</option>
                    </select>
                    <select class="form_input form_input-direction">
                        <option value="test">тестовый</option>
                        <option value="for sale">на продажу</option>
                        <option value="for us">себе</option>
                        <option value="for service">сервису</option>
                    </select>
                </div>
                <input type="text" class="form_input form_input-tracking"
                       :name=inputNames.tracking_number
                       v-model="tracking_number"
                       :class="{invalid: ($v.tracking_number.$dirty && !$v.tracking_number.required)}">
                <div class="form_table-div-2">
                    <input type="text" class="form_input form_input-holder"
                           :name=inputNames.holder
                           v-model="holder"
                           :class="{invalid: ($v.holder.$dirty && !$v.holder.required || $v.holder.$dirty && !$v.holder.validName)}">
                    <input type="text" placeholder="enter shop (optional)" class="form_input form_input-shop"
                           :name=inputNames.shop
                           v-model="shop">
                </div>
            </div>
            <delete-button :index="index"></delete-button>
        </div>
        <orders-form-errors :v="$v"></orders-form-errors>
    </div>
</template>

<script>
    import DeleteButton from './DeleteButton';
    import OrdersFormErrors from './OrdersFormErrors';

    import {required, integer} from 'vuelidate/lib/validators';
    export default {
        mounted() {
            document.getElementById('form').classList.add('form_table-orders');
            this.setComponentData();
        },

        props: ['dataRow', 'index'],

        components: {DeleteButton, OrdersFormErrors},

         data: () => {
            return {
                inputNames: {
                    name : '',
                    content : '',
                    quantity : '',
                    price : '',
                    condition : '',
                    tracking_number : '',
                    holder : '',
                    shop : '',
                },

                name : "",
                content : "",
                quantity : "",
                price : "",
                condition : "",
                tracking_number : "",
                holder : "",
                shop : "",
            }
         },
        validations: {
            name : {required, validName(name) {
                    return /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/.test(name)
                }},
            content : {required},
            quantity : {integer, required},
            price : {integer, required},
            condition : {integer, required},
            tracking_number : {required},
            holder : {required, validName(holder) {
                    return /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/.test(holder)
                }},
        },

        methods: {
            setComponentData: function () {
                this.inputNames.name = 'orders['+this.index+'][name]';
                this.inputNames.content = 'orders['+this.index+'][content]';
                this.inputNames.quantity = 'orders['+this.index+'][quantity]';
                this.inputNames.price = 'orders['+this.index+'][price]';
                this.inputNames.condition = 'orders['+this.index+'][condition]';
                this.inputNames.tracking_number = 'orders['+this.index+'][tracking_number]';
                this.inputNames.holder = 'orders['+this.index+'][holder]';

                this.name  = this.dataRow[1];
                this.content  = this.dataRow[2];
                this.quantity  = this.dataRow[3];
                this.price  = this.dataRow[4];
                this.condition  = 0;
                this.tracking_number  = this.dataRow[5];
                this.holder  = this.dataRow[6];
                this.shop  = "";

                this.$v.$touch();
            }
        }
    }
</script>

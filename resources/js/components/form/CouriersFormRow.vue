<template>
    <div class="form_table-row">
        <div class="form_table-inputs">
            <div class="form_table-data">
                <input type="text" class="form_input form_input-name"
                       v-model="name"
                       :name="inputNames.name"
                       :class="{invalid: ($v.name.$dirty && !$v.name.required || $v.name.$dirty && !$v.name.validName)}">

                <input type="text" class=" form_input form_input-email"
                       v-model="email"
                       :name="inputNames.email"
                       :class="{invalid: ($v.email.$dirty && !$v.email.required || $v.email.$dirty && !$v.email.email)}">

                <input type="text" class="form_input form_input-paypal"
                       v-model="paypal"
                       :name="inputNames.paypal"
                       :class="{invalid: ($v.paypal.$dirty && !$v.paypal.email)}">

                <input type="text" class="form_input form_input-address"
                       v-model="address"
                       :name="inputNames.address"
                       :class="{invalid: ($v.address.$dirty && !$v.address.required)}">

                <div class="form_table-div">
                    <input type="text" class="form_input form_input-city"
                           v-model="city"
                           :name="inputNames.city"
                           :class="{invalid: ($v.city.$dirty && !$v.city.required || $v.city.$dirty && !$v.city.validName)}">

                    <input type="text" class="form_input form_input-state"
                           v-model="state"
                           :name="inputNames.state"
                           :class="{invalid: ($v.state.$dirty && !$v.state.required || $v.state.$dirty && !$v.state.validState)}">

                    <input type="text" class="form_input form_input-zip"
                           v-model="zip"
                           :name="inputNames.zip"
                           :class="{invalid: ($v.zip.$dirty && !$v.zip.required || $v.zip.$dirty && !$v.zip.validZip)}">
                </div>

                <input type="text" class="form_input form_input-phone1"
                       v-model="phone_1"
                       :name="inputNames.phone_1"
                       :class="{invalid: ($v.phone_1.$dirty && !$v.phone_1.required || $v.phone_1.$dirty && !$v.phone_1.validPhone)}">

                <input type="text" class="form_input form_input-phone2"
                       v-model.trim="phone_2"
                       :name="inputNames.phone_2"
                       :class="{invalid: ($v.phone_2.$dirty && !$v.phone_2.validPhone)}">
            </div>
            <delete-button :index="index"></delete-button>
        </div>
        <couriers-form-errors :v="$v"></couriers-form-errors>
    </div>
</template>

<script>
    import DeleteButton from './DeleteButton';
    import CouriersFormErrors from './CouriersFormErrors';
    import {required, email} from 'vuelidate/lib/validators';

    export default {
        mounted() {

            this.setComponentData();

        },
        props: ['dataRow', 'index'],
        components: {DeleteButton, CouriersFormErrors},

        validations: {
            name: {
                required, validName(name) {
                    return /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/.test(name)
                }
            },
            email: {required, email},
            paypal: {email},
            address: {required},
            city: {
                required, validName(city) {
                    return /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/.test(city)
                }
            },
            state: {
                required, validState(state) {
                    return this.states.includes(state);
                }
            },
            zip: {
                required, validZip(state) {
                    return /^\d{5}(-\d{4})?$/.test(state);
                }
            },
            tracking_number: {required},
            holder: {
                required, validName(holder) {
                    return /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/.test(holder)
                }
            },

            phone_1: {
                required, validPhone(phone_1) {
                    return /^\d{3}-\d{3}-\d{4}$/.test(phone_1)
                }
            },

            phone_2: {
                validPhone(phone_2) {
                    return /^$|^\d{3}-\d{3}-\d{4}$/.test(phone_2)
                }
            },
        },

        data: () => {
            return {
                inputNames: {
                    name: '',
                    email: '',
                    paypal: '',
                    address: '',
                    city: '',
                    state: '',
                    zip: '',
                    phone_1: '',
                    phone_2: '',
                },

                name: '',
                email: '',
                paypal: '',
                address: '',
                city: '',
                state: '',
                zip: '',
                phone_1: '',
                phone_2: '',

                states: [
                    "AK", "AL", "AR", "AS", "AZ", "CA", "CO", "CT", "DC", "DE", "FL", "GA", "GU", "HI", "IA", "ID", "IL",
                    "IN", "KS", "KY", "LA", "MA", "MD", "ME", "MI", "MN", "MO", "MS", "MT", "NC", "ND", "NE", "NH", "NJ",
                    "NM", "NV", "NY", "OH", "OK", "OR", "PA", "PR", "RI", "SC", "SD", "TN", "TX", "UT", "VA", "VI", "VT",
                    "WA", "WI", "WV", "WY"
                ]
            }
        },

        methods: {
            setComponentData: function () {
                this.inputNames.name = 'couriers[' + this.index + '][name]';
                this.inputNames.email = 'couriers[' + this.index + '][email]';
                this.inputNames.paypal = 'couriers[' + this.index + '][paypal_email]';
                this.inputNames.address = 'couriers[' + this.index + '][address]';
                this.inputNames.city = 'couriers[' + this.index + '][city]';
                this.inputNames.state = 'couriers[' + this.index + '][state]';
                this.inputNames.zip = 'couriers[' + this.index + '][zip]';
                this.inputNames.phone_1 = 'couriers[' + this.index + '][phone_1]';
                this.inputNames.phone_2 = 'couriers[' + this.index + '][phone_2]';

                this.name = this.dataRow[1];
                this.email = this.dataRow[2];
                this.paypal = this.dataRow[3];
                this.address = this.dataRow[4];
                this.city = this.dataRow[5];
                this.state = this.dataRow[6];
                this.zip = this.dataRow[7];
                this.phone_1 = this.dataRow[8];
                //this.phone_2 = this.dataRow[9] || this.dataRow[8];
                this.phone_2 = this.dataRow[9] || "";

                this.$v.$touch();
            }
        }
    }
</script>

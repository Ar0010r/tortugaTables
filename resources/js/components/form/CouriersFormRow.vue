<template>
    <div class="form_table-row">
        <div class="form_table-inputs">
            <div class="form_table-data">
                <input type="text" :value="dataRow[1]" class="form_input form_input-name" :name="'couriers['+index+'][name]'">
                <input type="text" :value="dataRow[2]" class=" form_input form_input-email" :name="'couriers['+index+'][email]'">
                <input type="text" :value="dataRow[3]" class="form_input form_input-paypal" :name="'couriers['+index+'][paypal_email]'">
                <input type="text" :value="dataRow[4]" class="form_input form_input-address" :name="'couriers['+index+'][address]'">
                <div class="form_table-div">
                    <input type="text" :value="dataRow[5]" class="form_input form_input-city" :name="'couriers['+index+'][city]'">
                    <input type="text" :value="dataRow[6]" class="form_input form_input-state" :name="'couriers['+index+'][state]'">
                    <input type="text" :value="dataRow[7]" class="form_input form_input-zip" :name="'couriers['+index+'][zip]'">
                </div>
                <input type="text" :value="dataRow[8]" class="form_input form_input-phone1" :name="'couriers['+index+'][phone_1]'">
                <input type="text" :value="dataRow[9]" class="form_input form_input-phone2" :name="'couriers['+index+'][phone_2]'">
            </div>
            <delete-button :index="index"></delete-button>
        </div>
        <div class="form_table-errors">
            <!-- <label class="error-msg form_input-name-error">В имени не должно быть ничего кроме букв</label>
             <label class=" error-msg form_input-email-error">В имени не должно быть ничего кроме букв</label>
             <label class=" error-msg form_input-address-error">В имени не должно быть ничего кроме букв</label>
             <label class=" error-msg form_input-phone-error">В имени не должно быть ничего кроме букв</label>-->
        </div>
    </div>
</template>

<script>
    import DeleteButton from './DeleteButton';
    export default {
        mounted() {

            //console.log(this.index);

        },
        props: ['dataRow', 'index'],
        components: {DeleteButton}
    }
</script>

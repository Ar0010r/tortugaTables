<template>
    <div class="form_table-row">
        <div class="form_table-inputs">
            <div class="form_table-data">
                <input type="text" :value="dataItem[1]" class="form_input form_input-name">


                <input type="text" :value="dataItem[2]" class=" form_input form_input-email">
                <input type="text" :value="dataItem[3]" class="form_input form_input-paypal">


                <input type="text" :value="dataItem[4]" class="form_input form_input-address">
                <div class="form_table-div">
                    <input type="text" :value="dataItem[5]" class="form_input form_input-city">
                    <input type="text" :value="dataItem[6]" class="form_input form_input-state">
                    <input type="text" :value="dataItem[7]" class="form_input form_input-zip">
                </div>


                <input type="text" :value="dataItem[8]" class="form_input form_input-phone1">
                <input type="text" :value="dataItem[9]" class="form_input form_input-phone2">

            </div>
            <div class="button-wrapper">
                <div class="close-container">
                    <div class="leftright"></div>
                    <div class="rightleft"></div>
                </div>
            </div>
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
    export default {
        mounted() {

        },

        props: ['dataItem']


    }
</script>

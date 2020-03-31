<template>
    <div class="form_table-row">
        <div class="form_table-inputs">
            <div class="form_table-data">
                <input type="text" :value="dataRow[1]" class=" form_input form_input-name" :name="['name'+index]">
                <input type="text" :value="dataRow[2]" class="form_input form_input-content" :name="['content'+index]">
                <div class="form_table-div">
                    <input type="text" :value="dataRow[3]" class="form_input form_input-quantity" :name="['quantity'+index]">
                    <input type="text" :value="dataRow[4]" class="form_input form_input-price" :name="['price'+index]">
                    <select class="form_input form_input-condition">
                        <option value="new">new</option>
                        <option value="ref">ref</option>
                        <option value="used">used</option>
                    </select>
                </div>
                <input type="text" :value="dataRow[5]" class="form_input form_input-tracking" :name="['tracking'+index]">
                <div class="form_table-div-2">
                    <input type="text" :value="dataRow[6]" class="form_input form_input-holder" :name="['holder'+index]">
                    <input type="text" placeholder="enter shop (optional)" class="form_input form_input-shop" :name="['shop'+index]">
                </div>
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

            document.getElementById('submit').classList.add('form_table-orders')

        },

        props: ['dataRow', 'index'],

        components: {DeleteButton}


    }
</script>

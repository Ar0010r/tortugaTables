<template>
    <div class="form_table-errors">
        <div class="errors-div_name errors-div">
            <label class="error-msg form_input-name-error"
                   v-if="(v.name.$dirty && !v.name.required)">Введите имя</label>
            <label class="error-msg form_input-name-error"
                   v-if="( v.name.$dirty && !v.name.validName)">В имени не должно быть ничего кроме букв</label>
        </div>
        <div class="errors-div_email errors-div">
            <label class="error-msg form_input-email-error"
                   v-if="(v.email.$dirty && !v.email.required)">Введите имейл</label>
            <label class="error-msg form_input-email-error"
                   v-if="(v.email.$dirty && !v.email.email)">Введите правильный имейл</label>
            <label class="error-msg form_input-paypal-error"
                   v-if="(v.paypal.$dirty && !v.paypal.email)">Введите правильный пейпал имейл</label>
        </div>
        <div class="errors-div_address errors-div">
            <label class="error-msg form_input-address-error"
                   v-if="(v.address.$dirty && !v.address.required)">Введите адрес</label>
            <label class="error-msg form_input-city-error"
                   v-if="(v.city.$dirty && !v.city.required)">Введите город</label>
            <label class="error-msg form_input-city-error"
                   v-if="(v.city.$dirty && !v.city.validName)">Название города должно состоять только из букв</label>
            <label class="error-msg form_input-state-error"
                   v-if="(v.state.$dirty && !v.state.required)">Введите штат</label>
            <label class="error-msg form_input-state-error"
                   v-if="( v.state.$dirty && !v.state.validState)">Введите двухбуквенную аббревиатуру штата</label>
            <label class="error-msg form_input-zip-error"
                   v-if="(v.zip.$dirty && !v.zip.required)">Введите зип код</label>
            <label class="error-msg form_input-zip-error"
                   v-if="(v.zip.$dirty && !v.zip.validZip)">Введите зип код в формате xxxxx-xxxx</label>
        </div>
        <div class="errors-div_phone errors-div">
            <label class="error-msg form_input-phone-error"
                   v-if="(v.phone_1.$dirty && !v.phone_1.required)">Введите телефон</label>
            <label class="error-msg form_input-phone-error"
                   v-if="(v.phone_1.$dirty && !v.phone_1.validPhone)">
                Допустимый формат телефона : xxx-xxx-xxxx</label>
            <label class="error-msg form_input-phone-error"
                   v-if="(v.phone_2.$dirty && !v.phone_2.validPhone)">
                Допустимый формат телефона : xxx-xxx-xxxx</label>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['v'],
    }
</script>

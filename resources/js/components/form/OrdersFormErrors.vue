<template>
    <div class="form_table-errors">
        <div class="errors-div">
            <label class="error-msg form_input-name-error"
                   v-if="(v.name.$dirty && !v.name.required)">Введите имя</label>
            <label class="error-msg form_input-name-error"
                   v-if="( v.name.$dirty && !v.name.validName)">
                В имени не должно быть ничего кроме букв</label>
        </div>
        <div class="errors-div">
            <label class=" error-msg form_input-content-error"
                   v-if="(v.content.$dirty && !v.content.required)"
            >Заполните поле с содержимым</label>
            <label class=" error-msg form_input-quantity-error"
                   v-if="(v.quantity.$dirty && !v.quantity.integer)"
            >В поле с количеством допустимы только цифры</label>
            <label class=" error-msg form_input-quantity-error"
                   v-if="(v.content.$dirty && !v.content.required)"
            >Заполните поле с содержимым</label>
            <label class=" error-msg form_input-condition-error"
                   v-if="(v.condition.$dirty && !v.condition.required || v.condition.$dirty && !v.condition.integer)"
            >Выберите состояние из списка</label>
        </div>
        <div class="errors-div">
            <label class=" error-msg form_input-tracking-error"
                   v-if="(v.tracking_number.$dirty && !v.tracking_number.required)"
            >Введите трек номер</label>
            <label class=" error-msg form_input-holder-error"
                   v-if="(v.holder.$dirty && !v.holder.required)"
            >Введите имя холдера</label>
            <label class=" error-msg form_input-holder-error"
                   v-if="(v.holder.$dirty && !v.holder.validName)"
            >В имени не должно быть ничего кроме букв</label>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {

        },

        props: ['v'],

    }
</script>

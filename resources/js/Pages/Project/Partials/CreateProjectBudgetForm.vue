
<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import {defineEmits, watch} from "vue";

const form = useForm({
    budget: '',
    spend: '',
    //valuation: ''
});


// Define emits
const emit = defineEmits(['update:form', 'submit']);

// Emit form values to parent
const emitFormValues = () => {
    emit('update:form', form);
};

// Watch for changes in form and emit updates
watch(form, (newForm) => {
    emit('update:form', newForm);
}, { deep: true });


function formatNumber(n: any) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function formatCurrency(event: any, blur: any) {
    // get input value
    let input_val = event.target.value;

    // don't validate empty input
    if (input_val === "") return;

    // original length
    let original_len = input_val.length;

    // initial caret position
    let caret_pos = event.target.selectionStart;

    // check for decimal
    if (input_val.indexOf(".") >= 0) {
        // get position of first decimal
        let decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        let left_side = input_val.substring(0, decimal_pos);
        let right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
            right_side += "00";
        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = "R " + left_side + "." + right_side;
    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = "R " + input_val;

        // final formatting
        if (blur === "blur") {
            input_val += ".00";
        }
    }

    // send updated string to input
    event.target.value = input_val;
    //form.valuation = input_val;

    // put caret back in the right position
    let updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    event.target.setSelectionRange(caret_pos, caret_pos);
}

function handleInput(event: any, blur: any) {
    formatCurrency(event, blur);
    emitFormValues();
}

</script>


<template>
    <section >
        <header>
            <h2 class="text-lg font-medium text-gray-900">Project financials <small><span class="text-gray-700">| Budget and spend</span></small></h2>

            <p class="mt-1 text-sm text-gray-600">
                Total budget and spend for the project in the current Financial Year
            </p>

        </header>


        <div class="mt-6 space-y-6 max-w-full" >
            <div >
                <InputLabel for="project-name" value="Budget" />
                <TextInput
                    id="project-budget"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.budget"
                    required
                    @input="handleInput"
                />

                <InputError class="mt-2" :message="form.errors.budget" />
            </div>
            <div >
                <InputLabel for="project-spend" value="Spend i.e. monies spent at the time of filling this form" />

                <TextInput
                    id="project-spend"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.spend"
                    required
                    autocomplete="spend"
                    @input="handleInput"
                />

                <InputError class="mt-2" :message="form.errors.spend" />
            </div>
        </div>
<!--        <div>-->
<!--            <InputLabel for="valuation" value="Asset value in Rands" />-->

<!--            <TextInput-->
<!--                id="valuation"-->
<!--                type="text"-->
<!--                class="mt-1 block w-full"-->
<!--                v-model="form.valuation"-->
<!--                autocomplete="valuation"-->
<!--                @input="formatCurrency"-->
<!--            />-->

<!--            <InputError class="mt-2" :message="form.errors.valuation" />-->
<!--        </div>-->
    </section>
</template>






<template>
    <div>
        <InputLabel v-if="label" :for="inputId" :value="label" />
        <TextInput
            :id="inputId"
            :type="type"
            class="mt-1 block w-full"
            :model-value="modelValue"
            @update:model-value="$emit('update:modelValue', $event)"
            v-bind="$attrs"
        />
        <InputError v-if="errorMessage" class="mt-2" :message="errorMessage" />
    </div>
</template>

<script setup>
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';

    defineProps({
        modelValue: {},
        type: {
            type: String,
            default: "text"
        },
        label: {
            type: String,
            default: ""
        },
        errorMessage: {
            type: String,
            default: ""
        },
    });
</script>
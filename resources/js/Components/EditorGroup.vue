<template>
    <div>
        <InputLabel v-if="label" :for="inputId" :value="label" />
        <editor api-key=""
                :model-value="modelValue"
                @update:model-value="$emit('update:modelValue', $event)"
                :init="config"
                v-bind="$attrs" />
        <InputError v-if="errorMessage" class="mt-1" :message="errorMessage" />
    </div>
</template>

<script setup>
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';

    import { ref } from 'vue';

    import Editor from '@tinymce/tinymce-vue';

    defineProps({
        modelValue: {},
        label: {
            type: String,
            default: "",
        },
        errorMessage: {
            type: String,
            default: "",
        },
    });

    const config = ref({
        height: 300
    });

</script>
<template>
    <Card class="mb-4">
        <template #header>
            Filters
        </template>
        <form class="grid grid-cols-4 gap-8">
            <div>
                <InputLabel value="Name" for="name"/>
                <TextInput type="text" id="name" class="mt-1 block w-full" v-model="filters.name"/>
            </div>
        </form>
    </Card>
</template>

<script setup>
    import { ref, watch } from 'vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import Card from '@/Components/Card/Card.vue';

    const props = defineProps({
        modelValue: {
            type: Object,
            default: () => ({})
        }
    });

    const emits = defineEmits("update:modelValue");

    const filters = ref({...props.modelValue});

    watch(filters, () => {
        emits("update:modelValue", filters.value);
    }, {
        deep: true
    });
</script>
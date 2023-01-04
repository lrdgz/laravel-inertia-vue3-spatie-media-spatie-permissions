<template>
    <div>
        <div class="flex items-center justify-between">
            <slot />
            <Button v-if="$slots.filters" color="white" @click="showFilters=!showFilters">
                <FilterIcon class="w-4 h-4"/>
            </Button>
        </div>
        <slot v-if="showFilters" name="filters"/>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import FilterIcon from "@/Components/Icons/Filter.vue";
    import Button from '@/Components/Button.vue';

    const props = defineProps({
        show: {
            type: Boolean,
            default: false
        }
    });

    const showFilters = ref(props.show ?? false);

</script>
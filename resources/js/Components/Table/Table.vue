<template>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="border-b">
                            <tr>
                                <Th v-for="header in headers" :key="header.label">
                                    {{ header.label }}
                                </Th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b" v-for="item in items.data" :key="item.id">
                                <slot :item="item" />
                            </tr>
                            <tr v-if="items.data.length === 0">
                                <Td :colspan="headers.length">
                                    No data available.
                                </Td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2" v-if="items.meta.links.length > 3">
        <Pagination :links="items.meta.links"/>
    </div>
</template>

<script setup>
    import Th from './Th.vue';
    import Td from './Td.vue';
    import Pagination from './Pagination.vue';

    defineProps({
        headers: {
            type: Array,
            default: () => []
        },

        items: {
            type: Object,
            default: () => ({})
        }
    });
</script>
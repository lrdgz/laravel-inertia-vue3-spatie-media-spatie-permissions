<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-gray-900">
        <div v-if="isLoading" class="w-full bg-gray-200 h-1">
            <div class="bg-blue-600 h-1 animate-progress">

            </div>
        </div>
        <div v-if="$slots.header" class="px-6 py-2 font-bold bg-gray-50">
            <slot name="header" />
        </div>
        <div class="p-6">
            <slot />
        </div>
        <div v-if="$slots.footer" class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
            <slot name="footer" />
        </div>
    </div>
</template>

<script setup>
    defineProps({
        isLoading: {
            type: Boolean,
            default: false
        }
    });
</script>
<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import Container from '@/Components/Container.vue';
    import Card from '@/Components/Card/Card.vue';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <Container>
            <Card>
                Dashboard
            </Card>
        </Container>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import Container from '@/Components/Container.vue';
    import Card from '@/Components/Card/Card.vue';
    import Button from '@/Components/Button.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { onMounted } from 'vue';

    const props = defineProps({
        edit: {
            type: Boolean,
            default: false
        },
        title: {
            type: String,
            required: true
        },
        routeResourceName: {
            type: String,
            required: true
        },
        item: {
            type: Object,
            default: () => ({})
        }
    });

    const form = useForm({
        name: '',
    });

    const submit = () => {
        props.edit 
            ? form.put(route(`admin.${props.routeResourceName}.update`, { id: props.item.id }))
            : form.post(route(`admin.${props.routeResourceName}.store`));
    }

    onMounted(() => {
        if(props.edit) {
            form.name = props.item.name;
        }
    })

</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ title }}</h2>
        </template>

        <Container>
            <Card>
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="name" value="Name" />

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                        />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div class="mt-4">
                        <Button :disabled="form.processing">
                            {{ form.processing ? 'Saving...' : 'Save' }}
                        </Button>
                    </div>
                </form>
            </Card>
        </Container>
    </AuthenticatedLayout>
</template>

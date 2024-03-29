<script setup>
    import { onMounted, watch } from 'vue';
    import kebabCase from "lodash/kebabCase";
    import replace from "lodash/replace";
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import Container from '@/Components/Container.vue';
    import Card from '@/Components/Card/Card.vue';
    import Button from '@/Components/Button.vue';
    import InputGroup from '@/Components/InputGroup.vue';
    import SelectGroup from '@/Components/SelectGroup.vue';
    import CheckboxGroup from '@/Components/CheckboxGroup.vue';

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
        },
        rootCategories: {
            type: Array,
            required: true
        },
    });

    const form = useForm({
        name: '',
        slug: '',
        active: true,
        parentId: '',
    });

    watch(
        () => form.name,
        (name) => {
            if(!props.edit){
                form.slug = kebabCase(replace(name, /&./, "and"));
            }
        }
    );

    const submit = () => {
        props.edit 
            ? form.put(route(`admin.${props.routeResourceName}.update`, { id: props.item.id }))
            : form.post(route(`admin.${props.routeResourceName}.store`));
    }

    onMounted(() => {
        if(props.edit) {
            form.name = props.item.name;
            form.slug = props.item.slug;
            form.active = Boolean(props.item.active);
            form.parentId = props.item.parent_id;
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
                    <div class="grid grid-cols-2 gap-6">
                        <InputGroup 
                            label="Name" 
                            v-model="form.name" 
                            :error-message="form.errors.name" 
                            :required="!edit"
                        />
                        <InputGroup 
                            label="Slug" 
                            v-model="form.slug" 
                            :error-message="form.errors.slug" 
                            :required="!edit"
                        />
                        <SelectGroup 
                            label="Parent Category" 
                            v-model="form.parentId" 
                            :items="rootCategories"
                            :error-message="form.errors.parentId"
                        />
                        <div class="mt-6">
                            <CheckboxGroup 
                                label="Active" 
                                v-model:checked="form.active" 
                                :error-message="form.errors.active" 
                            />
                        </div>
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

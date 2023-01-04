<script setup>
    import { ref } from 'vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Container from '@/Components/Container.vue';
    import Card from '@/Components/Card/Card.vue';
    import Table from '@/Components/Table/Table.vue';
    import Td from '@/Components/Table/Td.vue';
    import Actions from '@/Components/Table/Actions.vue';
    import Button from '@/Components/Button.vue';
    import Modal from '@/Components/Modal.vue';
    import Filters from './Filters.vue';
    import AddNew from "@/Components/AddNew.vue";
    import useDeleteItem from "@/Composables/useDeleteItem.js";
    import useFilters from "@/Composables/useFilters.js";

    const props = defineProps({
        title: {
            type: String,
            required: true
        },

        filters: {
            type: Object,
            default: () => {}
        },

        routeResourceName: {
            type: String,
            required: true
        },

        items: {
            type: Object,
            default: () => {}
        },

        headers: {
            type: Object,
            default: () => {}
        },

        can: {
            type: Object
        },
        rootCategories: {
            type: Array
        },
    });

    const {
        deleteModal,
        isDeleting,
        itemToDelete,
        showDeleteModal,
        handleDeleteItem
    } = useDeleteItem({
        routeResourceName: props.routeResourceName
    });

    const {
        filters,
        isLoading,
        isFilled
    } = useFilters({
        filters: props.filters,
        routeResourceName: props.routeResourceName
    });

</script>

<template>
    <Head :title="title" />
    
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ title }}</h2>
        </template>

        <Container>
            <AddNew :show="isFilled">
                <Button v-if="can.create" :href="route(`admin.${routeResourceName}.create`)">Add New</Button>
                <template #filters>
                    <Filters v-model="filters" :categories="rootCategories" class="mt-4"/>
                </template>
            </AddNew>
            <Card class="mt-4" :is-loading="isLoading">
                <Table :headers="headers" :items="items">
                    <template v-slot="{ item }">
                        <Td>
                            {{ item.name }}
                        </Td>
                        <Td>
                            <Button 
                                v-if="item.children_count > 0" 
                                :href="route(`admin.${routeResourceName}.index`, { parentId: item.id })"
                                small
                            >{{ item.children_count }}</Button>
                            <span v-else>
                                {{ item.children_count }}
                            </span>
                        </Td>
                        <Td>
                            <Button :color="item.active ? 'green' : 'red'" small>
                                {{ item.active ? 'Active' : 'Inactive' }}
                            </Button>
                        </Td>
                        <Td>
                            {{ item.created_at_formatted }}
                        </Td>
                        <Td>
                            <Actions 
                                :edit-link="route(`admin.${routeResourceName}.edit`, {id: item.id})" 
                                :show-edit="item.can.edit"
                                :show-delete="item.can.delete"
                                @deleteClicked="showDeleteModal(item)"
                            />
                        </Td>
                    </template>
                </Table>
            </Card>
        </Container>
    </AuthenticatedLayout>

    <Modal :show="deleteModal" maxWidth="sm" :closeable=true>
        <Card>
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-2">Are you sure to delete this item?</h2>
            </template>
            {{itemToDelete.name}}
            <Card>
                <template #footer>
                    <Button @click="handleDeleteItem" :disabled="isDeleting">
                        <span v-if="isDeleting">Deleting</span>
                        <span v-else>Delete</span>
                    </Button>
                    <Button>Close</Button>
                </template>
            </Card>
        </Card>
    </Modal>
</template>

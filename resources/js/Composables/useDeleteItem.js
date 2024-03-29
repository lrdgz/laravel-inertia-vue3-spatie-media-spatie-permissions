import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

export default (params) => {
    const { 
        routeResourceName,
    } = params;

    const deleteModal = ref(false);
    const isDeleting = ref(false);
    const itemToDelete = ref({});

    const showDeleteModal = (item) => {
        deleteModal.value = true;
        itemToDelete.value = item;
    };

    const handleDeleteItem = () => {
        Inertia.delete(
            route(`admin.${routeResourceName}.destroy`, {id: itemToDelete.value.id}),
            {
                preserveScroll: true,
                preserveState: true,
                onBefore: () => {
                    isDeleting.value = true;
                },
                onSuccess: () => {
                    deleteModal.value = false;
                    itemToDelete.value = {};
                },
                onFinish: () => {
                    isDeleting.value = false;
                }
            }
        )
    }

    return {
        deleteModal,
        isDeleting,
        itemToDelete,
        showDeleteModal,
        handleDeleteItem
    }
};
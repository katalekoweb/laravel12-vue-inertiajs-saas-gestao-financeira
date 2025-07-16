<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const toast = useToast();

const props = defineProps({
    categories: {
        type: Object,
        default: () => ({})
    },
    query: {
        type: String,
        default: () => ("")
    }
})

const queryString = ref(props.query)

const deleteRecord = (id) => {
    if (confirm('Sure?')) {
        const form = useForm({
            id: id
        })

        form.delete(route('admin.categories.destroy', id), {
            onSuccess: () => {}
        })
    }
}
</script>

<template>

    <Head title="Categories" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Categories
                </h2>

                <Link class="underline" :href="route('admin.categories.create')">New category</Link>
            </div>
        </template>

        <Toast />

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white space-y-4 p-4 shadow-sm sm:rounded-lg dark:bg-gray-800">

                    <form method="get" class="flex space-x-2">
                        <TextInput name="query" placeholder="Search here..." v-model="queryString" />
                        <SecondaryButton type="submit">Search</SecondaryButton>
                        <Link v-if="queryString" class=" bg-red-700 text-white px-5 rounded-md p-2 shadow-md" :href="route('admin.categories.index')"> Clean</Link>
                    </form>

                    <div class="w-full overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>
                                        Name
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="categories.data.length == 0">
                                    <td class="text-center" colspan="3">No records found</td>
                                </tr>
                                <tr v-for="category in categories.data" :key="category.id">
                                    <td> {{ category.id }} </td>
                                    <td> {{ category.name }} </td>
                                    <td class=" flex items-center space-x-2">
                                        <Link :href="route('admin.categories.edit', category.id)">
                                        <PrimaryButton>Edit</PrimaryButton>
                                        </Link>
                                        <DangerButton @click="deleteRecord(category.id)">Delete</DangerButton>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div>
                        <Pagination :links="categories.links" />
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

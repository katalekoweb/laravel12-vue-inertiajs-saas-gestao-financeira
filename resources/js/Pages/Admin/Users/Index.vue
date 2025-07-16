<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import { ref } from 'vue';

const toast = useToast();

const props = defineProps({
    users: {
        type: Object,
        default: () => ({})
    },
    stats: {
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

        form.delete(route('admin.users.destroy', id), {
            onSuccess: () => {}
        })
    }
}
</script>

<template>

    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Users
                </h2>

                <Link class="underline" :href="route('admin.users.create')">New user</Link>
            </div>
        </template>

        <Toast />

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white space-y-4 p-4 shadow-sm sm:rounded-lg dark:bg-gray-800">

                    <div class="border-b grid grid-cols-2">
                        <div class="py-4">
                            <div class="text-xl">Total Users</div>
                            <div class="text-3xl">
                                {{ stats.all_users }}
                            </div>
                        </div>
                        <div class="py-4 border-b-2 border-green-500">
                            <div class="text-xl">Active Users</div>
                            <div class="text-3xl">
                                {{ stats.active_users }}
                            </div>
                        </div>
                    </div>

                    <form method="get" class="flex space-x-2">
                        <TextInput name="query" placeholder="Search here..." v-model="queryString" />
                        <SecondaryButton type="submit">Search</SecondaryButton>
                        <Link v-if="queryString" class=" bg-red-700 text-white px-5 rounded-md p-2 shadow-md" :href="route('admin.users.index')"> Clean</Link>
                    </form>

                    <div class="w-full overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>
                                        Name
                                    </th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="users.data.length == 0">
                                    <td class="text-center" colspan="5">No records found</td>
                                </tr>
                                <tr v-for="user in users.data" :key="user.id">
                                    <td> {{ user.id }} </td>
                                    <td> {{ user.name }} </td>
                                    <td> {{ user.email }} </td>
                                    <td> {{ user.role }} </td>
                                    <td class=" flex items-center space-x-2">
                                        <Link :href="route('admin.users.edit', user.id)">
                                        <PrimaryButton>Edit</PrimaryButton>
                                        </Link>
                                        <DangerButton @click="deleteRecord(user.id)">Delete</DangerButton>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div>
                        <Pagination :links="users.links" />
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

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
    finances: {
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

        form.delete(route('admin.finances.destroy', id), {
            onSuccess: () => {}
        })
    }
}
</script>

<template>

    <Head title="Finances" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Finances
                </h2>

                <Link class="underline" :href="route('admin.finances.create')">New record</Link>
            </div>
        </template>

        <Toast />

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white space-y-4 p-4 shadow-sm sm:rounded-lg dark:bg-gray-800">

                    <div class="border-b grid grid-cols-2 md:grid-cols-4">
                        <div class="py-4">
                            <div class="text-xl">Total Records</div>
                            <div class="text-3xl">
                                {{ stats.all_finances }}
                            </div>
                        </div>
                        <div class="py-4 border-b-2 border-green-500">
                            <div class="text-xl">Active Records</div>
                            <div class="text-3xl">
                                {{ stats.active_finances }}
                            </div>
                        </div>
                        <div class="py-4 border-b-2 border-blue-500">
                            <div class="text-xl">Total Incomes</div>
                            <div class="text-3xl">
                                {{ stats.incomes }}
                            </div>
                        </div>
                        <div class="py-4 border-b-2 border-orange-500">
                            <div class="text-xl">Total Expenses</div>
                            <div class="text-3xl">
                                {{ stats.expenses }}
                            </div>
                        </div>
                    </div>

                    <form method="get" class="flex space-x-2">
                        <TextInput name="query" placeholder="Search here..." v-model="queryString" />
                        <SecondaryButton type="submit">Search</SecondaryButton>
                        <Link v-if="queryString" class=" bg-red-700 text-white px-5 rounded-md p-2 shadow-md" :href="route('admin.finances.index')"> Clean</Link>
                    </form>

                    <div class="w-full overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>
                                        Description
                                    </th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="finances.data.length == 0">
                                    <td class="text-center" colspan="6">No records found</td>
                                </tr>
                                <tr v-for="finance in finances.data" :key="finance.id">
                                    <td> {{ finance.id }} </td>
                                    <td> {{ finance.description }} </td>
                                    <td> {{ finance.amount }} </td>
                                    <td> {{ finance.type }} </td>
                                    <td> {{ finance.category?.name }} </td>
                                    <td>{{ finance.transaction_date }}</td>
                                    <td class=" flex items-center space-x-2">
                                        <Link :href="route('admin.finances.edit', finance.id)">
                                        <PrimaryButton>Edit</PrimaryButton>
                                        </Link>
                                        <DangerButton @click="deleteRecord(finance.id)">Delete</DangerButton>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div>
                        <Pagination :links="finances.links" />
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

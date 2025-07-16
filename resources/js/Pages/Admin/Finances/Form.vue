<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {Money} from 'v-money'

const money = {
    decimal: ',',
    thousands: '.',
    prefix: 'R$ ',
    suffix: '',
    precision: 2,
    masked: false
}

const props = defineProps({
    finance: {
        type: Object,
        default: () => ({})
    },
    categories: {
        type: Object,
        default: () => ({})
    },
    tenants: {
        type: Object,
        default: () => ({})
    },
    types: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({
    description: props.finance.description,
    amount: props.finance.amount,
    category_id: props.finance.category_id,
    type: props.finance.type,
    transaction_date: props.finance.transaction_date,
    is_active: props.finance?.is_active,
    tenant_id: props.finance?.tenant_id,
})

const save = () => {
    if (props.finance.id) {
        form.put(route('admin.finances.update', props.finance.id))
    } else {
        form.post(route('admin.finances.store'))
    }
}

</script>

<template>

    <Head :title="finance.id ? 'Edit finance' : 'Create new finance'" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ finance.id ? 'Edit finance' : 'Create new finance' }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800 space-y-4">

                    <div>
                        <InputLabel for="description" value="Description" />
                        <TextInput id="description" type="text" class="mt-1 block w-full" v-model="form.description"
                            required autofocus autocomplete="description" />
                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>

                    <div>
                        <InputLabel for="amount" value="Amount" />
                        <TextInput id="amount" v-money="money" type="text" class="mt-1 block w-full" v-model="form.amount" />
                        <InputError class="mt-2" :message="form.errors.amount" />
                    </div>

                    <div>
                        <InputLabel for="type" value="Type" />
                        <select class="w-full border" name="type" v-model="form.type" id="type">
                            <option value="">Select</option>
                            <option v-for="(typeItem, index) in types" :key="index" :value="index"> {{ typeItem }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.type" />
                    </div>

                    <div>
                        <InputLabel for="transaction_date" value="Transaction Date" />
                        <TextInput id="transaction_date" type="date" class="mt-1 block w-full"
                            v-model="form.transaction_date" />
                        <InputError class="mt-2" :message="form.errors.transaction_date" />
                    </div>



                    <div>
                        <InputLabel for="category_id" value="Category" />
                        <select class="w-full border" name="category_id" v-model="form.category_id" id="category_id">
                            <option value="">Select</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">{{
                                category.name }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.tenant_id" />
                    </div>

                    <div v-if="$page.props.auth.user.is_super_admin == 1">
                        <InputLabel for="tenant_id" value="Tenant" />
                        <select class="w-full border" name="tenant_id" v-model="form.tenant_id" id="tenant_id">
                            <option value="">Select</option>
                            <option v-for="tenant in tenants" :key="tenant.id" :value="tenant.id">{{ tenant.name }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.tenant_id" />
                    </div>

                    <div>
                        <InputLabel for="is_active" value="Is Active" />
                        <input id="is_active" type="checkbox" class="mt-1 block" v-model="form.is_active" />
                        <InputError class="mt-2" :message="form.errors.is_active" />
                    </div>

                    <div class=" flex items-center justify-end">
                        <div class="">
                            <PrimaryButton @click="save()">Save</PrimaryButton>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

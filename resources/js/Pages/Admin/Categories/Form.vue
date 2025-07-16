<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    category: {
        type: Object,
        default: () => ({})
    },
    tenants: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({
    name: props.category.name,
    is_active: props.category?.is_active,
    tenant_id: props.category?.tenant_id,
})

const save = () => {
    if (props.category.id) {
        form.put(route('admin.categories.update', props.category.id))
    } else {
        form.post(route('admin.categories.store'))
    }
}

</script>

<template>

    <Head :title="category.id ? 'Edit category' : 'Create new category'" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ category.id ? 'Edit category' : 'Create new category' }}
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800 space-y-4">

                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div v-if="$page.props.auth.user.is_super_admin == 1">
                        <InputLabel for="tenant_id" value="Tenant" />
                        <select class="w-full border" name="tenant_id" v-model="form.tenant_id" id="tenant_id">
                            <option value="">Select</option>
                            <option v-for="tenant in tenants" :key="tenant.id" :value="tenant.id">{{ tenant.name }}</option>
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

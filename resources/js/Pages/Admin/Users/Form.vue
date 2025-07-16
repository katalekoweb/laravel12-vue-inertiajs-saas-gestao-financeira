<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    user: {
        type: Object,
        default: () => ({})
    },
    tenants: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    role: props.user.role,
    is_active: props.user?.is_active,
    tenant_id: props.user.tenant_id,
})

const save = () => {
    if (props.user.id) {
        form.put(route('admin.users.update', props.user.id))
    } else {
        form.post(route('admin.users.store'))
    }
}

</script>

<template>

    <Head :title="user.id ? 'Edit user' : 'Create new user'" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ user.id ? 'Edit user' : 'Create new user' }}
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

                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div>
                        <InputLabel for="role" value="Role" />
                        <select class="w-full border" name="role" v-model="form.role" id="role">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.role" />
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

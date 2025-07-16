<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const toast = useToast();

const props = defineProps({
    tenant: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({
    name: props.tenant.name,
    email: props.tenant.email,
    phone: props.tenant.phone,
    address: props.tenant.address,
    domain: props.tenant.domain,
    doc: props.tenant.doc,
})

const save = () => {
    form.post(route('admin.settings.update', props.tenant.id))
}

</script>

<template>

    <Head :title="tenant.id ? 'Edit tenant' : 'Create new tenant'" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ tenant.id ? 'Edit tenant' : 'Create new tenant' }}
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
                        <InputLabel for="doc" value="Doc" />
                        <TextInput id="doc" type="text" class="mt-1 block w-full" v-model="form.doc" />
                        <InputError class="mt-2" :message="form.errors.doc" />
                    </div>

                     <div>
                        <InputLabel for="domain" value="Domain" />
                        <TextInput id="domain" type="text" class="mt-1 block w-full" v-model="form.domain" />
                        <InputError class="mt-2" :message="form.errors.domain" />
                    </div>

                     <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                     <div>
                        <InputLabel for="phone" value="Phone" />
                        <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" />
                        <InputError class="mt-2" :message="form.errors.phone" />
                    </div>

                    <div>
                        <InputLabel for="address" value="Address" />
                        <TextInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" />
                        <InputError class="mt-2" :message="form.errors.address" />
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

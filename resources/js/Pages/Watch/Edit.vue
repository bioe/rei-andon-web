<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});

const routeGroupName = 'watches';
const headerTitle = ref('Watch');

const form = useForm({
    code: props.data.code ?? '',
    ip_address: props.data.ip_address ?? '',
    active: props.data.active,
});

// const submit = () => {
//     form.get(route('users.index'), {
//         preserveScroll: true,
//     });
// };
</script>

<template>
    <Head :title="headerTitle" />

    <AuthenticatedLayout>
        <template #header>
            {{ headerTitle }}
        </template>

        <form
            @submit.prevent="data.id == null ? form.post(route(routeGroupName + '.store')) : form.patch(route(routeGroupName + '.update', data.id))">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab_1">Details</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade pt-10 show active" id="tab_1" role="tabpanel" aria-labelledby="tab_1">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <InputLabel for="code" value="Code" />
                                    <TextInput id="code" type="text" v-model="form.code" :invalid="form.errors.code"
                                        required />
                                    <InputError :message="form.errors.code" />
                                </div>
                                <div class="col-md-4">
                                    <InputLabel for="ip_address" value="IP Address" />
                                    <TextInput id="ip_address" type="text" v-model="form.ip_address" :invalid="form.errors.ip_address"
                                        required />
                                    <InputError :message="form.errors.ip_address" />
                                </div>
                                <div class="col-12">
                                    <Checkbox id="checkActive" v-model:checked="form.active">
                                        Active
                                    </Checkbox>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12">
                        <Link class="btn btn-secondary me-2" :href="route(routeGroupName + '.index')">Back</Link>
                        <PrimaryButton type="submit" v-html="data.id == null ? 'Create' : 'Save'"></PrimaryButton>
                    </div>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
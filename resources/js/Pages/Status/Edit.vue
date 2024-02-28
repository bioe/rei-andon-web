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

const routeGroupName = 'statuses';
const headerTitle = ref('Status');

const form = useForm({
    code: props.data.code ?? '',
    name: props.data.name ?? '',
    description: props.data.description ?? '',
    state: props.data.state ?? '',
    button_1: props.data.button_1 ?? '',
    button_2: props.data.button_2 ?? '',
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
                                    <InputLabel for="name" value="Name" />
                                    <TextInput id="name" type="text" v-model="form.name" :invalid="form.errors.name"
                                        required />
                                    <InputError :message="form.errors.name" />
                                </div>
                                <div class="col-md-4">
                                    <InputLabel for="state" value="State" />
                                    <select id="state" v-model="form.state" :invalid="form.errors.state"
                                        class="form-select">
                                        <option value="">Please Select</option>
                                        <option value="warning">Warning</option>
                                        <option value="error">Error</option>
                                    </select>
                                    <InputError :message="form.errors.state" />
                                </div>
                                <div class="col-md-4">
                                    <InputLabel for="button_1" value="Button 1" />
                                    <TextInput id="button_1" type="text" v-model="form.button_1"
                                        :invalid="form.errors.button_1" required />
                                    <InputError :message="form.errors.button_1" />
                                </div>
                                <div class="col-md-4">
                                    <InputLabel for="button_2" value="Button 2" />
                                    <TextInput id="button_2" type="text" v-model="form.button_2"
                                        :invalid="form.errors.button_2" />
                                    <InputError :message="form.errors.button_2" />
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
<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
// import the component
import Treeselect from "@zanmato/vue3-treeselect";
// import the styles
import "@zanmato/vue3-treeselect/dist/vue3-treeselect.min.css";

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    type_of_machines: {
        type: Array
    }
});

const routeGroupName = 'groups';
const headerTitle = ref('Group');

const form = useForm({
    name: props.data.name ?? '',
    description: props.data.description ?? '',
    machine_list: props.data.machine_list ?? [],
    active: props.data.active,
    segment_code: props.data.segment_code ?? ''
});
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
                                <div class="col-md-6">
                                    <InputLabel for="name" value="Name" />
                                    <TextInput id="name" type="text" v-model="form.name" :invalid="form.errors.name"
                                        required />
                                    <InputError :message="form.errors.name" />
                                </div>
                                <div class="col-md-6">
                                    <InputLabel for="description" value="Description" />
                                    <TextAreaInput class="form-control" id="description" type="text"
                                        v-model="form.description" :invalid="form.errors.description" required />
                                    <InputError :message="form.errors.description" />
                                </div>
                                <div class="col-md-6">
                                    <InputLabel for="segment_code" value="Segment / Zone" />
                                    <TextInput id="segment_code" type="text" v-model="form.segment_code"
                                        :invalid="form.errors.segment_code" required />
                                    <InputError :message="form.errors.segment_code" />
                                </div>
                                <div class="col-md-6">
                                    <InputLabel for="machines" value="Machines Types" />
                                    <treeselect v-model="form.machine_list" :multiple="true"
                                        :options="props.type_of_machines" placeholder="Select your machine(s)..." />
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
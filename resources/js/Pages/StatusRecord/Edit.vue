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
    machines: {
        type: Object,
        default: () => ({}),
    },
    statuses: {
        type: Object,
        default: () => ({}),
    }
});

const routeGroupName = 'statusrecords';
const headerTitle = ref('Record');

const form = useForm({
    machine_code: props.data.machine_code ?? null,
    status_id: props.data.status_id ?? null
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
                                    <InputLabel for="machine_code" value="Machine Code" />
                                    <select v-model="form.machine_code" class="form-select"
                                        :class="{ 'is-invalid': form.errors.machine_code }" id="machine_code" required>
                                        <option :value='null'>Please Select</option>
                                        <option v-for="m in machines" :value="m.code">{{ m.code }}</option>
                                    </select>
                                    <InputError :message="form.errors.machine_code" />
                                </div>
                                <div class="col-md-12">
                                    <InputLabel for="status_id" value="Status" />
                                    <select v-model="form.status_id" class="form-select"
                                        :class="{ 'is-invalid': form.errors.status_id }" id="status_id" required>
                                        <option :value='null'>Please Select</option>
                                        <option v-for="s in statuses" :value="s.id">{{ s.code }} - {{ s.name }}</option>
                                    </select>
                                    <InputError :message="form.errors.status_id" />
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
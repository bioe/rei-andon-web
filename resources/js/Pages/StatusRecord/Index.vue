<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import HeadRow from '@/Components/Table/HeadRow.vue';
import Paginate from '@/Components/Table/Paginate.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { formatDate } from '@/helper';

const props = defineProps({
    header: {
        type: Object
    },
    filters: {
        type: Object
    },
    list: {
        type: Object,
        default: () => ({}),
    },
    segments: {
        type: Object,
    }
});

const routeGroupName = 'statusrecords';
const headerTitle = ref('Records');
const form = useForm(props.filters);

const sort = (field) => {
    form.sort.field = field;
    form.sort.direction = form.sort.direction == "" || form.sort.direction == "desc" ? "asc" : "desc";
    submit();
}

const submit = () => {
    form.get(route(routeGroupName + '.index'), {
        preserveScroll: true,
    });
};

const destroy = (id, name) => {
    const c = confirm(`Delete this status ${name} ?`);
    if (c) {
        router.delete(route(routeGroupName + '.destroy', id));
    }
};
</script>

<template>

    <Head :title="headerTitle" />

    <AuthenticatedLayout>
        <template #header>
            {{ headerTitle }}
        </template>

        <div class="my-3 p-3 bg-body rounded shadow-sm">

            <form @submit.prevent="submit">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-floating mb-3">
                            <input v-model="form.keyword" type="text" class="form-control" id="keywordInput"
                                placeholder="Keyword" autocomplete="off">
                            <label for="keywordInput">Keyword</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating mb-3">
                            <select v-model="form.segment_code" class="form-select" id="zoneInput">
                                <option :value='null'>All</option>
                                <option v-for="s in segments" :value="s.code">{{ s.code }}</option>
                            </select>
                            <label for="zoneInput">Zone</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <PrimaryButton type="submit" :disabled="form.processing">
                            <i class="bi bi-search"></i>
                            Search
                        </PrimaryButton>
                    </div>
                </div>
            </form>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <HeadRow v-if="$page.props.auth.isEditable">Actions</HeadRow>
                        <HeadRow v-for="head in header" :field="head.field" :sort="head.sortable ? filters.sort : null"
                            @sortEvent="sort" :disabled="form.processing">{{ head.title }}</HeadRow>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in list.data">
                        <td v-if="$page.props.auth.isEditable" width="5%">
                            <button @click="destroy(item.id, item.id)" class="btn btn-sm btn-link">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                        <td>{{ item.machine_code }}</td>
                        <td>{{ item.segment_code }}</td>
                        <td>{{ item.employee_code }}</td>
                        <td>{{ formatDate(item.created_at) }}</td>
                        <td>
                            {{ item.status.code }}<br/>
                            {{ item.status.name }}
                        </td>
                        <td>
                            <template v-if="item.attending">
                            {{ formatDate(item.attending.created_at) }} 
                            <br /> By: {{ item.attending.employee_name }}
                            </template>
                        </td>
                        <td>{{ formatDate(item.attended_at) }}</td>
                        <td>{{ formatDate(item.resolved_at) }}</td>
                        <td>{{ formatDate(item.completed_at) }}</td>
                    </tr>
                </tbody>
            </table>
            <Paginate :data="list" />
        </div>


    </AuthenticatedLayout>
</template>
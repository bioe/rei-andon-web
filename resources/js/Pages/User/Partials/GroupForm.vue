<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Link } from '@inertiajs/vue3';
// import the component
import Treeselect from "@zanmato/vue3-treeselect";
// import the styles
import "@zanmato/vue3-treeselect/dist/vue3-treeselect.min.css";

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    group_options: {
        type: Array
    }
});

const routeGroupName = 'users.group';

const form = useForm({
    groups: props.data.group_ids ?? [],
});
</script>

<template>
    <form @submit.prevent="form.patch(route(routeGroupName + '.update', data.id))">

        <div class="row g-3">
            <div class="col-md-6">
                <InputLabel for="groups" value="Groups" />
                <treeselect v-model="form.groups" :multiple="true" :options="props.group_options"
                    placeholder="Select your group(s)..." />
            </div>
            <div class="col-12">
                <PrimaryButton type="submit" v-html="data.id == null ? 'Create' : 'Save'"></PrimaryButton>
            </div>
        </div>
    </form>
</template>


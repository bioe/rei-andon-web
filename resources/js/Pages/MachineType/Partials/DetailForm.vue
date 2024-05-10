<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});

const routeGroupName = 'machinetypes';

const form = useForm({
    code: props.data.code ?? '',
    name: props.data.name ?? '',
});
</script>

<template>
    <form
        @submit.prevent="data.id == null ? form.post(route(routeGroupName + '.store')) : form.patch(route(routeGroupName + '.update', data.id))">

        <div class="row g-3">
            <div class="col-md-6">
                <InputLabel for="mt-code" value="Code" />
                <TextInput id="mt-code" type="text" v-model="form.code" :invalid="form.errors.code" required />
                <InputError :message="form.errors.code" />
            </div>

            <div class="col-md-6">
                <InputLabel for="mt-name" value="Name" />
                <TextInput id="mt-name" type="text" v-model="form.name" :invalid="form.errors.name" />
                <InputError :message="form.errors.name" />
            </div>
            <div class="col-12">
                <PrimaryButton type="submit" v-html="data.id == null ? 'Create' : 'Save'"></PrimaryButton>
            </div>
        </div>
    </form>
</template>

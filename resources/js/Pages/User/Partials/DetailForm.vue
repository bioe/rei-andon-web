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
    useUsername: {
        type: Boolean
    },
    user_type_options: {
        type: Array,
    },
    shift_options: {
        type: Array,
    },
});

const routeGroupName = 'users';

const form = useForm({
    username: props.data.username ?? null,
    name: props.data.name ?? '',
    email: props.data.email ?? '',
    active: props.data.active,
    user_type: props.data.user_type,
    shift: props.data.shift,
    password: '',
});
</script>

<template>
    <form
        @submit.prevent="data.id == null ? form.post(route(routeGroupName + '.store')) : form.patch(route(routeGroupName + '.update', data.id))">

        <div class="row g-3">
            <div v-if="useUsername" class="col-md-6">
                <InputLabel for="username" value="Employee Code" />
                <TextInput id="username" type="text" v-model="form.username" :invalid="form.errors.username" required
                    placeholder="Login ID" />
                <InputError :message="form.errors.username" />
            </div>

            <!-- <div class="col-md-6">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" v-model="form.email" :invalid="form.errors.email" required />
                <InputError :message="form.errors.email" />
            </div> -->

            <div class="col-md-6">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" type="password" v-model="form.password" :invalid="form.errors.password" placeholder="Leave blank if no change" />
                <InputError :message="form.errors.password" />
            </div>

            <div class="col-md-6">
                <InputLabel for="name" value="Name" />
                <TextInput id="name" type="text" v-model="form.name" :invalid="form.errors.name" required />
                <InputError :message="form.errors.name" />
            </div>

            <div class="col-md-6">
                <InputLabel for="user_type" value="User Role" />
                <select class="form-select" name="user_type" v-model="form.user_type" :invalid="form.errors.user_type">
                    <option v-for="v in user_type_options" :value="v">{{ v }}</option>
                </select>
                <InputError :message="form.errors.user_type" />
            </div>

            <!-- <div class="col-md-6">
                <InputLabel for="shift" value="Shift" />
                <select class="form-select" name="shift" v-model="form.shift" :invalid="form.errors.shift">
                    <option :value="null">Select your shift</option>
                    <option v-for="v in shift_options" :value="v">{{ v }}</option>
                </select>
                <InputError :message="form.errors.shift" />
            </div> -->

            <div class="col-12">
                <Checkbox id="checkActive" v-model:checked="form.active">
                    Active
                </Checkbox>
            </div>
            <div class="col-12">
                <PrimaryButton type="submit" v-html="data.id == null ? 'Create' : 'Save'"></PrimaryButton>
            </div>
        </div>
    </form>
</template>

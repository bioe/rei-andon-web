<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import Alert from '@/Components/Alert.vue';
import GuestPrimaryButton from '@/Components/Guest/GuestPrimaryButton.vue';
import axios from 'axios';

const props = defineProps({
    timeout_sec: {
        type: Number
    },
    watch_login_log_id: {
        type: Number
    }
});

const isLoading = ref(false)
const successMsg = ref('')
const errorMsg = ref('')

const form = useForm({
    watch_code: '',
    username: '',
});

const submit = () => {
    isLoading.value = true;
    errorMsg.value = "";
    successMsg.value = "";
    form.post(route('watch_login'), {
        onSuccess: (res) => loginTimeout(),
        onError: () => isLoading.value = false
    })
};

let interval = null;
let timeout = null;
//Wait until the watch accept the login, too long then timeout
const loginTimeout = () => {
    interval = setInterval(checkIsLogin, 1000, props.watch_login_log_id);

    timeout = setTimeout(() => {
        reset();
        errorMsg.value = "Unable to login, please try again.";
    }, props.timeout_sec)
}

function checkIsLogin(id) {
    axios.get(route('watch_is_login', id)).then(function (response) {
        if (response.data.success) {
            reset();
            form.reset();
            successMsg.value = response.data.message;
        }
    }).catch(function () {
    });;
}

function reset() {
    clearInterval(interval);
    clearTimeout(timeout);
    isLoading.value = false;
}
</script>

<template>
    <GuestLayout>

        <Head title="Watch Login" />
        <h1 class="h3 mb-3 fw-normal">Andon Watch Login</h1>
        <Alert :message="successMsg" :status="'success'" />
        <Alert :message="errorMsg" :status="'danger'" />


        <form @submit.prevent="submit">
            <div class="form-floating" :class="{ 'is-invalid': form.errors.watch_code }">
                <input type="text" class="form-control" id="floatingCode" placeholder="Code"
                    :class="{ 'is-invalid': form.errors.watch_code }" v-model="form.watch_code" required
                    autocomplete="false">
                <label for="floatingCode">Watch Code</label>
            </div>
            <InputError class="my-1" :message="form.errors.watch_code" />


            <div class="form-floating my-2" :class="{ 'is-invalid': form.errors.username }">
                <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.username }"
                    id="floatingUsername" v-model="form.username" placeholder="Employee Code" required
                    autocomplete="false">
                <label for="floatingUsername">Employee Code</label>
            </div>
            <InputError class="my-1" :message="form.errors.username" />

            <!-- Optional, Customer might want it -->
            <!-- <div class="form-floating my-2" :class="{ 'is-invalid': form.errors.password }">
                <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.password }"
                    id="floatingPassword" required v-model="form.password" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <InputError class="my-1" :message="form.errors.password" /> -->

            <GuestPrimaryButton :disabled="isLoading">
                <template v-if="isLoading">
                    <span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                    <span role="status">Connecting...</span>
                </template>
                <template v-else>
                    Log in
                </template>
            </GuestPrimaryButton>

            <div class="mt-4">
                <Link :href="route('login')"> Admin Login
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>

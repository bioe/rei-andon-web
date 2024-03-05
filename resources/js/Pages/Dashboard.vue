<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    watches:{
        type: Object
    }
});

//Compute
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h3>Watches Status</h3>
            <div class="row">
                <div v-for="watch in watches" class="col-lg-3 text-light">
                    <div class="watch-column text-center rounded-3" :class="{ 'bg-success': watch.is_connected , 'bg-danger': !watch.is_connected }">
                        <h2>{{ watch.code }}</h2>
                        {{ watch.login_user?.username ?? 'N/A' }} 
                    </div>
                </div>
      
            </div>
        </div>


    </AuthenticatedLayout>
</template>

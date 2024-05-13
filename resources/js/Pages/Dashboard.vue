<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    watches: {
        type: Object
    },
    machines: {
        type: Object
    },
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
            <h3>Machines</h3>
            <div class="row">
                <div v-for="m in machines" class="col-lg-3 text-light">
                    <a :href="route('statusrecords.create') + '?machine_code=' + m.code"
                        style="text-decoration:none; color: inherit;">
                        <div class="d-flex justify-content-center align-items-center rounded-3 machine-column">
                            <div class="text-center">
                                <h3>{{ m.code }}</h3>
                                <h4 v-if="m.last_status_record && m.last_status_record.attended == null">
                                    {{ m.last_status_record.status.code }}
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>

        <!-- <div class=" my-3 p-3 bg-body rounded shadow-sm">
                            <h3>Watches Status</h3>
                            <div class="row">
                                <div v-for="watch in watches" class="col-lg-3 text-light">
                                    <div class="watch-column text-center rounded-3"
                                        :class="{ 'bg-success': watch.is_connected, 'bg-danger': !watch.is_connected }">
                                        <h2>{{ watch.code }}</h2>
                                        {{ watch.login_user?.username ?? 'N/A' }}
                                    </div>
                                </div>

                            </div>
                        </div> -->


    </AuthenticatedLayout>
</template>

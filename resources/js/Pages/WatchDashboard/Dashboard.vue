<script setup>
import { Head } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref } from 'vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

let intervalId;

const props = defineProps({
    watches: {
        type: Object
    },
    refresh_second: {
        type: Number
    }
});

const localWatches = ref(props.watches);

onMounted(() => {
    intervalId = setInterval(fetchData, props.refresh_second * 1000); // 10000 ms = 10 seconds
});

onUnmounted(() => {
    clearInterval(intervalId);
});

const fetchData = async () => {
    try {
        const response = await axios.get(route('watch_dashboard.refresh'));
        localWatches.value = response.data.watches;
    } catch (err) {
    }
};

</script>

<template>

    <Head title="Watch Dashboard" />

    <DashboardLayout>
        <template #header>
            Andon Dashboard
        </template>
      
        <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <div class="container-fluid py-1">
                <h2>Watch Status</h2>
                <div class="row">
                    <div v-for="watch in localWatches" class="col-lg-3 text-light">
                        <div class="d-flex flex-column justify-content-center align-items-center rounded-4 watch-column m-1"
                            :class="watch.colour_class">
                            <div><b>{{ watch.code }}</b></div>
                            <div>{{ watch.login_user?.name ?? 'No Login' }}</div>
                            <div v-if="watch.login_user?.active_response_record">
                                {{ watch.login_user?.active_response_record?.status_record?.machine_code }} - 
                                {{ watch.login_user?.active_response_record?.status_record?.status?.name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>

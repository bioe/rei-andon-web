<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref } from 'vue';
import MachineBox from './MachineBox.vue';

let intervalId;

const props = defineProps({
    watches: {
        type: Object
    },
    group_machines: {
        type: Object
    },
    refresh_second: {
        type: Number
    }
});

const localGroupMachines = ref(props.group_machines);

onMounted(() => {
    intervalId = setInterval(fetchData, props.refresh_second * 1000); // 10000 ms = 10 seconds
});

onUnmounted(() => {
    clearInterval(intervalId);
});

const fetchData = async () => {
    try {
        const response = await axios.get(route('dashboard.refresh'));
        localGroupMachines.value = response.data.group_machines;
    } catch (err) {
    }
};

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <div v-for="(machines, group) in localGroupMachines" class="my-3 p-3 bg-body rounded shadow-sm">
            <h3>{{ group }}</h3>
            <div class="row">
                <MachineBox v-for="m in machines" :machine="m"></MachineBox>
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

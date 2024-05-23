<script setup>
import { computed } from 'vue';
const props = defineProps({
    machine: {
        type: Object,
    },
});

const bgColor = computed(() => props.machine.bg_colour ?? 'bg-success')

</script>

<template>
    <div class="col-lg-3 text-light">
        <a :href="route('statusrecords.create') + '?machine_code=' + machine.code"
            style="text-decoration:none; color:inherit;">
            <div class="d-flex justify-content-center align-items-center rounded-4 machine-column m-1" :class="bgColor">
                <div class="text-center">
                    <h3>{{ machine.code }}</h3>
                    <h4 v-if="machine.current_status_code != null">
                        {{ machine.current_status_code }}
                    </h4>
                    <h5 v-if="machine.current_employee != null">
                        {{ machine.current_employee }}
                    </h5>
                </div>
            </div>
        </a>
    </div>
</template>

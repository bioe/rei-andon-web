<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import { onBeforeMount } from 'vue';

onBeforeMount(() => {
    //Load CSS Guest Body
    document.body.className = 'guest';
    //Vue added root div, need add container class to not break the layout
    document.querySelector('#app').classList = ['container'];
})

</script>

<template>
    <main class="form-signin w-100 m-auto text-center">
        <div>
            <Link href="/">
            <!-- <ApplicationLogo class="mb-4" width="72" height="57" /> -->
            <img src="/images/bio.png" width="70" height="70" />
            </Link>
        </div>
        <slot />
        <p class="my-5 text-muted">Bioenergy &copy; 2024 - v{{ $page.props.version }} </p>
    </main>
</template>

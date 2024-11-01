<script setup>
import { onBeforeMount } from 'vue';

onBeforeMount(() => {
    //Load CSS Guest Body
    document.body.className = 'dashboard';
    //Vue added root div, need add container class to not break the layout
    document.querySelector('#app').classList = ['container py-4'];
})

</script>
<template>
<main>
    <div>
      <header class="pb-3 mb-4 border-bottom">
        <span class="fs-4"> <slot name="header" /></span>
      </header>

      <slot />
  
      <footer class="pt-3 mt-4 text-body-secondary border-top">
        <p class="my-1 text-muted">Bioenergy &copy; 2024 - v{{ $page.props.version }} </p>
      </footer>
    </div>
  </main>
</template>

<style>
</style>
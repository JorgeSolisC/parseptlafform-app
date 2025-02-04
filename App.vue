<template>
	<component :is="layout" />
	<Toast />
</template>

<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const layout = computed(() => store.state.layout.layout);
const route = useRoute();
const store = useStore();

store.dispatch('layout/setAppLayout');

</script>
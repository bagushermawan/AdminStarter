<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
// import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { Toaster } from '@/components/ui/sonner';
import 'vue-sonner/style.css';
import { useAppearance } from '@/composables/useAppearance';
import { computed } from 'vue';

const { appearance } = useAppearance();
interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}
const toasterTheme = computed(() => {
  return appearance.value === 'system' ? 'system' : appearance.value;
});

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
        <Toaster position="top-right" closeButton richColors :expand="false" :theme="toasterTheme"/>
    </AppLayout>
</template>

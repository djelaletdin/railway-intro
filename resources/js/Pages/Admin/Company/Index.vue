<template>
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative flex min-h-screen flex-col items-center selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <h2 class="my-5 text-2xl font-bold">Companies</h2>

                <CompaniesTable :companies="companies" />
            </div>
        </div>
    </div>
</template>

<script setup>
import CompaniesTable from '@/Components/CompaniesTable.vue';

defineProps({
    companies: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <Link
        :href="route('company.show', { company: company.slug })"
        id="docs-card"
        class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-0 ring-railway transition hover:text-black/70 hover:ring-1 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
    >
        <div class="relative flex items-center gap-6 lg:items-end">
            <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">
                <div class="flex size-12 shrink-0 items-center justify-center rounded-full fill-railway sm:size-16">
                    <img :src="company.logo_url" class="max-h-32" alt="Company Logo"/>
                </div>

                <div class="pt-3 sm:pt-5 lg:pt-0">
                    <h2 class="text-xl font-semibold text-black dark:text-white">
                        {{ company.name }}
                    </h2>

                    <p class="mt-4 text-sm/relaxed">
                        {{ company.description }}
                    </p>
                </div>
            </div>

            <svg
                class="size-6 shrink-0 stroke-railway"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"
                />
            </svg>
        </div>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    company: {
        type: Object,
        required: true,
        validator: (company) => {
            return company.name && company.description && company.slug
        }
    }
})
</script>

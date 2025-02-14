<template>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div
            v-for="company in subCompanies"
            :key="company.id"
            class="relative bg-white rounded-lg ring-1 ring-gray-200 shadow-md overflow-visible mt-10" >
            <!-- Logo Section -->
            <div class="absolute -top-10 left-4 w-28 h-28 bg-white rounded-lg shadow-lg flex items-center justify-center p-4">
                <div v-if="company.logo_path" class="w-full h-full flex items-center justify-center">
                    <img
                        :src="company.logo_path"
                        :alt="company.name"
                        class="w-full h-full object-contain"
                    />
                </div>
                <div
                    v-else
                    class="w-full h-full bg-gray-100 flex items-center justify-center"
                >
          <span class="text-3xl font-semibold text-gray-500">
            {{ company.name.charAt(0).toUpperCase() }}
          </span>
                </div>
            </div>
            <!-- Card Content -->
            <div class="">
                <div class="p-6 pl-40">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ company.name }}</h2>
                    <p class="text-gray-600 text-sm">
                        {{ company.description || company.name }}
                    </p>
                </div>
                <!-- Card Footer -->
                <div class="border-t-4 border-railway p-6 w-full">
                    <a
                        v-if="company.website"
                        :href="company.website"
                        target="_blank"
                        class="text-gray-600 hover:underline text-sm inline-flex items-center"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span>{{ getDomain(company.website) }}</span>

                    </a>
                    <a
                        v-else-if="company.email"
                        :href="`mailto:${company.email}`"
                        class="text-gray-600 hover:underline text-sm inline-flex items-center"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>{{ company.email }}</span>

                    </a>

                    <a
                        v-else-if="company.phone"
                        class="text-gray-600 hover:underline text-sm inline-flex items-center"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>{{ company.phone }}</span>

                    </a>


                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    subCompanies: {
        type: Array,
        required: true,
        default: () => []
    }
})

const getDomain = (url) => {
    if (!url) return ''
    try {
        return url.replace(/^https?:\/\//, '').replace(/\/$/, '')
    } catch (e) {
        return url
    }
}
</script>

<style scoped>
.shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.absolute {
    border: 1px solid rgba(0, 0, 0, 0.05);
}
</style>

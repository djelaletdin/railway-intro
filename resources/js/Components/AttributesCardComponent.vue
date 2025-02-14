<template>
    <div class="flex flex-wrap justify-center gap-8">
        <div v-for="attribute in attributes"
             :key="attribute.id"
             class="bg-white rounded-lg shadow px-10 py-6 ring-gray-200 ring-1 hover:shadow-lg transition-shadow">
            <div class="text-gray-500 text-sm mb-1">{{ attribute.name }}</div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
            </svg>

            <!-- Number type attributes -->
            <div v-if="attribute.type === 'number'"
                 class="text-2xl font-bold text-gray-800">
                <template v-if="attribute.name === 'Annual Revenue'">
                    ${{ formatNumber(attribute.pivot.value) }}M
                </template>
                <template v-else>
                    {{ attribute.pivot.value }}
                </template>
            </div>

            <!-- Text type attributes -->
            <div v-else-if="attribute.type === 'text'"
                 class="flex flex-wrap gap-2">
        <span v-for="value in splitTextValue(attribute.pivot.value)"
              :key="value"
              class="px-2 py-1 bg-blue-100 text-blue-800 text-sm rounded-full">
          {{ value }}
        </span>
            </div>
            <div class="text-gray-400 text-xs mt-2">{{ attribute.description }}</div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    attributes: {
        type: Array,
        required: true,
        default: () => []
    }
})

const formatNumber = (value) => {
    return Number(value).toLocaleString('en-US')
}

const splitTextValue = (value) => {
    return value.split(',').map(item => item.trim())
}
</script>

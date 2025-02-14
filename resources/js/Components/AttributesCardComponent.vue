<template>
    <div class="flex flex-wrap justify-center gap-8">

        <div v-for="attribute in attributes"
             :key="attribute.id"
             class="bg-railway rounded-2xl shadow px-10 py-6 ring-gray-200 ring-1 hover:shadow-lg transition-shadow w-72">
            <div class="inline-flex" >
                <i :class="'text-white fa-2xl mt-4 ' + attribute.icon"></i>
            </div>


            <!-- Number type attributes -->
            <div v-if="attribute.type === 'number'"
                 class="text-2xl font-bold text-white mt-4">
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

<template>
    <div class="space-y-6 w-auto">
        <div class="bg-white rounded-lg ring-1 ring-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Company Attributes</h3>

            <!-- Attribute Rows -->
            <div class="space-y-4">
                <div v-for="(row, index) in attributeRows" :key="index" class="grid grid-cols-12 gap-4">
                    <!-- Attribute Select -->
                    <div class="col-span-4">
                        <select
                            v-model="row.selectedAttribute"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            @change="handleAttributeSelect(index)"
                        >
                            <option value="">Select Attribute</option>
                            <option
                                v-for="attr in availableAttributes(index)"
                                :key="attr.id"
                                :value="attr.id"
                            >
                                {{ attr.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Value Input -->
                    <div class="col-span-6">
                        <template v-if="row.selectedAttribute">
                            <!-- Number Input -->
                            <div v-if="getAttributeType(row.selectedAttribute) === 'number'" class="relative">
                                <input
                                    v-model="row.value"
                                    type="number"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :placeholder="getAttributePlaceholder(row.selectedAttribute)"
                                />
                                <span
                                    v-if="getAttributeName(row.selectedAttribute) === 'Annual Revenue'"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500"
                                >
                  M
                </span>
                            </div>

                            <!-- Text Input -->
                            <input
                                v-else
                                v-model="row.value"
                                type="text"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                :placeholder="getAttributePlaceholder(row.selectedAttribute)"
                            />
                        </template>
                    </div>

                    <!-- Remove Button -->
                    <div class="col-span-2 flex items-center">
                        <button
                            type="button"
                            @click="removeAttribute(index)"
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Remove
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add Attribute Button -->
            <button
                type="button"
                @click="addAttributeRow"
                class="mt-4 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Add Attribute
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'

const props = defineProps({
    attributes: {
        type: Array,
        required: true,
        default: () => [],
    },
})

const emit = defineEmits(['update:attributes'])

// Structure for attribute rows
const attributeRows = ref([
    { selectedAttribute: '', value: '' },
])

// Get available attributes (excluding already selected ones)
const availableAttributes = (currentIndex) => {
    const selectedIds = attributeRows.value
        .map((row, idx) => (idx !== currentIndex ? row.selectedAttribute : null))
        .filter((id) => id)

    return props.attributes.filter((attr) => !selectedIds.includes(attr.id))
}

const getAttributeType = (attributeId) => {
    const attribute = props.attributes.find((attr) => attr.id === attributeId)
    return attribute?.type
}

const getAttributeName = (attributeId) => {
    const attribute = props.attributes.find((attr) => attr.id === attributeId)
    return attribute?.name
}

const getAttributePlaceholder = (attributeId) => {
    const attribute = props.attributes.find((attr) => attr.id === attributeId)
    return attribute ? `Enter ${attribute.name.toLowerCase()}` : ''
}

// Actions
const addAttributeRow = () => {
    attributeRows.value.push({ selectedAttribute: '', value: '' })
}

const removeAttribute = (index) => {
    attributeRows.value.splice(index, 1)
    if (attributeRows.value.length === 0) {
        addAttributeRow()
    }
}

const handleAttributeSelect = (index) => {
    // Reset value when attribute changes
    attributeRows.value[index].value = ''
}

// Get formatted data for submission
const getFormattedData = () => {
    return attributeRows.value
        .filter((row) => row.selectedAttribute && row.value)
        .map((row) => ({
            attribute_id: row.selectedAttribute,
            value: row.value,
        }))
}

// Emit the attributes data whenever it changes
watch(
    attributeRows,
    () => {
        emit('update:attributes', getFormattedData())
    },
    { deep: true }
)
</script>

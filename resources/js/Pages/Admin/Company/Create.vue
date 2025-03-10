<template>
    <Head title="Täze bölüm" />

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <form @submit.prevent="submit" enctype="multipart/form-data">
            <!-- Company Details -->
            <div class="bg-white shadow sm:rounded-lg p-6 mb-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Company Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" v-model="form.name"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               required>
                        <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" v-model="form.email"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               required>
                        <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Website</label>
                        <input v-model="form.website"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <div v-if="form.errors.website" class="text-red-500 text-sm mt-1">{{ form.errors.website }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" v-model="form.phone"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <div v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}</div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea v-model="form.description" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea v-model="form.content" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        <div v-if="form.errors.content" class="text-red-500 text-sm mt-1">{{ form.errors.content }}</div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea v-model="form.address" rows="2"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        <div v-if="form.errors.address" class="text-red-500 text-sm mt-1">{{ form.errors.address }}</div>
                    </div>

                    <!-- Company Media Section -->
                    <div class="col-span-2 rounded-lg ring-1 ring-gray-200 p-8">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Company Logo</label>
                                <div class="mt-1 flex items-center space-x-4">
                                    <div v-if="logoPreview.company" class="relative w-24 h-24">
                                        <img :src="logoPreview.company" alt="Logo preview" class="object-cover rounded-lg">
                                        <button type="button" @click="removeLogo('company')"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input type="file" @change="handleLogoUpload($event, 'company')"
                                           class="mt-1 block w-full" accept="image/*">
                                </div>
                                <div v-if="form.errors.logo" class="text-red-500 text-sm mt-1">{{ form.errors.logo }}</div>
                                <div v-if="logoPreview.company" class="mt-2">
                                    <label class="block text-sm font-medium text-gray-700">Logo Description</label>
                                    <input type="text" v-model="form.logoDescriptions.company"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           placeholder="Enter logo description">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Company Media</label>
                                <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div v-for="(preview, index) in mediaPreview.company" :key="index" class="relative">
                                        <img :src="preview" alt="Media preview" class="w-full h-32 object-cover rounded-lg">
                                        <div class="mt-1">
                                            <input type="text" v-model="form.mediaDescriptions.company[index]"
                                                   class="w-full text-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                   placeholder="Media description">
                                        </div>
                                        <button type="button" @click="removeMedia('company', index)"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <label class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center cursor-pointer hover:border-gray-400">
                                        <input type="file" @change="handleMediaUpload($event, 'company')"
                                               class="hidden" accept="image/*" multiple>
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <CompanyAttributablesForm
                            :attributes="attributes"
                            @update:attributes="handleAttributesUpdate"
                        />
                    </div>

                </div>
            </div>

            <!-- Sub Companies Section -->
            <div class="bg-white shadow sm:rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Sub Companies</h2>
                    <button type="button" @click="addSubCompany"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        Add Sub Company
                    </button>
                </div>
                <div v-for="(subCompany, index) in form.subCompanies" :key="index" class="border rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-md font-medium">Sub Company {{ index + 1 }}</h3>
                        <button type="button" @click="removeSubCompany(index)"
                                class="text-red-600 hover:text-red-800">Remove</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" v-model="subCompany.name"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" v-model="subCompany.email"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Website</label>
                            <input type="url" v-model="subCompany.website"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" v-model="subCompany.phone"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea v-model="subCompany.description" rows="2"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea v-model="subCompany.address" rows="2"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                    </div>
                    <!-- Sub Company Media Section -->
                    <div class="col-span-2 space-y-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sub Company Logo</label>
                            <div class="mt-1 flex items-center space-x-4">
                                <div v-if="getSubCompanyLogoPreview(index)" class="relative w-24 h-24">
                                    <img :src="getSubCompanyLogoPreview(index)" alt="Logo preview" class="object-cover rounded-lg">
                                    <button type="button" @click="removeLogo('subCompany', index)"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <input type="file" @change="handleLogoUpload($event, 'subCompany', index)"
                                       class="mt-1 block w-full" accept="image/*">
                            </div>
                            <div v-if="getSubCompanyLogoPreview(index)" class="mt-2">
                                <label class="block text-sm font-medium text-gray-700">Logo Description</label>
                                <input type="text" v-model="form.logoDescriptions.subCompanies[index]"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="Enter logo description">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sub Company Media</label>
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div v-for="(preview, mediaIndex) in getSubCompanyMediaPreviews(index)" :key="mediaIndex" class="relative">
                                    <img :src="preview" alt="Media preview" class="w-full h-32 object-cover rounded-lg">
                                    <div class="mt-1">
                                        <input type="text" v-model="form.mediaDescriptions.subCompanies[index][mediaIndex]"
                                               class="w-full text-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               placeholder="Media description">
                                    </div>
                                    <button type="button" @click="removeMedia('subCompany', index, mediaIndex)"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <label class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center cursor-pointer hover:border-gray-400">
                                    <input type="file" @change="handleMediaUpload($event, 'subCompany', index)"
                                           class="hidden" accept="image/*" multiple>
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </label>
                            </div>
                        </div>

                        <!-- Branches Section with Media -->
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-md font-medium">Branches</h4>
                            <button type="button" @click="addBranch(index)"
                                    class="inline-flex items-center px-3 py-1 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Add Branch
                            </button>
                        </div>
                        <div v-for="(branch, branchIndex) in subCompany.branches" :key="branchIndex"
                             class="border rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-center mb-4">
                                <h5 class="text-sm font-medium">Branch {{ branchIndex + 1 }}</h5>
                                <button type="button" @click="removeBranch(index, branchIndex)"
                                        class="text-red-600 hover:text-red-800">Remove</button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" v-model="branch.name"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" v-model="branch.email"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Manager Name</label>
                                    <input type="text" v-model="branch.manager_name"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                                    <input type="text" v-model="branch.phone"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea v-model="branch.description" rows="2"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Address</label>
                                    <textarea v-model="branch.address" rows="2"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                              required></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Latitude</label>
                                    <input type="number" v-model="branch.latitude" step="any"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Longitude</label>
                                    <input type="number" v-model="branch.longitude" step="any"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                            <!-- Branch Media Section -->
                            <div class="col-span-2 space-y-4 mt-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Branch Logo</label>
                                    <div class="mt-1 flex items-center space-x-4">
                                        <div v-if="getBranchLogoPreview(index, branchIndex)" class="relative w-24 h-24">
                                            <img :src="getBranchLogoPreview(index, branchIndex)" alt="Logo preview" class="object-cover rounded-lg">
                                            <button type="button" @click="removeLogo('branch', index, branchIndex)"
                                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <input type="file" @change="handleLogoUpload($event, 'branch', index, branchIndex)"
                                               class="mt-1 block w-full" accept="image/*">
                                    </div>
                                    <div v-if="getBranchLogoPreview(index, branchIndex)" class="mt-2">
                                        <label class="block text-sm font-medium text-gray-700">Logo Description</label>
                                        <input type="text" v-model="form.logoDescriptions.branches[`${index}-${branchIndex}`]"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                               placeholder="Enter logo description">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Branch Media</label>
                                    <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                                        <div v-for="(preview, mediaIndex) in getBranchMediaPreviews(index, branchIndex)" :key="mediaIndex" class="relative">
                                            <img :src="preview" alt="Media preview" class="w-full h-32 object-cover rounded-lg">
                                            <div class="mt-1">
                                                <input type="text" v-model="form.mediaDescriptions.branches[`${index}-${branchIndex}`][mediaIndex]"
                                                       class="w-full text-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                       placeholder="Media description">
                                            </div>
                                            <button type="button" @click="removeMedia('branch', index, branchIndex, mediaIndex)"
                                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <label class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center cursor-pointer hover:border-gray-400">
                                            <input type="file" @change="handleMediaUpload($event, 'branch', index, branchIndex)"
                                                   class="hidden" accept="image/*" multiple>
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700"
                        :disabled="form.processing">
                    Create Company
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import {Head, useForm} from '@inertiajs/vue3'
import { ref } from 'vue'
import AttributesCardComponent from "@/Components/AttributesCardComponent.vue";
import CompanyAttributablesForm from "@/Components/CompanyAttributablesForm.vue";


const props = defineProps({
    attributes: {
        type: Array,
        required: true,
    },
})

// Form state
const form = useForm({
    name: '',
    description: '',
    content: '',
    website: '',
    email: '',
    phone: '',
    address: '',
    logo: null,
    media: [],
    subCompanies: [],
    attributes: [],
    // Add descriptions for media
    logoDescriptions: {
        company: '',
        subCompanies: {},
        branches: {}
    },
    mediaDescriptions: {
        company: [],
        subCompanies: {},
        branches: {}
    }
})

const handleAttributesUpdate = (attributes) => {
    form.attributes = attributes
}

// Preview state
const logoPreview = ref({
    company: null,
    subCompanies: {},
    branches: {}
})

const mediaPreview = ref({
    company: [],
    subCompanies: {},
    branches: {}
})

// Helper functions for handling media
const createPreviewURL = (file) => {
    return URL.createObjectURL(file)
}

// Logo handling
const handleLogoUpload = (event, type, subCompanyIndex = null, branchIndex = null) => {
    const file = event.target.files[0]
    if (!file) return

    if (type === 'company') {
        form.logo = file
        logoPreview.value.company = createPreviewURL(file)
        // Initialize description if not already set
        if (!form.logoDescriptions.company) {
            form.logoDescriptions.company = ''
        }
    } else if (type === 'subCompany') {
        form.subCompanies[subCompanyIndex].logo = file
        if (!logoPreview.value.subCompanies[subCompanyIndex]) {
            logoPreview.value.subCompanies[subCompanyIndex] = {}
        }
        logoPreview.value.subCompanies[subCompanyIndex] = createPreviewURL(file)
        // Initialize description if not already set
        if (!form.logoDescriptions.subCompanies[subCompanyIndex]) {
            form.logoDescriptions.subCompanies[subCompanyIndex] = ''
        }
    } else if (type === 'branch') {
        form.subCompanies[subCompanyIndex].branches[branchIndex].logo = file
        if (!logoPreview.value.branches[`${subCompanyIndex}-${branchIndex}`]) {
            logoPreview.value.branches[`${subCompanyIndex}-${branchIndex}`] = {}
        }
        logoPreview.value.branches[`${subCompanyIndex}-${branchIndex}`] = createPreviewURL(file)
        // Initialize description if not already set
        const branchKey = `${subCompanyIndex}-${branchIndex}`
        if (!form.logoDescriptions.branches[branchKey]) {
            form.logoDescriptions.branches[branchKey] = ''
        }
    }
}

const removeLogo = (type, subCompanyIndex = null, branchIndex = null) => {
    if (type === 'company') {
        form.logo = null
        logoPreview.value.company = null
        form.logoDescriptions.company = ''
    } else if (type === 'subCompany') {
        form.subCompanies[subCompanyIndex].logo = null
        logoPreview.value.subCompanies[subCompanyIndex] = null
        form.logoDescriptions.subCompanies[subCompanyIndex] = ''
    } else if (type === 'branch') {
        form.subCompanies[subCompanyIndex].branches[branchIndex].logo = null
        logoPreview.value.branches[`${subCompanyIndex}-${branchIndex}`] = null
        const branchKey = `${subCompanyIndex}-${branchIndex}`
        form.logoDescriptions.branches[branchKey] = ''
    }
}

// Media handling
const handleMediaUpload = (event, type, subCompanyIndex = null, branchIndex = null) => {
    const files = Array.from(event.target.files)
    if (!files.length) return

    if (type === 'company') {
        const startIndex = form.media.length
        form.media = [...(form.media || []), ...files]
        mediaPreview.value.company = [
            ...(mediaPreview.value.company || []),
            ...files.map(createPreviewURL)
        ]
        // Initialize descriptions for new media
        for (let i = 0; i < files.length; i++) {
            form.mediaDescriptions.company[startIndex + i] = ''
        }
    } else if (type === 'subCompany') {
        if (!form.subCompanies[subCompanyIndex].media) {
            form.subCompanies[subCompanyIndex].media = []
        }
        const startIndex = form.subCompanies[subCompanyIndex].media.length
        form.subCompanies[subCompanyIndex].media = [
            ...form.subCompanies[subCompanyIndex].media,
            ...files
        ]

        if (!mediaPreview.value.subCompanies[subCompanyIndex]) {
            mediaPreview.value.subCompanies[subCompanyIndex] = []
        }
        mediaPreview.value.subCompanies[subCompanyIndex] = [
            ...(mediaPreview.value.subCompanies[subCompanyIndex] || []),
            ...files.map(createPreviewURL)
        ]

        // Initialize descriptions for new media
        if (!form.mediaDescriptions.subCompanies[subCompanyIndex]) {
            form.mediaDescriptions.subCompanies[subCompanyIndex] = []
        }
        for (let i = 0; i < files.length; i++) {
            form.mediaDescriptions.subCompanies[subCompanyIndex][startIndex + i] = ''
        }
    } else if (type === 'branch') {
        if (!form.subCompanies[subCompanyIndex].branches[branchIndex].media) {
            form.subCompanies[subCompanyIndex].branches[branchIndex].media = []
        }
        const startIndex = form.subCompanies[subCompanyIndex].branches[branchIndex].media.length
        form.subCompanies[subCompanyIndex].branches[branchIndex].media = [
            ...form.subCompanies[subCompanyIndex].branches[branchIndex].media,
            ...files
        ]

        const branchKey = `${subCompanyIndex}-${branchIndex}`
        if (!mediaPreview.value.branches[branchKey]) {
            mediaPreview.value.branches[branchKey] = []
        }
        mediaPreview.value.branches[branchKey] = [
            ...(mediaPreview.value.branches[branchKey] || []),
            ...files.map(createPreviewURL)
        ]

        // Initialize descriptions for new media
        if (!form.mediaDescriptions.branches[branchKey]) {
            form.mediaDescriptions.branches[branchKey] = []
        }
        for (let i = 0; i < files.length; i++) {
            form.mediaDescriptions.branches[branchKey][startIndex + i] = ''
        }
    }
}

const removeMedia = (type, subCompanyIndex = null, branchIndex = null, mediaIndex = null) => {
    if (type === 'company') {
        // Remove the file from the form and preview
        form.media.splice(mediaIndex, 1)
        mediaPreview.value.company.splice(mediaIndex, 1)
        form.mediaDescriptions.company.splice(mediaIndex, 1)
    } else if (type === 'subCompany') {
        // For sub-company, remove media at specified index
        form.subCompanies[subCompanyIndex].media.splice(mediaIndex, 1)
        mediaPreview.value.subCompanies[subCompanyIndex].splice(mediaIndex, 1)
        form.mediaDescriptions.subCompanies[subCompanyIndex].splice(mediaIndex, 1)
    } else if (type === 'branch') {
        // For branch, remove media at specified index
        form.subCompanies[subCompanyIndex].branches[branchIndex].media.splice(mediaIndex, 1)
        const branchKey = `${subCompanyIndex}-${branchIndex}`
        mediaPreview.value.branches[branchKey].splice(mediaIndex, 1)
        form.mediaDescriptions.branches[branchKey].splice(mediaIndex, 1)
    }
}

// Helper functions for sub-companies
const addSubCompany = () => {
    form.subCompanies.push({
        name: '',
        description: '',
        website: '',
        email: '',
        phone: '',
        address: '',
        logo: null,
        media: [],
        branches: []
    })

    // Initialize media descriptions storage
    const index = form.subCompanies.length - 1
    if (!form.mediaDescriptions.subCompanies[index]) {
        form.mediaDescriptions.subCompanies[index] = []
    }
}

const removeSubCompany = (index) => {
    form.subCompanies.splice(index, 1)

    // Clean up previews and descriptions
    if (logoPreview.value.subCompanies[index]) {
        delete logoPreview.value.subCompanies[index]
    }
    if (mediaPreview.value.subCompanies[index]) {
        delete mediaPreview.value.subCompanies[index]
    }
    if (form.logoDescriptions.subCompanies[index]) {
        delete form.logoDescriptions.subCompanies[index]
    }
    if (form.mediaDescriptions.subCompanies[index]) {
        delete form.mediaDescriptions.subCompanies[index]
    }

    // Clean up branch data
    Object.keys(logoPreview.value.branches || {}).forEach(key => {
        if (key.startsWith(`${index}-`)) {
            delete logoPreview.value.branches[key]
        }
    })
    Object.keys(mediaPreview.value.branches || {}).forEach(key => {
        if (key.startsWith(`${index}-`)) {
            delete mediaPreview.value.branches[key]
        }
    })
    Object.keys(form.logoDescriptions.branches || {}).forEach(key => {
        if (key.startsWith(`${index}-`)) {
            delete form.logoDescriptions.branches[key]
        }
    })
    Object.keys(form.mediaDescriptions.branches || {}).forEach(key => {
        if (key.startsWith(`${index}-`)) {
            delete form.mediaDescriptions.branches[key]
        }
    })
}

// Helper functions for branches
const addBranch = (subCompanyIndex) => {
    if (!form.subCompanies[subCompanyIndex].branches) {
        form.subCompanies[subCompanyIndex].branches = []
    }

    form.subCompanies[subCompanyIndex].branches.push({
        name: '',
        description: '',
        email: '',
        manager_name: '',
        phone: '',
        address: '',
        latitude: null,
        longitude: null,
        logo: null,
        media: []
    })

    // Initialize storage for media descriptions
    const branchIndex = form.subCompanies[subCompanyIndex].branches.length - 1
    const branchKey = `${subCompanyIndex}-${branchIndex}`
    if (!form.mediaDescriptions.branches[branchKey]) {
        form.mediaDescriptions.branches[branchKey] = []
    }
}

const removeBranch = (subCompanyIndex, branchIndex) => {
    form.subCompanies[subCompanyIndex].branches.splice(branchIndex, 1)

    // Clean up previews and descriptions
    const branchKey = `${subCompanyIndex}-${branchIndex}`
    if (logoPreview.value.branches[branchKey]) {
        delete logoPreview.value.branches[branchKey]
    }
    if (mediaPreview.value.branches[branchKey]) {
        delete mediaPreview.value.branches[branchKey]
    }
    if (form.logoDescriptions.branches[branchKey]) {
        delete form.logoDescriptions.branches[branchKey]
    }
    if (form.mediaDescriptions.branches[branchKey]) {
        delete form.mediaDescriptions.branches[branchKey]
    }
}

// Helper methods for accessing nested logo and media previews
const getSubCompanyLogoPreview = (index) => {
    return logoPreview.value.subCompanies[index] || null
}

const getSubCompanyMediaPreviews = (index) => {
    return mediaPreview.value.subCompanies[index] || []
}

const getBranchLogoPreview = (subCompanyIndex, branchIndex) => {
    const key = `${subCompanyIndex}-${branchIndex}`
    return logoPreview.value.branches[key] || null
}

const getBranchMediaPreviews = (subCompanyIndex, branchIndex) => {
    const key = `${subCompanyIndex}-${branchIndex}`
    return mediaPreview.value.branches[key] || []
}

// Submit form
const submit = () => {
    form.post(route('admin.companies.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            // Reset form and previews after successful submission
            form.reset()
            logoPreview.value = {
                company: null,
                subCompanies: {},
                branches: {}
            }
            mediaPreview.value = {
                company: [],
                subCompanies: {},
                branches: {}
            }
        }
    })
}
</script>

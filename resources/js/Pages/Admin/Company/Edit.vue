<template>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <form @submit.prevent="submit" enctype="multipart/form-data">
            <!-- Company Details -->
            <div class="bg-white shadow sm:rounded-lg p-6 mb-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Company Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Company Name</label>
                        <input type="text" v-model="form.name" class="mt-1 block w-full rounded-md border-gray-300">
                        <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Website</label>
                        <input v-model="form.website" class="mt-1 block w-full rounded-md border-gray-300">
                        <div v-if="form.errors.website" class="text-red-500 text-sm mt-1">{{
                                form.errors.website
                            }}
                        </div>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" v-model="form.email" class="mt-1 block w-full rounded-md border-gray-300">
                        <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="tel" v-model="form.phone" class="mt-1 block w-full rounded-md border-gray-300">
                        <div v-if="form.errors.phone" class="text-red-500 text-sm mt-1">{{ form.errors.phone }}</div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea v-model="form.address" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                        <div v-if="form.errors.address" class="text-red-500 text-sm mt-1">{{
                                form.errors.address
                            }}
                        </div>
                    </div>

                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea v-model="form.description" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                        <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{
                                form.errors.description
                            }}
                        </div>
                    </div>

                    <!-- Company Media Section -->
                    <div class="col-span-2">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Company Logo</label>
                                <div class="mt-1 flex items-center space-x-4">
                                    <div v-if="logoPreview.company || mediaUrls.company.logo"
                                         class="relative w-24 h-24">
                                        <img :src="logoPreview.company || mediaUrls.company.logo" alt="Logo preview"
                                             class="object-cover rounded-lg">
                                        <button type="button" @click="removeLogo('company')"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <input type="file" @change="handleLogoUpload($event, 'company')"
                                           class="mt-1 block w-full" accept="image/*">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Company Media</label>
                                <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div v-for="(preview, index) in mediaPreview.company" :key="'new-' + index"
                                         class="relative">
                                        <img :src="preview" alt="Media preview"
                                             class="w-full h-32 object-cover rounded-lg">
                                        <button type="button" @click="removeMedia('company', index)"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div v-for="(url, index) in mediaUrls.company.media" :key="'existing-' + index"
                                         class="relative">
                                        <img :src="url" alt="Media preview" class="w-full h-32 object-cover rounded-lg">
                                        <button type="button" @click="removeExistingMedia('company', index)"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <label
                                        class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center cursor-pointer hover:border-gray-400">
                                        <input type="file" @change="handleMediaUpload($event, 'company')"
                                               class="hidden" accept="image/*" multiple>
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub Companies Section -->
            <div class="bg-white shadow sm:rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-medium text-gray-900">Sub Companies</h2>
                    <button type="button" @click="addSubCompany"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Add Sub Company
                    </button>
                </div>

                <div v-for="(subCompany, index) in form.subCompanies" :key="subCompany.id || index"
                     class="border rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-md font-medium text-gray-900">Sub Company #{{ index + 1 }}</h3>
                        <button type="button" @click="removeSubCompany(index)"
                                class="text-red-500 hover:text-red-700">Remove
                        </button>
                    </div>

                    <!-- Sub Company Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Same fields as company, but for sub-company -->
                        <!-- Include media handling similar to company section -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-gray-700">Company Name</label>
                            <input type="text" v-model="subCompany.name"
                                   class="mt-1 block w-full rounded-md border-gray-300">
                            <!--                            <div v-if="subCompany.errors.name" class="text-red-500 text-sm mt-1">{{ subCompany.errors.name }}</div>-->
                        </div>
                    </div>

                    <!-- Branches Section -->
                    <div class="mt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-md font-medium text-gray-900">Branches</h4>
                            <button type="button" @click="addBranch(index)"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Add Branch
                            </button>
                        </div>

                        <div v-for="(branch, branchIndex) in subCompany.branches" :key="branch.id || branchIndex"
                             class="border rounded-lg p-4 mb-4">
                            <!-- Branch Fields -->
                            <!-- Include media handling similar to company section -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700"
                        :disabled="form.processing">
                    Update Company
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3'
import {ref} from 'vue'

const props = defineProps({
    company: {
        type: Object,
        required: true
    },
    mediaUrls: {
        type: Object,
        required: true
    }
})

// Initialize form with existing data
const form = useForm({
    _method: 'POST',
    name: props.company.name,
    description: props.company.description,
    website: props.company.website,
    email: props.company.email,
    phone: props.company.phone,
    address: props.company.address,
    logo: null,
    media: [],
    deletedMedia: [],
    subCompanies: props.company.sub_companies.map(subCompany => ({
        id: subCompany.id,
        name: subCompany.name,
        description: subCompany.description,
        website: subCompany.website,
        email: subCompany.email,
        phone: subCompany.phone,
        address: subCompany.address,
        logo: null,
        media: [],
        deletedMedia: [],
        branches: subCompany.branches.map(branch => ({
            id: branch.id,
            name: branch.name,
            description: branch.description,
            manager_name: branch.manager_name,
            email: branch.email,
            phone: branch.phone,
            address: branch.address,
            latitude: branch.latitude,
            longitude: branch.longitude,
            logo: null,
            media: [],
            deletedMedia: []
        }))
    }))
})

const submit = () => {
    form.post(route('admin.companies.update', {company: props.company.id}), {
        onSuccess: () => {
            console.log("i am submitted");
            // Clear all preview URLs to prevent memory leaks
            Object.values(mediaPreview.value.company).forEach(URL.revokeObjectURL)
            Object.values(mediaPreview.value.subCompanies).forEach(previews =>
                previews.forEach(URL.revokeObjectURL)
            )
            Object.values(mediaPreview.value.branches).forEach(previews =>
                previews.forEach(URL.revokeObjectURL)
            )
            if (logoPreview.value.company) URL.revokeObjectURL(logoPreview.value.company)
            Object.values(logoPreview.value.subCompanies).forEach(preview => {
                if (preview) URL.revokeObjectURL(preview)
            })
            Object.values(logoPreview.value.branches).forEach(preview => {
                if (preview) URL.revokeObjectURL(preview)
            })
        }
    })
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

// Helper function to create preview URLs
const createPreviewURL = (file) => URL.createObjectURL(file)

// Handle logo upload
const handleLogoUpload = (event, type, subCompanyIndex = null, branchIndex = null) => {
    const file = event.target.files[0]
    if (!file) return

    if (type === 'company') {
        form.logo = file
        logoPreview.value.company = createPreviewURL(file)
    } else if (type === 'subCompany') {
        form.subCompanies[subCompanyIndex].logo = file
        logoPreview.value.subCompanies[subCompanyIndex] = createPreviewURL(file)
    } else if (type === 'branch') {
        form.subCompanies[subCompanyIndex].branches[branchIndex].logo = file
        const branchKey = `${subCompanyIndex}-${branchIndex}`
        logoPreview.value.branches[branchKey] = createPreviewURL(file)
    }
}

// Remove logo
const removeLogo = (type, subCompanyIndex = null, branchIndex = null) => {
    if (type === 'company') {
        form.logo = null
        if (logoPreview.value.company) URL.revokeObjectURL(logoPreview.value.company)
        logoPreview.value.company = null
    } else if (type === 'subCompany') {
        form.subCompanies[subCompanyIndex].logo = null
        if (logoPreview.value.subCompanies[subCompanyIndex]) {
            URL.revokeObjectURL(logoPreview.value.subCompanies[subCompanyIndex])
        }
        logoPreview.value.subCompanies[subCompanyIndex] = null
    } else if (type === 'branch') {
        const branchKey = `${subCompanyIndex}-${branchIndex}`
        form.subCompanies[subCompanyIndex].branches[branchIndex].logo = null
        if (logoPreview.value.branches[branchKey]) {
            URL.revokeObjectURL(logoPreview.value.branches[branchKey])
        }
        logoPreview.value.branches[branchKey] = null
    }
}

// Add a new sub-company
const addSubCompany = () => {
    form.subCompanies.push({
        id: null,
        name: '',
        description: '',
        website: '',
        email: '',
        phone: '',
        address: '',
        logo: null,
        media: [],
        deletedMedia: [],
        branches: []
    })
}

// Remove a sub-company
const removeSubCompany = (index) => {
    form.subCompanies.splice(index, 1)
    delete logoPreview.value.subCompanies[index]
    delete mediaPreview.value.subCompanies[index]
}

// Add a new branch to a sub-company
const addBranch = (subCompanyIndex) => {
    form.subCompanies[subCompanyIndex].branches.push({
        id: null,
        name: '',
        description: '',
        manager_name: '',
        email: '',
        phone: '',
        address: '',
        latitude: null,
        longitude: null,
        logo: null,
        media: [],
        deletedMedia: []
    })
}

// Remove a branch from a sub-company
const removeBranch = (subCompanyIndex, branchIndex) => {
    form.subCompanies[subCompanyIndex].branches.splice(branchIndex, 1)
    const branchKey = `${subCompanyIndex}-${branchIndex}`
    delete logoPreview.value.branches[branchKey]
    delete mediaPreview.value.branches[branchKey]
}
</script>

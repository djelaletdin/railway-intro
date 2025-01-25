<template>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">ID</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Slug</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="company in companies.data" :key="company.id">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900">{{ company.id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">{{ company.name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ company.slug }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                  <span :class="[
                    company.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800',
                    'inline-flex rounded-full px-2 text-xs font-semibold leading-5'
                  ]">
                    {{ company.is_active ? 'Active' : 'Inactive' }}
                  </span>
                            </td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <div class="flex justify-end gap-2">
                                    <Link :href="`/admin/companies/${company.id}/edit`"
                                          class="inline-flex items-center px-3 py-1 text-sm font-medium text-blue-600 hover:text-blue-800">
                                        Edit
                                    </Link>
                                    <button @click="deleteCompany(company.id)"
                                            class="inline-flex items-center px-3 py-1 text-sm font-medium text-red-600 hover:text-red-800">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                    <div class="flex flex-1 justify-between sm:hidden">
                        <Link v-if="companies.prev_page_url"
                              :href="companies.prev_page_url"
                              class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Previous
                        </Link>
                        <Link v-if="companies.next_page_url"
                              :href="companies.next_page_url"
                              class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Next
                        </Link>
                    </div>
                    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing
                                <span class="font-medium">{{ companies.from }}</span>
                                to
                                <span class="font-medium">{{ companies.to }}</span>
                                of
                                <span class="font-medium">{{ companies.total }}</span>
                                results
                            </p>
                        </div>
                        <div>
                            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                <template v-for="(link, i) in companies.links" :key="i">
                                    <Link v-if="link.url"
                                          :href="link.url"
                                          :class="[
                          link.active ? 'bg-blue-50 text-blue-600' : 'text-gray-500 hover:bg-gray-50',
                          'relative inline-flex items-center px-4 py-2 text-sm font-medium border'
                        ]"
                                          v-html="link.label" />
                                    <span v-else
                                          :class="[
                          'relative inline-flex items-center px-4 py-2 text-sm font-medium border text-gray-300 cursor-not-allowed',
                        ]"
                                          v-html="link.label" />
                                </template>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    companies: {
        type: Object,
        required: true
    }
});

const deleteCompany = (id) => {
    if (confirm('Are you sure you want to delete this company?')) {
        router.delete(`/admin/companies/${id}`, {
            preserveScroll: true,
            preserveState: true,
        });
    }
};
</script>

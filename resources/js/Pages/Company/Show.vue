<script setup>
import { Head } from "@inertiajs/vue3";
import AttributesCardComponent from "@/Components/AttributesCardComponent.vue";
import CompanyCard from "@/Components/CompanyCard.vue";
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    company: Object,
    logo: String,
    subCompanies: Object,
    media: Object
});

// References to the column elements
const leftColumn = ref(null);
const rightColumn = ref(null);
const leftWrapper = ref(null);
const rightWrapper = ref(null);

// Function to check if columns should be sticky
const handleScroll = () => {
    if (!leftColumn.value || !rightColumn.value || !leftWrapper.value || !rightWrapper.value) return;

    const scrollTop = window.scrollY || document.documentElement.scrollTop;

    // Get the size
    const leftContentHeight = leftWrapper.value.offsetHeight;
    const rightContentHeight = rightWrapper.value.offsetHeight;

    const leftContentWidth = leftWrapper.value.offsetWidth;
    const rightContentWidth = rightWrapper.value.offsetWidth;


    // get viewport height
    const windowHeight = window.innerHeight;

    // Get the position of each column relative to the top of the document
    const leftColumnTop = getOffsetTop(leftColumn.value);
    const rightColumnTop = getOffsetTop(rightColumn.value);

    // Calculate how far we've scrolled into each column
    const leftScrolledAmount = scrollTop - leftColumnTop;
    const rightScrolledAmount = scrollTop - rightColumnTop;

    // Reset any previous positioning to ensure accurate measurements
    leftWrapper.value.style.position = 'relative';
    rightWrapper.value.style.position = 'relative';

    // Apply stickiness based on whether we've scrolled past the content height
    if (leftContentHeight < rightContentHeight) {
        // Left column is shorter
        if (leftContentHeight > windowHeight && leftScrolledAmount + windowHeight >= leftContentHeight) {
            leftWrapper.value.style.position = 'fixed';
            leftWrapper.value.style.top = `-${leftContentHeight - windowHeight + 32}px`; // 32px is 2rem
            leftWrapper.value.style.width = `${leftContentWidth}px`; // Preserve width
        } else {
            leftWrapper.value.style.position = 'relative';
            leftWrapper.value.style.top = 'auto';
            leftWrapper.value.style.width = 'auto';
        }

        rightWrapper.value.style.position = 'relative';
        rightWrapper.value.style.top = 'auto';
        rightWrapper.value.style.width = 'auto';
    } else {
        // Right column is shorter or equal
        if (rightContentHeight > windowHeight && rightScrolledAmount + windowHeight >= rightContentHeight) {
            rightWrapper.value.style.position = 'fixed';
            rightWrapper.value.style.top = `-${rightContentHeight - windowHeight + 32}px`; // 32px is 2rem
            rightWrapper.value.style.width = `${rightContentWidth}px`; // Preserve width
        } else {
            rightWrapper.value.style.position = 'relative';
            rightWrapper.value.style.top = 'auto';
            rightWrapper.value.style.width = 'auto';
        }

        leftWrapper.value.style.position = 'relative';
        leftWrapper.value.style.top = 'auto';
        leftWrapper.value.style.width = 'auto';
    }
};

// Helper function to get the offset top of an element relative to the document
const getOffsetTop = (element) => {
    let offsetTop = 0;
    while(element) {
        offsetTop += element.offsetTop;
        element = element.offsetParent;
    }
    return offsetTop;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    // Initial check after DOM has fully rendered
    setTimeout(handleScroll, 100);

    // Also check on window resize as content heights might change
    window.addEventListener('resize', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    window.removeEventListener('resize', handleScroll);
});
</script>

<template>
    <Head :title="company?.name || 'Company'"/>
    <div class="text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative flex flex-col items-center justify-center">
            <div class="relative w-full px-4 md:px-8 lg:px-40 mt-10">
                <!-- Header with Logo and Contact Info -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-8 md:mb-16">
                    <img :src="logo" class="h-20 md:h-32 mb-4 md:mb-0" alt="Company Logo"/>

                    <div class="flex flex-col gap-3 text-sm">
                        <div v-if="company.email" class="flex items-center gap-2">
                            <i class="fas fa-envelope text-gray-500"></i>
                            <span>{{ company.email }}</span>
                        </div>

                        <div v-if="company.phone" class="flex items-center gap-2">
                            <i class="fas fa-phone text-gray-500"></i>
                            <span>{{ company.phone }}</span>
                        </div>

                        <div v-if="company.address" class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-gray-500"></i>
                            <span class="max-w-72">{{ company.address }}</span>
                        </div>
                    </div>
                </div>
                <div class="w-full mb-12">
                    <img class="w-full" :src="media[0]" alt="">
                </div>
                <!-- Two-column layout with dynamic stickiness -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 relative mt-4">
                    <!-- Main Content Column (Left) -->
                    <div ref="leftColumn" class="order-2 md:order-1 h-min">
                        <div ref="leftWrapper" class="h-min" style="top: 2rem;">
                            <span class="font-black text-3xl md:text-4xl text-black mb-4 md:mb-8 block">
                                {{ company.name }}
                            </span>
                            <span class="font-black text-xl md:text-2xl text-gray-400 mb-4 md:mb-8 block">
                                {{ company.description }}
                            </span>
                            <p class="text-gray-700 text-lg md:text-xl whitespace-pre-line first-letter:text-2xl md:first-letter:text-3xl first-letter:font-bold first-line:tracking-wide mb-6 md:mb-8">
                                {{ company.content }}
                            </p>


                            <div class="mb-12">
                                <AttributesCardComponent :attributes="company.attributes"/>
                            </div>
                            <div class="mb-12">
                                <h2 class="font-black text-2xl text-black mb-8 block">Şahamçalar</h2>
                                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-2 gap-8">
                                    <CompanyCard
                                        v-for="company in subCompanies"
                                        :key="company.id"
                                        :company="company"
                                    />
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Photos Column (Right) -->
                    <div ref="rightColumn" class="order-1 md:order-2 ">
                        <div ref="rightWrapper" class="h-min" style="top: 2rem;">
                            <div class="grid grid-cols-1 gap-4 md:gap-6">
                                <div v-for="(image, index) in media" :key="index" class="aspect-w-16 aspect-h-9 mb-4 md:mb-6">
                                    <img :src="image" class="w-full h-full object-cover rounded" alt="Company Image" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

.aspect-w-16 {
    position: relative;
    padding-bottom: calc(9 / 16 * 100%);
}
.aspect-w-16 > img {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    object-fit: cover;
    object-position: center;
}
</style>

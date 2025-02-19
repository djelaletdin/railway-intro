<script setup>
import { Head } from "@inertiajs/vue3";
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Navigation } from 'vue3-carousel';
import AttributesCardComponent from "@/Components/AttributesCardComponent.vue";
import SubCompaniesComponent from "@/Components/SubCompaniesComponent.vue";
import CompanyCard from "@/Components/CompanyCard.vue";

const props = defineProps({
    company: Object,
    logo: String,
    subCompanies: Object,
    media: Object
});

const carouselConfig = {
    itemsToShow: 1.1,
    wrapAround: true,
    gap: 10,
    // autoplay: 5000,
}
</script>

<template>
{{ logo }}
    <Head :title="company?.name || 'Company'"/>
    <div class=" text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative flex flex-col items-center justify-center">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl mt-10">
                <div class="flex justify-between items-center">
                    <img :src="logo" class="h-32" alt="Company Logo"/>

                    <div class="hidden md:flex flex-col gap-3 text-sm">
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
                            <span class=" max-w-72">{{ company.address }}</span>
                        </div>
                    </div>
                </div>
                <div v-if="!(media.length<=0)" class="carousel-wrapper my-5">
                    <Carousel v-bind="carouselConfig">
                        <Slide v-for="slide in media" :key="slide">
                            <div class="carousel__item relative w-full h-full overflow-hidden">
                                <img
                                    :src="slide"
                                    class="slide-image w-full h-full object-cover"
                                />
                            </div>
                        </Slide>

                        <template #addons>
                            <Navigation class="navigation" />
<!--                            <Pagination />-->
                        </template>
                    </Carousel>

                </div>
                <div class="my-16">
                    <span class="font-black text-4xl text-black mb-8 block">
                        {{ company.name }}
                    </span>
                    <span class="font-black text-2xl text-gray-400 mb-8 block">
                        {{ company.description }}
                    </span>
                    <p class="text-gray-700 text-xl whitespace-pre-line first-letter:text-3xl first-letter:font-bold first-line:tracking-wide mb-8">
                        {{ company.content }}
                    </p>

                    <div class="mb-8">
                        <AttributesCardComponent :attributes="company.attributes"/>
                    </div>

                    <div class="mb-8">
                        <h2 class="font-black text-2xl text-black mb-8 block">Şahamçalar</h2>
<!--                       <SubCompaniesComponent :sub-companies="subCompanies" />-->
                        <div class="grid gap-6 lg:grid-cols-3 lg:gap-8">
                            <CompanyCard
                                v-for="company in subCompanies"
                                :key="company.id"
                                :company="company"
                            />
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</template>

<style scoped>
.carousel__item {
    //height: 90vh;
    width: 100%;
    position: relative;
}

.slide-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>

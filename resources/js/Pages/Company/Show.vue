<script setup>
import { Head } from "@inertiajs/vue3";
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Navigation } from 'vue3-carousel';
import AttributesCardComponent from "@/Components/AttributesCardComponent.vue";
import SubCompaniesComponent from "@/Components/SubCompaniesComponent.vue";

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

    <Head :title="company?.name || 'Company'"/>
    <div class=" text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative flex flex-col items-center justify-center">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl mt-10">
                <div class="flex gap-4 items-center ">
                    <img
                        :src="logo"
                        class="h-32"
                    />
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
                       <SubCompaniesComponent :sub-companies="subCompanies" />


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

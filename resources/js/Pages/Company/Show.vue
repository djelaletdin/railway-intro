<script setup>
import { Head } from "@inertiajs/vue3";
import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Navigation } from 'vue3-carousel';

const props = defineProps({
    company: Object,
    subCompanies: Object,
    media: Object
});

const carouselConfig = {
    itemsToShow: 1.1,
    wrapAround: true,
    gap: 10,
}
</script>

<template>

    <Head :title="company?.name || 'Company'"/>
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20]">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <div v-if="!(media.length<=0)" class="carousel-wrapper">
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
                {{ company.description }}
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

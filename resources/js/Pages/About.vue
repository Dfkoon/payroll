<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import MobileNav from '@/Components/MobileNav.vue';
import Footer from '@/Components/Footer.vue';
import RotatingText from '@/Components/RotatingText.vue';

const { props: pageProps } = usePage();
const t = (key) => pageProps.translations.messages[key] || key;
const locale = computed(() => pageProps.locale);
</script>

<template>
    <Head :title="t('about_us') + ' - ' + t('brand_name')" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-[#f8fafc] text-slate-900 font-sans selection:bg-blue-600 selection:text-white pb-20 mesh-gradient">
        <header class="pt-48 pb-32 bg-gray-50 relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
                <span class="inline-block px-5 py-2 bg-blue-600/10 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-widest mb-8 reveal-up">{{ t('about_us_badge') }}</span>
                <h1 class="text-6xl md:text-9xl font-black text-slate-900 leading-[0.85] mb-12 tracking-tighter reveal-up flex flex-wrap justify-center items-center gap-x-4">
                    <span>{{ locale === 'ar' ? 'عن' : 'About' }}</span>
                    <RotatingText
                        :texts="locale === 'ar' ? ['سلامين', 'رحلتنا', 'قيمنا', 'عالمنا'] : ['Salamein', 'Journey', 'Values', 'World']"
                        mainClassName="px-4 py-2 bg-slate-900 text-white rounded-3xl"
                        staggerFrom="last"
                        :initial="{ y: '100%', opacity: 0 }"
                        :animate="{ y: 0, opacity: 1 }"
                        :exit="{ y: '-120%', opacity: 0 }"
                        :staggerDuration="0.025"
                        splitLevelClassName="overflow-hidden pb-1"
                        :transition="{ type: 'spring', damping: 30, stiffness: 400 }"
                        :rotationInterval="3000"
                    />
                </h1>
                <p class="text-2xl text-gray-500 max-w-3xl mx-auto leading-relaxed">
                    {{ t('about_description') }}
                </p>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-white to-transparent"></div>
        </header>

        <section class="py-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div :class="['grid lg:grid-cols-2 gap-24 items-center', locale === 'ar' ? '' : 'lg:grid-cols-2']">
                <div class="relative">
                    <div class="aspect-square bg-blue-600 rounded-[5rem] overflow-hidden shadow-2xl skew-y-3">
                        <img src="https://images.unsplash.com/photo-1516483642774-72383167a8a2?q=80&w=800" class="w-full h-full object-cover -skew-y-3 scale-110">
                    </div>
                    <div :class="['absolute -bottom-10 w-64 h-64 bg-white rounded-[3rem] p-10 shadow-2xl flex flex-col justify-center border border-gray-100', locale === 'ar' ? '-right-10' : '-left-10']">
                        <span class="text-4xl font-black text-blue-600 mb-2">+10</span>
                        <span class="text-sm font-bold text-gray-400 uppercase">{{ t('years_experience') }}</span>
                    </div>
                </div>
                <div :class="[locale === 'ar' ? 'text-right' : 'text-left']">
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-10 leading-tight">{{ t('extraordinary_journey') }}</h2>
                    <div class="space-y-8 text-xl text-gray-500 leading-loose">
                        <p>{{ t('about_p1') }}</p>
                        <p>{{ t('about_p2') }}</p>
                    </div>
                    <div class="mt-16 grid grid-cols-2 gap-8">
                        <div class="p-8 bg-gray-50 rounded-3xl border border-gray-100">
                            <span class="block text-3xl font-black text-gray-900 mb-2">5,000+</span>
                            <span class="text-sm font-bold text-gray-400">{{ t('happy_travelers') }}</span>
                        </div>
                        <div class="p-8 bg-gray-50 rounded-3xl border border-gray-100">
                            <span class="block text-3xl font-black text-gray-900 mb-2">50+</span>
                            <span class="text-sm font-bold text-gray-400">{{ t('unique_destinations') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap');
.font-sans {
    font-family: 'Cairo', sans-serif !important;
}
</style>

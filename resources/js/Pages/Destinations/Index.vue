<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import MobileNav from '@/Components/MobileNav.vue';

const { props: pageProps } = usePage();
const t = (key) => pageProps.translations.messages[key] || key;
const locale = computed(() => pageProps.locale);

const props = defineProps({
    destinations: Array,
});
</script>

<template>
    <Head :title="t('destinations_title') + ' - ' + t('brand_name')" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-[#fcfdfe] text-gray-900 font-sans selection:bg-blue-500 selection:text-white pb-20 md:pb-0">
        <!-- Luxury Navigation -->
        <nav class="fixed w-full z-50 top-0 bg-white/80 backdrop-blur-xl border-b border-gray-100 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-24">
                    <Link :href="route('home')" class="flex items-center gap-4 group">
                        <div class="shrink-0 flex items-center justify-center p-3 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 shadow-xl shadow-blue-500/20 group-hover:scale-105 transition-transform">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="text-3xl font-black tracking-tighter text-gray-900 leading-none">{{ t('brand_short') }} <span class="text-blue-600">Travel</span></span>
                    </Link>
                    <div :class="['hidden lg:flex items-center gap-12 font-bold text-gray-500', locale === 'ar' ? 'flex-row' : 'flex-row-reverse']">
                        <Link :href="route('contact')" class="hover:text-blue-600 transition-colors">{{ t('contact') }}</Link>
                        <Link :href="route('blog.index')" class="hover:text-blue-600 transition-colors">{{ t('blog') }}</Link>
                        <Link :href="route('destinations.index')" class="text-blue-600">{{ t('destinations') }}</Link>
                        <Link :href="route('tours.index')" class="hover:text-blue-600 transition-colors">{{ t('tours') }}</Link>
                    </div>
                </div>
            </div>
        </nav>

        <header class="pt-48 pb-24 relative overflow-hidden bg-white">
            <div class="absolute top-0 right-0 w-1/3 h-full bg-blue-50/50 skew-x-12 translate-x-20"></div>
            <div :class="['max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10', locale === 'ar' ? 'text-right' : 'text-left']">
                <span class="inline-block px-5 py-2 bg-blue-100 text-blue-700 rounded-full text-xs font-black uppercase tracking-widest mb-6">{{ t('destinations_subtitle') }}</span>
                <h1 class="text-6xl md:text-8xl font-black text-gray-900 mb-8 leading-[1.1] tracking-tighter">
                    {{ t('discover_wonders') }}
                </h1>
                <p class="text-2xl text-gray-400 max-w-2xl leading-relaxed font-medium">
                    {{ t('destinations_description') }}
                </p>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                <Link v-for="dest in destinations" :key="dest.id"
                      :href="route('destinations.show', dest.slug)"
                      class="group relative h-[32rem] rounded-[3.5rem] overflow-hidden shadow-2xl hover:shadow-blue-500/20 transition-all duration-700 cursor-pointer border-8 border-white">
                    <img :src="dest.image_path" :alt="dest.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 brightness-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/10 to-transparent opacity-80 group-hover:opacity-90 transition-opacity"></div>
                    
                    <div :class="['absolute bottom-12 right-12 left-12', locale === 'ar' ? 'text-right' : 'text-left']">
                        <h3 class="text-4xl font-black text-white mb-4 tracking-tight drop-shadow-lg">{{ dest.name }}</h3>
                        <p class="text-white/70 font-medium mb-8 line-clamp-2">{{ dest.description }}</p>
                        <div class="flex items-center justify-between pointer-events-none">
                            <span class="flex items-center gap-2 text-blue-400 font-black text-sm uppercase">
                                <svg :class="['w-5 h-5', locale === 'ar' ? '' : 'rotate-180']" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                {{ t('explore_tours') }}
                            </span>
                            <div class="w-14 h-14 rounded-full bg-white/10 backdrop-blur-xl flex items-center justify-center text-white border border-white/20 group-hover:bg-blue-600 group-hover:border-blue-500 transition-all duration-500">
                                <svg :class="['w-7 h-7', locale === 'ar' ? 'rotate-180' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
        </main>

        <section class="py-32 mt-20 bg-gray-900 rounded-[5rem] mx-4 overflow-hidden relative">
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <div class="absolute top-20 right-20 w-80 h-80 bg-blue-600 rounded-full blur-[100px]"></div>
                <div class="absolute bottom-20 left-20 w-80 h-80 bg-indigo-600 rounded-full blur-[100px]"></div>
            </div>
            <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
                <h2 class="text-4xl md:text-6xl font-black text-white mb-8 leading-tight tracking-tight">{{ t('not_found_perfect_destination') }}</h2>
                <p class="text-xl text-gray-400 mb-12 font-medium">{{ t('not_found_perfect_destination_desc') }}</p>
                <Link :href="route('contact')" class="px-12 py-6 bg-blue-600 text-white rounded-full font-black text-2xl hover:bg-indigo-600 hover:scale-105 shadow-2xl shadow-blue-500/30 transition-all inline-block">{{ t('contact_advisor') }}</Link>
            </div>
        </section>

        <MobileNav />
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap');
.font-sans {
    font-family: 'Cairo', sans-serif !important;
}
</style>

<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import Footer from '@/Components/Footer.vue';

const { props: pageProps } = usePage();
const locale = computed(() => pageProps.locale);
const t = (key) => pageProps.translations.messages[key] || key;
</script>

<template>
    <Head :title="t('terms') + ' - Salamein Travel'" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-[#f8fafc] text-gray-900 font-sans selection:bg-blue-600 selection:text-white pb-20">
        <!-- Luxury Navigation -->
        <nav class="fixed w-full z-50 top-0 bg-white/80 backdrop-blur-xl border-b border-slate-100 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="flex justify-between items-center h-24">
                    <Link :href="route('home')" class="flex items-center gap-4 transition-transform hover:scale-105">
                        <div class="shrink-0 flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 shadow-xl shadow-blue-500/20">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="text-3xl font-black tracking-tighter text-slate-900 leading-none">سلامين <span class="text-blue-600">Travel</span></span>
                    </Link>
                </div>
            </div>
        </nav>

        <main class="pt-48 pb-32">
            <div class="max-w-4xl mx-auto px-6 lg:px-8">
                <div :class="['bg-white rounded-[3rem] p-12 md:p-20 shadow-xl shadow-blue-500/5 border border-gray-50', locale === 'ar' ? 'text-right' : 'text-left']">
                    <h1 class="text-4xl font-black text-gray-900 mb-12 tracking-tight">{{ t('terms') }} ⚖️</h1>
                    
                    <div class="prose prose-xl prose-blue max-w-none text-gray-600 leading-loose space-y-12">
                        <section>
                            <h2 class="text-2xl font-black text-blue-600 mb-4">1. {{ t('booking_policy') }}</h2>
                            <p class="font-bold text-slate-400">{{ t('booking_policy_desc') }}</p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-black text-blue-600 mb-4">2. {{ t('cancellation_policy') }}</h2>
                            <p class="font-bold text-slate-400">{{ t('cancellation_policy_desc') }}</p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-black text-blue-600 mb-4">3. {{ t('hotel_categories') }}</h2>
                            <p class="font-bold text-slate-400">{{ t('hotel_categories_desc') }}</p>
                        </section>

                        <section>
                            <h2 class="text-2xl font-black text-blue-600 mb-4">4. {{ t('privacy_payment') }}</h2>
                            <p class="font-bold text-slate-400">{{ t('privacy_payment_desc') }}</p>
                        </section>
                    </div>

                    <div class="mt-20 pt-10 border-t border-gray-100 text-center">
                        <Link :href="route('home')" class="text-blue-600 font-black hover:underline">{{ t('back_to_home') }}</Link>
                    </div>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap');
.font-sans {
    font-family: 'Cairo', sans-serif !important;
}
</style>

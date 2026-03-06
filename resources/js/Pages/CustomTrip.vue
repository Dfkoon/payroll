<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Footer from '@/Components/Footer.vue';
import MobileNav from '@/Components/MobileNav.vue';
import RotatingText from '@/Components/RotatingText.vue';

const { props: pageProps } = usePage();
const locale = computed(() => pageProps.locale);
const t = (key) => pageProps.translations.messages[key] || key;

const form = useForm({
    name: '',
    email: '',
    destination: '',
    travelers: 1,
    budget: 'luxury',
    message: '',
});

const submit = () => {
    // Mock submission
    alert(t('request_success'));
    form.reset();
};
</script>

<template>
    <Head :title="t('custom_trip_title') + ' - ' + t('brand_name')" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-[#f8fafc] text-slate-900 font-sans selection:bg-blue-600 selection:text-white pb-20 mesh-gradient">
        <!-- Luxury Navigation -->
        <nav class="fixed w-full z-50 top-0 bg-white/80 backdrop-blur-xl border-b border-slate-100 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="flex justify-between items-center h-24">
                    <Link :href="route('home')" class="flex items-center gap-4 transition-transform hover:scale-105">
                        <div class="shrink-0 flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 shadow-xl shadow-blue-500/20">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="text-3xl font-black tracking-tighter text-slate-900 leading-none">{{ t('brand_short') }} <span class="text-blue-600">Travel</span></span>
                    </Link>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 flex flex-col lg:flex-row gap-20 pt-48 items-start mb-32">
            <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
                <span class="inline-block px-5 py-2 bg-blue-600/10 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-widest mb-8 reveal-up">{{ t('custom_trip_badge') }}</span>
                <h1 class="text-6xl md:text-9xl font-black text-slate-900 leading-[0.85] mb-12 tracking-tighter reveal-up flex flex-wrap justify-center items-center gap-x-4">
                    <span>{{ locale === 'ar' ? 'صمم' : 'Design' }}</span>
                    <RotatingText
                        :texts="locale === 'ar' ? ['رحلتك', 'مغامرتك', 'حلمك'] : ['Your Trip', 'Your Story', 'Your Dream']"
                        mainClassName="px-4 py-2 bg-slate-900 text-white rounded-3xl"
                        staggerFrom="last"
                        :initial="{ y: '100%', opacity: 0 }"
                        :animate="{ y: 0, opacity: 1 }"
                        :exit="{ y: '-120%', opacity: 0 }"
                        :staggerDuration="0.025"
                        splitLevelClassName="overflow-hidden pb-1"
                        :transition="{ type: 'spring', damping: 30, stiffness: 400 }"
                        :rotationInterval="2500"
                    />
                </h1>
                <p class="text-2xl text-gray-500 leading-relaxed font-bold">{{ t('custom_trip_description') }}</p>
                
                <div class="mt-20 space-y-12">
                    <div :class="['flex gap-8 items-center', locale === 'ar' ? 'flex-row-reverse' : 'flex-row']">
                        <div class="w-20 h-20 rounded-3xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 shadow-xl shadow-blue-500/5">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div :class="[locale === 'ar' ? 'text-right' : 'text-left']">
                            <h4 class="text-2xl font-black text-gray-900 mb-2">{{ t('price_transparency') }}</h4>
                            <p class="text-gray-400 font-bold">{{ t('price_transparency_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/2 w-full">
                <form @submit.prevent="submit" class="bg-white rounded-[4rem] p-12 shadow-2xl shadow-blue-500/10 border border-gray-50">
                    <div class="grid md:grid-cols-2 gap-8 mb-10">
                        <div :class="[locale === 'ar' ? 'text-right' : 'text-left']">
                            <label class="block mb-3 font-black text-gray-900">{{ t('full_name') }}</label>
                            <input v-model="form.name" type="text" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-blue-600 outline-none font-bold" :placeholder="t('name_placeholder')">
                        </div>
                        <div :class="[locale === 'ar' ? 'text-right' : 'text-left']">
                            <label class="block mb-3 font-black text-gray-900">{{ t('email_address') }}</label>
                            <input v-model="form.email" type="email" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-blue-600 outline-none font-bold" placeholder="name@company.com">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8 mb-10">
                        <div :class="[locale === 'ar' ? 'text-right' : 'text-left']">
                            <label class="block mb-3 font-black text-gray-900">{{ t('fav_destination') }}</label>
                            <select v-model="form.destination" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-blue-600 outline-none font-black text-gray-400">
                                <option value="">{{ t('all') }}</option>
                                <option value="petra">{{ t('petra') }}</option>
                                <option value="wadi-rum">{{ t('wadi_rum') }}</option>
                                <option value="dead-sea">{{ t('dead_sea') }}</option>
                            </select>
                        </div>
                        <div :class="[locale === 'ar' ? 'text-right' : 'text-left']">
                            <label class="block mb-3 font-black text-gray-900">{{ t('travelers_count') }}</label>
                            <input v-model="form.travelers" type="number" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-blue-600 outline-none font-bold">
                        </div>
                    </div>

                    <div :class="['mb-10', locale === 'ar' ? 'text-right' : 'text-left']">
                        <label class="block mb-3 font-black text-gray-900">{{ t('additional_details') }}</label>
                        <textarea v-model="form.message" class="w-full bg-gray-50 border-none rounded-[2rem] p-6 focus:ring-2 focus:ring-blue-600 outline-none font-bold h-40" :placeholder="t('additional_details_placeholder')"></textarea>
                    </div>

                    <button type="submit" class="w-full py-6 bg-blue-600 text-white rounded-full font-black text-2xl hover:bg-gray-900 shadow-xl transition-all duration-500">{{ t('send_request') }} ✈️</button>
                </form>
            </div>
        </div>

        <Footer />
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap');
.font-sans {
    font-family: 'Cairo', sans-serif !important;
}
</style>

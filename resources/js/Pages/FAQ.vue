<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import RotatingText from '@/Components/RotatingText.vue';

const { props: pageProps } = usePage();
const t = (key) => pageProps.translations.messages[key] || key;
const locale = computed(() => pageProps.locale);

const faqs = computed(() => [
    { q: t('faq_q1'), a: t('faq_a1') },
    { q: t('faq_q2'), a: t('faq_a2') },
    { q: t('faq_q3'), a: t('faq_a3') },
    { q: t('faq_q4'), a: t('faq_a4') },
]);

const openIndex = ref(0);
</script>

<template>
    <Head :title="t('faq_title') + ' - ' + t('brand_name')" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-[#f8fafc] text-slate-900 font-sans selection:bg-blue-600 selection:text-white pb-20 mesh-gradient">
        <header class="pt-48 pb-24 bg-white text-center">
            <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
                <span class="inline-block px-5 py-2 bg-blue-600/10 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-widest mb-8 reveal-up">{{ t('faq_badge') }}</span>
                <h1 class="text-6xl md:text-9xl font-black text-slate-900 leading-[0.85] mb-12 tracking-tighter reveal-up flex flex-wrap justify-center items-center gap-x-4">
                    <span>{{ locale === 'ar' ? 'الأسئلة' : 'Common' }}</span>
                    <RotatingText
                        :texts="locale === 'ar' ? ['الشائعة', 'المتكررة', 'الهامة'] : ['Questions', 'FAQs', 'Concerns']"
                        mainClassName="px-4 py-2 bg-blue-600 text-white rounded-3xl"
                        staggerFrom="last"
                        :initial="{ y: '100%', opacity: 0 }"
                        :animate="{ y: 0, opacity: 1 }"
                        :exit="{ y: '-120%', opacity: 0 }"
                        :staggerDuration="0.025"
                        splitLevelClassName="overflow-hidden pb-1"
                        :transition="{ type: 'spring', damping: 30, stiffness: 400 }"
                        :rotationInterval="2800"
                    />
                </h1>
                <p class="text-xl text-gray-500 font-medium">{{ t('faq_subtitle') }}</p>
            </div>
        </header>

        <main class="max-w-4xl mx-auto px-4 py-20">
            <div class="space-y-6">
                <div v-for="(faq, index) in faqs" :key="index" 
                     class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden transition-all duration-500"
                     :class="openIndex === index ? 'shadow-xl shadow-blue-500/10' : ''">
                    <button @click="openIndex = openIndex === index ? -1 : index" 
                            :class="['w-full p-10 flex justify-between items-center text-2xl font-black', locale === 'ar' ? 'text-right' : 'text-left']">
                        {{ faq.q }}
                        <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center transition-transform duration-500"
                             :class="openIndex === index ? 'rotate-180 bg-blue-600 text-white' : ''">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </button>
                    <div v-show="openIndex === index" :class="['px-10 pb-10 text-xl text-gray-500 leading-relaxed font-bold', locale === 'ar' ? 'text-right' : 'text-left']">
                        {{ faq.a }}
                    </div>
                </div>
            </div>

            <div class="mt-32 p-16 bg-gray-900 rounded-[4rem] text-white text-center relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-3xl font-black mb-6">{{ t('didnt_find_answer') }}</h3>
                    <p class="text-lg text-gray-400 mb-10 font-bold">{{ t('support_24_7') }}</p>
                    <Link :href="route('contact')" class="px-10 py-5 bg-blue-600 rounded-full font-black text-xl hover:bg-white hover:text-blue-600 transition-all shadow-2xl shadow-blue-500/20">{{ t('talk_to_us_now') }}</Link>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap');
.font-sans {
    font-family: 'Cairo', sans-serif !important;
}
</style>

<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import MobileNav from '@/Components/MobileNav.vue';

const { props } = usePage();
const booking = computed(() => props.booking);
const locale = computed(() => props.locale);
const t = (key) => props.translations.messages[key] || key;

onMounted(() => {
    // Reveal animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
});
</script>

<template>
    <Head :title="t('booking_success') + ' - ' + t('brand_short')" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-slate-50 selection:bg-blue-600 selection:text-white pb-32">
        <main class="max-w-4xl mx-auto px-6 pt-32 text-center">
            <!-- Success Icon -->
            <div class="reveal-up mb-12">
                <div class="w-32 h-32 rounded-full bg-green-500/10 flex items-center justify-center mx-auto text-green-500 shadow-2xl shadow-green-500/20 border-4 border-white">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-5xl md:text-7xl font-black text-slate-900 mb-6 tracking-tighter reveal-up">
                {{ t('booking_confirmed_msg') }}
            </h1>
            <p class="text-xl text-slate-400 font-medium max-w-2xl mx-auto mb-16 reveal-up">
                {{ t('booking_success_desc') }}
            </p>

            <!-- Booking Summary Card -->
            <div class="glass-card p-10 rounded-[3rem] border-white/60 shadow-2xl text-start reveal-up mb-16">
                <div class="flex items-center gap-8 mb-10 pb-10 border-b border-slate-100/50">
                    <img :src="booking.tour.image_path" class="w-24 h-24 rounded-2xl object-cover shadow-lg">
                    <div>
                        <span class="text-blue-600 font-black text-xs uppercase tracking-widest">{{ booking.tour.category.name }}</span>
                        <h3 class="text-2xl font-black text-slate-900 mt-1">{{ booking.tour.title }}</h3>
                        <div class="flex items-center gap-4 text-slate-400 font-bold text-sm mt-2">
                            <span>{{ booking.booking_date }}</span>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span>{{ booking.hotel_category }} {{ t('stars') }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-10">
                    <div class="space-y-6">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ t('booking_id') }}</span>
                            <span class="text-xl font-black text-slate-900 mt-1">#SLM-{{ booking.id }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ t('payment_status') }}</span>
                            <span class="text-lg font-black text-green-600 mt-1 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-green-600"></span>
                                {{ t('paid_in_full') }}
                            </span>
                        </div>
                    </div>
                    <div class="bg-blue-600/5 p-6 rounded-3xl border border-blue-100/50">
                        <span class="text-[10px] font-black text-blue-600 uppercase tracking-widest">{{ t('total_amount') }}</span>
                        <div class="text-4xl font-black text-blue-600 mt-2">${{ booking.total_amount }}</div>
                    </div>
                </div>
            </div>

            <!-- CTAs -->
            <div class="flex flex-col md:flex-row items-center justify-center gap-6 reveal-up">
                <Link :href="route('dashboard')" class="px-12 py-5 rounded-2xl bg-slate-900 text-white font-black text-sm uppercase tracking-widest hover:bg-blue-600 transition-all shadow-xl shadow-slate-900/20 w-full md:w-auto text-center">
                    {{ t('go_to_dashboard') }}
                </Link>
                <Link :href="route('home')" class="px-12 py-5 rounded-2xl bg-white border border-slate-200 text-slate-900 font-black text-sm uppercase tracking-widest hover:bg-slate-50 transition-all w-full md:w-auto text-center">
                    {{ t('back_to_home') }}
                </Link>
            </div>
        </main>

        <MobileNav />
    </div>
</template>

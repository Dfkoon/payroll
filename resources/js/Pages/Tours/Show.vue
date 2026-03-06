<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.css';
import { Arabic } from 'flatpickr/dist/l10n/ar.js';
import MobileNav from '@/Components/MobileNav.vue';

const { props: pageProps } = usePage();
const locale = computed(() => pageProps.locale);
const t = (key) => pageProps.translations.messages[key] || key;

const props = defineProps({
    tour: Object,
});

const activeDay = ref(0);
const selectedDate = ref('');
const datePicker = ref(null);

onMounted(() => {
    flatpickr(datePicker.value, {
        locale: locale.value === 'ar' ? Arabic : null,
        minDate: 'today',
        dateFormat: 'Y-m-d',
        onChange: (selectedDates, dateStr) => {
            selectedDate.value = dateStr;
        }
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
});

const goBack = () => {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        router.visit(route('home'));
    }
};
</script>

<template>
    <Head :title="tour.title + ' - ' + t('brand_name')" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-[#f8fafc] text-slate-900 font-sans selection:bg-blue-600 selection:text-white pb-20 md:pb-0">
        
        <!-- Premium Navbar -->
        <nav class="glass-nav h-20 flex items-center">
            <div class="max-w-7xl mx-auto px-6 w-full flex justify-between items-center">
                <Link :href="route('home')" class="flex items-center gap-3">
                    <div class="shrink-0 w-10 h-10 rounded-xl premium-gradient flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <span class="text-xl font-black text-slate-900 leading-none">{{ t('brand_short') }} <span class="text-blue-600">Travel</span></span>
                </Link>

                <div class="flex items-center gap-6">
                    <button @click="goBack" class="flex items-center gap-2 px-6 py-2 bg-slate-950 text-white rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-xl shadow-slate-900/10">
                        <svg :class="['w-4 h-4', locale === 'ar' ? 'rotate-180' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        {{ t('back') }}
                    </button>
                    <Link :href="route('language.switch', locale === 'ar' ? 'en' : 'ar')" 
                          class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-[10px] font-black hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                        {{ locale === 'ar' ? 'EN' : 'AR' }}
                    </Link>
                </div>
            </div>
        </nav>

        <main>
            <!-- Hero Header -->
            <div class="relative h-[70vh] overflow-hidden">
                <img :src="tour.image_path" :alt="tour.title" class="w-full h-full object-cover brightness-75">
                <div class="absolute inset-0 bg-gradient-to-t from-[#f8fafc] via-transparent to-black/20"></div>
                
                <div class="absolute bottom-0 left-0 right-0 max-w-7xl mx-auto px-6 pb-24 reveal-up">
                    <div class="flex flex-wrap items-center gap-4 mb-8">
                        <span class="px-6 py-2 bg-blue-600 text-white rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl">
                            {{ tour.category.name }}
                        </span>
                        <span v-if="tour.destination?.is_international" class="px-6 py-2 bg-slate-950 text-white rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl">
                            {{ t('international') }}
                        </span>
                        <span class="px-6 py-2 bg-emerald-500 text-white rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-2xl flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                            {{ t('all_inclusive') }}
                        </span>
                    </div>
                    <h1 class="text-5xl md:text-8xl font-black text-slate-900 tracking-tighter leading-[0.9] mb-10 max-w-4xl">{{ tour.title }}</h1>
                    <div class="flex flex-wrap items-center gap-12 text-slate-600 font-black text-sm uppercase">
                        <span class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-white shadow-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            </div>
                            {{ tour.location }}
                        </span>
                        <span class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-white shadow-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            {{ tour.days }} {{ t('days') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="max-w-7xl mx-auto px-6 py-24">
                <div class="grid lg:grid-cols-3 gap-16">
                    <div class="lg:col-span-2 space-y-24">
                        <section class="reveal-up">
                            <div class="inline-flex items-center gap-4 text-blue-600 mb-8">
                                <div class="w-12 h-1.5 bg-blue-600 rounded-full"></div>
                                <h2 class="text-4xl font-black text-slate-900 uppercase tracking-tighter">{{ t('overview') }}</h2>
                            </div>
                            <p class="text-xl text-slate-500 leading-relaxed font-bold">
                                {{ tour.description }}
                            </p>
                            
                            <!-- Inclusion Feature List -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-16">
                                <div class="p-8 bg-white border border-slate-100 rounded-[3rem] shadow-sm flex items-start gap-6 group hover:border-blue-500 transition-all">
                                    <div class="w-16 h-16 rounded-[1.5rem] bg-blue-50 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 16v2m3-6v6m3-8v8m9-1.114V5a2 2 0 00-2-2H4a2 2 0 00-2 2v6.435M13.963 14.212A4.498 4.498 0 0112 15c-1.026 0-1.959-.344-2.697-.923m.007-7.355A4.498 4.498 0 0112 6c1.026 0 1.959.344 2.697.923" /></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-black text-slate-950 mb-2">{{ t('includes_meals') }}</h4>
                                        <p class="text-sm text-slate-400 font-bold">{{ t('meals_desc') }}</p>
                                    </div>
                                </div>
                                <div class="p-8 bg-white border border-slate-100 rounded-[3rem] shadow-sm flex items-start gap-6 group hover:border-blue-500 transition-all">
                                    <div class="w-16 h-16 rounded-[1.5rem] bg-blue-50 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-black text-slate-950 mb-2">{{ t('includes_accommodation') }}</h4>
                                        <p class="text-sm text-slate-400 font-bold">{{ t('hotel_desc') }}</p>
                                    </div>
                                </div>
                                <div class="md:col-span-2 p-8 bg-blue-600 rounded-[3rem] shadow-xl flex items-center gap-8 group">
                                    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center shrink-0 text-white">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div class="text-white">
                                        <h4 class="text-2xl font-black mb-1">{{ t('everything_included') }}</h4>
                                        <p class="text-white/70 font-bold text-sm">{{ t('all_inclusive_full_desc') }}</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Itinerary -->
                        <section v-if="tour.itinerary" class="reveal-up">
                            <div class="inline-flex items-center gap-4 text-blue-600 mb-12">
                                <div class="w-12 h-1.5 bg-blue-600 rounded-full"></div>
                                <h2 class="text-4xl font-black text-slate-900 uppercase tracking-tighter">{{ t('itinerary') }}</h2>
                            </div>
                            <div class="space-y-8">
                                <div v-for="(day, index) in tour.itinerary" :key="index" 
                                     class="group relative pl-12 md:pl-0">
                                    <!-- Timeline Line -->
                                    <div class="absolute left-6 md:left-1/2 top-0 bottom-0 w-1 bg-slate-100 -translate-x-1/2 hidden md:block"></div>
                                    
                                    <div :class="['flex flex-col md:flex-row items-center gap-12', index % 2 === 0 ? 'md:flex-row-reverse' : '']">
                                        <!-- Content Card -->
                                        <div class="flex-1 w-full scale-100 hover:scale-105 transition-transform duration-500">
                                            <div class="glass-card !p-12 rounded-[4rem] hover:!bg-white/90 shadow-xl border border-white">
                                                <div class="flex items-center gap-6 mb-8 md:hidden">
                                                     <div class="w-16 h-16 rounded-2xl premium-gradient flex flex-col items-center justify-center text-white font-black">
                                                        <span class="text-[8px] uppercase">{{ t('day') }}</span>
                                                        <span class="text-2xl">{{ day.day || (index + 1) }}</span>
                                                    </div>
                                                </div>
                                                <h3 class="text-3xl font-black text-slate-900 mb-6 tracking-tighter">{{ day.title }}</h3>
                                                <p class="text-lg text-slate-500 leading-relaxed font-bold">{{ day.description }}</p>
                                            </div>
                                        </div>

                                        <!-- Center Node -->
                                        <div class="relative z-10 w-24 h-24 rounded-[2rem] premium-gradient hidden md:flex flex-col items-center justify-center text-white shadow-2xl shadow-blue-500/20 border-8 border-[#f8fafc]">
                                            <span class="text-[10px] font-black uppercase tracking-widest">{{ t('day') }}</span>
                                            <span class="text-4xl font-black">{{ day.day || (index + 1) }}</span>
                                        </div>

                                        <!-- Spacer for alignment -->
                                        <div class="flex-1 hidden md:block"></div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Map -->
                        <section v-if="tour.map_lat" class="reveal-up">
                            <div class="h-[30rem] rounded-[5rem] overflow-hidden border-[16px] border-white shadow-2xl">
                                <iframe width="100%" height="100%" frameborder="0" scrolling="no" :src="'https://maps.google.com/maps?q=' + tour.map_lat + ',' + tour.map_lng + '&hl=' + locale + '&z=14&output=embed'"></iframe>
                            </div>
                        </section>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-32 space-y-8">
                            <div class="glass-card !p-12 rounded-[4.5rem] shadow-2xl shadow-blue-500/10 bg-white border border-white relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-40 h-40 bg-blue-500/5 rounded-full -mr-20 -mt-20"></div>
                                
                                <div class="relative z-10">
                                    <div class="mb-12">
                                        <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest block mb-4">{{ t('starting_from') }}</span>
                                        <div class="flex items-end gap-3">
                                            <span class="text-7xl font-black text-blue-600 tracking-tighter leading-none">${{ Math.floor(tour.price) }}</span>
                                            <div class="flex flex-col mb-1">
                                                <span class="text-slate-950 font-black text-xs uppercase leading-none">{{ t('per_person') }}</span>
                                                <span class="text-emerald-500 font-bold text-[9px] uppercase tracking-tighter">{{ t('all_inclusive') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-6 mb-12">
                                        <div class="flex items-center justify-between p-6 bg-slate-50 rounded-3xl group hover:bg-white hover:shadow-xl transition-all cursor-default">
                                            <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">{{ t('type') }}</span>
                                            <span class="text-slate-950 font-black text-sm uppercase">{{ tour.type === 'private' ? t('private') : tour.type === 'group' ? t('group') : t('package') }}</span>
                                        </div>
                                        <div class="flex items-center justify-between p-6 bg-slate-50 rounded-3xl group hover:bg-white hover:shadow-xl transition-all cursor-default">
                                            <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">{{ t('duration') }}</span>
                                            <span class="text-slate-950 font-black text-sm uppercase">{{ tour.days }} {{ t('days') }}</span>
                                        </div>
                                    </div>

                                    <div class="mb-12">
                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 px-2">{{ t('select_date') }}</label>
                                        <div class="relative group">
                                            <input ref="datePicker" type="text" 
                                                   class="w-full p-6 bg-slate-100 border-none rounded-3xl font-black text-slate-900 focus:bg-white focus:ring-[6px] focus:ring-blue-500/10 transition-all placeholder:text-slate-400 shadow-inner" 
                                                   :placeholder="t('select_date')">
                                            <svg class="absolute right-6 top-6 w-6 h-6 text-slate-300 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    </div>

                                    <Link :href="route('bookings.store', tour.id)" method="post" as="button" class="btn-premium w-full !py-8 !text-2xl uppercase tracking-widest !rounded-[2.5rem] shadow-blue-500/40">
                                        {{ t('book_now') }}
                                    </Link>
                                    
                                    <div class="mt-12 flex items-center justify-center gap-6 p-8 bg-blue-50 rounded-[2.5rem] border-2 border-dashed border-blue-200">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" class="h-6 opacity-30 grayscale hover:grayscale-0 transition-all cursor-none" alt="Stripe">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-blue-900 uppercase tracking-[0.2em]">{{ t('booking_secured') }}</span>
                                            <span class="text-[8px] text-blue-600 font-bold uppercase tracking-tighter">PCI-DSS Compliant</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Trust Badges -->
                            <div class="flex justify-center gap-6 opacity-40">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-4" alt="Visa">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-4" alt="Mastercard">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <MobileNav />
    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap');

.font-sans {
    font-family: 'Cairo', sans-serif !important;
}

.premium-gradient {
    background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
}

.glass-nav {
    @apply fixed top-0 w-full bg-white/70 backdrop-blur-2xl border-b border-white/20 shadow-sm z-[100];
}

.glass-card {
    @apply bg-white/80 backdrop-blur-xl border border-white/40 shadow-xl p-6;
}

.btn-premium {
    @apply px-10 py-5 bg-blue-600 text-white font-black rounded-full shadow-2xl shadow-blue-500/20 hover:scale-105 active:scale-95 transition-all duration-500;
}

.reveal-up {
    opacity: 0;
    transform: translateY(50px);
    transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
}

.reveal-up.active {
    opacity: 1;
    transform: translateY(0);
}
</style>

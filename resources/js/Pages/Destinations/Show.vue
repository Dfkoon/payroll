<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import WhatsAppButton from '@/Components/WhatsAppButton.vue';
import { computed, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import MobileNav from '@/Components/MobileNav.vue';

const { props: pageProps } = usePage();
const locale = computed(() => pageProps.locale);
const t = (key) => pageProps.translations.messages[key] || key;

const props = defineProps({
    destination: Object,
});

onMounted(() => {
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

const getTourFallbackImage = (tour) => {
    const categoryId = tour.category_id || 0;
    const fallbacks = {
        1: 'https://images.unsplash.com/photo-1547234935-80c7145ec969?q=80&w=1200', // Adventure (Wadi Rum)
        2: 'https://images.unsplash.com/photo-1580983220430-80415303534b?q=80&w=1200', // Cultural (Petra)
        3: 'https://images.unsplash.com/photo-1540202404-b911c43d8b5a?q=80&w=1200', // Luxury (Dead Sea)
        4: 'https://images.unsplash.com/photo-1572252009572-132952b8dce4?q=80&w=1200', // Religious (Baptism Site)
    };
    return fallbacks[categoryId] || 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=1200'; // General Travel
};
</script>

<template>
    <Head :title="destination.name + ' - ' + t('brand_name')" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-slate-50 text-slate-900 font-sans selection:bg-blue-600 selection:text-white pb-32 md:pb-0 mesh-gradient">
        <!-- Luxury Hero Section -->
        <header class="relative h-[70vh] md:h-[85vh] overflow-hidden">
            <img :src="destination.image_path" class="w-full h-full object-cover scale-110 active:scale-100 transition-transform duration-[20s] brightness-[0.6] contrast-[1.1] animate-slow-zoom">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-50 via-slate-900/10 to-black/40"></div>
            
            <nav class="absolute top-0 w-full z-50 p-8 flex justify-between items-center px-8 md:px-12">
                <button @click="goBack" class="flex items-center gap-3 px-8 py-3 bg-white text-slate-900 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all shadow-2xl">
                    <svg :class="['w-5 h-5', locale === 'ar' ? 'rotate-180' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    {{ t('back') }}
                </button>

                <Link :href="route('home')" class="flex items-center gap-3">
                    <div class="shrink-0 w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center shadow-2xl shadow-black/20">
                         <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </Link>
            </nav>

            <div :class="['absolute bottom-16 md:bottom-32 left-0 right-0 max-w-7xl mx-auto px-6 md:px-12 reveal-up', locale === 'ar' ? 'text-right' : 'text-left']">
                <div :class="['flex flex-col gap-4 md:gap-8', locale === 'ar' ? 'items-start' : 'items-start']">
                    <span class="inline-block px-4 py-1.5 md:px-6 md:py-3 glass-card !bg-blue-600 !text-white !border-none rounded-full text-[8px] md:text-[10px] font-black uppercase tracking-[0.3em] shadow-2xl">
                        {{ t('explore_destination_badge') }}
                    </span>
                    <h1 class="text-5xl sm:text-7xl md:text-9xl font-black text-white leading-[0.85] tracking-tighter drop-shadow-2xl">
                        {{ destination.name }}
                    </h1>
                    <p class="text-lg md:text-3xl text-white/90 max-w-3xl leading-snug font-medium drop-shadow-lg">
                        {{ destination.description }}
                    </p>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 md:px-12 py-24 md:py-32 relative z-10 -mt-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 md:gap-20">
                <!-- Tours List -->
                <div class="lg:col-span-8 space-y-16 md:space-y-24">
                    <div :class="['reveal-up flex flex-col md:flex-row items-start md:items-center justify-between border-b border-slate-200 pb-8 md:pb-12 gap-8', locale === 'ar' ? 'flex-row' : 'flex-row-reverse']">
                        <div class="space-y-2">
                             <h2 class="text-4xl md:text-6xl font-black text-slate-900 tracking-tighter">
                                {{ t('available_tours') }}
                            </h2>
                            <div class="w-16 h-1 bg-blue-600 rounded-full"></div>
                        </div>
                        <span class="px-5 py-2 bg-blue-600/5 text-blue-600 rounded-full font-black text-[10px] md:text-xs uppercase tracking-widest border border-blue-100 backdrop-blur-sm">
                            {{ destination.tours.length }} {{ t('tours_count') }}
                        </span>
                    </div>

                    <div v-if="destination.tours.length > 0" class="space-y-12">
                        <Link v-for="tour in destination.tours" :key="tour.id"
                               :href="route('tours.show', tour.id)"
                               :class="['group reveal-up glass-card !p-6 md:!p-10 flex flex-col md:flex-row gap-8 md:gap-16 items-center border-white shadow-2xl shadow-blue-500/5 hover:shadow-blue-500/20 hover:-translate-y-4 transition-all duration-700 rounded-[3rem] md:rounded-[4.5rem]', locale === 'ar' ? 'md:flex-row' : 'md:flex-row-reverse']">
                            
                            <div class="w-full md:w-96 h-80 shrink-0 rounded-[3rem] overflow-hidden shadow-2xl relative">
                                <img :src="tour.image_path || getTourFallbackImage(tour)" 
                                     @error="$event.target.src = getTourFallbackImage(tour)"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[2s] ease-out">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                            </div>

                            <div class="flex-1 w-full">
                                <div :class="['flex justify-between items-start mb-8', locale === 'ar' ? 'flex-row' : 'flex-row-reverse']">
                                    <span class="px-4 py-1.5 bg-blue-50 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-widest">{{ tour.category.name }}</span>
                                    <div class="flex items-center gap-2 text-amber-500 font-black">
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span class="text-sm font-black">{{ tour.rating_avg || '5.0' }}</span>
                                    </div>
                                </div>
                                <h3 :class="['text-4xl font-black text-slate-900 mb-6 group-hover:text-blue-600 transition-colors tracking-tighter', locale === 'ar' ? 'text-right' : 'text-left']">{{ tour.title }}</h3>
                                <p :class="['text-slate-400 font-bold mb-12 line-clamp-2 leading-relaxed text-lg', locale === 'ar' ? 'text-right' : 'text-left']">{{ tour.description }}</p>
                                
                                <div :class="['flex items-center justify-between pt-10 border-t border-slate-100', locale === 'ar' ? 'flex-row' : 'flex-row-reverse']">
                                    <div :class="['flex flex-col', locale === 'ar' ? 'items-start' : 'items-end']">
                                        <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1">{{ t('starting_from') }}</span>
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-blue-600 font-black text-3xl md:text-4xl tracking-tighter">${{ Math.floor(tour.price) }}</span>
                                            <span class="text-slate-300 font-bold text-[10px] md:text-sm">/ {{ t('per_person') }}</span>
                                        </div>
                                    </div>
                                    <div :class="['flex items-center gap-10', locale === 'ar' ? 'flex-row' : 'flex-row-reverse']">
                                        <span class="hidden sm:flex text-slate-400 font-black text-xs uppercase tracking-widest items-center gap-3">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0"></path></svg>
                                            {{ tour.days }} {{ t('days') }}
                                        </span>
                                        <div class="w-16 h-16 rounded-full bg-slate-900 text-white flex items-center justify-center group-hover:bg-blue-600 group-hover:scale-110 transition-all shadow-xl shadow-slate-900/10">
                                            <svg :class="['w-7 h-7', locale === 'ar' ? 'rotate-180' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Link>
                    </div>
                </div>

                <!-- Premium Sidebar Info -->
                <div class="lg:col-span-4 space-y-12">
                    <div class="sticky top-12 space-y-12">
                        <div class="glass-card !p-8 md:!p-12 rounded-[2.5rem] md:rounded-[4rem] border-white shadow-2xl relative overflow-hidden reveal-up">
                            <div class="absolute -top-20 -right-20 w-64 h-64 bg-blue-600/5 rounded-full blur-[100px]"></div>
                            <h4 :class="['text-2xl md:text-3xl font-black text-slate-900 mb-8 md:mb-10 tracking-tighter', locale === 'ar' ? 'text-right' : 'text-left']">{{ t('why_choose_destination') }} {{ destination.name }}</h4>
                            <ul class="space-y-8 md:space-y-10">
                                <li :class="['flex items-start gap-4 md:gap-6 group', locale === 'ar' ? 'flex-row' : 'flex-row-reverse text-left']">
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-blue-600/10 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all shadow-sm">
                                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-7h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <div :class="locale === 'ar' ? 'text-right' : 'text-left'">
                                        <h5 class="font-black text-slate-900 mb-1 uppercase text-[10px] md:text-xs">{{ t('ancient_history') }}</h5>
                                        <p class="text-slate-400 font-bold leading-relaxed text-xs md:text-sm">{{ t('ancient_history_desc') }}</p>
                                    </div>
                                </li>
                                <li :class="['flex items-start gap-4 md:gap-6 group', locale === 'ar' ? 'flex-row' : 'flex-row-reverse text-left']">
                                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-amber-600/10 text-amber-600 flex items-center justify-center shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-all shadow-sm">
                                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                    </div>
                                    <div :class="locale === 'ar' ? 'text-right' : 'text-left'">
                                        <h5 class="font-black text-slate-900 mb-1 uppercase text-[10px] md:text-xs">{{ t('royal_service') }}</h5>
                                        <p class="text-slate-400 font-bold leading-relaxed text-xs md:text-sm">{{ t('royal_service_desc') }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- Interactive Map Section -->
                        <div v-if="destination.latitude && destination.longitude" class="glass-card !p-0 rounded-[2.5rem] md:rounded-[3.5rem] border-white shadow-3xl overflow-hidden reveal-up h-[28rem] md:h-[35rem] relative group">
                            <div class="absolute top-6 left-6 z-10 px-6 py-3 bg-white/90 backdrop-blur-md rounded-2xl shadow-xl border border-white/20">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-900">{{ t('location_on_map') || 'Explore on Map' }}</span>
                            </div>
                            <iframe 
                                class="w-full h-full grayscale-[0.2] contrast-[1.1] brightness-[0.9] hover:grayscale-0 transition-all duration-1000"
                                frameborder="0" scrolling="no" marginheight="0" marginwidth="0" 
                                :src="`https://maps.google.com/maps?q=${destination.latitude},${destination.longitude}&z=14&output=embed`"
                            ></iframe>
                        </div>

                        <div class="glass-card !p-12 rounded-[4rem] border-white shadow-2xl relative overflow-hidden reveal-up">
                            <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-amber-600/5 rounded-full blur-[100px]"></div>
                            <h4 :class="['text-3xl font-black text-slate-900 mb-8 tracking-tighter', locale === 'ar' ? 'text-right' : 'text-left']">{{ t('visit_us') }}</h4>
                            <div class="space-y-6">
                                <div :class="['flex items-center gap-5', locale === 'ar' ? 'flex-row' : 'flex-row-reverse']">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <p class="text-slate-500 font-bold text-sm leading-relaxed">{{ t('office_address') }}</p>
                                </div>
                                <div :class="['flex items-center gap-5', locale === 'ar' ? 'flex-row' : 'flex-row-reverse']">
                                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </div>
                                    <p class="text-slate-500 font-bold text-sm leading-relaxed">{{ t('phone') }}</p>
                                </div>
                                <div :class="['flex items-center gap-5', locale === 'ar' ? 'flex-row' : 'flex-row-reverse']">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0"></path></svg>
                                    </div>
                                    <p class="text-slate-500 font-bold text-sm leading-relaxed">{{ t('working_hours') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="premium-gradient rounded-[4rem] p-12 text-white shadow-3xl shadow-blue-500/40 relative overflow-hidden group reveal-up">
                            <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                            <div class="relative z-10">
                                <h4 :class="['text-4xl font-black mb-8 tracking-tighter leading-tight', locale === 'ar' ? 'text-right' : 'text-left']">{{ t('private_experience_title') }}</h4>
                                <p :class="['font-bold text-white/80 mb-12 leading-relaxed text-lg', locale === 'ar' ? 'text-right' : 'text-left']">{{ t('private_experience_desc') }}</p>
                                <Link :href="route('contact')" class="w-full block text-center py-6 bg-white text-blue-600 rounded-[2.5rem] font-black text-sm uppercase tracking-widest hover:scale-105 transition-transform shadow-2xl">
                                    {{ t('get_private_quote') }}
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <MobileNav />
        <!-- WhatsApp Floating Button -->
        <WhatsAppButton />
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap');
.font-sans {
    font-family: 'Cairo', sans-serif !important;
}

.premium-gradient {
    background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
}

.glass-card {
    @apply bg-white/80 backdrop-blur-xl border border-white/40 shadow-xl p-6;
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

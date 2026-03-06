<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import MobileNav from '@/Components/MobileNav.vue';

const { props } = usePage();
const category = computed(() => props.category);
const locale = computed(() => props.locale);
const t = (key) => props.translations.messages[key] || key;

onMounted(() => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
});
</script>

<template>
    <Head :title="category.name + ' - ' + t('brand_name')" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-slate-50 selection:bg-blue-600 selection:text-white pb-32">
        <!-- Floating Navbar -->
        <nav class="fixed top-0 left-0 right-0 z-50 px-6 py-8">
            <div class="max-w-7xl mx-auto flex justify-between items-center glass-card p-6 rounded-[2.5rem] border-white/40 shadow-2xl">
                <Link :href="route('home')" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl premium-gradient flex items-center justify-center text-white shadow-lg group-hover:rotate-12 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2 2 2 0 012 2v.657M16.486 4.54a4.5 4.5 0 00-8.212 2.73 4.5 4.5 0 001.095 4.639L12 16.03l3.631-4.12A4.5 4.5 0 0016.486 4.54z"></path></svg>
                    </div>
                    <span class="text-xl font-black tracking-tighter text-gradient">{{ t('brand_short') }}</span>
                </Link>
                <div class="flex items-center gap-4">
                    <button @click="window.history.back()" class="flex items-center gap-2 px-6 py-2 bg-slate-900 text-white rounded-full text-xs font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-xl shadow-slate-900/20">
                        <svg :class="['w-4 h-4', locale === 'ar' ? 'rotate-180' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        {{ t('back') }}
                    </button>
                    <Link :href="route('tours.index')" class="btn-glass !py-3 !px-6 !text-xs">{{ t('all_tours') }}</Link>
                    <Link :href="route('language.switch', locale === 'ar' ? 'en' : 'ar')" 
                       class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center font-black text-[10px] hover:scale-110 transition-transform">
                        {{ locale === 'ar' ? 'EN' : 'AR' }}
                    </Link>
                </div>
            </div>
        </nav>

        <!-- Header Section -->
        <header class="pt-48 pb-20 relative overflow-hidden bg-white">
            <div class="absolute inset-0 opacity-5">
                <div class="absolute top-0 left-0 w-96 h-96 bg-blue-600 rounded-full blur-[120px] -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-600 rounded-full blur-[120px] translate-x-1/2 translate-y-1/2"></div>
            </div>

            <div class="max-w-7xl mx-auto px-6 relative z-10 reveal-up">
                <div class="inline-flex items-center gap-3 px-5 py-2 glass-card !bg-blue-600/5 !border-blue-100/50 rounded-2xl text-blue-600 text-[10px] font-black uppercase tracking-widest mb-10">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                    {{ t('exclusive_categories') }}
                </div>
                <h1 class="text-6xl md:text-9xl font-black text-gradient mb-10 tracking-tighter leading-tight">
                    {{ category.name }}
                </h1>
                <p class="text-xl md:text-3xl text-slate-400 max-w-3xl font-medium leading-relaxed">
                    {{ t('category_show_subtitle') }} {{ category.name }}.
                </p>
            </div>
        </header>

        <!-- Tours Grid -->
        <main class="max-w-7xl mx-auto px-6 py-24">
            <div v-if="category.tours && category.tours.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                <div v-for="tour in category.tours" :key="tour.id" 
                     class="group bg-white rounded-[4rem] overflow-hidden shadow-2xl hover:-translate-y-4 transition-all duration-700 reveal-up border border-slate-50">
                    <div class="relative h-[24rem] overflow-hidden">
                        <img :src="tour.image_path || 'https://images.unsplash.com/photo-1547234935-80c7145ec969?q=80&w=800'" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        
                        <!-- Top Floating Price Badge -->
                        <div class="absolute top-10" :class="locale === 'ar' ? 'left-10' : 'right-10'">
                            <span class="text-6xl font-black text-white tracking-tighter">${{ Math.floor(tour.price) }}</span>
                        </div>
                    </div>

                    <div class="p-12 text-center">
                        <div class="flex items-center justify-center gap-2 text-blue-600 font-black text-xs mb-6 uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            {{ tour.location }}
                        </div>
                        <h3 class="text-3xl font-black text-slate-900 mb-6 tracking-tighter leading-tight">{{ tour.title }}</h3>
                        <p class="text-slate-500 font-medium text-sm leading-relaxed mb-10 px-4 line-clamp-2">{{ tour.description }}</p>
                        
                        <div class="flex flex-col items-center gap-8 border-t border-slate-50 pt-10">
                            <div class="flex items-center gap-8 text-slate-400 font-black text-xs uppercase tracking-widest">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 
                                    {{ tour.days }} {{ t('days') }}
                                </span>
                            </div>
                            <Link :href="route('tours.show', tour.id)" class="px-14 py-5 rounded-[1.5rem] bg-slate-900 text-white font-black text-sm uppercase tracking-widest hover:bg-blue-600 transition-all shadow-2xl shadow-slate-900/20 active:scale-95">
                                {{ t('details') }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-40 glass-card rounded-[4rem] reveal-up">
                <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-10 overflow-hidden">
                    <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                </div>
                <h3 class="text-4xl font-black text-gradient px-4 mb-4">{{ t('coming_soon') }}</h3>
                <p class="text-slate-400 font-bold max-w-md mx-auto">{{ t('coming_soon_subtitle') }}</p>
            </div>
        </main>

        <MobileNav />
    </div>
</template>


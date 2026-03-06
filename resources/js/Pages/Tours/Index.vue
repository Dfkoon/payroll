<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import MobileNav from '@/Components/MobileNav.vue';
import WhatsAppButton from '@/Components/WhatsAppButton.vue';
import SkeletonCard from '@/Components/SkeletonCard.vue';

const { props } = usePage();
const locale = computed(() => props.locale);
const t = (key) => props.translations.messages[key] || key;

const isLoading = ref(true);
const wishlist = ref([]);

const pageProps = defineProps({
    tours: Array,
});

onMounted(() => {
    // Load wishlist from localStorage
    const savedWishlist = localStorage.getItem('wishlist');
    if (savedWishlist) {
        wishlist.value = JSON.parse(savedWishlist);
    }

    // Simulate loading for Skeleton effect
    setTimeout(() => {
        isLoading.value = false;
    }, 1200);
});

const toggleWishlist = (tourId) => {
    if (wishlist.value.includes(tourId)) {
        wishlist.value = wishlist.value.filter(id => id !== tourId);
    } else {
        wishlist.value.push(tourId);
    }
    localStorage.setItem('wishlist', JSON.stringify(wishlist.value));
};

const isInWishlist = (tourId) => wishlist.value.includes(tourId);

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

const selectedScope = ref('all'); // 'all', 'local', 'international'
const selectedCategory = ref('all');
const searchQuery = ref('');

const scopes = computed(() => [
    { id: 'all', name: t('all') || 'All' },
    { id: 'local', name: t('local') || 'Local' },
    { id: 'international', name: t('international') || 'International' },
    { id: 'wishlist', name: t('wishlist') || 'Wishlist' },
]);

const filteredTours = computed(() => {
    return pageProps.tours.filter(tour => {
        // Scope Filter
        if (selectedScope.value === 'local' && tour.is_international) return false;
        if (selectedScope.value === 'international' && !tour.is_international) return false;
        if (selectedScope.value === 'wishlist' && !wishlist.value.includes(tour.id)) return false;
        const isInternational = !!tour.destination?.is_international;
        const matchesScope = selectedScope.value === 'all' || 
                            (selectedScope.value === 'local' && !isInternational) ||
                            (selectedScope.value === 'international' && isInternational);

        // Category Filter
        const matchesCategory = selectedCategory.value === 'all' || tour.category.slug === selectedCategory.value;

        // Search Filter
        const matchesSearch = tour.title.toLowerCase().includes(searchQuery.value.toLowerCase()) || 
                             tour.location.toLowerCase().includes(searchQuery.value.toLowerCase());

        return matchesScope && matchesCategory && matchesSearch;
    });
});

const categories = computed(() => [
    { name: t('all'), slug: 'all' },
    { name: t('cultural'), slug: 'cultural' },
    { name: t('adventure'), slug: 'adventure' },
    { name: t('religious'), slug: 'religious' },
    { name: t('tours_category'), slug: 'tours' },
    { name: t('others'), slug: 'others' },
]);

onMounted(() => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.1 });

    // Only observe static elements like the header
    document.querySelectorAll('.reveal-up:not(.tour-card)').forEach(el => observer.observe(el));
});
</script>

<template>
    <Head :title="t('tours') + ' - ' + t('brand_name')" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-[#f8fafc] text-slate-900 font-sans selection:bg-blue-600 selection:text-white pb-20 md:pb-0">
        
        <!-- Premium Navbar -->
        <nav class="glass-nav h-20 flex items-center">
            <div class="max-w-7xl mx-auto px-6 w-full flex justify-between items-center">
                <Link :href="route('home')" class="flex items-center gap-3 group">
                    <div class="shrink-0 w-10 h-10 rounded-xl premium-gradient flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:rotate-12 transition-all">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <span class="text-2xl font-black text-slate-900 leading-none">{{ t('brand_short') }} <span class="text-blue-600">Travel</span></span>
                </Link>

                <div class="flex items-center gap-6">
                    <div class="relative w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center hover:bg-red-50 group transition-all shadow-sm cursor-pointer" @click="selectedScope = 'wishlist'">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <span v-if="wishlist.length" class="absolute -top-2 -right-2 w-4 h-4 bg-red-500 text-white text-[8px] font-black rounded-full flex items-center justify-center border-2 border-white">
                            {{ wishlist.length }}
                        </span>
                    </div>
                    <Link :href="route('language.switch', locale === 'ar' ? 'en' : 'ar')" 
                          class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-[10px] font-black hover:bg-slate-900 hover:text-white transition-all shadow-sm">
                        {{ locale === 'ar' ? 'EN' : 'AR' }}
                    </Link>
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="hidden sm:block btn-premium !py-3 !px-6 !text-xs">{{ t('dashboard') }}</Link>
                    <Link v-else :href="route('login')" class="hidden sm:block btn-premium !py-3 !px-6 !text-xs ring-4 ring-blue-500/5">{{ t('login') }}</Link>
                </div>
            </div>
        </nav>

        <!-- Dynamic Header -->
        <header class="pt-32 pb-20 bg-white border-b border-slate-50">
            <div class="max-w-7xl mx-auto px-6 reveal-up text-center">
                <span class="inline-block py-2 px-6 bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest rounded-full mb-6">{{ t('explore_tours') }}</span>
                <h1 class="text-5xl md:text-8xl font-black text-slate-900 mb-8 tracking-tighter leading-none">
                    {{ t('explore_adventures') }}
                </h1>
                <p class="text-xl text-slate-400 max-w-2xl mx-auto font-bold leading-relaxed px-4">
                    {{ t('hero_subtitle') }}
                </p>
            </div>
        </header>

        <!-- Advanced Filters -->
        <div class="sticky top-20 z-40 bg-white/80 backdrop-blur-2xl border-b border-slate-100 py-8 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 space-y-8">
                <div class="flex flex-col lg:flex-row justify-between items-center gap-10">
                    <!-- Scope Filter: Local/International -->
                    <div class="flex items-center gap-2 p-2 bg-slate-100/80 rounded-3xl w-full lg:w-auto relative shadow-inner">
                        <button v-for="scope in scopes" :key="scope.id"
                                @click="selectedScope = scope.id"
                                :class="[
                                    'relative px-10 py-3.5 rounded-2xl text-[10px] md:text-xs font-black uppercase tracking-[0.2em] transition-all duration-500 whitespace-nowrap z-10',
                                    selectedScope === scope.id ? 'text-blue-600' : 'text-slate-400 hover:text-slate-600'
                                ]">
                            <!-- Background Active Indicator -->
                            <div v-if="selectedScope === scope.id" 
                                 class="absolute inset-0 bg-white rounded-2xl shadow-xl shadow-blue-500/10 z-[-1] animate-in fade-in zoom-in duration-300"></div>
                            {{ scope.name }}
                        </button>
                    </div>

                    <!-- Search Input -->
                    <div class="relative w-full lg:w-[35rem] group">
                        <input type="text" v-model="searchQuery" 
                               :placeholder="t('search_placeholder')"
                               class="w-full pl-14 pr-8 py-5 rounded-3xl border-none bg-slate-100 focus:bg-white focus:ring-[6px] focus:ring-blue-500/10 transition-all font-black text-sm placeholder:text-slate-400">
                        <svg class="absolute left-5 top-5 w-6 h-6 text-slate-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                </div>

                <!-- Category Filter: Adventure/Cultural... -->
                <div class="flex items-center gap-4 overflow-x-auto pb-2 no-scrollbar scroll-smooth">
                    <div class="flex items-center gap-2 shrink-0 px-4 py-2 bg-blue-50 rounded-xl">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                        <span class="text-[9px] font-black text-blue-600 uppercase tracking-widest">{{ t('category_label') }}</span>
                    </div>
                    
                    <button v-for="cat in categories" :key="cat.slug"
                            @click="selectedCategory = cat.slug"
                            :class="[
                                'px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 whitespace-nowrap border-2',
                                selectedCategory === cat.slug 
                                ? 'border-blue-600 bg-blue-600 text-white shadow-lg shadow-blue-500/20 scale-105' 
                                : 'border-transparent bg-slate-50 text-slate-400 hover:bg-slate-100 hover:text-slate-600'
                            ]">
                        {{ cat.name }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Tour Grid -->
        <main class="max-w-7xl mx-auto px-6 py-24 min-h-[60vh]">
            <!-- Tour Grid with Skeleton Loading -->
            <div v-if="isLoading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                <SkeletonCard v-for="i in 6" :key="i" />
            </div>

            <TransitionGroup 
                v-else-if="filteredTours.length" 
                name="tour-grid" 
                tag="div" 
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12"
            >
                <Link v-for="tour in filteredTours" :key="tour.id" :href="route('tours.show', tour.id)"
                      class="group glass-card !p-6 rounded-[4rem] hover:shadow-[0_40px_80px_-20px_rgba(0,0,0,0.15)] hover:-translate-y-4 transition-all duration-700 bg-white tour-card">
                    <div class="relative h-[25rem] rounded-[3rem] overflow-hidden mb-8 shadow-2xl">
                        <img :src="tour.image_path || getTourFallbackImage(tour)" 
                             @error="$event.target.src = getTourFallbackImage(tour)"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[2s] ease-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        
                        <!-- Badges -->
                        <div class="absolute top-8 left-8 right-8 flex justify-between items-start">
                            <div class="px-6 py-2 bg-white/90 backdrop-blur-xl rounded-2xl text-[12px] font-black text-slate-900 shadow-xl">
                                ${{ Math.floor(tour.price) }}
                            </div>
                            <button @click.stop.prevent="toggleWishlist(tour.id)" 
                                    class="w-12 h-12 rounded-2xl bg-white/90 backdrop-blur-xl flex items-center justify-center shadow-xl transition-all hover:scale-110 active:scale-95 group/wish">
                                <svg :class="['w-6 h-6 transition-colors', isInWishlist(tour.id) ? 'text-red-500 fill-current' : 'text-slate-400 group-hover/wish:text-red-400']" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="absolute top-8 right-8 flex flex-col items-end gap-3">
                            <span class="px-4 py-2 bg-blue-600 text-white rounded-xl text-[9px] font-black uppercase tracking-widest shadow-xl">{{ tour.category.name }}</span>
                            <span v-if="tour.destination?.is_international" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-[9px] font-black uppercase tracking-widest shadow-xl">{{ t('international') }}</span>
                        </div>

                        <!-- All Inclusive Badge -->
                        <div class="absolute bottom-6 left-6 right-6 flex items-center gap-2 p-4 bg-white/10 backdrop-blur-2xl border border-white/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-all translate-y-4 group-hover:translate-y-0">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-[10px] font-black text-white uppercase tracking-widest">{{ t('all_inclusive') }}</span>
                        </div>
                    </div>

                    <div class="px-6 text-center">
                        <div class="flex items-center justify-center gap-2 text-blue-600 font-black text-[10px] mb-5 uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            {{ tour.location }}
                        </div>
                        <h3 class="text-3xl font-black text-slate-900 mb-6 tracking-tighter leading-tight group-hover:text-blue-600 transition-colors">{{ tour.title }}</h3>
                        
                        <div class="flex items-center justify-center gap-8 py-6 border-t border-slate-50 text-slate-400">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-[10px] font-black uppercase tracking-widest">{{ tour.days }} {{ t('days') }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-amber-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                <span class="text-[10px] font-black text-slate-900">4.9</span>
                            </div>
                        </div>

                        <div class="w-full py-5 bg-slate-50 group-hover:bg-blue-600 group-hover:text-white rounded-3xl text-center font-black text-[10px] uppercase tracking-widest transition-all">
                            {{ t('details') }}
                        </div>
                    </div>
                </Link>
            </TransitionGroup>

            <!-- Empty Results -->
            <div v-else class="text-center py-40 glass-card rounded-[5rem] reveal-up">
                <div class="w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-10 group">
                     <svg class="w-16 h-16 text-slate-200 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <h3 class="text-4xl font-black text-slate-900 px-4 mb-4 tracking-tighter">{{ t('no_results') }}</h3>
                <p class="text-slate-400 font-bold mb-12">{{ t('search_different') }}</p>
                <button @click="selectedScope = 'all'; selectedCategory = 'all'; searchQuery = ''" class="btn-premium px-12 !py-6">{{ t('reset_search') }}</button>
            </div>
        </main>

        <MobileNav />

        <!-- WhatsApp Floating Button -->
        <WhatsAppButton />
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
    @apply px-10 py-4 bg-blue-600 text-white font-black rounded-full shadow-2xl shadow-blue-500/20 hover:scale-105 active:scale-95 transition-all duration-500;
}

.reveal-up {
    opacity: 0;
    transform: translateY(50px);
    transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
}

.reveal-up.active {
    opacity: 1;
    transform: translateY(0);
}

/* Tour Grid Transitions */
.tour-grid-enter-active,
.tour-grid-leave-active {
    transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.tour-grid-enter-from {
    opacity: 0;
    transform: translateY(30px) scale(0.95);
}

.tour-grid-leave-to {
    opacity: 0;
    transform: scale(0.9);
}

.tour-grid-move {
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
}

.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import SearchOverlay from '@/Components/SearchOverlay.vue';
import MobileNav from '@/Components/MobileNav.vue';
import Footer from '@/Components/Footer.vue';
import RotatingText from '@/Components/RotatingText.vue';
import WhatsAppButton from '@/Components/WhatsAppButton.vue';

const { props: pageProps } = usePage();
const locale = computed(() => pageProps.locale);
const t = (key) => pageProps.translations.messages[key] || key;

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    local_destinations: Array,
    international_destinations: Array,
    featured_tours: Array,
    categories: Array,
});

const searchOverlay = ref(null);
const toggleSearch = () => searchOverlay.value.toggle();

const getCategoryFallbackImage = (id) => {
    const fallbacks = [
        '/images/categories/economy.png',
        '/images/categories/premium.png',
        '/images/categories/luxury.png',
        '/images/categories/cultural.png',
    ];
    return fallbacks[(id || 0) % fallbacks.length];
};

const getDestinationFallbackImage = (id) => {
    const fallbacks = [
        'https://images.unsplash.com/photo-1582650625119-3a31f8fa2691?q=80&w=1000', // Desert/Camel
        'https://images.unsplash.com/photo-1589828132952-b8dce4939b4b?q=80&w=1000', // Modern City (Saudi/UAE aesthetic)
        'https://images.unsplash.com/photo-1572252009286-268acec5ca0a?q=80&w=1000', // Historic ruins
        'https://images.unsplash.com/photo-1540202404-b911c43d8b5a?q=80&w=1000', // Beach/Resort
    ];
    return fallbacks[(id || 0) % fallbacks.length];
};

onMounted(() => {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
});

const wishlist = ref([]);
onMounted(() => {
    const savedWishlist = localStorage.getItem('wishlist');
    if (savedWishlist) {
        wishlist.value = JSON.parse(savedWishlist);
    }
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

const testimonials = [
    {
        id: 1,
        name: locale.value === 'ar' ? 'أحمد السعيد' : 'Ahmad Al-Saeed',
        role: locale.value === 'ar' ? 'مسافر من السعودية' : 'Traveler from KSA',
        feedback: locale.value === 'ar' ? 'تجربة لا تنسى في وادي رم، التنسيق كان رائعاً والخدمة متميزة جداً. أنصح الجميع بالتعامل معهم.' : 'An unforgettable experience in Wadi Rum, the coordination was wonderful and the service was very distinguished.',
        rating: 5,
        image: 'https://i.pravatar.cc/150?u=ahmad'
    },
    {
        id: 2,
        name: locale.value === 'ar' ? 'سارة جونسون' : 'Sarah Johnson',
        role: locale.value === 'ar' ? 'مسافرة من بريطانيا' : 'Traveler from UK',
        feedback: locale.value === 'ar' ? 'الأردن بلد مذهل! الرحلة كانت منظمة بشكل جيد وكان دليلنا واسع المعرفة ولطيفاً جداً.' : 'Jordan is amazing! The trip was well organized and our guide was very knowledgeable and kind.',
        rating: 5,
        image: 'https://i.pravatar.cc/150?u=sarah'
    },
    {
        id: 3,
        name: locale.value === 'ar' ? 'محمد خليل' : 'Mohammad Khalil',
        role: locale.value === 'ar' ? 'مسافر من الإمارات' : 'Traveler from UAE',
        feedback: locale.value === 'ar' ? 'أفضل مكتب سياحي تعاملت معه، مصداقية واهتمام بأدق التفاصيل. كانت رحلة العمر حقاً.' : 'The best travel agency I have dealt with, credibility and attention to the smallest details. It was truly the trip of a lifetime.',
        rating: 5,
        image: 'https://i.pravatar.cc/150?u=mohammad'
    }
];
</script>

<template>
    <Head :title="t('home') + ' - ' + t('brand_name')" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-[#f8fafc] text-slate-900 font-sans selection:bg-blue-600 selection:text-white pb-20 md:pb-0 scroll-smooth mesh-gradient">
        
        <!-- Premium Glass Navbar -->
        <nav class="glass-nav h-24 flex items-center z-[100]">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 w-full flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <Link :href="route('home')" class="flex items-center gap-4 group">
                        <div class="shrink-0 w-12 h-12 rounded-2xl premium-gradient flex items-center justify-center shadow-2xl shadow-blue-500/30 group-hover:rotate-12 transition-all duration-500">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-3xl font-black tracking-tighter text-slate-900 leading-none">{{ t('brand_short') }} <span class="text-blue-600">Travel</span></span>
                    </Link>
                </div>

                <!-- Desktop Nav -->
                <div class="hidden md:flex items-center gap-10">
                    <Link :href="route('tours.index')" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-colors">{{ t('tours') }}</Link>
                    <Link :href="route('destinations.index')" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-colors">{{ t('destinations') }}</Link>
                    <Link :href="route('blog.index')" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-colors">{{ t('blog') }}</Link>
                    <Link :href="route('about')" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-colors">{{ t('about') }}</Link>
                </div>

                <div class="flex items-center gap-6">
                    <Link :href="route('language.switch', locale === 'ar' ? 'en' : 'ar')" 
                          class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-[10px] font-black hover:bg-slate-900 hover:text-white hover:scale-110 transition-all shadow-sm">
                        {{ locale === 'ar' ? 'EN' : 'AR' }}
                    </Link>
                    
                    <Link :href="route('tours.index')" class="relative w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center hover:bg-red-50 group transition-all shadow-sm">
                        <svg class="w-6 h-6 text-slate-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <span v-if="wishlist.length" class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white text-[10px] font-black rounded-full flex items-center justify-center border-2 border-white animate-bounce">
                            {{ wishlist.length }}
                        </span>
                    </Link>

                    <button @click="toggleSearch" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center hover:bg-blue-600 group transition-all shadow-sm">
                        <svg class="w-6 h-6 text-slate-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>

                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="hidden sm:block btn-premium !py-4 !px-8 !text-xs">{{ t('dashboard') }}</Link>
                    <Link v-else :href="route('login')" class="hidden sm:block btn-premium !py-4 !px-8 !text-xs ring-4 ring-blue-500/10">{{ t('login') }}</Link>
                </div>
            </div>
        </nav>

        <!-- Dynamic Hero Section -->
        <header class="relative h-screen flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1547234935-80c7145ec969?auto=format&fit=crop&q=80&w=2500" 
                     class="w-full h-full object-cover brightness-[0.6] contrast-[1.1] animate-slow-zoom" alt="Hero">
                <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-[#f8fafc]"></div>
            </div>

            <div class="relative z-10 max-w-6xl mx-auto px-6 text-center reveal-up">
                <div class="inline-flex items-center gap-3 px-6 py-3 rounded-full bg-white/10 backdrop-blur-2xl border border-white/20 shadow-2xl mb-10 group hover:bg-white/20 transition-all cursor-default">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    <span class="text-white text-[10px] font-black uppercase tracking-[0.3em]">
                        {{ t('hero_badge') }}
                    </span>
                </div>
                <h1 class="text-3xl sm:text-6xl md:text-9xl font-black text-white leading-[0.85] mb-6 md:mb-10 tracking-tighter flex flex-wrap justify-center items-center gap-x-4">
                    <span>{{ locale === 'ar' ? 'اكتشف' : 'Discover' }}</span>
                    <RotatingText
                        :texts="locale === 'ar' ? ['الجمال', 'التاريخ', 'السحر', 'المغامرة'] : ['Beauty', 'History', 'Magic', 'Adventure']"
                        mainClassName="px-3 py-1.5 md:px-4 md:py-2 bg-blue-600 text-white rounded-xl md:rounded-2xl"
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
                <p class="text-lg md:text-3xl text-white/90 max-w-3xl mx-auto font-medium mb-10 md:text-3xl md:mb-16 leading-tight">
                    {{ t('home_subtitle_2') }}
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 md:gap-8">
                    <Link :href="route('tours.index')" class="w-full sm:w-auto btn-premium group !py-4 !px-8 md:!py-6 md:!px-12 text-lg md:!text-xl !rounded-full md:!rounded-[2.5rem] shadow-blue-600/40">
                        {{ t('explore_tours') }}
                        <svg :class="['w-5 h-5 md:w-6 md:h-6 inline-block mr-3 group-hover:translate-x-2 transition-transform', locale === 'ar' ? 'rotate-180' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </Link>
                    <button @click="toggleSearch" class="w-full sm:w-auto btn-glass !py-4 !px-8 md:!py-6 md:!px-12 text-lg md:!text-xl !rounded-full md:!rounded-[2.5rem]">
                        {{ t('search_cta') }}
                    </button>
                </div>
            </div>

            <!-- New Integrated Stats Bar (Nahdi Style - Dark Mode) -->
            <div class="relative md:absolute bottom-0 md:bottom-20 left-0 right-0 z-10 px-6 py-12 md:py-0 bg-transparent">
                <div class="max-w-5xl mx-auto reveal-up">
                    <div class="glass-card !bg-slate-950/40 !border-white/20 backdrop-blur-3xl rounded-[3rem] md:rounded-full p-2 md:p-3 flex flex-col md:flex-row items-center gap-2 md:gap-4 shadow-[0_32px_128px_-16px_rgba(0,0,0,0.6)] border border-white/10 relative overflow-hidden group">
                        <!-- Decorative Glow -->
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-500/10 via-transparent to-blue-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>

                        <!-- Tours Stat -->
                        <div class="flex-1 w-full md:w-auto flex items-center justify-between md:justify-center gap-4 px-8 py-5 md:py-4 bg-white/5 md:bg-transparent rounded-full md:rounded-none group/stat transition-all hover:bg-white/10">
                            <div class="w-12 h-12 rounded-full bg-purple-600/30 text-purple-400 flex items-center justify-center border border-purple-500/30 shadow-lg shadow-purple-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="text-left md:text-center">
                                <span class="block text-2xl md:text-3xl font-black text-white tracking-tighter drop-shadow-md leading-tight">150+</span>
                                <span class="text-[9px] font-black text-purple-400 uppercase tracking-[0.2em]">{{ t('tours') }}</span>
                            </div>
                        </div>

                        <!-- Divider (Desktop Only) -->
                        <div class="hidden md:block w-px h-12 bg-white/10"></div>

                        <!-- Happy Clients Stat -->
                        <div class="flex-1 w-full md:w-auto flex items-center justify-between md:justify-center gap-4 px-8 py-5 md:py-4 bg-white/5 md:bg-transparent rounded-full md:rounded-none group/stat transition-all hover:bg-white/10">
                            <div class="w-12 h-12 rounded-full bg-blue-600/30 text-blue-400 flex items-center justify-center border border-blue-500/30 shadow-lg shadow-blue-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div class="text-left md:text-center">
                                <span class="block text-2xl md:text-3xl font-black text-white tracking-tighter drop-shadow-md leading-tight">5k+</span>
                                <span class="text-[9px] font-black text-blue-400 uppercase tracking-[0.2em]">{{ t('happy_clients') }}</span>
                            </div>
                        </div>

                        <!-- Divider (Desktop Only) -->
                        <div class="hidden md:block w-px h-12 bg-white/10"></div>

                        <!-- Rating Stat -->
                        <div class="flex-1 w-full md:w-auto flex items-center justify-between md:justify-center gap-4 px-8 py-5 md:py-4 bg-white/5 md:bg-transparent rounded-full md:rounded-none group/stat transition-all hover:bg-white/10">
                            <div class="w-12 h-12 rounded-full bg-amber-500/30 text-amber-400 flex items-center justify-center border border-amber-500/30 shadow-lg shadow-amber-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                            </div>
                            <div class="text-left md:text-center">
                                <span class="block text-2xl md:text-3xl font-black text-white tracking-tighter drop-shadow-md leading-tight">4.9</span>
                                <span class="text-[9px] font-black text-amber-400 uppercase tracking-[0.2em]">{{ t('customer_rating') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Categories: The Gateway -->
        <section class="max-w-7xl mx-auto px-6 py-20 md:py-40">
            <div class="text-center mb-16 md:mb-24 reveal-up">
                <h2 class="text-4xl md:text-7xl font-black text-slate-900 tracking-tighter mb-4 md:mb-6">{{ t('featured_categories_title') }}</h2>
                <div class="w-16 md:w-32 h-1 md:h-2 bg-blue-600 mx-auto rounded-full mb-6 md:mb-8"></div>
                <p class="text-lg md:text-2xl text-slate-400 font-bold max-w-2xl mx-auto">{{ t('featured_categories_subtitle') }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 reveal-up">
                <Link v-for="cat in categories" :key="cat.id" :href="route('categories.show', cat.id)" 
                      class="group relative h-[24rem] md:h-[32rem] rounded-[2.5rem] md:rounded-[3.5rem] overflow-hidden transition-all duration-700 bg-slate-900 shadow-2xl hover:shadow-blue-500/20 hover:-translate-y-4">
                    
                    <!-- Background Image with Parallax-like scale -->
                    <img :src="cat.image_path || getCategoryFallbackImage(cat.id)" 
                         @error="$event.target.src = getCategoryFallbackImage(cat.id)"
                         class="w-full h-full object-cover transition-all duration-1000 scale-110 group-hover:scale-100 opacity-60 group-hover:opacity-100" 
                         alt="Category">
                    
                    <!-- Sophisticated Gradient Overlays -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent opacity-80 group-hover:opacity-60 transition-opacity"></div>
                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-600/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                    <div class="absolute inset-0 flex flex-col justify-end p-6 md:p-10 translate-y-8 group-hover:translate-y-0 transition-transform duration-700">
                        <div class="glass-card !bg-white/10 !border-white/20 backdrop-blur-xl p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] border border-white/10 relative overflow-hidden group/glass">
                            <!-- Shine Effect -->
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover/glass:translate-x-full transition-transform duration-1000"></div>
                            
                            <div class="relative z-10 flex flex-col items-center text-center">
                                <div class="flex items-center gap-1 mb-2 md:mb-3">
                                    <svg v-for="s in 5" :key="s" :class="['w-2.5 h-2.5 md:w-3 md:h-3', s <= (cat.stars || 4) ? 'text-amber-400 fill-current' : 'text-white/20']" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl md:text-3xl font-black text-white mb-1 md:mb-2 tracking-tighter">{{ cat.name }}</h3>
                                <p class="text-white/60 text-[10px] md:text-xs font-bold uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity duration-500">{{ t('explore_style') }}</p>
                                
                                <div class="mt-4 md:mt-6 w-10 h-10 md:w-12 md:h-12 rounded-full bg-blue-600 flex items-center justify-center transform scale-0 group-hover:scale-100 transition-transform duration-500 shadow-xl shadow-blue-500/50">
                                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>
        </section>

        <!-- Local Destinations: Discover Jordan -->
        <section class="bg-[#fafbff] py-20 md:py-40 rounded-[3rem] md:rounded-[10rem] relative overflow-hidden border-y border-blue-50">
            <!-- Decorative Orbs -->
            <div class="absolute top-0 left-0 w-[40rem] h-[40rem] bg-blue-100/40 rounded-full blur-[120px] -translate-y-1/2 -translate-x-1/2"></div>
            <div class="absolute bottom-0 right-0 w-[30rem] h-[30rem] bg-purple-100/30 rounded-full blur-[100px] translate-y-1/2 translate-x-1/2"></div>

            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-16 md:mb-24 reveal-up">
                    <div class="space-y-2 md:space-y-4">
                        <span class="text-blue-600 font-black tracking-[0.3em] uppercase text-[10px] md:text-xs">{{ t('local_destinations') }}</span>
                        <h2 class="text-4xl md:text-7xl font-black text-slate-900 tracking-tighter">{{ t('discover_jordan_title') }}</h2>
                    </div>
                    <Link :href="route('destinations.index')" class="w-full sm:w-auto px-8 py-4 bg-white border border-slate-100 rounded-full font-black text-[10px] md:text-sm uppercase tracking-widest hover:bg-slate-950 hover:text-white transition-all text-center shadow-xl shadow-slate-200/50">
                        {{ t('view_all') }}
                    </Link>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 reveal-up">
                    <div v-for="dest in local_destinations" :key="dest.id" 
                         class="group relative h-[24rem] md:h-[32rem] rounded-[3rem] md:rounded-[4rem] overflow-hidden shadow-2xl hover:-translate-y-4 transition-all duration-700 bg-white border-8 border-white shadow-slate-200/60 hover:shadow-blue-500/20">
                        
                        <div class="absolute inset-0">
                            <img :src="dest.image_path || getDestinationFallbackImage(dest.id)" 
                                 @error="$event.target.src = getDestinationFallbackImage(dest.id)"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 brightness-[0.9] group-hover:brightness-100" alt="Tour">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>
                        </div>
                        
                        <div class="absolute top-6 right-6 px-4 py-2 glass-card !bg-blue-600 !border-none rounded-2xl text-[9px] md:text-[10px] font-black text-white uppercase tracking-widest shadow-2xl">
                            {{ t('top_destination_badge') }}
                        </div>

                        <div class="absolute bottom-6 left-6 right-6 md:bottom-10 md:left-10 md:right-10 text-white text-center">
                            <h3 class="text-3xl md:text-5xl font-black mb-3 md:mb-4 tracking-tighter drop-shadow-2xl">{{ dest.name }}</h3>
                            <p class="text-white/90 font-medium mb-6 md:mb-10 line-clamp-2 text-xs md:text-sm leading-relaxed drop-shadow-lg">{{ dest.description }}</p>
                            <Link :href="route('destinations.show', dest.slug || dest.id)" class="inline-flex items-center gap-3 text-[10px] md:text-xs font-black uppercase tracking-widest text-white hover:text-blue-600 bg-white/10 hover:bg-white px-6 py-3 md:px-8 md:py-4 rounded-full backdrop-blur-md transition-all duration-500 border border-white/20 hover:border-white shadow-2xl">
                                {{ t('details') }}
                                <svg :class="['w-4 h-4 md:w-5 md:h-5', locale === 'ar' ? 'rotate-180' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Tours: The Best Offers -->
        <section class="py-20 md:py-40">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16 md:mb-24 reveal-up">
                    <span class="text-blue-600 font-black tracking-widest uppercase text-[10px] md:text-xs mb-3 md:mb-4 block">{{ t('featured_tours') }}</span>
                    <h2 class="text-4xl md:text-7xl font-black text-slate-900 tracking-tighter">{{ t('all_tours') }}</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-12 reveal-up">
                    <Link v-for="tour in featured_tours" :key="tour.id" :href="route('tours.show', tour.id)" 
                          class="group glass-card !p-4 md:!p-6 rounded-[2.5rem] md:rounded-[3.5rem] hover:shadow-2xl transition-all duration-500 bg-white">
                        <div class="relative h-60 md:h-72 rounded-[2rem] md:rounded-[2.5rem] overflow-hidden mb-6 md:mb-8 shadow-xl">
                            <img :src="tour.image_path || getTourFallbackImage(tour)" 
                                 @error="$event.target.src = getTourFallbackImage(tour)"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[2s] ease-out" alt="Tour">
                            <div class="absolute top-4 left-4 right-4 md:top-6 md:left-6 md:right-6 flex justify-between items-start">
                                <div class="px-4 py-1.5 md:px-5 md:py-2 glass-card !bg-white/90 !border-none !text-slate-900 rounded-xl md:rounded-2xl text-[8px] md:text-[10px] font-black uppercase tracking-widest shadow-xl">
                                    ${{ Math.floor(tour.price) }}
                                </div>
                                <button @click.stop.prevent="toggleWishlist(tour.id)" 
                                        class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white/90 backdrop-blur-xl flex items-center justify-center shadow-xl transition-all hover:scale-110 active:scale-95 group/wish">
                                    <svg :class="['w-5 h-5 md:w-6 md:h-6 transition-colors', isInWishlist(tour.id) ? 'text-red-500 fill-current' : 'text-slate-400 group-hover/wish:text-red-400']" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="px-2 md:px-4">
                            <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-3 block">{{ tour.destination?.name }}</span>
                            <h3 class="text-2xl md:text-3xl font-black text-slate-900 mb-4 md:mb-6 tracking-tighter line-clamp-1">{{ tour.title }}</h3>
                            
                            <div class="flex items-center gap-4 md:gap-8 mb-6 md:mb-8 text-slate-400">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-[10px] md:text-xs font-bold">{{ tour.days }} {{ t('days') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 md:w-5 md:h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <span class="text-[10px] md:text-xs font-black text-slate-900">4.9</span>
                                </div>
                            </div>

                            <div class="w-full py-4 md:py-5 bg-slate-50 group-hover:bg-blue-600 text-slate-900 group-hover:text-white rounded-2xl md:rounded-[2rem] text-center font-black text-[10px] md:text-xs uppercase tracking-widest transition-all">
                                {{ t('details') }}
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <!-- International Trips: Global Adventures -->
        <section class="bg-[#fdfaff] py-20 md:py-40 rounded-[3rem] md:rounded-[10rem] border-y border-purple-100/50 relative overflow-hidden">
            <!-- Decorative Background Element -->
            <div class="absolute top-0 right-0 w-[50rem] h-[50rem] bg-purple-100/30 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2"></div>
            
            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="text-center mb-16 md:mb-24 reveal-up">
                    <span class="text-purple-600 font-black tracking-widest uppercase text-[10px] md:text-xs mb-3 md:mb-4 block">{{ t('international_trips') }}</span>
                    <h2 class="text-4xl md:text-8xl font-black text-slate-900 tracking-tighter leading-tight">{{ t('global_adventures_title') }}</h2>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 reveal-up">
                    <Link v-for="dest in international_destinations" :key="dest.id" :href="route('destinations.show', dest.slug || dest.id)" 
                         class="group relative h-[35rem] rounded-[4rem] overflow-hidden border-8 border-white shadow-2xl shadow-purple-200/20 hover:shadow-purple-300/40 transition-all duration-700 block">
                        <!-- Image Container with better overlay -->
                        <div class="absolute inset-0">
                            <img :src="dest.image_path || getDestinationFallbackImage(dest.id)" 
                                 @error="$event.target.src = getDestinationFallbackImage(dest.id)"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000 brightness-[0.85] group-hover:brightness-100" alt="Destination">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-80 group-hover:opacity-40 transition-opacity"></div>
                        </div>
                        
                        <div class="absolute bottom-8 left-0 right-0 px-8 md:bottom-12 md:px-12 text-center text-white">
                            <h3 class="text-3xl md:text-6xl font-black mb-2 md:mb-4 tracking-tighter drop-shadow-2xl">{{ dest.name }}</h3>
                            <p class="text-white/90 font-medium mb-6 md:mb-8 max-w-sm mx-auto text-xs md:text-sm line-clamp-2 leading-relaxed drop-shadow-lg">{{ dest.description }}</p>
                            <div class="inline-flex h-10 px-6 md:h-12 md:px-10 items-center justify-center bg-white text-purple-600 rounded-full font-black text-[10px] md:text-xs uppercase tracking-widest group-hover:bg-purple-600 group-hover:text-white shadow-2xl transition-all duration-500 transform group-hover:scale-110">
                                {{ t('explore_tours') }}
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Premium Testimonials Section -->
        <section class="py-24 md:py-48 bg-slate-50/50 relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-[50rem] h-[50rem] bg-indigo-600/5 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-[40rem] h-[40rem] bg-blue-600/5 rounded-full blur-[100px] translate-y-1/2 -translate-x-1/2"></div>

            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-end gap-12 mb-20 md:mb-32 reveal-up">
                    <div class="max-w-3xl">
                        <span class="text-blue-600 font-black tracking-widest uppercase text-[10px] md:text-xs mb-4 block">
                            {{ t('testimonials_subtitle') }}
                        </span>
                        <h2 class="text-5xl md:text-8xl font-black text-slate-900 tracking-tighter leading-none">
                            {{ t('testimonials_title') }}
                        </h2>
                    </div>
                </div>

                <div class="flex flex-nowrap md:grid md:grid-cols-3 gap-8 md:gap-16 overflow-x-auto pb-12 md:pb-0 no-scrollbar snap-x">
                    <div v-for="item in testimonials" :key="item.id" 
                         class="min-w-[85vw] md:min-w-0 snap-center group reveal-up relative">
                        <!-- Card -->
                        <div class="glass-card !p-10 md:!p-14 rounded-[3.5rem] md:rounded-[5rem] bg-white border-white shadow-2xl shadow-blue-500/5 hover:shadow-blue-500/15 transition-all duration-700 hover:-translate-y-4 relative z-10 overflow-hidden">
                            <!-- Floating Quote Icon -->
                            <div class="absolute -top-6 -right-6 text-blue-600/10 group-hover:text-blue-600/20 transition-colors duration-700">
                                <svg class="w-32 h-32 fill-current" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.899 15.617 14 17.517 14H20V5H11V14H14.017V21ZM5.017 21V18C5.017 16.899 6.617 14 8.517 14H11V5H2V14H5.017V21Z"/></svg>
                            </div>

                            <!-- Rating -->
                            <div class="flex gap-1 mb-10 relative z-10">
                                <svg v-for="i in (item.rating || 5)" :key="i" class="w-5 h-5 text-amber-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>

                            <p class="text-xl md:text-2xl font-medium text-slate-700 leading-[1.8] italic mb-12 relative z-10">
                                "{{ item.feedback || item.comment }}"
                            </p>

                            <div class="flex items-center gap-6 pt-10 border-t border-slate-100 relative z-10">
                                <img :src="item.image || item.avatar" class="w-16 h-16 rounded-2xl object-cover shadow-lg border-2 border-white ring-4 ring-blue-500/5">
                                <div>
                                    <h4 class="text-lg font-black text-slate-900 mb-1 leading-tight">{{ item.name }}</h4>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-blue-600">
                                        {{ t('traveler_from') }} {{ (item.role || '').replace('Traveler from ', '').replace('Traveler from', '').replace('Al Mosafer from', '').replace('Mosafer from', '').trim() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <Footer />

        <SearchOverlay ref="searchOverlay" />
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

.text-gradient {
    background: linear-gradient(to right, #0f172a, #2563eb);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.btn-premium {
    @apply px-10 py-5 bg-blue-600 text-white font-black rounded-full shadow-2xl shadow-blue-500/20 hover:scale-105 active:scale-95 transition-all duration-500;
}

.btn-glass {
    @apply px-10 py-5 bg-white/10 backdrop-blur-xl border border-white/20 text-white font-black rounded-full hover:bg-white/20 transition-all duration-500;
}

.glass-nav {
    @apply fixed top-0 w-full bg-white/70 backdrop-blur-2xl border-b border-white/20 shadow-sm z-[100];
}

.glass-card {
    @apply bg-white/80 backdrop-blur-xl border border-white/40 shadow-xl p-6;
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

@keyframes slow-zoom {
    from { transform: scale(1); }
    to { transform: scale(1.15); }
}

.animate-slow-zoom {
    animation: slow-zoom 20s linear infinite alternate;
}
</style>

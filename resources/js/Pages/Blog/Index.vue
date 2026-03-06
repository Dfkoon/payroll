<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import MobileNav from '@/Components/MobileNav.vue';
import Footer from '@/Components/Footer.vue';
import RotatingText from '@/Components/RotatingText.vue';

const { props: pageProps } = usePage();
const locale = computed(() => pageProps.locale);
const t = (key) => pageProps.translations.messages[key] || key;

const props = defineProps({
    posts: Array,
});
</script>

<template>
    <Head :title="t('blog') + ' - ' + t('brand_name')" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-[#fcfdfe] text-gray-900 font-sans selection:bg-blue-500 selection:text-white pb-20 mesh-gradient">
        <!-- Navigation -->
        <nav class="fixed w-full z-50 top-0 bg-white/70 backdrop-blur-md border-b border-white/20 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center gap-3">
                        <Link :href="route('home')" class="flex items-center gap-3">
                            <div class="shrink-0 flex items-center justify-center p-2 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 shadow-lg shadow-blue-500/30">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15l-1.5 1.5M3 15C3 15 7.5 9 12 9c4.5 0 9 6 9 6l1.5-1.5M12 9V3M12 3l-3 3M12 3l3 3m-9 9a9 9 0 1018 0" />
                                </svg>
                            </div>
                            <span class="text-2xl font-black tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600">{{ t('brand_short') }}</span>
                        </Link>
                    </div>
                    
                    <div class="hidden md:flex items-center gap-8">
                        <Link :href="route('tours.index')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                            {{ t('destinations_title') }}
                        </Link>
                        <Link :href="route('blog.index')" class="text-blue-600 font-bold border-b-2 border-blue-600 transition-colors">
                            {{ t('blog') }}
                        </Link>
                    </div>

                    <div class="flex items-center gap-4">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">
                            {{ t('dashboard') }}
                        </Link>
                        <Link v-else :href="route('login')" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">{{ t('login') }}</Link>
                        <Link :href="route('language.switch', locale === 'ar' ? 'en' : 'ar')" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-black hover:bg-slate-900 hover:text-white transition-all">
                            {{ locale === 'ar' ? 'EN' : 'AR' }}
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Header -->
        <header class="pt-32 pb-12 bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
                <span class="inline-block px-5 py-2 bg-blue-600/10 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-widest mb-8 reveal-up">{{ t('blog_badge') }}</span>
                <h1 class="text-6xl md:text-9xl font-black text-slate-900 leading-[0.85] mb-12 tracking-tighter reveal-up flex flex-wrap justify-center items-center gap-x-4">
                    <span>{{ locale === 'ar' ? 'أحدث' : 'Latest' }}</span>
                    <RotatingText
                        :texts="locale === 'ar' ? ['المقالات', 'القصص', 'النصائح', 'الوجهات'] : ['Articles', 'Stories', 'Tips', 'Locations']"
                        mainClassName="px-4 py-2 bg-blue-600 text-white rounded-3xl"
                        staggerFrom="last"
                        :initial="{ y: '100%', opacity: 0 }"
                        :animate="{ y: 0, opacity: 1 }"
                        :exit="{ y: '-120%', opacity: 0 }"
                        :staggerDuration="0.025"
                        splitLevelClassName="overflow-hidden pb-1"
                        :transition="{ type: 'spring', damping: 30, stiffness: 400 }"
                        :rotationInterval="2600"
                    />
                </h1>
                <p class="text-xl text-gray-500 max-w-2xl mx-auto">{{ t('blog_subtitle') }}</p>
            </div>
        </header>

        <!-- Posts Grid -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div v-if="posts.length > 0" class="grid md:grid-cols-2 lg:grid-cols-3 gap-12">
                <article v-for="post in posts" :key="post.id" 
                         class="group bg-white rounded-[2.5rem] overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl transition-all duration-500">
                     <Link :href="route('blog.show', post.id)">
                        <div class="relative h-64 overflow-hidden">
                            <img :src="post.image_path" :alt="post.title" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </div>
                        <div :class="['p-8', locale === 'ar' ? 'text-right' : 'text-left']">
                            <span class="text-blue-600 text-xs font-black uppercase tracking-widest mb-3 block">{{ t('travel_tips') }}</span>
                            <h3 class="text-2xl font-black text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">{{ post.title }}</h3>
                            <p class="text-gray-500 leading-relaxed mb-6 line-clamp-3">{{ post.excerpt }}</p>
                            <div class="inline-flex items-center gap-2 text-blue-600 font-black hover:gap-4 transition-all">
                                {{ t('read_more') }} 
                                <svg :class="['w-4 h-4', locale === 'ar' ? 'rotate-180' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </Link>
                </article>
            </div>
            
            <!-- Empty state -->
            <div v-else class="text-center py-20">
                <p class="text-gray-500 text-xl">{{ t('no_articles') }}</p>
            </div>
        </main>
    </div>
</template>

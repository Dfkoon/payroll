<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import MobileNav from '@/Components/MobileNav.vue';

const { props: pageProps } = usePage();
const locale = computed(() => pageProps.locale);
const t = (key) => pageProps.translations.messages[key] || key;

const props = defineProps({
    post: Object,
});

onMounted(() => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
});
</script>

<template>
    <Head :title="post.title + ' - ' + t('brand_name')" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-slate-50 text-slate-900 font-sans selection:bg-blue-600 selection:text-white pb-32 md:pb-0">
        <!-- Navigation -->
        <nav class="fixed w-full z-50 top-0 glass-nav h-24 flex items-center px-8 md:px-12 border-b border-slate-100/50">
            <div class="max-w-7xl mx-auto w-full flex justify-between items-center">
                <div class="flex items-center gap-8">
                    <button @click="window.history.back()" class="flex items-center gap-2 px-6 py-2 bg-slate-900 text-white rounded-full text-xs font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-xl shadow-slate-900/20">
                        <svg :class="['w-4 h-4', locale === 'ar' ? 'rotate-180' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        {{ t('back') }}
                    </button>
                    <Link :href="route('home')" class="flex items-center gap-3">
                        <div class="shrink-0 w-10 h-10 rounded-xl premium-gradient flex items-center justify-center shadow-lg shadow-blue-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15C3 15 7.5 9 12 9c4.5 0 9 6 9 6"></path></svg>
                        </div>
                        <span class="text-xl font-black text-gradient uppercase tracking-tighter">{{ t('brand_short') }}</span>
                    </Link>
                </div>
                
                <div class="hidden md:flex items-center gap-10">
                    <Link :href="route('tours.index')" class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-colors">{{ t('destinations') }}</Link>
                    <Link :href="route('blog.index')" class="text-xs font-black uppercase tracking-widest text-slate-900 hover:text-blue-600 transition-colors underline decoration-blue-500 decoration-4 underline-offset-8">{{ t('blog') }}</Link>
                </div>

                <div class="flex items-center gap-4">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-xs font-black uppercase text-slate-900">{{ t('dashboard') }}</Link>
                    <Link v-else :href="route('login')" class="text-xs font-black uppercase text-slate-900">{{ t('login') }}</Link>
                </div>
            </div>
        </nav>

        <main class="pt-24">
            <!-- Article Header -->
            <div class="relative h-[65vh] md:h-[80vh] overflow-hidden">
                <img :src="post.image_path" :alt="post.title" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-50 via-transparent to-black/20"></div>
                <div class="absolute bottom-24 left-0 right-0 max-w-5xl mx-auto px-8 md:px-12 reveal-up">
                    <span class="px-5 py-2 glass-card !bg-blue-600 !text-white !border-none rounded-full text-[10px] font-black tracking-widest mb-8 inline-block uppercase">{{ t('travel_articles') }}</span>
                    <h1 class="text-6xl md:text-8xl font-black text-slate-900 tracking-tighter leading-[0.9] mb-10 drop-shadow-2xl">{{ post.title }}</h1>
                </div>
            </div>

            <!-- Article Content -->
            <div class="max-w-4xl mx-auto px-8 md:px-12 py-32">
                <div class="reveal-up -mt-56 relative z-10">
                    <div class="glass-card !p-12 md:!p-24 rounded-[4rem] border-white shadow-2xl shadow-blue-500/5 relative overflow-hidden">
                        <div class="absolute -top-20 -right-20 w-64 h-64 bg-blue-600/5 rounded-full blur-[100px]"></div>
                        
                        <p class="text-2xl md:text-3xl font-black text-blue-600 mb-16 leading-tight tracking-tight">{{ post.excerpt }}</p>
                        
                        <div class="prose prose-2xl prose-slate max-w-none text-slate-500 leading-relaxed font-medium space-y-10">
                            {{ post.body }}
                        </div>
                        
                        <div class="mt-24 pt-12 border-t border-slate-100/50 flex flex-col md:flex-row items-center justify-between gap-10">
                            <button @click="window.history.back()" class="flex items-center gap-3 text-slate-900 font-black text-sm uppercase tracking-widest hover:text-blue-600 group transition-all">
                                <svg class="w-6 h-6 group-hover:-translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path></svg>
                                {{ t('back_to_articles') }}
                            </button>
                            
                            <div class="flex items-center gap-6">
                                <span class="text-slate-300 font-black text-[10px] uppercase tracking-widest">{{ t('share') }}</span>
                                <div class="flex gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all cursor-pointer shadow-sm">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </div>
                                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-sky-500 hover:text-white transition-all cursor-pointer shadow-sm">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <MobileNav />
    </div>
</template>


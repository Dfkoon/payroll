<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const { props: pageProps } = usePage();
const t = (key) => pageProps.translations.messages[key] || key;
const locale = computed(() => pageProps.locale);
</script>

<template>
    <footer :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="bg-white border-t border-slate-100 pt-32 pb-12 overflow-hidden relative">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-blue-50/30 skew-x-12 translate-x-32"></div>
        
        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-20 mb-32">
                <!-- Brand Section -->
                <div class="space-y-10">
                    <Link :href="route('home')" class="flex items-center gap-4 group">
                        <div class="shrink-0 w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center shadow-2xl shadow-blue-500/20 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="text-3xl font-black tracking-tighter text-slate-900 leading-none">سلامين <span class="text-blue-600">Travel</span></span>
                    </Link>
                    <p class="text-lg text-slate-400 font-medium leading-relaxed max-w-sm">
                        {{ t('footer_description') }}
                    </p>
                    <div class="flex items-center gap-6">
                        <a v-for="i in ['facebook', 'instagram', 'twitter', 'whatsapp']" :key="i" href="#" class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white hover:scale-110 transition-all">
                            <i :class="['fab', `fa-${i}`, 'text-xl']"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-sm font-black uppercase tracking-widest text-slate-900 mb-10">{{ t('quick_links') }}</h4>
                    <ul class="space-y-6">
                        <li><Link :href="route('tours.index')" class="text-slate-400 font-bold hover:text-blue-600 transition-colors">{{ t('tours') }}</Link></li>
                        <li><Link :href="route('destinations.index')" class="text-slate-400 font-bold hover:text-blue-600 transition-colors">{{ t('destinations') }}</Link></li>
                        <li><Link :href="route('about')" class="text-slate-400 font-bold hover:text-blue-600 transition-colors">{{ t('about') }}</Link></li>
                        <li><Link :href="route('contact')" class="text-slate-400 font-bold hover:text-blue-600 transition-colors">{{ t('contact') }}</Link></li>
                    </ul>
                </div>

                <!-- Popular Categories -->
                <div>
                    <h4 class="text-sm font-black uppercase tracking-widest text-slate-900 mb-10">{{ t('exclusive_categories') }}</h4>
                    <ul class="space-y-6">
                        <li><Link href="#" class="text-slate-400 font-bold hover:text-blue-600 transition-colors">{{ t('adventure') }}</Link></li>
                        <li><Link href="#" class="text-slate-400 font-bold hover:text-blue-600 transition-colors">{{ t('cultural') }}</Link></li>
                        <li><Link href="#" class="text-slate-400 font-bold hover:text-blue-600 transition-colors">{{ t('religious') }}</Link></li>
                        <li><Link href="#" class="text-slate-400 font-bold hover:text-blue-600 transition-colors">{{ t('others') }}</Link></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="space-y-10">
                    <h4 class="text-sm font-black uppercase tracking-widest text-slate-900 mb-10">{{ t('contact') }}</h4>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="shrink-0 w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <p class="text-sm text-slate-400 font-bold leading-relaxed">{{ t('office_address') }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="shrink-0 w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <p class="text-sm text-slate-400 font-bold leading-relaxed">{{ t('phone') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-12 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-8">
                <p class="text-xs font-black text-slate-300 uppercase tracking-widest">
                    &copy; {{ new Date().getFullYear() }} {{ t('all_rights_reserved') }}
                </p>
                <div class="flex items-center gap-10">
                    <Link :href="route('terms')" class="text-xs font-black text-slate-300 uppercase tracking-widest hover:text-blue-600 transition-colors">{{ t('terms') }}</Link>
                    <Link :href="route('faq')" class="text-xs font-black text-slate-300 uppercase tracking-widest hover:text-blue-600 transition-colors">{{ t('faq') }}</Link>
                </div>
            </div>
        </div>
    </footer>
</template>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
</style>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const { props } = usePage();
const locale = computed(() => props.locale);
const t = (key) => props.translations.messages[key] || key;

const navItems = [
    { name: 'home', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', route: 'home' },
    { name: 'tours', icon: 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7', route: 'tours.index' },
    { name: 'destinations', icon: 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z', route: 'destinations.index' },
    { name: 'login', icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', route: 'login' },
];
</script>

<template>
    <div class="mobile-bottom-nav" :dir="locale === 'ar' ? 'rtl' : 'ltr'">
        <Link v-for="item in navItems" :key="item.name" :href="route(item.route)" 
              class="flex flex-col items-center gap-1 transition-all duration-300 group"
              :class="route().current(item.route) ? 'text-blue-600' : 'text-gray-400 hover:text-gray-600'">
            <div class="p-2 rounded-xl transition-all duration-300" 
                 :class="route().current(item.route) ? 'bg-blue-50' : 'group-hover:bg-gray-50'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="item.icon" />
                </svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-tighter">{{ t(item.name) }}</span>
        </Link>
    </div>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const { props } = usePage();
const locale = computed(() => props.locale);
const t = (key) => props.translations.messages[key] || key;
</script>

<template>
    <Head :title="t('dashboard')" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                :class="['text-3xl font-black leading-tight text-gray-900', locale === 'ar' ? 'text-right' : 'text-left']"
            >
                {{ t('dashboard') }}
            </h2>
        </template>

        <div class="py-12" :dir="locale === 'ar' ? 'rtl' : 'ltr'">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Welcome Stat Cards -->
                <div class="grid md:grid-cols-3 gap-6 mb-12">
                    <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm flex items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-gray-400 block">{{ t('total_bookings') }}</span>
                            <span class="text-3xl font-black text-gray-900">0</span>
                        </div>
                    </div>
                    <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm flex items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-gray-400 block">{{ t('upcoming_trips') }}</span>
                            <span class="text-3xl font-black text-gray-900">0</span>
                        </div>
                    </div>
                    <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm flex items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-gray-400 block">{{ t('account_level') }}</span>
                            <span class="text-3xl font-black text-gray-900">{{ t('bronze') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-[2.5rem] border border-gray-100">
                    <div :class="['p-12', locale === 'ar' ? 'text-right' : 'text-left']">
                        <h3 class="text-2xl font-black text-gray-900 mb-6">{{ t('welcome_back') }} {{ $page.props.auth.user.name }}! 👋</h3>
                        <p class="text-gray-500 mb-10 leading-relaxed max-w-2xl">
                            {{ t('dashboard_intro') }}
                        </p>
                        
                        <div :class="['bg-blue-50 rounded-3xl p-8 border border-blue-100 flex items-center justify-between flex-col md:flex-row gap-6', locale === 'ar' ? 'md:flex-row' : 'md:flex-row']">
                            <p class="text-blue-900 font-bold text-center md:text-right">{{ t('no_bookings_yet') }}</p>
                            <Link :href="route('tours.index')" class="px-8 py-3 bg-blue-600 text-white rounded-full font-black shadow-lg shadow-blue-500/30 hover:scale-105 transition-transform whitespace-nowrap">
                                {{ t('browse_tours') }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap');

body {
    font-family: 'Cairo', sans-serif !important;
}
</style>

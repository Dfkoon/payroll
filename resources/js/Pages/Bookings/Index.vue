<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const { props: pageProps } = usePage();
const locale = computed(() => pageProps.locale);
const t = (key) => pageProps.translations.messages[key] || key;

const props = defineProps({
    bookings: Array,
});

const getStatusClass = (status) => {
    switch (status) {
        case 'pending': return 'bg-amber-100 text-amber-700 border-amber-200';
        case 'paid': return 'bg-emerald-100 text-emerald-700 border-emerald-200';
        case 'cancelled': return 'bg-rose-100 text-rose-700 border-rose-200';
        default: return 'bg-gray-100 text-gray-700 border-gray-200';
    }
};

const getStatusLabel = (status) => {
    switch (status) {
        case 'pending': return t('status_pending');
        case 'paid': return t('status_paid');
        case 'cancelled': return t('status_cancelled');
        default: return status;
    }
};
</script>

<template>
    <Head :title="t('my_bookings')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 :class="['text-3xl font-black leading-tight text-gray-900', locale === 'ar' ? 'text-right' : 'text-left']">{{ t('booking_record') }}</h2>
        </template>

        <div class="py-12" :dir="locale === 'ar' ? 'rtl' : 'ltr'">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div v-if="bookings.length > 0" class="space-y-6">
                    <div v-for="booking in bookings" :key="booking.id" 
                         class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300">
                        <div class="flex flex-col md:flex-row">
                            <!-- Tour Image -->
                            <div class="md:w-64 h-48 md:h-auto shrink-0 relative">
                                <img :src="booking.tour.image_path" :alt="booking.tour.title" class="w-full h-full object-cover">
                            </div>

                            <!-- Details -->
                            <div :class="['p-8 flex-1 flex flex-col justify-between', locale === 'ar' ? 'text-right' : 'text-left']">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-bold text-blue-600">{{ booking.tour.category.name }}</span>
                                        <span :class="['px-4 py-1.5 rounded-full text-xs font-black border uppercase', getStatusClass(booking.status)]">
                                            {{ getStatusLabel(booking.status) }}
                                        </span>
                                    </div>
                                    <h3 class="text-2xl font-black text-gray-900 mb-2">{{ booking.tour.title }}</h3>
                                    <div class="flex flex-wrap items-center gap-6 text-gray-400 text-sm font-bold">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ t('trip_date') }} {{ booking.booking_date }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ t('price_label') }} ${{ booking.total_amount }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-6 pt-6 border-t border-gray-50 flex items-center justify-between">
                                    <Link :href="route('tours.show', booking.tour.id)" class="text-gray-400 hover:text-blue-600 font-bold text-sm transition-colors">
                                        {{ t('view_tour_details') }}
                                    </Link>
                                    
                                    <Link v-if="booking.status === 'pending'" :href="route('bookings.checkout', booking.id)" 
                                          class="px-8 py-2.5 bg-blue-600 text-white rounded-full font-black shadow-lg shadow-blue-500/30 hover:scale-105 transition-transform text-sm">
                                        {{ t('complete_payment') }}
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div class="bg-white rounded-[2.5rem] p-20 text-center border border-gray-100 shadow-sm">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-blue-50 text-blue-600 mb-8">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-2">{{ t('no_bookings_title') }}</h3>
                    <p class="text-gray-500 mb-8">{{ t('no_bookings_subtitle') }}</p>
                    <Link :href="route('tours.index')" class="inline-block px-10 py-4 bg-blue-600 text-white rounded-full font-black shadow-xl shadow-blue-500/30 hover:scale-105 transition-transform text-lg">
                        {{ t('browse_tours') }}
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

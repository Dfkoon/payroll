<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const isOpen = ref(false);
const searchQuery = ref('');

const toggle = () => isOpen.value = !isOpen.value;

defineExpose({ toggle });
</script>

<template>
    <div v-if="isOpen" class="fixed inset-0 z-[100] bg-white/95 backdrop-blur-2xl flex flex-col p-10 md:p-20 overflow-y-auto animate-in fade-in duration-500">
        <button @click="toggle" class="absolute top-10 left-10 w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="max-w-5xl mx-auto w-full text-right mt-20">
            <h2 class="text-4xl font-black text-gray-400 mb-8 uppercase tracking-widest">ابحث عن مغامرتك القادمة</h2>
            <div class="relative group">
                <input v-model="searchQuery" type="text" autoFocus
                       class="w-full bg-transparent border-b-4 border-gray-100 py-10 text-5xl md:text-7xl font-black focus:border-blue-600 focus:ring-0 transition-all outline-none placeholder:text-gray-100"
                       placeholder="إلى أين تريد الذهاب؟">
                <div class="absolute bottom-0 right-0 h-1 bg-blue-600 w-0 group-focus-within:w-full transition-all duration-700"></div>
            </div>

            <div class="grid md:grid-cols-2 gap-20 mt-32">
                <div>
                    <h3 class="text-xl font-black text-gray-900 mb-8 border-r-4 border-blue-600 pr-4">وجهات شائعة</h3>
                    <ul class="space-y-6">
                        <li><Link :href="route('destinations.show', 'petra')" class="text-3xl font-bold text-gray-400 hover:text-blue-600 transition-colors">البتراء</Link></li>
                        <li><Link :href="route('destinations.show', 'wadi-rum')" class="text-3xl font-bold text-gray-400 hover:text-blue-600 transition-colors">وادي رم</Link></li>
                        <li><Link :href="route('destinations.show', 'dead-sea')" class="text-3xl font-bold text-gray-400 hover:text-blue-600 transition-colors">البحر الميت</Link></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-black text-gray-900 mb-8 border-r-4 border-indigo-600 pr-4">تصنيفات الجولات</h3>
                    <ul class="space-y-6">
                        <li><Link :href="route('tours.index', { type: 'private' })" class="text-3xl font-bold text-gray-400 hover:text-indigo-600 transition-colors">جولات خاصة</Link></li>
                        <li><Link :href="route('tours.index', { type: 'group' })" class="text-3xl font-bold text-gray-400 hover:text-indigo-600 transition-colors">رحلات جماعية</Link></li>
                        <li><Link :href="route('tours.index', { type: 'package' })" class="text-3xl font-bold text-gray-400 hover:text-indigo-600 transition-colors">باقات كاملة</Link></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

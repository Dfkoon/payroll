<script setup>
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const showMessage = ref(false);
const isVisible = ref(false);
const { props } = usePage();
const locale = ref(props.auth?.user?.locale || 'ar');

onMounted(() => {
    // Show button after 2 seconds
    setTimeout(() => {
        isVisible.value = true;
    }, 2000);

    // Show message bubble after 5 seconds
    setTimeout(() => {
        showMessage.value = true;
    }, 5000);

    // Auto-hide message bubble after 10 seconds
    setTimeout(() => {
        showMessage.value = false;
    }, 15000);
});

const whatsappNumber = '+962XXXXXXXXX'; // Replace with real number
const message = locale.value === 'ar' ? 'مرحباً، أود الاستفسار عن الرحلات السياحية.' : 'Hello, I would like to inquire about tour packages.';
const whatsappUrl = `https://wa.me/${whatsappNumber.replace('+', '')}?text=${encodeURIComponent(message)}`;
</script>

<template>
    <div :class="[
        'fixed bottom-24 md:bottom-10 z-[60] transition-all duration-1000 transform',
        isVisible ? 'translate-y-0 opacity-100' : 'translate-y-20 opacity-0',
        locale === 'ar' ? 'left-6 md:left-10' : 'right-6 md:right-10'
    ]">
        <!-- Message Bubble -->
        <div :class="[
            'absolute bottom-full mb-4 w-48 p-4 bg-white rounded-2xl shadow-2xl border border-slate-100 transition-all duration-500 transform origin-bottom',
            showMessage ? 'scale-100 opacity-100 translate-y-0' : 'scale-0 opacity-0 translate-y-10',
            locale === 'ar' ? 'left-0' : 'right-0'
        ]">
            <p class="text-xs font-bold text-slate-800 leading-relaxed">
                {{ locale === 'ar' ? 'مرحباً! هل لديك أي استفسار عن رحلاتنا؟' : 'Hi! Do you have any questions about our trips?' }}
            </p>
            <!-- Tiny Arrow -->
            <div :class="[
                'absolute -bottom-2 w-4 h-4 bg-white border-r border-b border-slate-100 rotate-45',
                locale === 'ar' ? 'left-6' : 'right-6'
            ]"></div>
        </div>

        <!-- WhatsApp Button -->
        <a :href="whatsappUrl" target="_blank" 
           class="group relative flex items-center justify-center w-14 h-14 md:w-16 md:h-16 bg-[#25D366] text-white rounded-full shadow-[0_20px_40px_rgba(37,211,102,0.4)] hover:shadow-[0_25px_50px_rgba(37,211,102,0.6)] hover:-translate-y-2 transition-all duration-500 overflow-hidden">
            
            <!-- Pulse Effect -->
            <div class="absolute inset-0 bg-white/20 rounded-full animate-ping opacity-20 group-hover:opacity-40"></div>
            
            <!-- Icon -->
            <svg class="w-8 h-8 md:w-10 md:h-10 relative z-10" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.445 0 .081 5.363.079 11.969c0 2.112.551 4.174 1.597 6.01L0 24l6.16-1.616a11.82 11.82 0 005.887 1.565h.005c6.608 0 11.974-5.366 11.976-11.974a11.859 11.859 0 00-3.511-8.455z"/>
            </svg>
        </a>
    </div>
</template>

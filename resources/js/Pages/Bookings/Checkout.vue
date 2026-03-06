<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import MobileNav from '@/Components/MobileNav.vue';

const { props } = usePage();
const booking = computed(() => props.booking);
const locale = computed(() => props.locale);
const t = (key) => props.translations.messages[key] || key;

const currentStep = ref(1);
const selectedCategory = ref('4');

const priceMultipliers = {
    '3': 1.0,
    '4': 1.2,
    '5': 1.5,
};

const totalPrice = computed(() => {
    return (booking.value.tour.price * priceMultipliers[selectedCategory.value]).toFixed(2);
});

const form = useForm({
    hotel_category: selectedCategory.value,
});

const nextStep = () => {
    if (currentStep.value < 3) currentStep.value++;
};

const prevStep = () => {
    if (currentStep.value > 1) currentStep.value--;
};

const submit = () => {
    form.hotel_category = selectedCategory.value;
    form.post(route('bookings.confirm', booking.value.id));
};

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
    <Head :title="t('checkout_title') + ' - Salamein'" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-slate-50 selection:bg-blue-600 selection:text-white pb-32">
        <!-- Progress Navbar -->
        <nav class="fixed top-0 left-0 right-0 z-50 px-6 py-8">
            <div class="max-w-7xl mx-auto flex justify-between items-center glass-card p-6 rounded-[2.5rem] border-white/40 shadow-2xl">
                <Link :href="route('home')" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl premium-gradient flex items-center justify-center text-white shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15C3 15 7.5 9 12 9c4.5 0 9 6 9 6"></path></svg>
                    </div>
                </Link>
                
                <div class="flex items-center gap-8">
                    <div v-for="step in 3" :key="step" class="flex items-center gap-3">
                        <div :class="[
                            'w-8 h-8 rounded-full flex items-center justify-center font-black text-xs transition-all duration-500',
                            currentStep >= step ? 'bg-blue-600 text-white scale-110 shadow-lg shadow-blue-500/30' : 'bg-slate-200 text-slate-400'
                        ]">
                            {{ step }}
                        </div>
                        <span v-if="currentStep === step" :class="['hidden md:block font-black text-xs uppercase tracking-widest text-slate-900 animate-fade-in']">
                            {{ t('checkout_step_' + step) }}
                        </span>
                    </div>
                </div>

                <div class="w-10"></div> <!-- Spacer -->
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-6 pt-48">
            <div class="grid lg:grid-cols-3 gap-16">
                <!-- Left Content: Multi-step Forms -->
                <div class="lg:col-span-2">
                    
                    <!-- Step 1: Summary -->
                    <div v-if="currentStep === 1" class="reveal-up space-y-12">
                        <h1 class="text-5xl font-black text-gradient tracking-tighter">{{ t('checkout_step_1') }}</h1>
                        <div class="glass-card p-10 rounded-[3.5rem] border-white shadow-2xl flex flex-col md:flex-row gap-10 items-center">
                            <img :src="booking.tour.image_path" class="w-48 h-48 rounded-[2.5rem] object-cover shadow-2xl border-4 border-white">
                            <div class="text-center md:text-start">
                                <span class="px-4 py-1.5 bg-blue-50 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-widest">{{ booking.tour.category.name }}</span>
                                <h2 class="text-3xl font-black text-slate-900 mt-4 mb-2 tracking-tighter">{{ booking.tour.title }}</h2>
                                <p class="text-slate-400 font-bold mb-6 flex items-center justify-center md:justify-start gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ booking.booking_date }}
                                </p>
                                <button @click="nextStep" class="btn-premium !py-4 !px-10">{{ t('continue_to_options') }}</button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Hotel Selection -->
                    <div v-if="currentStep === 2" class="reveal-up space-y-12">
                        <h1 class="text-5xl font-black text-gradient tracking-tighter">{{ t('checkout_step_2') }}</h1>
                        <div class="grid md:grid-cols-3 gap-8">
                            <button v-for="stars in ['3', '4', '5']" :key="stars"
                                    @click="selectedCategory = stars"
                                    :class="[
                                        'p-10 rounded-[3rem] border-2 transition-all duration-500 text-center group relative overflow-hidden',
                                        selectedCategory === stars ? 'border-blue-600 bg-white shadow-2xl' : 'border-white bg-white/50 hover:bg-white hover:shadow-xl'
                                    ]"
                            >
                                <div class="flex flex-col items-center">
                                    <div class="flex gap-1 mb-6 text-amber-400 group-hover:scale-110 transition-transform">
                                        <svg v-for="i in parseInt(stars)" :key="i" class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    </div>
                                    <span class="text-2xl font-black text-slate-900 mb-2">{{ stars }} {{ t('stars') }}</span>
                                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-6">
                                        {{ stars === '3' ? t('hotel_economy') : stars === '4' ? t('hotel_premium') : t('hotel_luxury') }}
                                    </p>
                                    <div :class="['w-8 h-8 rounded-full border-4 transition-all duration-500', selectedCategory === stars ? 'border-blue-600 bg-blue-600 shadow-lg shadow-blue-500/50' : 'border-slate-100 bg-white']"></div>
                                </div>
                            </button>
                        </div>
                        <div class="flex justify-between items-center pt-8">
                            <button @click="prevStep" class="text-slate-400 font-black text-sm uppercase tracking-widest hover:text-blue-600">{{ t('back') }}</button>
                            <button @click="nextStep" class="btn-premium !py-5 !px-14">{{ t('proceed_to_payment') }}</button>
                        </div>
                    </div>

                    <!-- Step 3: Payment Mock -->
                    <div v-if="currentStep === 3" class="reveal-up space-y-12">
                        <h1 class="text-5xl font-black text-gradient tracking-tighter">{{ t('checkout_step_3') }}</h1>
                        <div class="glass-card p-12 rounded-[3.5rem] border-blue-100 shadow-2xl">
                            <div class="flex items-center justify-between mb-12">
                                <div class="flex items-center gap-6">
                                    <div class="w-20 h-12 bg-white rounded-xl border border-slate-100 flex items-center justify-center p-3 shadow-sm">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" class="h-full">
                                    </div>
                                    <h3 class="text-2xl font-black text-slate-900">{{ t('credit_card') }}</h3>
                                </div>
                                <div class="px-5 py-2 bg-green-50 text-green-600 rounded-full font-black text-[10px] uppercase tracking-widest">{{ t('secure_payment_msg') }}</div>
                            </div>

                            <div class="space-y-6 opacity-40 grayscale pointer-events-none mb-12">
                                <div class="h-16 bg-slate-100 rounded-2xl w-full"></div>
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="h-16 bg-slate-100 rounded-2xl"></div>
                                    <div class="h-16 bg-slate-100 rounded-2xl"></div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-8">
                                <button @click="prevStep" class="text-slate-400 font-black text-sm uppercase tracking-widest hover:text-blue-600">{{ t('back') }}</button>
                                <button @click="submit" class="btn-premium !py-6 !px-20 text-lg">
                                    {{ t('confirm_payment') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar: Order Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-48">
                        <div class="glass-card p-10 rounded-[3rem] border-white/60 shadow-2xl relative overflow-hidden reveal-up">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-600/5 rounded-full blur-3xl"></div>
                            
                            <h3 class="text-2xl font-black text-slate-900 mb-10 tracking-tighter">{{ t('price_summary') }}</h3>
                            
                            <div class="space-y-6 mb-10">
                                <div class="flex justify-between text-slate-400 font-black text-xs uppercase tracking-widest">
                                    <span>{{ t('base_price') }}</span>
                                    <span class="text-slate-900">${{ Math.floor(booking.tour.price) }}</span>
                                </div>
                                <div class="flex justify-between text-slate-400 font-black text-xs uppercase tracking-widest">
                                    <span>{{ t('hotel_upgrade') }} ({{ selectedCategory }}*)</span>
                                    <span class="text-blue-600">+ {{ ((priceMultipliers[selectedCategory] - 1) * 100).toFixed(0) }}%</span>
                                </div>
                                <div class="pt-8 border-t border-slate-100 flex justify-between items-center mt-8">
                                    <span class="text-xl font-black text-slate-900 tracking-tighter">{{ t('total_amount') }}</span>
                                    <span class="text-5xl font-black text-blue-600 tracking-tighter">${{ Math.floor(totalPrice) }}</span>
                                </div>
                            </div>

                            <div class="flex flex-col items-center gap-6 py-8 px-6 bg-slate-50/50 rounded-[2rem] border border-slate-100/50">
                                <span class="text-[10px] font-black text-slate-300 uppercase underline decoration-blue-500/30">{{ t('secure_payment_msg') }}</span>
                                <div class="flex gap-4 grayscale opacity-30">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-4">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-4">
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


<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Footer from '@/Components/Footer.vue';
import MobileNav from '@/Components/MobileNav.vue';
import RotatingText from '@/Components/RotatingText.vue';

const { props: pageProps } = usePage();
const locale = computed(() => pageProps.locale);
const t = (key) => pageProps.translations.messages[key] || key;

const messageSent = ref(false);
const form = ref({
    name: '',
    email: '',
    phone: '',
    subject: 'General Inquiry',
    message: '',
    method: 'whatsapp'
});

const submit = () => {
    // In a real app, you'd use Inertia post here
    messageSent.value = true;
};
</script>

<template>
    <Head :title="t('contact') + ' - ' + t('brand_name')" />

    <div :dir="locale === 'ar' ? 'rtl' : 'ltr'" class="min-h-screen bg-[#f8fafc] text-slate-900 font-sans selection:bg-blue-600 selection:text-white pb-20 mesh-gradient">
        <!-- Luxury Navigation -->
        <nav class="fixed w-full z-[100] top-0 bg-white/70 backdrop-blur-2xl border-b border-slate-100 shadow-sm transition-all duration-500">
            <div class="max-w-7xl mx-auto px-6 md:px-12">
                <div class="flex justify-between items-center h-24 md:h-28">
                    <Link :href="route('home')" class="flex items-center gap-4 transition-transform hover:scale-105 group">
                        <div class="shrink-0 flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 shadow-xl shadow-blue-500/20 group-hover:rotate-6 transition-transform">
                            <svg class="w-7 h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="text-3xl md:text-4xl font-black tracking-tighter text-slate-900 leading-none">
                            {{ t('brand_short') }} <span class="text-blue-600">Travel</span>
                        </span>
                    </Link>
                </div>
            </div>
        </nav>

        <main class="pt-40 md:pt-60 pb-32 relative overflow-hidden">
            <!-- Background Decorative Orbs -->
            <div class="absolute top-0 right-0 w-[60rem] h-[60rem] bg-blue-600/5 rounded-full blur-[150px] -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-[50rem] h-[50rem] bg-indigo-600/5 rounded-full blur-[120px] translate-y-1/2 -translate-x-1/2"></div>

            <div class="max-w-7xl mx-auto px-6 md:px-12 relative z-10">
                <!-- Unified Grid Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 md:gap-24 items-start">
                    
                    <!-- Left Column: Header & Info -->
                    <div class="lg:col-span-12 xl:col-span-5 space-y-16">
                        <div class="text-center xl:text-right space-y-8">
                            <span class="inline-block px-6 py-2 bg-blue-600 text-white rounded-2xl text-[10px] md:text-xs font-black uppercase tracking-[0.2em] shadow-xl animate-fade-in reveal-up">
                                {{ t('contact_badge') || (locale === 'ar' ? 'تواصل مباشر' : 'Direct Contact') }}
                            </span>
                            <h1 class="text-7xl md:text-[10rem] font-black text-slate-900 leading-[0.8] tracking-tighter reveal-up">
                                {{ locale === 'ar' ? 'تواصل' : 'Contact' }}
                                <span class="block text-blue-600 mt-2">{{ locale === 'ar' ? 'معنا' : 'Us' }}</span>
                            </h1>
                            <p class="text-xl md:text-2xl text-slate-500 font-medium leading-relaxed max-w-2xl mx-auto xl:mr-0 reveal-up">
                                {{ t('contact_description') }}
                            </p>
                        </div>

                        <!-- Contact Cards Grouped -->
                        <div class="grid gap-6 md:gap-8 reveal-up">
                            <div class="flex items-center gap-6 md:gap-8 group glass-card !p-8 md:!p-10 rounded-[3rem] md:rounded-[4rem] border-white/60 shadow-2xl shadow-blue-500/5 hover:shadow-blue-500/15 hover:-translate-y-2 transition-all duration-700 bg-white/40">
                                <div class="w-16 h-16 md:w-20 md:h-20 shrink-0 rounded-[2rem] md:rounded-[2.5rem] bg-blue-600 text-white flex items-center justify-center shadow-2xl shadow-blue-500/30 group-hover:scale-110 transition-transform duration-500">
                                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div class="space-y-1">
                                    <span class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em]">{{ t('call_us') }}</span>
                                    <span class="text-2xl md:text-4xl font-black text-slate-900 tracking-tighter" dir="ltr">+962 7000 0000</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-6 md:gap-8 group glass-card !p-8 md:!p-10 rounded-[3rem] md:rounded-[4rem] border-white/60 shadow-2xl shadow-indigo-500/5 hover:shadow-indigo-500/15 hover:-translate-y-2 transition-all duration-700 bg-white/40">
                                <div class="w-16 h-16 md:w-20 md:h-20 shrink-0 rounded-[2rem] md:rounded-[2.5rem] bg-indigo-600 text-white flex items-center justify-center shadow-2xl shadow-indigo-500/30 group-hover:scale-110 transition-transform duration-500">
                                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="space-y-1">
                                    <span class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em]">{{ t('email_us') }}</span>
                                    <span class="text-2xl md:text-4xl font-black text-slate-900 tracking-tighter">info@jsalamein.com</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-6 md:gap-8 group glass-card !p-8 md:!p-10 rounded-[3rem] md:rounded-[4rem] border-white/60 shadow-2xl shadow-amber-500/5 hover:shadow-amber-500/15 hover:-translate-y-2 transition-all duration-700 bg-white/40">
                                <div class="w-16 h-16 md:w-20 md:h-20 shrink-0 rounded-[2rem] md:rounded-[2.5rem] bg-amber-500 text-white flex items-center justify-center shadow-2xl shadow-amber-500/30 group-hover:scale-110 transition-transform duration-500">
                                    <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div class="space-y-1">
                                    <span class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em]">{{ t('main_office') }}</span>
                                    <span class="text-2xl md:text-4xl font-black text-slate-900 tracking-tighter">{{ t('amman_jordan') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Enhanced Contact Form -->
                    <div class="lg:col-span-12 xl:col-span-7 reveal-up">
                        <div class="bg-white/70 backdrop-blur-3xl rounded-[4rem] md:rounded-[6rem] p-10 md:p-20 border border-white shadow-[0_100px_150px_-30px_rgba(37,99,235,0.12)] relative overflow-hidden group">
                            <!-- Background Shine -->
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
                            
                            <div v-if="!messageSent" class="relative z-10">
                                <form @submit.prevent="submit" class="space-y-12">
                                    <div class="grid md:grid-cols-2 gap-10">
                                        <div class="space-y-4">
                                            <label class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em] px-2">{{ t('full_name') }}</label>
                                            <input v-model="form.name" type="text" required class="w-full px-10 py-6 rounded-3xl border-none bg-slate-100 focus:bg-white focus:ring-[6px] focus:ring-blue-500/10 transition-all font-black text-slate-900 placeholder:text-slate-300" :placeholder="t('name_placeholder')">
                                        </div>
                                        <div class="space-y-4">
                                            <label class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em] px-2 flex justify-between">
                                                {{ t('email_address') }}
                                                <span class="text-blue-400 font-bold lowercase text-[10px]">{{ t('optional') }}</span>
                                            </label>
                                            <input v-model="form.email" type="email" class="w-full px-10 py-6 rounded-3xl border-none bg-slate-100 focus:bg-white focus:ring-[6px] focus:ring-blue-500/10 transition-all font-black text-slate-900 placeholder:text-slate-300" placeholder="mail@example.com">
                                        </div>
                                    </div>

                                    <div class="grid md:grid-cols-2 gap-10">
                                        <div class="space-y-4">
                                            <label class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em] px-2">{{ t('phone_number') }}</label>
                                            <input v-model="form.phone" type="tel" required class="w-full px-10 py-6 rounded-3xl border-none bg-slate-100 focus:bg-white focus:ring-[6px] focus:ring-blue-500/10 transition-all font-black text-slate-900 placeholder:text-slate-300" placeholder="+962 7XXX XXXX">
                                        </div>
                                        <div class="space-y-4">
                                            <label class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em] px-2">{{ t('subject') }}</label>
                                            <div class="relative">
                                                <select v-model="form.subject" class="w-full px-10 py-6 rounded-3xl border-none bg-slate-100 focus:bg-white focus:ring-[6px] focus:ring-blue-500/10 transition-all font-black text-slate-900 appearance-none cursor-pointer">
                                                    <option value="General Inquiry">{{ t('subject_general') }}</option>
                                                    <option value="Private Tour">{{ t('subject_private') }}</option>
                                                    <option value="Website Issue">{{ t('subject_issue') }}</option>
                                                    <option value="Other">{{ t('others') }}</option>
                                                </select>
                                                <svg class="absolute left-8 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-6">
                                        <label class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em] px-2">{{ t('preferred_contact_method') }}</label>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <label v-for="m in ['whatsapp', 'sms', 'call']" :key="m" 
                                                   :class="['cursor-pointer flex flex-col items-center gap-4 p-8 rounded-3xl border-4 transition-all duration-500', form.method === m ? 'border-blue-600 bg-blue-600 shadow-2xl shadow-blue-500/40' : 'border-transparent bg-slate-100 text-slate-400 hover:bg-slate-200 hover:text-slate-600']">
                                                <input type="radio" v-model="form.method" :value="m" class="hidden">
                                                <div :class="['w-16 h-16 rounded-2xl flex items-center justify-center transition-all duration-500 shadow-xl shadow-black/5', form.method === m ? 'bg-white text-blue-600 group-hover:scale-110' : 'bg-white text-slate-400']">
                                                    <svg v-if="m === 'whatsapp'" class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                                    <svg v-else-if="m === 'sms'" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012-2H9l-3 3v8a2 2 0 01-2 2z"></path></svg>
                                                    <svg v-else class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                </div>
                                                <span :class="['text-[10px] md:text-xs font-black uppercase tracking-widest transition-colors duration-500', form.method === m ? 'text-white' : 'text-slate-400']">
                                                    {{ t('contact_method_' + m) }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <label class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em] px-2">{{ t('message') }}</label>
                                        <textarea v-model="form.message" required rows="6" class="w-full px-10 py-8 rounded-[3rem] border-none bg-slate-100 focus:bg-white focus:ring-[6px] focus:ring-blue-500/10 transition-all font-black text-slate-900 placeholder:text-slate-300 min-h-[15rem]" :placeholder="t('message_placeholder')"></textarea>
                                    </div>

                                    <button type="submit" class="w-full py-8 md:py-10 bg-blue-600 text-white rounded-[3rem] md:rounded-[4rem] font-black text-2xl md:text-3xl shadow-2xl shadow-blue-500/40 hover:scale-[1.02] active:scale-95 transition-all duration-500">
                                        {{ t('send_message') }} 🚀
                                    </button>
                                </form>
                            </div>
                            <div v-else class="text-center py-20 relative z-10">
                                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full bg-emerald-500 text-white flex items-center justify-center mx-auto mb-10 shadow-2xl shadow-emerald-500/20">
                                    <svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <h3 class="text-5xl md:text-7xl font-black text-slate-900 mb-6 tracking-tighter">{{ t('success_sent') }}</h3>
                                <p class="text-2xl md:text-3xl text-slate-400 font-bold mb-16 max-w-lg mx-auto leading-relaxed">{{ t('success_msg') }}</p>
                                <button @click="messageSent = false" class="px-12 py-5 bg-slate-900 text-white rounded-full font-black text-xs md:text-sm uppercase tracking-[0.2em] hover:bg-blue-600 transition-all duration-500 shadow-2xl">
                                    {{ t('send_another') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <Footer />
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap');
.font-sans {
    font-family: 'Cairo', sans-serif !important;
}

.glass-card {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
}
</style>

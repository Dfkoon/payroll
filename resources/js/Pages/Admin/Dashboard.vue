<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

const { props } = usePage();
const stats = computed(() => props.stats);

onMounted(() => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal-up').forEach(el => observer.observe(el));
});

const formatCurrency = (val) => new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(val);
</script>

<template>
    <Head title="Admin Control Center - Salamein" />

    <div class="min-h-screen bg-[#0a0a0a] text-white selection:bg-blue-600/30 font-sans p-8 lg:p-12 overflow-x-hidden">
        <!-- Dashboard Header -->
        <header class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-8 mb-20 reveal-up">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-1 px-4 bg-blue-600 rounded-full"></div>
                    <span class="text-blue-500 font-black text-xs uppercase tracking-widest">Global Control Center</span>
                </div>
                <h1 class="text-6xl font-black tracking-tighter leading-none mb-4">Salamein <span class="text-blue-600">Travel</span> Admin</h1>
                <p class="text-slate-500 font-bold max-w-xl leading-relaxed">System Status: <span class="text-green-500">OPTIMAL</span> • Real-time traffic monitoring active.</p>
            </div>
            
            <Link :href="route('home')" class="flex items-center gap-4 bg-white/5 border border-white/10 hover:bg-white/10 px-8 py-4 rounded-3xl transition-all group">
                <span class="text-sm font-black uppercase tracking-widest text-slate-300 group-hover:text-white transition-colors">Go to Website</span>
                <svg class="w-5 h-5 text-blue-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </Link>
        </header>

        <main class="max-w-7xl mx-auto space-y-20">
            <!-- Grid Layout Section -->
            <div class="grid lg:grid-cols-4 gap-8">
                <!-- Stat Cards -->
                <div v-for="(val, label) in { 'Total Revenue': formatCurrency(stats.total_revenue), 'Active Bookings': stats.bookings_count, 'Total Tours': stats.tours_count, 'Customers': stats.users_count }" :key="label" 
                     class="glass-card-dark p-8 rounded-[2.5rem] border-white/5 reveal-up hover:scale-105 transition-all duration-700 group cursor-default">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-6 block group-hover:text-blue-500 transition-colors">{{ label }}</span>
                    <div class="text-4xl font-black tracking-tighter text-white mb-2">{{ val }}</div>
                    <div class="flex items-center gap-2 text-xs font-bold text-green-500/80">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        <span>+12.5% this month</span>
                    </div>
                </div>
            </div>

            <!-- Management Sections Hub -->
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Navigation Hub -->
                <div class="lg:col-span-1 space-y-8">
                    <h3 class="text-2xl font-black tracking-tighter text-slate-400 mb-10 px-2">Management Modules</h3>
                    <nav class="space-y-4">
                        <Link :href="route('admin.tours.index')" class="management-link reveal-up group">
                            <div class="icon-box"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                            <div class="flex flex-col">
                                <span class="title">Manage Tours</span>
                                <span class="desc">Pricing, itineraries & images</span>
                            </div>
                        </Link>
                        <Link :href="route('admin.bookings.index')" class="management-link reveal-up group" style="transition-delay: 100ms">
                            <div class="icon-box"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div>
                            <div class="flex flex-col">
                                <span class="title">Bookings Tracker</span>
                                <span class="desc">Orders, statuses & users</span>
                            </div>
                        </Link>
                        <Link :href="route('admin.blog.index')" class="management-link reveal-up group" style="transition-delay: 200ms">
                            <div class="icon-box"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM15 4v4h4"/></svg></div>
                            <div class="flex flex-col">
                                <span class="title">Blog & Content</span>
                                <span class="desc">Write articles & news</span>
                            </div>
                        </Link>
                    </nav>
                </div>

                <!-- Recent Activity -->
                <div class="lg:col-span-2">
                    <div class="glass-card-dark p-12 rounded-[3.5rem] border-white/5 reveal-up h-full">
                        <div class="flex justify-between items-center mb-12">
                            <h3 class="text-3xl font-black tracking-tighter">Live Bookings</h3>
                            <Link :href="route('admin.bookings.index')" class="text-xs font-black uppercase tracking-widest text-blue-500 underline decoration-blue-500/30 hover:text-white transition-colors">View All</Link>
                        </div>
                        
                        <div class="space-y-6">
                            <div v-for="booking in stats.recent_bookings" :key="booking.id" class="flex items-center justify-between p-6 bg-white/5 rounded-3xl border border-white/5 hover:border-blue-500/30 transition-all duration-500">
                                <div class="flex items-center gap-6">
                                    <div class="w-14 h-14 rounded-2xl bg-blue-600/20 flex items-center justify-center text-blue-500 font-black">
                                        {{ booking.user.name.charAt(0) }}
                                    </div>
                                    <div>
                                        <h4 class="font-black text-white text-lg tracking-tight">{{ booking.tour.title }}</h4>
                                        <p class="text-slate-500 font-bold text-sm">{{ booking.user.email }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-black text-blue-500 mb-1">${{ Math.floor(booking.total_amount) }}</div>
                                    <span :class="[
                                        'text-[9px] font-black uppercase tracking-widest px-3 py-1 rounded-full',
                                        booking.status === 'confirmed' ? 'bg-green-500/10 text-green-500' : 'bg-amber-500/10 text-amber-500'
                                    ]">{{ booking.status }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>
.glass-card-dark {
    background: rgba(255, 255, 255, 0.02);
    backdrop-filter: blur(40px);
    -webkit-backdrop-filter: blur(40px);
}

.management-link {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 2rem;
    transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
}

.management-link:hover {
    background: rgba(37, 99, 235, 0.1);
    border-color: rgba(37, 99, 235, 0.3);
    transform: translateX(10px);
}

.management-link .icon-box {
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 1.25rem;
    background: rgba(255, 255, 255, 0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #475569;
    transition: all 0.4s ease;
}

.management-link:hover .icon-box {
    background: #2563eb;
    color: white;
    box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
}

.management-link .title {
    font-size: 1.125rem;
    font-weight: 900;
    letter-spacing: -0.025em;
    color: #f8fafc;
}

.management-link .desc {
    font-size: 0.75rem;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.reveal-up {
    opacity: 0;
    transform: translateY(30px);
    transition: all 1s cubic-bezier(0.23, 1, 0.32, 1);
}

.reveal-up.active {
    opacity: 1;
    transform: translateY(0);
}

.text-gradient {
    background: linear-gradient(to right, #fff, #475569);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>

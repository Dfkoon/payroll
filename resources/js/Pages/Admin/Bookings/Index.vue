<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

const { props } = usePage();
const bookings = computed(() => props.bookings);
const stats = computed(() => props.stats);

const form = useForm({
    status: '',
});

const updateStatus = (booking, newStatus) => {
    form.status = newStatus;
    form.patch(route('admin.bookings.update', booking.id), {
        preserveScroll: true
    });
};

const deleteBooking = (id) => {
    if (confirm('Permanently remove this booking record?')) {
        form.delete(route('admin.bookings.destroy', id), {
            preserveScroll: true
        });
    }
};

const formatCurrency = (val) => new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(val);

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
    <Head title="Booking Tracker - Salamein Admin" />

    <div class="min-h-screen bg-[#0a0a0a] text-white selection:bg-blue-600/30 font-sans p-8 lg:p-12">
        <header class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-8 mb-16 reveal-up">
            <div>
                <Link :href="route('admin.dashboard')" class="text-blue-500 font-black text-xs uppercase tracking-widest mb-4 flex items-center gap-2 group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Dashboard Root
                </Link>
                <h1 class="text-5xl font-black tracking-tighter">Reservation <span class="text-blue-600">Pulse</span></h1>
            </div>
            
            <div class="flex gap-4">
                <div v-for="(val, label) in { 'Confirmed': stats.confirmed, 'Pending': stats.pending, 'Revenue': formatCurrency(stats.revenue) }" :key="label" class="bg-white/5 border border-white/5 px-6 py-4 rounded-3xl">
                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-500 block mb-1">{{ label }}</span>
                    <span class="text-xl font-black text-white">{{ val }}</span>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto">
            <div class="glass-card-dark rounded-[3rem] border-white/5 overflow-hidden reveal-up">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-white/5">
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-slate-500">Customer & Tour</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-slate-500 text-center">Date</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-slate-500 text-center">Total</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-slate-500 text-center">Status</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-slate-500 text-right">Control</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <tr v-for="booking in bookings" :key="booking.id" class="hover:bg-white/[0.02] transition-colors group">
                            <td class="p-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center font-black text-white shadow-lg overflow-hidden shrink-0">
                                        {{ booking.user.name.charAt(0) }}
                                    </div>
                                    <div>
                                        <h3 class="font-black text-white tracking-tight text-lg mb-1">{{ booking.tour.title }}</h3>
                                        <p class="text-slate-500 font-bold text-xs uppercase tracking-widest">{{ booking.user.name }} • {{ booking.user.email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-8 text-center text-slate-400 font-bold text-sm">{{ booking.booking_date }}</td>
                            <td class="p-8 text-center">
                                <span class="text-xl font-black text-blue-500 tracking-tighter">${{ Math.floor(booking.total_amount) }}</span>
                            </td>
                            <td class="p-8 text-center">
                                <select 
                                    @change="(e) => updateStatus(booking, e.target.value)"
                                    :value="booking.status"
                                    :class="[
                                        'px-4 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest border-2 transition-all cursor-pointer',
                                        booking.status === 'confirmed' ? 'border-green-500/30 bg-green-500/5 text-green-500' : 
                                        booking.status === 'cancelled' ? 'border-red-500/30 bg-red-500/5 text-red-500' : 
                                        'border-amber-500/30 bg-amber-500/5 text-amber-500'
                                    ]"
                                >
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </td>
                            <td class="p-8 text-right">
                                <button @click="deleteBooking(booking.id)" class="w-12 h-12 bg-red-500/10 hover:bg-red-500/20 rounded-xl flex items-center justify-center text-red-500/50 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</template>

<style scoped>
.glass-card-dark {
    background: rgba(255, 255, 255, 0.02);
    backdrop-filter: blur(40px);
    -webkit-backdrop-filter: blur(40px);
    border: 1px solid rgba(255, 255, 255, 0.05);
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

select {
    appearance: none;
    -webkit-appearance: none;
}

select:focus {
    outline: none;
}
</style>

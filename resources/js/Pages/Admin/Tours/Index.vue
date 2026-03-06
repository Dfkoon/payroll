<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';

const { props } = usePage();
const tours = computed(() => props.tours);
const categories = computed(() => props.categories);

const showCreateModal = ref(false);
const editingTour = ref(null);

const form = useForm({
    title: '',
    description: '',
    price: '',
    days: '',
    category_id: '',
    is_featured: false
});

const openCreate = () => {
    editingTour.value = null;
    form.reset();
    showCreateModal.value = true;
};

const openEdit = (tour) => {
    editingTour.value = tour;
    form.title = tour.title;
    form.description = tour.description;
    form.price = tour.price;
    form.days = tour.days;
    form.category_id = tour.category_id;
    form.is_featured = !!tour.is_featured;
    showCreateModal.value = true;
};

const submit = () => {
    if (editingTour.value) {
        form.patch(route('admin.tours.update', editingTour.value.id), {
            onSuccess: () => {
                showCreateModal.value = false;
                editingTour.value = null;
            }
        });
    } else {
        form.post(route('admin.tours.store'), {
            onSuccess: () => {
                showCreateModal.value = false;
            }
        });
    }
};

const deleteTour = (id) => {
    if (confirm('Are you sure you want to delete this tour?')) {
        form.delete(route('admin.tours.destroy', id));
    }
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
    <Head title="Manage Tours - Salamein Admin" />

    <div class="min-h-screen bg-[#0a0a0a] text-white selection:bg-blue-600/30 font-sans p-8 lg:p-12">
        <header class="max-w-7xl mx-auto flex justify-between items-center mb-16 reveal-up">
            <div>
                <Link :href="route('admin.dashboard')" class="text-blue-500 font-black text-xs uppercase tracking-widest mb-4 flex items-center gap-2 group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to Dashboard
                </Link>
                <h1 class="text-5xl font-black tracking-tighter">Tour <span class="text-blue-600">Inventory</span></h1>
            </div>
            <button @click="openCreate" class="bg-blue-600 hover:bg-blue-700 text-white font-black px-8 py-4 rounded-3xl transition-all shadow-2xl shadow-blue-600/20 active:scale-95">
                Add New Tour
            </button>
        </header>

        <main class="max-w-7xl mx-auto">
            <div class="glass-card-dark rounded-[3rem] border-white/5 overflow-hidden reveal-up">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-white/5">
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-slate-500">Tour Details</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-slate-500 text-center">Price</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-slate-500 text-center">Featured</th>
                            <th class="p-8 text-[10px] font-black uppercase tracking-widest text-slate-500 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <tr v-for="tour in tours" :key="tour.id" class="hover:bg-white/[0.02] transition-colors group">
                            <td class="p-8">
                                <div class="flex items-center gap-6">
                                    <div class="w-16 h-16 rounded-2xl bg-slate-800 shrink-0 overflow-hidden border border-white/10">
                                        <img :src="tour.image_path" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                                    </div>
                                    <div>
                                        <h3 class="font-black text-lg tracking-tight mb-1">{{ tour.title }}</h3>
                                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">{{ tour.category.name }} • {{ tour.days }} Days</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-8 text-center">
                                <div class="text-2xl font-black text-blue-500 tracking-tighter">${{ Math.floor(tour.price) }}</div>
                            </td>
                            <td class="p-8 text-center">
                                <div :class="['inline-flex w-10 h-10 items-center justify-center rounded-xl border-2 transition-all', tour.is_featured ? 'border-amber-500/50 bg-amber-500/10 text-amber-500' : 'border-white/10 text-slate-700']">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </div>
                            </td>
                            <td class="p-8 text-right">
                                <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <button @click="openEdit(tour)" class="w-12 h-12 bg-white/5 hover:bg-white/10 rounded-xl flex items-center justify-center text-slate-400 hover:text-white transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button @click="deleteTour(tour.id)" class="w-12 h-12 bg-red-500/10 hover:bg-red-500/20 rounded-xl flex items-center justify-center text-red-500/50 hover:text-red-500 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Dynamic Form Modal -->
        <div v-if="showCreateModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/90 backdrop-blur-xl animate-fade-in">
            <div class="glass-card-dark border-white/10 w-full max-w-2xl p-12 rounded-[4rem] relative overflow-hidden reveal-up active shadow-[0_0_100px_rgba(37,99,235,0.1)]">
                <button @click="showCreateModal = false" class="absolute top-10 right-10 text-slate-500 hover:text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <h2 class="text-4xl font-black tracking-tighter mb-10">{{ editingTour ? 'Update Tour' : 'Create New Journey' }}</h2>
                
                <form @submit.prevent="submit" class="space-y-8">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-4">Title</label>
                            <input v-model="form.title" type="text" class="admin-input" placeholder="e.g. Petra Night Walk">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-4">Duration (Days)</label>
                            <input v-model="form.days" type="number" class="admin-input" placeholder="3">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-4">Base Price ($)</label>
                            <input v-model="form.price" type="number" step="0.01" class="admin-input" placeholder="299.00">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-4">Category</label>
                            <select v-model="form.category_id" class="admin-input">
                                <option value="" disabled>Select Category</option>
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-4">Description</label>
                        <textarea v-model="form.description" class="admin-input min-h-[150px]" placeholder="Tell the world about this adventure..."></textarea>
                    </div>

                    <div class="flex items-center gap-4 bg-white/5 p-6 rounded-3xl border border-white/5">
                        <input type="checkbox" v-model="form.is_featured" class="w-6 h-6 rounded-lg bg-[#1a1a1a] border-white/10 text-blue-600 focus:ring-blue-600 focus:ring-offset-0">
                        <span class="text-sm font-bold text-slate-300">Feature this tour on homepage</span>
                    </div>

                    <div class="pt-6">
                        <button type="submit" :disabled="form.processing" class="w-full bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white font-black py-6 rounded-3xl transition-all shadow-xl shadow-blue-600/20 text-lg uppercase tracking-widest">
                            {{ editingTour ? 'Save Changes' : 'Initialize Tour' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
.glass-card-dark {
    background: rgba(255, 255, 255, 0.02);
    backdrop-filter: blur(40px);
    -webkit-backdrop-filter: blur(40px);
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.admin-input {
    width: 100%;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 1.5rem;
    padding: 1.25rem 1.5rem;
    color: white;
    font-size: 1rem;
    font-weight: 600;
    transition: all 0.4s ease;
}

.admin-input:focus {
    background: rgba(37, 99, 235, 0.05);
    border-color: rgba(37, 99, 235, 0.5);
    outline: none;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
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

@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}

.animate-fade-in {
    animation: fade-in 0.4s ease-out forwards;
}
</style>

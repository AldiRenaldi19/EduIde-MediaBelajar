<div x-data="{ 
    messages: [],
    remove(id) {
        this.messages = this.messages.filter(m => m.id !== id)
    },
    add(message, type = 'success') {
        const id = Date.now()
        this.messages.push({ id, message, type })
        setTimeout(() => this.remove(id), 5000)
    }
}"
@notify.window="add($event.detail.message, $event.detail.type)"
class="fixed bottom-8 right-8 z-[100] flex flex-col gap-3 pointer-events-none">
    
    <template x-for="msg in messages" :key="msg.id">
        <div x-show="true" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="pointer-events-auto min-w-[320px] max-w-[400px] glass-card p-5 rounded-3xl border border-white/10 shadow-2xl flex items-center gap-4 relative overflow-hidden group">
            
            {{-- Type Indicator --}}
            <div :class="{
                'bg-indigo-500/20 text-indigo-400': msg.type === 'success',
                'bg-rose-500/20 text-rose-400': msg.type === 'error',
                'bg-amber-500/20 text-amber-400': msg.type === 'warning'
            }" class="w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0">
                <template x-if="msg.type === 'success'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </template>
                <template x-if="msg.type === 'error'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </template>
            </div>

            <div class="flex-grow">
                <p class="text-xs font-black uppercase tracking-widest text-white/40 mb-1" x-text="msg.type"></p>
                <p class="text-sm font-bold text-white/90" x-text="msg.message"></p>
            </div>

            <button @click="remove(msg.id)" class="text-white/20 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Progress line --}}
            <div class="absolute bottom-0 left-0 h-[2px] bg-gradient-to-r from-indigo-500 to-indigo-500/10 transition-all duration-[5000ms] ease-linear"
                 style="width: 100%"
                 x-init="$el.style.width = '0%'"></div>
        </div>
    </template>
</div>

{{-- Flash PHP sessions to JS events --}}
@if(session('success'))
    <div x-data x-init="window.dispatchEvent(new CustomEvent('notify', { detail: { message: '{{ session('success') }}', type: 'success' } }))"></div>
@endif
@if(session('error'))
    <div x-data x-init="window.dispatchEvent(new CustomEvent('notify', { detail: { message: '{{ session('error') }}', type: 'error' } }))"></div>
@endif
@if($errors->any())
    <div x-data x-init="window.dispatchEvent(new CustomEvent('notify', { detail: { message: '{{ $errors->first() }}', type: 'error' } }))"></div>
@endif

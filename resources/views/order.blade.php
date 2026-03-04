<x-layouts.app>
    <div class="flex flex-col gap-6 lg:flex-row" x-data="{ 
        activeCategory: 'makanan', 
        search: '',
        paymentMethod: 'cash',
        showQrModal: false,
        cart: [],
        addToCart(product) {
            const existingItem = this.cart.find(item => item.name === product.name);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                this.cart.push({ ...product, quantity: 1 });
            }
        },
        checkout() {
            if (this.cart.length === 0) return;
            
            if (this.paymentMethod === 'qris') {
                this.showQrModal = true;
            } else {
                this.confirmPayment();
            }
        },
        async confirmPayment() {
            try {
                const response = await fetch('{{ route('orders.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        cart: this.cart,
                        payment_method: this.paymentMethod
                    })
                });
                
                const result = await response.json();
                
                if (result.status === 'success') {
                    window.location.href = result.redirect_url;
                } else {
                    alert(result.message);
                }
            } catch (error) {
                console.error('Checkout error:', error);
                alert('An error occurred during checkout');
            }
        },
        get total() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        }
    }">
        <!-- Sidebar Navigation -->
        <aside class="w-full lg:w-64 shrink-0">
            <div class="sticky top-6 space-y-2">
                <h2 class="px-4 text-xs font-semibold tracking-wider text-slate-400 uppercase mb-4">Categories</h2>
                <nav class="space-y-1">
                    <button 
                        @click="activeCategory = 'makanan'"
                        :class="activeCategory === 'makanan' ? 'bg-orange-500 text-white shadow-lg' : 'text-slate-600 hover:bg-white hover:text-orange-500'"
                        class="flex items-center w-full px-4 py-3 text-sm font-medium transition-all duration-200 rounded-2xl group">
                        <span class="mr-3">🍔</span>
                        Makanan
                    </button>
                    <button 
                        @click="activeCategory = 'minuman'"
                        :class="activeCategory === 'minuman' ? 'bg-orange-500 text-white shadow-lg' : 'text-slate-600 hover:bg-white hover:text-orange-500'"
                        class="flex items-center w-full px-4 py-3 text-sm font-medium transition-all duration-200 rounded-2xl group">
                        <span class="mr-3">☕</span>
                        Minuman
                    </button>
                    <button 
                        @click="activeCategory = 'camilan'"
                        :class="activeCategory === 'camilan' ? 'bg-orange-500 text-white shadow-lg' : 'text-slate-600 hover:bg-white hover:text-orange-500'"
                        class="flex items-center w-full px-4 py-3 text-sm font-medium transition-all duration-200 rounded-2xl group">
                        <span class="mr-3">🍿</span>
                        Camilan
                    </button>
                </nav>
            </div>
        </aside>

        <!-- Product Grid -->
        <div class="grow">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold tracking-tight capitalize text-slate-900" x-text="activeCategory"></h1>
                <div class="relative w-64">
                    <input type="text" x-model="search" placeholder="Search menu..." class="w-full px-4 py-2 text-sm bg-white border-0 shadow-sm rounded-xl focus:ring-2 focus:ring-orange-500 ring-1 ring-slate-200">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>

        <!-- Order Summary (Cart) -->
        <aside class="w-full lg:w-96 shrink-0">
            <div class="sticky top-6 bg-white rounded-4xl shadow-xl border border-slate-100 flex flex-col max-h-[calc(100vh-3rem)]">
                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-xl font-bold text-slate-900 flex items-center justify-between">
                        My Order
                        <span class="bg-orange-100 text-orange-600 text-xs px-2 py-1 rounded-lg" x-text="cart.length + ' items'"></span>
                    </h2>
                </div>

                <div class="grow overflow-y-auto p-6 space-y-4">
                    <template x-for="(item, index) in cart" :key="index">
                        <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl group">
                            <img :src="item.image" alt="Product Image" class="w-12 h-12 rounded-xl object-cover">
                            <div class="grow">
                                <h4 class="text-sm font-semibold text-slate-900" x-text="item.name"></h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <button @click="item.quantity > 1 ? item.quantity-- : cart.splice(index, 1)" class="w-6 h-6 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-orange-50 hover:border-orange-200 hover:text-orange-600 transition-colors">-</button>
                                    <span class="text-xs font-bold text-slate-700 w-4 text-center" x-text="item.quantity"></span>
                                    <button @click="item.quantity++" class="w-6 h-6 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-orange-50 hover:border-orange-200 hover:text-orange-600 transition-colors">+</button>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-slate-900" x-text="'Rp ' + ((item.price * item.quantity)/1000) + 'k'"></p>
                            </div>
                        </div>
                    </template>

                    <template x-if="cart.length === 0">
                        <div class="py-12 text-center">
                            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-3xl text-slate-400">🛒</span>
                            </div>
                            <p class="text-slate-500">Your cart is empty</p>
                        </div>
                    </template>
                </div>

                <div class="p-6 bg-slate-50/50 rounded-b-4xl border-t border-slate-100">
                    <div class="mb-6">
                        <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Payment Method</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <button @click="paymentMethod = 'cash'" 
                                    :class="paymentMethod === 'cash' ? 'ring-2 ring-orange-500 bg-orange-50 text-orange-600' : 'bg-white text-slate-600'"
                                    class="flex flex-col items-center justify-center p-3 rounded-2xl transition-all border border-slate-100">
                                <span class="text-xl mb-1">💵</span>
                                <span class="text-xs font-bold">Tunai/Cash</span>
                            </button>
                            <button @click="paymentMethod = 'qris'" 
                                    :class="paymentMethod === 'qris' ? 'ring-2 ring-orange-500 bg-orange-50 text-orange-600' : 'bg-white text-slate-600'"
                                    class="flex flex-col items-center justify-center p-3 rounded-2xl transition-all border border-slate-100">
                                <span class="text-xl mb-1">🤳</span>
                                <span class="text-xs font-bold">QRIS</span>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2 mb-6 text-sm">
                        <div class="flex justify-between text-slate-500">
                            <span>Subtotal</span>
                            <span class="font-semibold text-slate-900" x-text="'Rp ' + (total/1000) + 'k'"></span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Tax (10%)</span>
                            <span class="font-semibold text-slate-900" x-text="'Rp ' + (total*0.1/1000) + 'k'"></span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-slate-900 pt-2 border-t border-slate-200">
                            <span>Total</span>
                            <span class="text-orange-600" x-text="'Rp ' + ((total + (total*0.1))/1000) + 'k'"></span>
                        </div>
                    </div>
                    <button @click="checkout()" :disabled="cart.length === 0" class="w-full py-4 bg-orange-500 text-white font-bold rounded-2xl shadow-lg shadow-orange-200 hover:bg-orange-600 transition-all disabled:opacity-50 disabled:grayscale">
                        Checkout Now
                    </button>
                </div>
            </div>
        </aside>

        <!-- QRIS Modal -->
        <div x-show="showQrModal" 
             class="fixed inset-0 z-100 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="bg-white rounded-[2.5rem] shadow-2xl max-w-md w-full overflow-hidden"
                 @click.away="showQrModal = false"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                
                <div class="p-8 text-center">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-slate-900 mb-2">Pembayaran QRIS</h3>
                        <p class="text-slate-500 text-sm italic">Silakan pindai kode di bawah ini untuk membayar</p>
                    </div>

                    <div class="bg-slate-50 p-6 rounded-3xl mb-8 flex items-center justify-center border border-slate-100">
                        <img src="{{ asset('storage/qris.png') }}" alt="QRIS Code" class="w-64 h-64 object-contain shadow-sm rounded-xl">
                    </div>

                    <div class="flex flex-col gap-3">
                        <button @click="confirmPayment()" 
                                class="w-full py-4 bg-orange-500 text-white font-bold rounded-2xl shadow-lg shadow-orange-200 hover:bg-orange-600 transition-all flex items-center justify-center gap-2">
                            <span>Sudah Bayar</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </button>
                        <button @click="showQrModal = false" 
                                class="w-full py-3 text-slate-400 font-semibold hover:text-slate-600 transition-colors">
                            Batal
                        </button>
                    </div>
                </div>
                
                <div class="bg-slate-50 px-8 py-4 flex items-center justify-between border-t border-slate-100">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Tagihan</span>
                    <span class="text-lg font-bold text-orange-600" x-text="'Rp ' + ((total + (total*0.1))/1000) + 'k'"></span>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
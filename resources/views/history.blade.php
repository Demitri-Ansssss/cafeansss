<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 italic">Riwayat Pesanan</h1>
            <p class="text-slate-500">Lihat semua pesanan yang telah Anda buat.</p>
        </div>

        <div class="space-y-6">
            @forelse ($orders as $order)
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-orange-100 flex items-center justify-center text-orange-600">
                                <span class="text-xl">🥡</span>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900">Order #{{ $order->id }}</h3>
                                <p class="text-xs text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $order->status === 'success' ? 'bg-emerald-100 text-emerald-600' : 'bg-orange-100 text-orange-600' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            <p class="mt-1 text-sm font-bold text-slate-900">Rp {{ number_format($order->total_price / 1000, 0) }}k</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach ($order->orderItems as $item)
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100 shrink-0">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="grow">
                                        <h4 class="text-sm font-semibold text-slate-900">{{ $item->product->name }}</h4>
                                        <p class="text-xs text-slate-500">{{ $item->quantity }} x Rp {{ number_format($item->price / 1000, 0) }}k</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-slate-900">Rp {{ number_format($item->subtotal / 1000, 0) }}k</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 pt-6 border-t border-slate-100 flex items-center justify-between text-sm">
                            <div class="text-slate-500 italic">
                                Metode Pembayaran: <span class="font-semibold text-slate-700 uppercase">{{ $order->payment_method }}</span>
                            </div>
                            <div class="text-slate-500 italic">
                                Tipe Order: <span class="font-semibold text-slate-700 uppercase">{{ $order->order_type }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-4xl border border-dashed border-slate-300">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">📭</div>
                    <h3 class="text-lg font-bold text-slate-900">Belum ada pesanan</h3>
                    <p class="text-slate-500 mb-6">Ayo mulai pesan menu favoritmu sekarang!</p>
                    <a href="{{ route('order.index') }}" class="inline-flex items-center px-6 py-3 bg-orange-500 text-white font-bold rounded-2xl hover:bg-orange-600 transition-colors">
                        Pesan Sekarang
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>

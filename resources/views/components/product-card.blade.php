@props(['product'])

<div class="flex flex-col bg-white border-0 shadow-sm rounded-3xl overflow-hidden group transition-all duration-300 hover:-translate-y-2 hover:shadow-xl ring-1 ring-slate-200" 
    x-show="activeCategory === '{{ strtolower($product->category->name) }}' && '{{ strtolower($product->name) }}'.includes(search.toLowerCase())"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-90"
     x-transition:enter-end="opacity-100 transform scale-100">
    <div class="aspect-square relative overflow-hidden">
        <img src="{{ asset('storage/' . $product->image) }}" 
             class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-110" 
             alt="{{ $product->name }}">
            </div>
            <div class="p-5 flex flex-col grow">
                <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $product->name }}</h3>
                <h3 class=" top-4 right-4 bg-white/90 backdrop-blur px-3 py-auto rounded-full text-xl font-bold text-orange-600">
                    Rp {{ number_format($product->price / 1000, 0) }}k
                </h3>
                <!-- <p class="text-sm text-slate-500 mb-4 line-clamp-2">{{ $product->description }}</p> -->
        <button @click="addToCart({ id: {{ $product->id }}, name: '{{ $product->name }}', price: {{ $product->price }}, image: '{{ asset('storage/' . $product->image) }}' })" 
                class="mt-auto w-full py-3 bg-orange-50 text-orange-600 font-semibold rounded-2xl hover:bg-orange-500 hover:text-white transition-colors duration-200">
            Add to Order
        </button>
    </div>
</div>
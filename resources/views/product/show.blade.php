@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-4">
        <a href="javascript:history.back()" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-black transition-colors group">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Collection
        </a>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16">
            
            <div class="w-full flex flex-col-reverse md:flex-row gap-4">
                
                @php
                    // កូដថ្មី៖ ការពារ Error និងជួយឲ្យស្គាល់ទាំង URL និង Upload File
                    $mainImg = ($product->image && str_starts_with($product->image, 'http')) ? $product->image : asset('storage/' . $product->image);
                    $img2 = ($product->image_2 && str_starts_with($product->image_2, 'http')) ? $product->image_2 : asset('storage/' . $product->image_2);
                    $img3 = ($product->image_3 && str_starts_with($product->image_3, 'http')) ? $product->image_3 : asset('storage/' . $product->image_3);
                @endphp

                <div class="flex md:flex-col gap-3 overflow-x-auto md:overflow-visible w-full md:w-20 lg:w-24 flex-shrink-0">
                    
                    <div class="aspect-w-1 aspect-h-1 bg-gray-50 border-2 border-black cursor-pointer hover:border-black transition-colors" onmouseover="changeMainImage('{{ $mainImg }}', this)">
                        <img src="{{ $mainImg }}" class="w-full h-full object-cover">
                    </div>

                    @if($product->image_2)
                    <div class="aspect-w-1 aspect-h-1 bg-gray-50 border border-gray-200 cursor-pointer hover:border-black transition-colors" onmouseover="changeMainImage('{{ $img2 }}', this)">
                        <img src="{{ $img2 }}" class="w-full h-full object-cover">
                    </div>
                    @endif

                    @if($product->image_3)
                    <div class="aspect-w-1 aspect-h-1 bg-gray-50 border border-gray-200 cursor-pointer hover:border-black transition-colors" onmouseover="changeMainImage('{{ $img3 }}', this)">
                        <img src="{{ $img3 }}" class="w-full h-full object-cover">
                    </div>
                    @endif

                </div>

                <div class="w-full bg-gray-50 aspect-w-4 aspect-h-5 relative overflow-hidden flex-1">
                    <img id="main-product-image" src="{{ $mainImg }}" alt="{{ $product->name }}" class="w-full h-full object-cover object-center transition-opacity duration-300">
                </div>
            </div>

            <div class="flex flex-col justify-center">
                <p class="text-xs uppercase tracking-widest text-gray-500 mb-2">{{ $product->category }}</p>
                <h1 class="text-3xl md:text-4xl font-serif text-gray-900 mb-4">{{ $product->name }}</h1>
                
                <p class="text-2xl font-medium text-gray-900 mb-6">${{ number_format($product->price, 2) }}</p>
                
                <div class="prose prose-sm text-gray-600 mb-6">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-2">Product Details</h3>
                    <p class="leading-relaxed whitespace-pre-line">{{ $product->description }}</p>
                </div>

                <div class="flex items-center mb-8">
                    <div class="flex text-yellow-400 text-sm">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <span class="ml-2 text-sm text-gray-500 hover:text-black hover:underline cursor-pointer transition-colors">(128 Reviews)</span>
                </div>

                <form action="/cart/add" method="POST" class="mt-auto">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="w-full bg-black text-white text-sm uppercase tracking-widest font-semibold py-4 hover:bg-gray-800 transition-colors duration-300">
                        Add To Cart
                    </button>
                </form>
                
                <div class="mt-6 border-t border-gray-100 pt-6 space-y-3 text-xs text-gray-500">
                    <p class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg> Free worldwide shipping over $200</p>
                    <p class="flex items-center"><svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg> Secure checkout</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-100 mt-12">
        <h2 class="text-2xl font-serif text-gray-900 mb-8">Similar Products</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-10">
            @forelse($similarProducts as $similar)
                @php
                    $similarImageUrl = ($similar->image && str_starts_with($similar->image, 'http')) ? $similar->image : asset('storage/' . $similar->image);
                @endphp
                <div class="group relative">
                    <a href="/product/{{ $similar->slug }}" class="block">
                        
                        <div class="w-full h-[300px] bg-gray-50 relative overflow-hidden mb-4 rounded-sm">
                            <img src="{{ $similarImageUrl }}" alt="{{ $similar->name }}" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                        </div>
                        
                        <h3 class="text-sm text-gray-900 font-medium truncate">{{ $similar->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">${{ number_format($similar->price, 2) }}</p>
                    </a>
                </div>
            @empty
                <p class="text-gray-500 text-sm">No similar products found.</p>
            @endforelse
        </div>
    </div>

    <script>
        function changeMainImage(imageUrl, element) {
            const mainImage = document.getElementById('main-product-image');
            mainImage.style.opacity = 0; 
            setTimeout(() => {
                mainImage.src = imageUrl;
                mainImage.style.opacity = 1;
            }, 150);

            let thumbnails = element.parentElement.children;
            for (let i = 0; i < thumbnails.length; i++) {
                thumbnails[i].classList.remove('border-black', 'border-2');
                thumbnails[i].classList.add('border-gray-200', 'border');
            }
            element.classList.remove('border-gray-200', 'border');
            element.classList.add('border-black', 'border-2');
        }
    </script>
@endsection

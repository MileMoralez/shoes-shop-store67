@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 py-16 text-center border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-serif text-gray-900 tracking-wide mb-4">Accessories</h1>
            <p class="text-gray-500 max-w-2xl mx-auto text-sm">
                The finishing touches. Premium leather goods, eyewear, and fine jewelry.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="sticky top-28">
                    <h3 class="text-xs uppercase tracking-widest text-gray-900 font-semibold mb-6">Filter By</h3>
                    
                    <div class="mb-8 border-b border-gray-100 pb-6">
                        <h4 class="text-sm text-gray-900 font-medium mb-4">Category</h4>
                        <ul class="space-y-3 text-sm text-gray-500">
                            <li><a href="#" class="hover:text-black transition text-black font-medium">All Accessories</a></li>
                            <li><a href="#" class="hover:text-black transition">Bags & Wallets</a></li>
                            <li><a href="#" class="hover:text-black transition">Sunglasses</a></li>
                            <li><a href="#" class="hover:text-black transition">Watches</a></li>
                            <li><a href="#" class="hover:text-black transition">Jewelry</a></li>
                        </ul>
                    </div>
                </div>
            </aside>

            <div class="flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                    
                    <div class="group relative">
                        <div class="w-full bg-gray-100 aspect-w-3 aspect-h-4 overflow-hidden h-[450px] relative">
                            <img src="https://images.unsplash.com/photo-1584916201218-f4242ceb4809?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Leather Tote Bag" class="w-full h-full object-cover object-center group-hover:opacity-90 transition-opacity">
                            <div class="absolute bottom-4 left-0 right-0 px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0">
                                <button class="w-full bg-white text-black py-3 text-xs uppercase tracking-widest font-semibold shadow-lg hover:bg-black hover:text-white transition-colors">Quick Add</button>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-900 font-medium"><a href="#">Leather Tote Bag</a></h3>
                                <p class="mt-1 text-sm text-gray-500">Bags</p>
                            </div>
                            <p class="text-sm font-medium text-gray-900">$210.00</p>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="w-full bg-gray-100 aspect-w-3 aspect-h-4 overflow-hidden h-[450px] relative">
                            <img src="https://images.unsplash.com/photo-1511499767150-a48a237f0083?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Acetate Sunglasses" class="w-full h-full object-cover object-center group-hover:opacity-90 transition-opacity">
                            <div class="absolute bottom-4 left-0 right-0 px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0">
                                <button class="w-full bg-white text-black py-3 text-xs uppercase tracking-widest font-semibold shadow-lg hover:bg-black hover:text-white transition-colors">Quick Add</button>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-900 font-medium"><a href="#">Acetate Sunglasses</a></h3>
                                <p class="mt-1 text-sm text-gray-500">Eyewear</p>
                            </div>
                            <p class="text-sm font-medium text-gray-900">$145.00</p>
                        </div>
                    </div>

                    <div class="group relative">
                        <div class="w-full bg-gray-100 aspect-w-3 aspect-h-4 overflow-hidden h-[450px] relative">
                            <img src="https://images.unsplash.com/photo-1524592094714-0f0654e20314?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Minimalist Watch" class="w-full h-full object-cover object-center group-hover:opacity-90 transition-opacity">
                            <div class="absolute bottom-4 left-0 right-0 px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0">
                                <button class="w-full bg-white text-black py-3 text-xs uppercase tracking-widest font-semibold shadow-lg hover:bg-black hover:text-white transition-colors">Quick Add</button>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-900 font-medium"><a href="#">Minimalist Watch</a></h3>
                                <p class="mt-1 text-sm text-gray-500">Watches</p>
                            </div>
                            <p class="text-sm font-medium text-gray-900">$185.00</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
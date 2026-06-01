@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 py-16 text-center border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-serif text-gray-900 tracking-wide mb-4">Anime & Streetwear</h1>
            <p class="text-gray-500 max-w-2xl mx-auto text-sm">
                Exclusive collaborations and graphic apparel inspired by Tokyo street culture.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="sticky top-28">
                    <h3 class="text-xs uppercase tracking-widest text-gray-900 font-semibold mb-6">Filter By</h3>
                    <div class="mb-8 border-b border-gray-100 pb-6">
                        <ul class="space-y-3 text-sm text-gray-500">
                            <li><a href="#" class="hover:text-black transition text-black font-medium">All Anime</a></li>
                            <li><a href="#" class="hover:text-black transition">Graphic Tees</a></li>
                            <li><a href="#" class="hover:text-black transition">Hoodies</a></li>
                            <li><a href="#" class="hover:text-black transition">Collectibles</a></li>
                        </ul>
                    </div>
                </div>
            </aside>

            <div class="flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                    <div class="group relative">
                        <div class="w-full bg-gray-100 aspect-w-3 aspect-h-4 overflow-hidden h-[450px] relative">
                            <img src="https://images.unsplash.com/photo-1560963689-02e8210bc64d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Graphic Hoodie" class="w-full h-full object-cover object-center group-hover:opacity-90 transition-opacity">
                            <div class="absolute bottom-4 left-0 right-0 px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0">
                                <button class="w-full bg-white text-black py-3 text-xs uppercase tracking-widest font-semibold shadow-lg hover:bg-black hover:text-white transition-colors">Quick Add</button>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-900 font-medium"><a href="#">Mecha Graphic Hoodie</a></h3>
                                <p class="mt-1 text-sm text-gray-500">Streetwear</p>
                            </div>
                            <p class="text-sm font-medium text-gray-900">$85.00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
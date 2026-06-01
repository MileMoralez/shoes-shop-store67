@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="text-3xl font-serif text-gray-900 mb-8 text-center">Your Shopping Cart</h1>

    @if(session('cart'))
        <div class="flex flex-col lg:flex-row gap-12">
            
            <div class="lg:w-2/3">
                <div class="border-t border-gray-200">
                    
                    @php $total = 0; @endphp
                    
                    @foreach(session('cart') as $id => $details)
                        @php
                            // ១. ការពារកុំឱ្យគាំងពេលទិន្នន័យក្នុង Cart ខូច ឬបាត់តម្លៃ
                            $price = isset($details['price']) ? $details['price'] : 0;
                            $quantity = isset($details['quantity']) ? $details['quantity'] : 1;
                            $total += $price * $quantity;
                            
                            // ២. កូដទាញរូបភាពដែលការពារមិនឱ្យលោត Error Class 'Str'
                            $imagePath = $details['image'] ?? '';
                            $imageUrl = \Illuminate\Support\Str::startsWith($imagePath, 'http') ? $imagePath : asset('storage/' . $imagePath);
                        @endphp
                        
                        <div class="py-6 border-b border-gray-200 flex flex-col sm:flex-row items-center gap-6">
                            
                            <div class="w-full sm:w-24 sm:h-24 flex-shrink-0 bg-gray-50 rounded overflow-hidden">
                                <img src="{{ $imageUrl }}" alt="{{ $details['name'] ?? 'Unknown Item' }}" class="w-full h-full object-cover">
                            </div>

                            <div class="flex-1 text-center sm:text-left">
                                <h3 class="text-lg font-medium text-gray-900"><a href="#">{{ $details['name'] ?? 'Unknown Product' }}</a></h3>
                                <p class="text-gray-500 mt-1">${{ number_format($price, 2) }}</p>
                            </div>
                            
                            <div class="flex items-center border border-gray-300 rounded">
                                <button class="px-3 py-1 text-gray-600 hover:text-black transition-colors update-cart" data-id="{{ $id }}" data-action="minus">-</button>
                                <input type="number" value="{{ $quantity }}" class="w-12 text-center text-sm font-medium focus:outline-none quantity-input" readonly>
                                <button class="px-3 py-1 text-gray-600 hover:text-black transition-colors update-cart" data-id="{{ $id }}" data-action="plus">+</button>
                            </div>

                            <div class="text-right ml-4 w-24">
                                <p class="text-lg font-medium text-gray-900">${{ number_format($price * $quantity, 2) }}</p>
                            </div>

                            <button class="text-red-500 hover:text-red-700 p-2 ml-2 transition-colors remove-from-cart" data-id="{{ $id }}" title="Remove item">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                            
                        </div>
                    @endforeach
                    
                </div>
            </div>

            <div class="lg:w-1/3">
                <div class="bg-gray-50 p-8 rounded-sm">
                    <h2 class="text-lg font-medium text-gray-900 mb-6 uppercase tracking-wider">Order Summary</h2>
                    
                    <div class="flex justify-between mb-4 text-gray-600">
                        <span>Subtotal</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between mb-4 text-gray-600">
                        <span>Shipping</span>
                        <span class="text-green-600 font-medium">Free</span>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 mt-4 flex justify-between">
                        <span class="text-lg font-bold text-gray-900">Total</span>
                        <span class="text-xl font-bold text-gray-900">${{ number_format($total, 2) }}</span>
                    </div>
                    
                    <a href="/checkout" class="mt-8 block w-full bg-black text-white text-center py-4 text-sm uppercase tracking-widest font-semibold hover:bg-gray-800 transition-colors">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
            
        </div>
    @else
        <div class="text-center py-16">
            <svg class="mx-auto h-24 w-24 text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            <h2 class="text-2xl font-medium text-gray-900 mb-4">Your cart is currently empty.</h2>
            <p class="text-gray-500 mb-8">Looks like you haven't added anything to your cart yet.</p>
            <a href="/" class="inline-block bg-black text-white px-8 py-4 text-sm uppercase tracking-widest font-semibold hover:bg-gray-800 transition-colors">
                Continue Shopping
            </a>
        </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    
    // បញ្ជាបូក និងដក
    $(".update-cart").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        var id = ele.attr("data-id");
        var action = ele.attr("data-action");
        var input = ele.siblings('.quantity-input');
        var qty = parseInt(input.val());

        if (action === 'plus') { qty++; } 
        else if (action === 'minus' && qty > 1) { qty--; } 
        else { return; } // បើស្មើ ១ ហើយចុចដកទៀត មិនឲ្យដើរទេ

        $.ajax({
           url: "{{ route('cart.update') }}",
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}', 
                id: id, 
                quantity: qty
            },
            success: function (response) {
                window.location.reload(); // Refresh ទំព័រដើម្បីលោតលុយថ្មី
            }
        });
    });

    // បញ្ជាលុប
    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        if(confirm("Are you sure you want to remove this product?")) {
            $.ajax({
               url: "{{ route('cart.remove') }}",
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
</script>
@endsection
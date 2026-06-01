<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan to Pay - ABA PayWay</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">
    
    <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-sm w-full text-center border-t-4 border-[#0055a6]">
        
        <div class="flex justify-center items-center gap-2 mb-2">
            <svg class="w-8 h-8 text-[#0055a6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h2 class="text-2xl font-black text-[#0055a6] tracking-wider">ABA PAY</h2>
        </div>
        <p class="text-gray-500 mb-6 text-sm font-medium">Scan to pay with ABA Mobile</p>

        <div class="flex justify-center mb-6 relative">
            <div class="p-3 border-2 border-dashed border-[#0055a6] rounded-xl shadow-sm bg-white">
                <img src="{{ $qrImage }}" alt="Dynamic KHQR" class="w-64 h-64 object-contain rounded">
            </div>
        </div>
<p class="text-sm text-gray-500 uppercase tracking-widest font-semibold mb-1">Total Payment</p>
<p class="text-4xl font-bold text-red-600 mb-0">${{ $amount }}</p>
<p class="text-lg font-bold text-[#0055a6] mb-6">~ {{ number_format($amount * 4100, 0) }} ៛</p>

        <a href="{{ $deepLink }}" class="block w-full py-4 bg-[#0055a6] text-white font-bold rounded-lg hover:bg-blue-800 transition-colors shadow-lg mb-4">
            Pay with ABA Mobile App
        </a>

        <form action="/checkout" method="POST" id="demo-success-form">
            @csrf
            </form>
        
        <button onclick="simulateSuccess()" class="text-sm font-bold text-green-600 hover:text-green-800 underline">
            [DEMO] I have paid already
        </button>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function simulateSuccess() {
            Swal.fire({
                title: 'Payment Received!',
                text: 'Your order has been successfully placed.',
                icon: 'success',
                confirmButtonColor: '#0055a6',
            }).then(() => {
                window.location.href = '/'; // លោតទៅទំព័រដើមវិញ
            });
        }
    </script>
</body>
</html>
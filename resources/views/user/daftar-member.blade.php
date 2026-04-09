<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Membership</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-100 py-10">
    <div class="max-w-3xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100">
                <h1 class="text-2xl font-bold text-slate-800">Transaksi Membership</h1>
                <p class="text-sm text-slate-500 mt-1">Lengkapi data pembayaran, lalu tunggu konfirmasi admin.</p>
            </div>

            <div class="px-6 pt-5">
                @if ($errors->any())
                    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 mb-5">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div
                        class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 mb-5">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <form action="{{ route('user.submit-member') }}" method="POST" enctype="multipart/form-data"
                class="p-6 space-y-5">
                @csrf
                <input type="hidden" name="client_time" id="clientTime" value="">

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Email Lengkap</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor WhatsApp</label>
                        <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp') }}" inputmode="numeric"
                            pattern="[0-9]+" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required
                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Pilihan Membership</label>
                        <select name="membership_plan" id="membershipPlan" required
                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="month" {{ old('membership_plan') === 'month' ? 'selected' : '' }}>Month (Rp
                                100.000)</option>
                            <option value="year" {{ old('membership_plan') === 'year' ? 'selected' : '' }}>Year (Rp
                                500.000)</option>
                        </select>
                        <input type="hidden" name="nominal" id="nominalValue" value="{{ old('nominal', 100000) }}">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Transaction ID</label>
                        <input type="text" value="Auto Generate oleh Sistem" readonly
                            class="w-full rounded-lg border border-slate-200 bg-slate-100 px-4 py-2.5 text-slate-500 outline-none">
                    </div>
                </div>

                <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 flex flex-col sm:flex-row items-center sm:items-start justify-between gap-4">
    <div>
        <p class="text-sm text-slate-700">Pembayaran aktif admin:</p>
        <p class="text-lg font-bold text-slate-900 mt-1">DANA / GOPAY: 0821-2154-0775</p>
        <p class="text-sm text-slate-600 mt-2">Nominal terpilih: <span id="nominalPreview"
                class="font-semibold">Rp 100.000</span></p>
    </div>
    
    <div class="shrink-0 bg-white p-2 rounded-xl border border-slate-200 shadow-sm">
        <img src="{{ asset('img/Qris.jpeg') }}" alt="QRIS Pembayaran" class="w-28 h-28 object-cover">
    </div>
</div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Payment Proof (JPG/PNG, max
                        10MB)</label>
                    <input type="file" name="bukti_pembayaran" required accept="image/png,image/jpg,image/jpeg"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Notes (Opsional)</label>
                    <textarea name="notes" rows="4"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">{{ old('notes') }}</textarea>
                </div>

                <label class="flex items-start gap-3 text-sm text-slate-700">
                    <input type="checkbox" name="confirmation" value="1" class="mt-1 rounded border-slate-300">
                    Saya konfirmasi bahwa data transaksi dan bukti pembayaran yang saya kirim adalah benar.
                </label>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('home') }}"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">Kembali ke
                        Halaman Utama</a>
                    <a href="{{ route('books') }}"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50">Batal
                        Payment</a>
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold">Kirim
                        Payment Details</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const membershipPlan = document.getElementById('membershipPlan');
        const nominalValue = document.getElementById('nominalValue');
        const nominalPreview = document.getElementById('nominalPreview');
        const clientTimeInput = document.getElementById('clientTime');

        const syncNominal = () => {
            if (membershipPlan.value === 'year') {
                nominalValue.value = 500000;
                nominalPreview.textContent = 'Rp 500.000';
            } else {
                nominalValue.value = 100000;
                nominalPreview.textContent = 'Rp 100.000';
            }
        };

        syncNominal();
        membershipPlan.addEventListener('change', syncNominal);

        if (clientTimeInput) {
            const syncClientTime = () => {
                clientTimeInput.value = new Date().toISOString();
            };

            syncClientTime();
            document.querySelector('form')?.addEventListener('submit', syncClientTime);
        }
    </script>
</body>

</html>

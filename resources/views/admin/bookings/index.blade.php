<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <div class="flex justify-between items-center mb-1">
            <h1 class="text-3xl font-bold text-gray-800">
                {{ Auth::user()->isPetugas() ? 'Transaksi' : 'Semua Booking' }}
            </h1>
            
            {{-- TOMBOL INPUT KENDARAAN MASUK (Hanya muncul untuk Petugas) --}}
            @if(Auth::user()->isPetugas())
                <a href="{{ route('petugas.transaksi.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl shadow transition text-sm">
                    + Input Kendaraan Masuk
                </a>
            @endif
        </div>
        <p class="text-gray-500 mb-6">Riwayat dan status booking dari semua pengguna</p>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-lg mb-4 flex items-center gap-2">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left p-4 text-sm font-semibold text-gray-600">User</th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-600">Slot</th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-600">Plat</th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-600">Status</th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-600">Pembayaran</th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $b)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-gray-50">
                        <td class="p-4 text-gray-800">{{ $b->user->name }}</td>
                        <td class="p-4 font-medium text-gray-800">{{ $b->slot->kode_slot ?? 'Area ' . ($b->parking_area_id ?? '-') }}</td>
                        <td class="p-4 text-gray-600">{{ $b->plat_kendaraan }}</td>
                        <td class="p-4">
                            <span @class([
                                'px-3 py-1 rounded-full text-xs font-medium',
                                'bg-yellow-100 text-yellow-700' => $b->status === 'booked',
                                'bg-blue-100 text-blue-700' => $b->status === 'aktif',
                                'bg-gray-100 text-gray-600' => $b->status === 'selesai',
                                'bg-red-100 text-red-700' => $b->status === 'dibatalkan',
                            ])>
                                {{ ucfirst($b->status) }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($b->payment)
                                <span @class([
                                    'px-3 py-1 rounded-full text-xs font-medium',
                                    'bg-green-100 text-green-700' => $b->payment->status === 'lunas',
                                    'bg-orange-100 text-orange-700' => $b->payment->status === 'pending',
                                ])>
                                    {{ ucfirst($b->payment->status) }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if(Auth::user()->isPetugas())
                                @if($b->status === 'aktif' && (!$b->payment || $b->payment->status !== 'lunas'))
                                    {{-- TOMBOL PROSES KELUAR (Jika masih aktif) --}}
                                    <form action="{{ route('petugas.transaksi.checkout', $b->id) }}" method="POST" class="inline" onsubmit="return confirm('Proses kendaraan keluar dan hitung biaya?')">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition">
                                            Proses Keluar
                                        </button>
                                    </form>
                                @elseif($b->payment && $b->payment->status === 'lunas')
                                    {{-- TOMBOL CETAK STRUK (Jika sudah lunas) --}}
                                    @if($b->struk_dicetak_at)
                                        <span class="text-gray-400 text-xs">Sudah dicetak</span>
                                    @else
                                        <a href="{{ route('petugas.struk.cetak', $b->id) }}" target="_blank"
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-violet-100 text-violet-700 hover:bg-violet-200 transition">
                                            Cetak Struk
                                        </a>
                                    @endif
                                @endif
                            @elseif(Auth::user()->isAdmin())
                                @if($b->struk_dicetak_at)
                                    <form action="{{ url('/admin/bookings/' . $b->id . '/reset-struk') }}" method="POST"
                                          onsubmit="return confirm('Reset status cetak struk booking #{{ $b->id }}? Struk akan bisa dicetak ulang.')">
                                        @csrf
                                        <button class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700 hover:bg-red-200 transition">
                                            Reset Struk
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs">Belum dicetak</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">Belum ada data booking.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Input Kendaraan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-2xl p-6">
                <form method="POST" action="{{ route('petugas.transaksi.store') }}" class="space-y-6">
                    @csrf

                    <!-- Pilih Plat Nomor -->
                    <div>
                        <x-input-label for="plat_nomor" :value="__('Cari Plat Nomor Terdaftar')" />
                        <select id="plat_nomor" name="plat_nomor" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-violet-500 focus:ring-violet-500 text-sm" required>
                            <option value="">-- KETIK ATAU PILIH PLAT NOMOR --</option>
                            @foreach($vehicles as $v)
                                <option value="{{ $v->plat_nomor }}">
                                    {{ $v->plat_nomor }} ({{ $v->jenis_kendaraan }} - {{ $v->pemilik ?? 'Tanpa Pemilik' }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('plat_nomor')" />
                    </div>

                    <!-- Pilih Area Parkir -->
                    <div>
                        <x-input-label for="parking_area_id" :value="__('Area Parkir')" />
                        <select id="parking_area_id" name="parking_area_id" class="mt-1 block w-full rounded-xl border-slate-300 focus:border-violet-500 focus:ring-violet-500 text-sm" required>
                            <option value="">-- PILIH AREA PARKIR --</option>
                            @foreach($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->nama_area }} (Kapasitas: {{ $area->kapasitas }})</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('parking_area_id')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700">{{ __('Simpan Transaksi') }}</x-primary-button>
                        <a href="{{ route('petugas.transaksi.index') }}" class="text-sm text-slate-500 hover:text-slate-700">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<div class="bg-white rounded-xl shadow p-6 border-t border-t-green-600">
    <h2 class="text-xl font-semibold text-slate-700 mb-4">Tinggalkan Komentar</h2>
    <p class="text-slate-500 text-sm mb-6">
        Identitas anda tidak akan dipublikasikan. Ruas yang wajib ditandai *
    </p>

    @if(session('comment_success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-green-700 text-sm">{{ session('comment_success') }}</p>
            </div>
        </div>
    @endif

    <form action="{{ route('comments.store') }}" method="POST" class="space-y-4">
        @csrf

        <input type="hidden" name="page_url" value="{{ url()->current() }}">
        <input type="hidden" name="page_title" value="{{ $pageTitle ?? 'Halaman Website' }}">

        <div>
            <label class="block text-slate-600 mb-1">
                Komentar <span class="text-red-500">*</span>
            </label>
            <textarea
                name="comment"
                class="w-full border border-slate-300 rounded-md p-2 focus:outline-none focus:border-green-600 @error('comment') border-red-500 @enderror"
                rows="5"
                placeholder="Tulis komentar Anda di sini..."
                required>{{ old('comment') }}</textarea>
            @error('comment')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <input
                    type="text"
                    name="name"
                    placeholder="Nama *"
                    value="{{ old('name') }}"
                    class="w-full border border-slate-300 rounded-md p-2 focus:outline-none focus:border-green-600 @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input
                    type="email"
                    name="email"
                    placeholder="Email *"
                    value="{{ old('email') }}"
                    class="w-full border border-slate-300 rounded-md p-2 focus:outline-none focus:border-green-600 @error('email') border-red-500 @enderror"
                    required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input
                    type="url"
                    name="website"
                    placeholder="Situs Web (opsional)"
                    value="{{ old('website') }}"
                    class="w-full border border-slate-300 rounded-md p-2 focus:outline-none focus:border-green-600 @error('website') border-red-500 @enderror">
                @error('website')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" id="saveInfo" name="save_info" class="border-slate-300" {{ old('save_info') ? 'checked' : '' }}>
            <label for="saveInfo" class="text-slate-600 text-sm">
                Simpan nama, email, dan situs web saya pada peramban ini untuk komentar saya berikutnya.
            </label>
        </div>

        <button
            type="submit"
            class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition-colors cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
            Kirimkan Komentar
        </button>
    </form>
</div>

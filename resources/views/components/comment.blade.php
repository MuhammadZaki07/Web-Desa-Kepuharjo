<div class="bg-white rounded-xl shadow p-6  border-t border-t-green-600">
    <h2 class="text-xl font-semibold text-slate-700 mb-4">Tinggalkan Komentar</h2>
    <p class="text-slate-500 text-sm mb-6">
        Identitas anda tidak akan dipublikasikan. Ruas yang wajib ditandai
    </p>
    <form class="space-y-4">
        <div>
            <label class="block text-slate-600 mb-1">Komentar</label>
            <textarea class="w-full border border-slate-300 rounded-md p-2 focus:outline-none focus:border-green-600" rows="5"
                required></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" placeholder="Nama"
                class="border border-slate-300 rounded-md p-2 focus:outline-none focus:border-green-600" required>
            <input type="email" placeholder="Email"
                class="border border-slate-300 rounded-md p-2 focus:outline-none focus:border-green-600" required>
            <input type="text" placeholder="Situs Web"
                class="border border-slate-300 rounded-md p-2 focus:outline-none focus:border-green-600">
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" id="saveInfo" class="border-slate-300">
            <label for="saveInfo" class="text-slate-600 text-sm">
                Simpan nama, email, dan situs web saya pada peramban ini untuk komentar saya berikutnya.
            </label>
        </div>

        <button type="submit"
            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 cursor-pointer">
            Kirimkan Komentar
        </button>
    </form>

</div>

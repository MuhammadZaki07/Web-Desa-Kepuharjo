<div>
    <button id="openFormBtn"
        class="fixed bottom-8 right-10 z-[999] text-white rounded-full w-14 h-14 shadow-lg bg-green-600 cursor-pointer transition-transform hover:scale-105">
        <i class="bi bi-pencil-square text-xl"></i>
    </button>

    <div id="floatingBtns"
        class="fixed bottom-[100px] right-12 flex flex-col items-center space-y-3 hidden transition-transform transform">
        <div id="csBtn"
            class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center cursor-pointer transition hover:scale-110">
            <i class="bi bi-telephone-forward text-xl"></i>
        </div>
        <div id="formBtn"
            class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center cursor-pointer transition hover:scale-110">
            <i class="bi bi-file-earmark-text text-xl"></i>
        </div>
    </div>

    <div id="formCard"
        class="fixed bottom-25 right-10 w-1/4 z-[9999] bg-white shadow-xl rounded-xl p-6 invisible opacity-0 scale-90 transition-all duration-300">
        <h2 class="text-2xl font-bold text-green-600">Form Pengajuan</h2>
        <p class="text-xs text-gray-600 mb-4">Mohon lengkapi form berikut untuk pengajuan. Data anda akan kami
            rahasiakan.</p>

        <form action="/pengajuan" method="POST" id="form" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="block text-sm font-semibold text-gray-700">Nama <span
                        class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" placeholder="Nama anda"
                    class="w-full p-2 border border-gray-300 rounded-md focus:border-green-600 focus:outline-none"
                    required>
            </div>

            <div class="mb-3">
                <label for="no_tlp" class="block text-sm font-semibold text-gray-700">Nomor telepon <span
                        class="text-red-500">*</span></label>
                <input type="text" id="no_tlp" name="no_tlp" placeholder="08***"
                    class="w-full p-2 border border-gray-300 rounded-md focus:border-green-600 focus:outline-none"
                    required>
            </div>

            <div class="mb-3">
                <label for="image" class="block text-sm font-semibold text-gray-700">Bukti Gambar (Optional)</label>
                <p class="text-xs text-gray-500 mb-2">Maksimal 5MB per gambar. Format: JPG, PNG, GIF</p>
                <div class="flex flex-wrap gap-4" id="imageContainer">
                    <div class="w-24 h-24 bg-gray-100 border border-gray-300 rounded-md flex items-center justify-center cursor-pointer"
                        id="addImageBtn">
                        <i class="bi bi-plus-lg text-gray-500 text-xl"></i>
                    </div>
                </div>
                <input type="file" multiple id="image" name="image[]" accept="image/*" class="hidden"
                    onchange="previewImage(event)">
            </div>

            <div class="mb-3">
                <label for="description" class="block text-sm font-semibold text-gray-700">Deskripsi <span
                        class="text-red-500">*</span></label>
                <textarea id="description" name="description" placeholder="Jelaskan pengajuan Anda dengan detail"
                    class="w-full p-2 border border-gray-300 rounded-md focus:border-green-600 focus:outline-none" rows="4"
                    required></textarea>
            </div>

            <button type="submit"
                class="w-full bg-green-600 text-white p-3 rounded-lg hover:bg-green-500 transition disabled:opacity-50 disabled:cursor-not-allowed">
                Kirim Pengajuan
            </button>
        </form>
    </div>
</div>

@push('js')
    <script>
        const openFormBtn = document.getElementById("openFormBtn");
        const floatingBtns = document.getElementById("floatingBtns");
        const csBtn = document.getElementById("csBtn");
        const formBtn = document.getElementById("formBtn");
        const formCard = document.getElementById("formCard");
        const addImageBtn = document.getElementById("addImageBtn");
        const imageInput = document.getElementById("image");
        const imageContainer = document.getElementById("imageContainer");
        const form = document.getElementById("form");

        if (openFormBtn) {
            openFormBtn.addEventListener("click", () => {
                floatingBtns.classList.toggle("hidden");
            });
        }

        if (csBtn) {
            csBtn.addEventListener("click", () => {
                window.open('https://wa.me/6285649729895', '_blank');
            });
        }

        if (formBtn) {
            formBtn.addEventListener("click", (event) => {
                event.stopPropagation();
                if (formCard.classList.contains("invisible")) {
                    formCard.classList.remove("invisible", "opacity-0", "scale-90");
                    formCard.classList.add("opacity-100", "scale-100");
                } else {
                    formCard.classList.remove("opacity-100", "scale-100");
                    formCard.classList.add("opacity-0", "scale-90");
                    setTimeout(() => formCard.classList.add("invisible"), 300);
                }
            });
        }

        if (addImageBtn) {
            addImageBtn.addEventListener("click", () => {
                imageInput.click();
            });
        }

        let selectedFiles = [];

        function previewImage(event) {
            const files = Array.from(event.target.files);

            files.forEach(file => {
                if (file.size > 5 * 1024 * 1024) {
                    alert(`File ${file.name} terlalu besar. Maksimal 5MB per gambar.`);
                    return;
                }

                if (!file.type.startsWith('image/')) {
                    alert(`File ${file.name} bukan gambar.`);
                    return;
                }

                selectedFiles.push(file);

                const reader = new FileReader();
                reader.onload = () => {
                    const imageDiv = document.createElement("div");
                    imageDiv.className =
                        "w-24 h-24 bg-gray-100 border border-gray-300 rounded-md relative group";

                    const img = document.createElement("img");
                    img.src = reader.result;
                    img.className = "w-full h-full object-cover rounded-md";

                    const removeBtn = document.createElement("button");
                    removeBtn.className =
                        "absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-sm cursor-pointer rounded-full hidden group-hover:flex items-center justify-center w-8 h-8";
                    removeBtn.innerHTML = '<i class="bi bi-trash"></i>';
                    removeBtn.onclick = () => {
                        const index = selectedFiles.indexOf(file);
                        if (index > -1) {
                            selectedFiles.splice(index, 1);
                        }
                        imageContainer.removeChild(imageDiv);
                    };

                    imageDiv.appendChild(img);
                    imageDiv.appendChild(removeBtn);
                    imageContainer.appendChild(imageDiv);
                };
                reader.readAsDataURL(file);
            });

            imageInput.value = "";
        }

        if (form) {
            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = 'Mengirim...';

                try {
                    const formData = new FormData();
                    formData.append('name', document.getElementById('name').value);
                    formData.append('no_tlp', document.getElementById('no_tlp').value);
                    formData.append('description', document.getElementById('description').value);

                    // Append selected images
                    selectedFiles.forEach((file, index) => {
                        formData.append('image[]', file);
                    });

                    const response = await fetch('/pengajuan', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        // Tampilkan pesan sukses
                        alert('Pengajuan berhasil dikirim! Kami akan segera meninjau pengajuan Anda.');

                        // Reset form
                        form.reset();
                        selectedFiles = [];

                        // Hapus preview gambar
                        const existingPreviews = imageContainer.querySelectorAll('div:not(#addImageBtn)');
                        existingPreviews.forEach(preview => preview.remove());

                        // Tutup form
                        formCard.classList.remove("opacity-100", "scale-100");
                        formCard.classList.add("opacity-0", "scale-90");
                        setTimeout(() => formCard.classList.add("invisible"), 300);

                    } else {
                        // Tampilkan error
                        let errorMessage = result.message || 'Terjadi kesalahan';

                        if (result.errors) {
                            const errors = Object.values(result.errors).flat();
                            errorMessage = errors.join('\n');
                        }

                        alert(errorMessage);
                    }

                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
                } finally {
                    // Restore button
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            });
        }

        window.addEventListener("click", (event) => {
            if (!formCard.contains(event.target) && !formBtn.contains(event.target)) {
                if (!formCard.classList.contains("invisible")) {
                    formCard.classList.remove("opacity-100", "scale-100");
                    formCard.classList.add("opacity-0", "scale-90");
                    setTimeout(() => formCard.classList.add("invisible"), 300);
                }
            }
        });
    </script>
@endpush

<div>
    <button id="openFormBtn" class="fixed bottom-8 right-10 z-[999] text-white rounded-full w-14 h-14 shadow-lg bg-green-600 cursor-pointer transition-transform hover:scale-105">
        <i class="bi bi-pencil-square text-xl"></i>
    </button>

    <div id="floatingBtns" class="fixed bottom-[100px] right-12 flex flex-col items-center space-y-3 hidden transition-transform transform">
        <div id="csBtn" class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center cursor-pointer transition hover:scale-110">
            <i class="bi bi-telephone-forward text-xl"></i>
        </div>
        <div id="formBtn" class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center cursor-pointer transition hover:scale-110">
            <i class="bi bi-file-earmark-text text-xl"></i>
        </div>
    </div>

    <div id="formCard" class="fixed bottom-25 right-10 w-1/4 z-[9999] bg-white shadow-xl rounded-xl p-6 invisible opacity-0 scale-90 transition-all duration-300">
        <h2 class="text-2xl font-bold text-green-600">Form Pengajuan</h2>
        <p class="text-xs text-gray-600 mb-4">Mohon lengkapi form berikut untuk pengajuan. Data anda akan kami rahasiakan.</p>

        <form action="#" method="POST" id="form">
            <div class="mb-3">
                <label for="name" class="block text-sm font-semibold text-gray-700">Nama <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded-md focus:border-green-600 focus:outline-none" required>
            </div>

            <div class="mb-3">
                <label for="email" class="block text-sm font-semibold text-gray-700">Email <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-md focus:border-green-600 focus:outline-none" required>
            </div>

            <div class="mb-3">
                <label for="image" class="block text-sm font-semibold text-gray-700">Bukti Gambar (Optional)</label>
                <div class="flex flex-wrap gap-4" id="imageContainer">
                    <div class="w-24 h-24 bg-gray-100 border border-gray-300 rounded-md flex items-center justify-center cursor-pointer" id="addImageBtn">
                        <i class="bi bi-plus-lg text-gray-500 text-xl"></i>
                    </div>
                </div>
                <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="previewImage(event)">
            </div>

            <div class="mb-3">
                <label for="description" class="block text-sm font-semibold text-gray-700">Deskripsi <span class="text-red-500">*</span></label>
                <textarea id="description" name="description" class="w-full p-2 border border-gray-300 rounded-md focus:border-green-600 focus:outline-none" required></textarea>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white p-3 rounded-lg hover:bg-green-500 transition">Kirim Pengajuan</button>
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

    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = () => {
                const imageDiv = document.createElement("div");
                imageDiv.className = "w-24 h-24 bg-gray-100 border border-gray-300 rounded-md relative group";

                const img = document.createElement("img");
                img.src = reader.result;
                img.className = "w-full h-full object-cover rounded-md";

                const removeBtn = document.createElement("button");
                removeBtn.className = "absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-sm cursor-pointer rounded-full hidden group-hover:flex items-center justify-center w-8 h-8";
                removeBtn.innerHTML = '<i class="bi bi-trash"></i>';
                removeBtn.onclick = () => {
                    imageContainer.removeChild(imageDiv);
                };

                imageDiv.appendChild(img);
                imageDiv.appendChild(removeBtn);
                imageContainer.appendChild(imageDiv);

                imageInput.value = "";
            };
            reader.readAsDataURL(file);
        }
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

<div>
    <div id="alertContainer" class="fixed top-4 right-4 z-[10000] space-y-2"></div>
    <button id="openFormBtn"
        class="fixed bottom-8 right-10 z-[9999] text-white rounded-full w-14 h-14 shadow-lg bg-green-600 cursor-pointer transition-transform hover:scale-105">
        <i class="bi bi-pencil-square text-xl"></i>
    </button>

    <div id="floatingBtns"
        class="fixed bottom-[100px] right-12 flex flex-col items-center space-y-3 hidden transition-transform transform z-[999]">
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
        class="fixed bottom-25 right-10 lg:w-1/4 w-4/5 z-[9999] bg-white shadow-xl rounded-xl p-6 invisible opacity-0 scale-90 transition-all duration-300">
        <h2 class="text-2xl font-bold text-green-600">Form Pengajuan</h2>
        <p class="text-xs text-gray-600 mb-4">Mohon lengkapi form berikut untuk pengajuan. Data anda akan kami
            rahasiakan.</p>

        <form id="form" enctype="multipart/form-data">
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
                <input type="tel" id="no_tlp" name="no_tlp" placeholder="08xxxxxxxxxx"
                    class="w-full p-2 border border-gray-300 rounded-md focus:border-green-600 focus:outline-none"
                    pattern="^(08|62)[0-9]{8,13}$"
                    title="Masukkan nomor telepon Indonesia yang valid (08xxxxxxxxxx atau 62xxxxxxxxxx)" maxlength="15"
                    required>
                <div id="phoneError" class="text-red-500 text-xs mt-1 hidden"></div>
                <div class="text-xs text-gray-500 mt-1">
                    Format: 08xxxxxxxxxx atau 62xxxxxxxxxx (10-15 digit)
                </div>
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
                <input type="file" multiple id="image" name="image[]" accept="image/*" class="hidden">
            </div>

            <div class="mb-3">
                <label for="description" class="block text-sm font-semibold text-gray-700">Deskripsi <span
                        class="text-red-500">*</span></label>
                <textarea id="description" name="description" placeholder="Jelaskan pengajuan Anda dengan detail"
                    class="w-full p-2 border border-gray-300 rounded-md focus:border-green-600 focus:outline-none" rows="4"
                    required></textarea>
            </div>

            <button type="submit"
                class="w-full cursor-pointer bg-green-600 text-white p-3 rounded-lg hover:bg-green-500 transition disabled:opacity-50 disabled:cursor-not-allowed">
                Kirim Pengajuan
            </button>
        </form>
    </div>
</div>

@push('js')
    <script>
        function showAlert(message, type = 'success', duration = 5000) {
            const alertContainer = document.getElementById('alertContainer');
            const alertId = 'alert-' + Date.now();

            const alertColors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };

            const alertIcons = {
                success: 'bi-check-circle',
                error: 'bi-exclamation-triangle',
                warning: 'bi-exclamation-triangle',
                info: 'bi-info-circle'
            };

            const alertDiv = document.createElement('div');
            alertDiv.id = alertId;
            alertDiv.className =
                `${alertColors[type]} text-white px-4 py-3 rounded-lg shadow-lg max-w-sm transform translate-x-full transition-transform duration-300 flex items-center justify-between`;

            alertDiv.innerHTML = `
            <div class="flex items-center">
                <i class="bi ${alertIcons[type]} text-lg mr-3"></i>
                <span class="text-sm font-medium">${message}</span>
            </div>
            <button onclick="closeAlert('${alertId}')" class="ml-4 text-white hover:text-gray-200 transition-colors">
                <i class="bi bi-x-lg"></i>
            </button>
        `;

            alertContainer.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.classList.remove('translate-x-full');
                alertDiv.classList.add('translate-x-0');
            }, 100);

            if (duration > 0) {
                setTimeout(() => {
                    closeAlert(alertId);
                }, duration);
            }
        }

        function closeAlert(alertId) {
            const alertDiv = document.getElementById(alertId);
            if (alertDiv) {
                alertDiv.classList.remove('translate-x-0');
                alertDiv.classList.add('translate-x-full');
                setTimeout(() => {
                    alertDiv.remove();
                }, 300);
            }
        }

        function validatePhoneNumber(phoneNumber) {
            const cleanedNumber = phoneNumber.replace(/[\s\-\(\)]/g, '');
            const patterns = [
                /^08[0-9]{8,11}$/,
                /^(\+62|62)[8-9][0-9]{7,10}$/,
                /^(\+62|62)[2-7][0-9]{7,9}$/
            ];

            return patterns.some(pattern => pattern.test(cleanedNumber));
        }

        function formatPhoneNumber(value) {
            let cleaned = value.replace(/[^\d+]/g, '');
            if (cleaned.startsWith('+62')) {
                return cleaned;
            } else if (cleaned.startsWith('62') && cleaned.length > 2) {
                return '+' + cleaned;
            } else if (cleaned.startsWith('0')) {
                return cleaned;
            } else if (cleaned.length > 0 && !cleaned.startsWith('0') && !cleaned.startsWith('6')) {
                return '08' + cleaned;
            }

            return cleaned;
        }

        const openFormBtn = document.getElementById("openFormBtn");
        const floatingBtns = document.getElementById("floatingBtns");
        const csBtn = document.getElementById("csBtn");
        const formBtn = document.getElementById("formBtn");
        const formCard = document.getElementById("formCard");
        const addImageBtn = document.getElementById("addImageBtn");
        const imageInput = document.getElementById("image");
        const imageContainer = document.getElementById("imageContainer");
        const form = document.getElementById("form");
        const phoneInput = document.getElementById("no_tlp");
        const phoneError = document.getElementById("phoneError");

        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value;
                const formatted = formatPhoneNumber(value);

                if (formatted !== value) {
                    e.target.value = formatted;
                }
                if (formatted.length > 3) {
                    if (validatePhoneNumber(formatted)) {
                        phoneInput.classList.remove('border-red-500');
                        phoneInput.classList.add('border-green-500');
                        phoneError.classList.add('hidden');
                    } else {
                        phoneInput.classList.remove('border-green-500');
                        phoneInput.classList.add('border-red-500');
                        phoneError.textContent = 'Format nomor telepon tidak valid';
                        phoneError.classList.remove('hidden');
                    }
                } else {
                    phoneInput.classList.remove('border-red-500', 'border-green-500');
                    phoneError.classList.add('hidden');
                }
            });

            phoneInput.addEventListener('keypress', function(e) {
                const allowedKeys = ['Backspace', 'Delete', 'Tab', 'ArrowLeft', 'ArrowRight'];
                const isNumber = /[0-9]/.test(e.key);
                const isPlus = e.key === '+' && e.target.value.length === 0;

                if (!isNumber && !isPlus && !allowedKeys.includes(e.key)) {
                    e.preventDefault();
                }
            });

            phoneInput.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                const formatted = formatPhoneNumber(pastedText);
                e.target.value = formatted;
                e.target.dispatchEvent(new Event('input'));
            });
        }

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
                    showAlert(`File ${file.name} terlalu besar. Maksimal 5MB per gambar.`, 'error');
                    return;
                }

                if (!file.type.startsWith('image/')) {
                    showAlert(`File ${file.name} bukan gambar.`, 'error');
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
                        event.stopPropagation();
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

        if (imageInput) {
            imageInput.addEventListener('change', previewImage);
        }

        if (form) {
            form.addEventListener("submit", async (e) => {
                e.preventDefault();
                const phoneValue = phoneInput.value;
                if (!validatePhoneNumber(phoneValue)) {
                    showAlert('Nomor telepon tidak valid. Pastikan menggunakan format Indonesia yang benar.',
                        'error');
                    phoneInput.focus();
                    return;
                }

                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = 'Mengirim...';

                try {
                    const formData = new FormData();
                    formData.append('name', document.getElementById('name').value);
                    formData.append('no_tlp', phoneValue);
                    formData.append('description', document.getElementById('description').value);

                    selectedFiles.forEach((file, index) => {
                        formData.append('image[]', file);
                    });

                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        throw new Error('CSRF token not found. Please refresh the page.');
                    }

                    const response = await fetch('/pengajuan', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        let result;

                        try {
                            const responseText = await response.text();
                            console.log('Response text:', responseText);

                            if (responseText.trim()) {
                                result = JSON.parse(responseText);
                            } else {
                                result = {
                                    success: true,
                                    message: 'Pengajuan berhasil dikirim!'
                                };
                            }
                        } catch (jsonError) {
                            console.error('Failed to parse JSON:', jsonError);
                            result = {
                                success: true,
                                message: 'Pengajuan berhasil dikirim!'
                            };
                        }

                        if (result.success !== false) {
                            showAlert(result.message || 'Pengajuan berhasil dikirim!', 'success');
                            form.reset();
                            selectedFiles = [];
                            const existingPreviews = imageContainer.querySelectorAll('div:not(#addImageBtn)');
                            existingPreviews.forEach(preview => preview.remove());
                            formCard.classList.remove("opacity-100", "scale-100");
                            formCard.classList.add("opacity-0", "scale-90");
                            setTimeout(() => formCard.classList.add("invisible"), 300);
                            floatingBtns.classList.add("hidden");
                            phoneInput.classList.remove('border-red-500', 'border-green-500');
                            phoneError.classList.add('hidden');
                        } else {
                            let errorMessage = result.message || 'Terjadi kesalahan saat mengirim pengajuan.';
                            if (result.errors) {
                                const errors = Object.values(result.errors).flat();
                                errorMessage = errors.join(', ');
                            }
                            showAlert(errorMessage, 'error');
                        }
                    } else {
                        let errorMessage = 'Terjadi kesalahan saat mengirim pengajuan.';
                        try {
                            const errorResult = await response.json();
                            if (errorResult.message) {
                                errorMessage = errorResult.message;
                            }
                            if (errorResult.errors) {
                                const errors = Object.values(errorResult.errors).flat();
                                errorMessage = errors.join(', ');
                            }
                        } catch (e) {
                            errorMessage = `Error ${response.status}: ${response.statusText}`;
                        }

                        showAlert(errorMessage, 'error');
                    }

                } catch (error) {
                    console.error('Network or other error:', error);

                    let errorMessage = 'Terjadi kesalahan jaringan. Silakan coba lagi.';

                    if (error.message.includes('CSRF token')) {
                        errorMessage = 'CSRF token tidak ditemukan. Silakan refresh halaman.';
                    } else if (error.name === 'TypeError' && error.message.includes('fetch')) {
                        errorMessage = 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                    }

                    showAlert(errorMessage, 'error');
                } finally {
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

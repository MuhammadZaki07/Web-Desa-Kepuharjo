<div class="z-[999] left-0 bg-white shadow-lg border border-slate-200 top-1/2 w-16 rounded-lg py-2 fixed">
    <div class="flex flex-col gap-4 text-white justify-center" id="social-share">
        <a href="#" id="wa-share" target="_blank" title="Share to WhatsApp" class="text-green-500 text-center hover:text-green-700 text-xl"
            title="Share to WhatsApp">
            <i class="bi bi-whatsapp"></i>
        </a>

        <a href="#" id="fb-share" target="_blank" title="Share to Facebook" class="text-blue-500 text-center hover:text-blue-700 text-xl"
            title="Share to Facebook">
            <i class="bi bi-facebook"></i>
        </a>

        <a href="#" id="twitter-share" title="Share to X (Twitter)" target="_blank" class="text-black text-center hover:text-black/50 text-xl"
            title="Share to X (Twitter)">
            <i class="bi bi-twitter-x"></i>
        </a>
    </div>
</div>

@push('js')
    <script>
        const pageUrl = encodeURIComponent(window.location.href);
        const shareText = encodeURIComponent("Cek halaman ini!");

        document.getElementById("wa-share").href = `https://wa.me/?text=${shareText}%20${pageUrl}`;
        document.getElementById("fb-share").href = `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`;
        document.getElementById("twitter-share").href =
            `https://twitter.com/intent/tweet?url=${pageUrl}&text=${shareText}`;
    </script>
@endpush

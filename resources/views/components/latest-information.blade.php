<section class="w-full py-10 lg:px-20 px-5">
    <div class="flex justify-center">
        <x-badge bg="bg-green-100" class="py-1 w-1/7 px-2 hidden lg:flex">
            Informasi Terkini
        </x-badge>
    </div>
    <x-running-blog :blogs="$blogs" />
    <x-fyp-blogs :viralBlogs="$viralBlogs"/>
</section>

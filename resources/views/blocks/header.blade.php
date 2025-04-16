<header class="bg-purple-custom text-white">
    <nav class="container mx-auto px-4 py-3 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}" class="font-bold">ТИ - ОСОБЛИВИЙ</a>
            <a href="{{ route('home') }}" class="hover:text-blue-200 transition-colors">Про нас</a>
            <a href="{{ route('clubs') }}" class="hover:text-blue-200 transition-colors">Наші гуртки</a>
            <a href="{{ route('teachers') }}" class="hover:text-blue-200 transition-colors">Наші викладачі</a>
        </div>
        <button class="border border-white px-4 py-1 rounded hover:bg-white hover:text-purple-600 transition-colors">
            Увійти в кабінет вчителя
        </button>
    </nav>
</header>

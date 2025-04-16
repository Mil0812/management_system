@extends('layouts.main')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($clubs as $club)
            <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                @if ($club->image)
                    <img src="{{ filter_var($club->image, FILTER_VALIDATE_URL) ? $club->image : asset('storage/' . $club->image) }}" alt="{{ $club->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">Немає зображення</span>
                    </div>
                @endif
                <div class="p-4">
                    <h2 class="text-xl font-bold mb-2">{{ $club->name }}</h2>
                    <p class="text-gray-600">{{ $club->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@extends('layouts.main')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($teachers as $teacher)
            <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                <div class="flex items-center p-4">
                    @if ($teacher->image)
                        <img src="{{ filter_var($teacher->image, FILTER_VALIDATE_URL) ? $teacher->image : asset('storage/' . $teacher->image) }}" alt="{{ $teacher->name }}" class="w-24 h-24 rounded-full object-cover mr-4">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                            <span class="text-gray-500">Немає фото</span>
                        </div>
                    @endif
                    <div>
                        <h2 class="text-xl font-bold">{{ $teacher->name }}</h2>
                        <p class="text-gray-600">{{ $teacher->email }}</p>
                        <p class="text-gray-600">Гуртки: {{ $teacher->clubs->pluck('name')->join(', ') }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

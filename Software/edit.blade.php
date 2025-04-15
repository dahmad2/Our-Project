<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Asset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.assets.update', $asset->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Postcode</label>
                        <input type="text" name="postcode" value="{{ old('postcode', $asset->postcode) }}" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Ward</label>
                        <input type="text" name="ward_name_current" value="{{ old('ward_name_current', $asset->ward_name_current) }}" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude', $asset->latitude) }}" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude', $asset->longitude) }}" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('admin.assets.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Asset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('notes.store') }}" method="post" class="max-w-2xl">
                    @csrf 
                    <x-text-input name='title' class="w-full" placeholder="Note Tittle" value="{{ @old('title') }}"></x-text-input>
                    @error('title')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror


                    <x-textarea name="description" class="w-full mt-6" placeholder="Type your note here" rows="8" value="{{ @old('description') }}" ></x-textarea>
                    @error('description')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror

                    <select name="notebook_id" class="w-full mt-6 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">-- Select Notebook --</option>
                        @foreach($notebooks as $notebook)
                        <option value="{{ $notebook->id }}">{{ $notebook->name }}</option>
                        @endforeach
                    </select>



                    <x-primary-button class="mt-6">Save Note</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
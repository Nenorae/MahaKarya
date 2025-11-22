<div>
    <form wire:submit.prevent="save">

        <h3>Pilih Keahlian (Skills)</h3>

        <div class="grid grid-cols-3 gap-4">
            @foreach($allSkills as $skill)
            <label class="flex items-center space-x-2">
                <input type="checkbox" value="{{ $skill->id }}" wire:model="selectedSkills">
                <span>{{ $skill->name }}</span>
            </label>
            @endforeach
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-4 rounded">
            Simpan Perubahan
        </button>
    </form>

    @if (session()->has('message'))
    <div class="alert alert-success mt-2">
        {{ session('message') }}
    </div>
    @endif
</div>
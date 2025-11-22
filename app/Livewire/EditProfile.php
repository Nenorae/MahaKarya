<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;

class EditProfile extends Component
{
    // Array untuk menampung ID skill yang dipilih user
    public $selectedSkills = [];

    public function mount()
    {
        // Ambil skill yang SUDAH dimiliki user saat halaman dimuat
        $this->selectedSkills = Auth::user()->skills->pluck('id')->toArray();
    }

    public function save()
    {
        $user = Auth::user();

        // Update data user lain (nama, email, dll)...

        // MAGIC: Simpan relasi Many-to-Many (skill_user)
        // 'sync' akan otomatis menambah yang baru dan menghapus yang tidak dicentang
        $user->skills()->sync($this->selectedSkills);

        session()->flash('message', 'Profil dan Skill berhasil diupdate!');
    }

    public function render()
    {
        return view('livewire.edit-profile', [
            'allSkills' => Skill::all() // Kirim semua opsi skill ke view
        ]);
    }
}

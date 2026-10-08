<?php

namespace Database\Seeders;

use App\Models\ChecklistItem;
use Illuminate\Database\Seeder;

class ChecklistItemSeeder extends Seeder
{
    /**
     * The five daily targets exactly as shown in the app.
     */
    public const ITEMS = [
        'Makan 3 kali dan 2 kali selingan',
        'Ada lauk hewani (ikan/telur/daging)',
        'Makan sayur dan buah',
        'Minum tablet tambah darah',
        'Minum air putih minimal 8 gelas',
    ];

    public function run(): void
    {
        foreach (self::ITEMS as $position => $label) {
            ChecklistItem::create([
                'label' => $label,
                'position' => $position,
            ]);
        }
    }
}

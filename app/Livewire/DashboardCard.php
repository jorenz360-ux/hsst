<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Donation;

class DashboardCard extends Component
{
    use WithPagination;

    public $title;

 
    public string $search = '';
    public ?string $from = null; // YYYY-MM-DD
    public ?string $to = null;   // YYYY-MM-DD

    protected $queryString = [
        'search' => ['except' => ''],
        'from' => ['except' => null],
        'to' => ['except' => null],
        'page' => ['except' => 1],
    ];

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFrom(): void { $this->resetPage(); }
    public function updatingTo(): void { $this->resetPage(); }

    public function resetFilters(): void
    {
        $this->reset(['search', 'from', 'to']);
        $this->resetPage();
    }

   public function render()
{
    $alumniId = Auth::user()?->alumni_id;

    if (!$alumniId) {
        return view('dashboard', [
            'donations' => Donation::whereRaw('1=0')->paginate(10), // empty result
        ]);
    }

    $donations = Donation::query()
        ->where('alumni_id', $alumniId) //  always filter
        ->when($this->search !== '', function ($q) {
            $s = '%' . $this->search . '%';
            $q->where(function ($qq) use ($s) {
                $qq->where('remarks', 'like', $s)
                   ->orWhere('amount', 'like', $s);
            });
        })
        ->when($this->from, fn ($q) => $q->whereDate('created_at', '>=', $this->from))
        ->when($this->to, fn ($q) => $q->whereDate('created_at', '<=', $this->to))
        ->latest()
        ->paginate(10);

    return view('dashboard', [
        'donations' => $donations,
    ]);
}
}
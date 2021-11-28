<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Income as IncomeModel;
use App\Models\Tags;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Livewire\WithPagination;

class Income extends Component
{
    use WithPagination;

    public $isModalOpen = 0, $tags=0, $selDate = '', $searchQuery='', $itemsPerPage = 0;
    public IncomeModel $income;

    protected $rules = [
        'income.name' => 'required',
        'income.price' => 'required',
        'income.user_id' => '',
        'income.description' =>'',
        'income.on_date' => 'required',
        'income.tags' => '',
        
    ];

    public function mount()
    {
        $this->selDate = Carbon::now()->format('Y-m-d');
        $this->itemsPerPage = 5;
    }
    
    public function render()
    {
        $incomeRecords = IncomeModel::where('user_id', auth()->user()->id)
                    ->when($this->selDate!='', function($query) {
                        $query->whereDate('on_date', $this->selDate);
                    })
                    ->when($this->searchQuery!='', function($query) {
                        $query->where('name', 'like', '%'.$this->searchQuery.'%');
                        $query->orWhere('tags', 'like', '%'.$this->searchQuery.'%');
                    })
                    ->when($this->searchQuery !='' && $this->selDate!='', function($query) {
                        $query->whereDate('on_date', $this->selDate)
                              ->where(function ($secondQuery) {
                                    $secondQuery->where('name', 'like', '%'.$this->searchQuery.'%')
                                                ->orWhere('tags', 'like', '%'.$this->searchQuery.'%');
                             });
                    });
        $totalIncome = $incomeRecords->sum('price');
        $incomeRecords = $incomeRecords->paginate($this->itemsPerPage);

        return view('livewire.income.list',[
            "totalIncome" => $totalIncome,
            "incomeRecords" => $incomeRecords,
            "timePeriod" => "Today's",
        ]);
    }

    public function create(){
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
        $this->tags = Tags::where('user_id', auth()->user()->id)
                      ->where('source_type', 1)
                      ->get();
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm(){
        $this->income = new IncomeModel;
        $this->income->on_date = date('Y-m-d',strtotime("now"));
    }

    public function store()
    {
        $this->validate();

        $tag = trim($this->income->tags);
        if(!empty($tag)){
            Tags::updateOrCreate([
                "name" => $tag,
                "user_id" => auth()->user()->id,
                "source_type" => 1,
            ],
            [
                "name" => $tag,
                "user_id" => auth()->user()->id,
                "source_type" => 1,
            ]);
        }
        
        session()->flash('message', isset($this->income->id) ? 'Income updated.' : 'Income created.');
        $this->income->price = floatval($this->income->price);
        $this->income->user_id = auth()->user()->id;
        $this->income->save();

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($income_id)
    {
        $income = IncomeModel::findOrFail($income_id);
        $this->income = $income;
        $this->income->price = round($this->income->price,2);
        $this->openModalPopover();
    }
    
    public function delete($income_id)
    {
        IncomeModel::find($income_id)->delete();
        session()->flash('message', 'Income deleted.');
    }
}

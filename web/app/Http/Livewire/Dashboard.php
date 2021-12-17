<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Expense;
use App\Models\Income;
use stdClass;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $year= null;
    public $graphData=null;
    public $graphTitle = null;
    public $graphType = null;
    
    public function mount()
    {
        $this->year = $this->year ?? date("Y");
        $this->graphType = $this->graphType ?? 'expenses';
    }

    public function render()
    {
        if ($this->graphType == 'expenses' || $this->graphType == '') {
            $records = $this->getExpenseGraphData();
            $this->graphTitle = "Annual Expense for ".$this->year;
        } else if($this->graphType=='compare'){
            $records = $this->getComparisonGraphData();
            $this->graphTitle = "Income vs Expense for ".$this->year;
        }else {
            $records = $this->getIncomeGraphData();
            $this->graphTitle = "Annual Income for ".$this->year;
        }

        $this->graphData = json_encode($records);

        return view('dashboard', [
            "data" => $this->graphData,
            "title" => $this->graphTitle,
        ]);
    }

    public function getComparisonGraphData(){
        $expenseData = Expense::Where('user_id', auth()->user()->id)
                    ->whereYear('created_at',$this->year)
                    ->orderBy('created_at')
                    ->get()
                    ->groupBy(function($date) {
                        return Carbon::parse($date->on_date)->format('m');
                    })
                    ->toArray();
        $incomeData = Income::Where('user_id', auth()->user()->id)
                    ->whereYear('created_at',$this->year)
                    ->orderBy('created_at')
                    ->get()
                    ->groupBy(function($date) {
                        return Carbon::parse($date->on_date)->format('m');
                    })
                    ->toArray();

        $x = [];
        $y = [];            
        $total_value = 0;
        foreach($expenseData as $month_key => $values ){
            foreach($values as $value){
                $total_value += $value['price'];
                
                
            }
            $x[] = $month_key;
            $y[] = round($total_value);
        }

       
        $trace1 =  new stdClass();
        $trace1->type = "bar";
        $trace1->name = "Expense";
        $trace1->x =  $x;
        $trace1->y =  $y;
       
        $x = [];
        $y = [];
        $total_value = 0;
        foreach($incomeData as $month_key => $values ){
            foreach($values as $value){
                $total_value += $value['price'];
            }
            $x[] = $month_key;
            $y[] = round($total_value);
        }

        $trace2 =  new stdClass();
        $trace2->type = "bar";
        $trace2->name = "Income";
        $trace2->x =  $x;
        $trace2->y =  $y;
        
        
        $data = [ $trace2, $trace1 ];
        return $data;       
    }

    public function getExpenseGraphData()
    {
        $expenseData = Expense::where('user_id', auth()->user()->id)
                    ->whereYear('created_at',$this->year)
                    ->orderBy('created_at')
                    ->get()
                    ->groupBy(function($date) {
                        return Carbon::parse($date->created_at)->format('m');
                    })
                    ->toArray();
         
        $records = $this->getGraphData($expenseData);            
        return $records;
    }

    public function getIncomeGraphData()
    {
        $incomeData = Income::where('user_id', auth()->user()->id)
                    ->whereYear('created_at',$this->year)
                    ->orderBy('created_at')
                    ->get()
                    ->groupBy(function($date) {
                        return Carbon::parse($date->created_at)->format('m');
                    })
                    ->toArray();
         
        $records = $this->getGraphData($incomeData);            
        return $records;
    }


    public function getGraphData($data)
    {
        $records = [];
        $column = 0;

        foreach($data as $month_key => $values){
            
            $data = new stdClass();
            $total_amount = 0;
            foreach($values as $value){
                $data->values[] = $value['price'];
                $data->labels[] = $value['tags'];
                $total_amount += $value['price'];
            }

            $data->domain = new stdClass();
            $data->domain->column = $column;
            $data->type = "pie";
            $data->title = new StdClass();
            $data->title->text = ucwords($this->graphType)." for ".date('M Y',strtotime($this->year."-".$month_key))."<br>Total: ".format_money($total_amount);
            
            $data->hole = .6;
            $data->textposition = "inside";
            $data->hoverinfo = 'label+percent';
            $data->automargin = true;
            $data->insidetextorientation = "radial";

            $records[] = $data;     
            $column++;

        }
        return $records;
    }
}
<div>
<x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
         {{ __('Overview ') }} 
        </h2> 
</x-slot>

<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <span class="mt-5">
                          <label for="selYear">Year: </label>
                          <input type="number" id="selYear" wire:model="year" list="year" max="{{ date('Y') }}" min="1900" />
                          <datalist id="year">
                                @php
                                  for($i=1950;$i<=date('Y');$i++){
                                    echo '<option value="'.$i.'">';
                                  }
                                @endphp
                          </datalist>
                        </span>
                        <span class="pl-10 mt-5">
                          <label for="selType">Source: </label>
                          <select id="selType" wire:model="graphType">
                            <option value="expenses">Expense</option>
                            <option value="income">Income</option>
                            <option value="compare">Income vs Expense</option>
                          </select>
                        </span>
                        <div id="myDiv" height="100%" width="100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src='https://cdn.plot.ly/plotly-2.6.3.min.js'></script>
<script>
var data = {!! $data !!};
var modeConfig = {displayModeBar: false};
var layout = {
  title: "{{ $title }}",
  margin: {"t": 80, "b": 0, "l": 0, "r": 0},
  showlegend: false,
  grid: {rows: 1, columns: 3}
};

var setLayoutGrid = (data) =>{
                
    layout.grid.rows = Math.ceil(data.length/3);

    if(data.length%3 == 0 || data.length > 3){
      layout.grid.columns = 3;
    }else if(data.length%2 == 0){
      layout.grid.columns = 2;
    }else{
      layout.grid.columns = 1;
    }
};



if(data.length > 0){
  setLayoutGrid(data);
  Plotly.newPlot('myDiv', data, layout, modeConfig);  
}




document.addEventListener("DOMContentLoaded", () => {

        Livewire.hook('element.updated', (el, component) => {
            layout.title = component.serverMemo.data.graphTitle;

            let graphData = JSON.parse(component.serverMemo.data.graphData);
            
            if(graphData.length > 0){
              if(graphData[0].type=='bar'){
                layout.showlegend = true;
                layout.grid = {};

              }else{
                setLayoutGrid(graphData);
                layout.showlegend = false;
              }
                     
              Plotly.newPlot('myDiv', graphData, layout, modeConfig);
                
            }else{
              document.getElementById('myDiv').innerHTML = `<p class="mt-5">
              Sorry, no data is available for this year.
              </p>`;
            }
            
        });

});
</script>
</div>
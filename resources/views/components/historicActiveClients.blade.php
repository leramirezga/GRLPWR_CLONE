@push('head-content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
<h2 class="section-title text-center">Historico clientes activos:</h2>
<div class="themed-block col-12 col-md-10 mx-auto mt-4 p-2">
    <x-chart id="historic-active-users" type="line" :labels="$labels" :datasets="$datasets" ></x-chart>
<h2 class="section-title text-center">Historico clientes retenidos:</h2>
<div class="themed-block col-12 col-md-10 mx-auto mt-4 p-2">
    <x-chart id="historic-retained-users" type="line" :labels="$labels2" :datasets="$datasets2" ></x-chart>
</div>
<h2 class="section-title text-center">Historico Porcentaje de clientes retenidos:</h2>
<div class="themed-block col-12 col-md-10 mx-auto mt-4 p-2">
    <x-chart id="historic-percent-retained-users" type="line" :labels="$labels3" :datasets="$datasets3" ></x-chart>
</div>
</div>

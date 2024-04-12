@push('head-content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
<h2 class="section-title text-center">Historico clientes activos:</h2>
<div class="themed-block col-12 col-md-10 mx-auto mt-4 p-2">
    <x-chart id="historic-active-users" type="line" :labels="$labels" :datasets="$dataset"></x-chart>
</div>
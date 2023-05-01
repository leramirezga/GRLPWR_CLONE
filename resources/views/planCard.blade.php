<div class="card floating-card bg-dark text-center py-5 px-3 mb-5 d-flex flex-column align-items-start" style="height: 75vh">
    <div class="mx-auto mb-auto">
        <h2>{{$plan->name}}</h2>
        <p>a</p>
    </div>
    <div class="mx-auto w-75">
        <h2><strong> ${{number_format($plan->price, 0, '.', ',')}}</strong></h2>

        @switch($plan->plan_type)
            @case(\App\Utils\PlanTypesEnum::Kangoo_rent->value)
            <p class="text-white-50">Kangoos Alquilados</p>
            @break

            @case(\App\Utils\PlanTypesEnum::Kangoo_own->value)
            <p class="text-white-50">Kangoos propios</p>
            @break
        @endswitch

        <table class="table bg-dark">
            <tbody>
            <tr class="border-bottom">
                <td class="border-top-0 text-left">Clases</td>
                <td class="border-top-0 text-right">{{$plan->number_of_classes}}</td>
            </tr>
            <tr class="border-bottom">
                <td class="border-top-0 text-left">Duración</td>
                <td class="border-top-0 text-right">{{$plan->duration_days}} días</td>
            </tr>
            </tbody>
        </table>
        <button class="btn btn-success mt-3" onclick="showPayModal({{$plan}})">Seleccionar</button>
    </div>
</div>
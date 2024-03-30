<div style="width: 270px;" class="card themed-block text-center py-4 px-1 mb-5 mx-auto d-flex flex-column align-items-center" style="height: 75vh">
    <div class="mx-auto mb-auto">
        <h2>Membresía</h2>
        <h2>{{$plan->name}}</h2>
        <div style="height: 160px" class="d-flex my-3">
            <img height="100%" src="{{asset("images/".$plan->image)}}" class="m-auto"/>
        </div>
    </div>
    <div class="mx-auto w-75">
        <h2><strong> ${{number_format($plan->price, 0, '.', ',')}}</strong></h2>

        <table class="table m-0">
            <tbody>
            @foreach(\App\ClassType::all() as $class)
                <tr @if($loop->first)class="border-top"@endif>
                    <td class="border-top-0 p-0 text-left align-middle">{{$class->type}}</td>
                    @if($loop->first)
                        <td class="border-top-0 text-right align-middle" rowspan="{{$loop->count}}">{{$plan->number_of_shared_classes ?? '∞'}}</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        {{--FIT-57: Uncomment this if you want specific classes
        @isset($plan->sharedClasses)
            <table class="table m-0">
                <tbody>
                    @foreach($plan->sharedClasses as $class)
                    <tr @if($loop->first)class="border-top"@endif>
                        <td class="border-top-0 text-left align-middle">{{$class->classType->type}}</td>
                        @if($loop->first)
                            <td class="border-top-0 text-right align-middle" rowspan="{{$loop->count}}">{{$plan->number_of_shared_classes}}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endisset
        @isset($plan->specificClasses)
            <table class="table m-0">
                <tbody>
                    @foreach($plan->specificClasses as $class)
                        <tr @if($loop->first)class="border-top"@endif>
                            <td class="border-top-0 text-left align-middle">{{$class->classType->type}}</td>
                            <td class="border-top-0 text-right align-middle">{{$class->number_of_classes}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endisset
        @isset($plan->unlimitedClasses)
            <table class="table m-0">
                <tbody>
                    @foreach($plan->unlimitedClasses as $class)
                        <tr @if($loop->first)class="border-top"@endif>
                            <td class="border-top-0 text-left align-middle">{{$class->classType->type}}</td>
                            @if($loop->first)
                                <td class="border-top-0 text-right align-middle" style="font-size: xx-large; line-height: 0.8" rowspan="{{$loop->count}}">∞</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endisset
        --}}
        @isset($plan->benefits)
            <table class="table m-0">
                <tbody>
                @foreach($plan->benefits as $benefit)
                    <tr @if($loop->first)class="border-top"@endif>
                        <td class="border-top-0 text-left pr-0 align-middle" style="width: 90%">{{$benefit->benefit}}</td>
                        <td class="border-top-0 text-right align-middle pl-0"><i class="fas fa-check"></i>                       </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endisset
        <table class="table m-0">
            <tbody>
            <tr class="border-top">
                <td class="border-top-0 text-left align-middle">Duración</td>
                <td class="border-top-0 text-right align-middle" style="width: 90%">{{$plan->duration_days}} días</td>
            </tr>
            </tbody>
        </table>
    </div>
    <a style="bottom: -20px" class="btn color-white themed-btn mt-3 position-absolute" @if(auth()->guest()) href="{{ route('register') }}" @else onclick="showPayModal({{$plan}})" @endif>Seleccionar</a>
</div>
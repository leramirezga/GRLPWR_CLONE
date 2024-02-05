<x-modalDarReview :reviewFor=$reviewFor>
    <x-slot:reviewModalId>
        reviewEntrenamiento
    </x-slot>
    <x-slot:route>
        {{route('darReviewEntrenamiento')}}
    </x-slot>
    <x-slot:questionTitle>
        {{$eventName}}
    </x-slot>
</x-modalDarReview>
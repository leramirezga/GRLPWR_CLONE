<div id="WheelOfLife-section" class="themed-block p-3"  style="display: none;">
    <form id="wheelOfLifeForm">
        @csrf
        <h1 class="text-center">¿Cómo te sientes en tu vida?</h1>
        <x-range name="health" description="Salud: ¿Estás contenta con tu fortaleza física y mental?" min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
        <x-range name="personal_growth" description="Desarrollo Personal: ¿Te sientes realizada con lo que quieres hacer?" min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
        <x-range name="home" description="Hogar: ¿Estás satisfecha en el sitio donde vives?" min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
        <x-range name="family_and_friends" description="Familia y amigos: ¿Estás satisfecha con tu círculo social?" min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
        <x-range name="love" description="Amor: ¿En qué medida hay armonía en tu vida sentimental?" min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
        <x-range name="leisure" description="Ocio: ¿Cuánto te llena el tiempo libre que tienes?" min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
        <x-range name="work" description="Trabajo: ¿Qué grado de satisfacción profesional tienes? " min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
        <x-range name="money" description="Dinero: ¿Estás contenta con el dinero que manejas?" min="1" max="10" showReason="1" reason="¿Por qué?" required></x-range>
        <div class="d-flex justify-content-between">
            <button class="btn btn-danger mt-3 mx-auto" onclick="hideWheelOfLifeSection()">Quitar Sección Como te sientes?</button>
            <button class="btn themed-btn mt-3 mx-auto d-block" type="submit">Guardar Sección</button>
        </div>
    </form>
</div>
<p class="mt-3 mx-auto text-center cursor-pointer" id="showWheelOfLifeSection" onclick="showWheelOfLifeSection()">+ Rueda de la vida</p>


@push('scripts')
    <script>
        function showWheelOfLifeSection() {
            const section = document.getElementById('WheelOfLife-section');
            document.getElementById('showWheelOfLifeSection').style.display = 'none';
            section.style.display = 'block';
        }
        function hideWheelOfLifeSection() {
            const section = document.getElementById('WheelOfLife-section');
            document.getElementById('showWheelOfLifeSection').style.display = 'block';
            section.style.display = 'none';
        }

        function saveWheelOfLifeTest(){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('saveWheelOfLifeTest') }}",
                method: "POST",
                data: {
                    user_id : {{$user->id}},
                    health : document.getElementById('health').value,
                    reason_health: document.getElementById('reason_health').value,
                    personal_growth: document.getElementById('personal_growth').value,
                    reason_personal_growth: document.getElementById('reason_personal_growth').value,
                    home: document.getElementById('home').value,
                    reason_home: document.getElementById('reason_home').value,
                    family_and_friends: document.getElementById('family_and_friends').value,
                    reason_family_and_friends: document.getElementById('reason_family_and_friends').value,
                    love : document.getElementById('love').value,
                    reason_love : document.getElementById('reason_love').value,
                    leisure : document.getElementById('leisure').value,
                    reason_leisure : document.getElementById('reason_leisure').value,
                    work : document.getElementById('work').value,
                    reason_work : document.getElementById('reason_work').value,
                    money : document.getElementById('money').value,
                    reason_money : document.getElementById('reason_money').value,
                },

                success: handleAjaxResponse,
                error: handleAjaxResponse
            });
        }

        $(document).ready(function() {
            $('#wheelOfLifeForm').submit(function (event) {
                event.preventDefault();
                saveWheelOfLifeTest();
            });
        });
    </script>
@endpush
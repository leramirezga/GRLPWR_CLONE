<div id="wellBeing-section" class="themed-block p-3"  style="display: none;">
    <form id="wellBeingForm">
        @csrf
        <h1 class="text-center">Mentalidad</h1>
        <x-range name="body_relation" description="De 1 a 10: ¿Cómo consideras es tú relación con tú cuerpo?" min="1" max="10" required></x-range>
        <x-input name="body_discomfort" description="¿Hay alguna parte de tu cuerpo que te haga sentir incómoda o que quieras mejorar?" type="text" required></x-input>
        <x-raddio name="stress" description="¿Experimentas estrés, ansiedad o algún otro desafío de salud mental?" checked="1" showReason="1" reason="¿Cúal?" required></x-raddio>
        <x-raddio name="spiritual_belief" description="¿Tienes alguna creencia espiritual o filosofía de vida que te sea importante?" checked="1" showReason="1" reason="¿Cúal?" required></x-raddio>
        <x-raddio name="stress_practice" description="¿Participas en prácticas de manejo del estrés o bienestar mental?" checked="1" showReason="1" reason="¿Cúal?" required></x-raddio>
        <div class="d-flex justify-content-between">
            <button class="btn btn-danger mt-3 mx-auto" onclick="hideWellBeingSection()">Quitar Sección de mentalidad</button>
            <button class="btn themed-btn mt-3 mx-auto d-block" type="submit">Guardar Sección</button>
        </div>
    </form>
</div>
<p class="mt-3 mx-auto text-center cursor-pointer" id="showWellBeingSection" onclick="showWellBeingSection()">+ Sección Mentalidad</p>

@push('scripts')
    <script>
        function showWellBeingSection() {
            const section = document.getElementById('wellBeing-section');
            document.getElementById('showWellBeingSection').style.display = 'none';
            section.style.display = 'block';
        }
        function hideWellBeingSection() {
            const section = document.getElementById('wellBeing-section');
            document.getElementById('showWellBeingSection').style.display = 'block';
            section.style.display = 'none';
        }

        function saveWellBeingTest(){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('saveWellBeingTest') }}",
                method: "POST",
                data: {
                    user_id : {{$user->id}},
                    body_relation : document.getElementById('body_relation')?.value,
                    body_discomfort: document.getElementById('body_discomfort')?.value,
                    stress: document.getElementById('reason-stress')?.value,
                    stress_practice: document.getElementById('reason-stress_practice')?.value,
                    spiritual_belief: document.getElementById('reason-spiritual_belief')?.value,
                },

                success: handleAjaxResponse,
                error: handleAjaxResponse
            });
        }

        $(document).ready(function() {
            $('#wellBeingForm').submit(function (event) {
                event.preventDefault();
                saveWellBeingTest();
            });
        });
    </script>
@endpush
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Hamming Distance') }}
        </h2>
    </x-slot>

@push('hamming.distance')
<script src="{{ asset('js/hamming-distance.js') }}" defer></script>
@endpush

<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
    <div id="msgError" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white">
            <strong class="me-auto">Hamming Distance</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>
</div>
    <div class="py-12">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-3 bg-white px-3 py-5">
                    <div class="row">
                        <div class="col-sm-1">
                            X
                        </div>
                        <div class="col-sm">
                            <input type="number" name="" min=0 id="numFirstInteger" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-1">
                            Y
                        </div>
                        <div class="col-sm">
                            <input type="number" name="" min=0 id="numSecondInteger" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row mt-3 justify-content-end">
                        <div class="col-sm-5 d-grid">
                            <button id="btnCalculate" class="btn btn-primary">Calculate</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 d-none" id="results">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 table-responsive">
                Distance is <span id="numHammingDistance"></span><br><br>

                Explanation:<br>
                <table id="tblBinary">
                    <thead id="th">
                    </thead>
                    <tbody>
                        <tr id="rwX"></tr>
                        <tr id="rwY"></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>

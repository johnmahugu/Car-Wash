@extends('layouts.main')

@section('content')
<div class="flex-center position-ref full-height" id="main-content">
    <div class="content">
        <div class="title m-b-md">
            <a href="/" style="text-decoration: none">Car Wash</a>
        </div>

        <div class="links">
            <a class="waves-effect waves-light btn btn-large" id="start" href="#"><i class="material-icons right">play_arrow</i>Start</a>
        </div>
    </div>
</div>
<div id="form-content" style="display:none;">
        <div id="step-1" class="row" style="display:none">
            <div class="col s12 m6" style="margin:auto;">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Welcome to the car wash</span>
                        <p>We will have to get some cursory information from you before we can start the car wash. Start by selecting your car type</p>
                    </div>
                    <div class="card-action">
                        <a href="#" class="vehicle_type">Car</a>
                        <a href="#" class="vehicle_type">Truck</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="step-2" class="row" style="display:none">
            <div class="col s12 m6" style="margin:auto;">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">Truck-Specific-Options</span>
                        <p>Does your truck have it's bed open?</p>
                        <p>
                            <input type="checkbox" id="truckBed" />
                            <label for="truckBed">Yes</label>
                        </p>
                        <p>Does your truck bed have mud in it?</p>
                        <p>
                            <input type="checkbox" id="truckMud" />
                            <label for="truckMud">Yes</label>
                        </p>
                    </div>
                    <div class="card-action">
                        <a href="#" class="continue">Continue</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="step-3" class="row" style="display:none">
            <div class="col s12 m6" style="margin:auto;">
                <div class="card blue-grey darken-1">
                    <div class="card-content white-text">
                        <span class="card-title">License Plate</span>
                        <p>Please enter your license plate number below to verify ownership and check for discounts!</p>
                        <input id="license" type="text" class="validate">
                        <label for="license">License Plate #</label>
                    </div>
                    <div class="card-action">
                        <a href="#" class="complete">Complete Car Wash</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="loading" style="display:none;">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-purple-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div><div class="gap-patch">
                        <div class="circle"></div>
                    </div><div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="error" style="display: none"></div>
</div>
@endsection

@section('scripts')
{{--Normally I am not a huge fan of jquery or structuring javascript directly on the page like this, but since it was outside of the scope of the project I included it to save some time.--}}
<script>
    $( document ).ready(function() {
        var mainContent = $('#main-content');
        var formData = {};
        formData._token = "{{ csrf_token() }}";

        $(document).on('click', '#start', function(e){
            e.preventDefault();
            mainContent.fadeOut("slow", function(){
                $('.links').remove();
                mainContent.removeClass('full-height');
                mainContent.css('align-items', 'flex-start');
                $('#step-1').show();
                $('#form-content').fadeIn();
                mainContent.fadeIn("slow");
            });
        });

        $(document).on('click', '.continue', function(e){
            e.preventDefault();
            $('#step-2').slideUp("slow", function(){
                $('#step-3').slideDown();
            });
        });

        $(document).on('click', '.complete', function(e){
            e.preventDefault();
            formData.license = $('#license').val();
            console.log(formData);
            $('#step-3').slideUp("slow", function(){
                $('#loading').slideDown();
                $.ajax({
                    type: "POST",
                    url: '/submit',
                    data: formData,
                    success: function(response){
                        if (response.error){
                            $('#error').html(response.error);
                            $('#loading').fadeOut('slow', function(){
                                $('#error').fadeIn();
                            });
                        }else{
                            window.location.href = "/transactionHistory/"+response.license;
                        }
                    },
                });
            });
        });
        //The following are simple data collection methods (these can be erased if using a normal form, just trying something a little different with the one page, one element at a time form)
        $(document).on('click', '.vehicle_type', function(e){
            e.preventDefault();
            formData.vehicle_type = $(this).text();
            $('#step-1').slideUp("slow", function(){
                if (formData.vehicle_type == 'Truck'){
                    $('#step-2').slideDown();
                }else{
                    $('#step-3').slideDown();
                }
            });

        });
        $(document).on('change', '#truckMud', function(e){
            e.preventDefault();
            if ($('#truckMud').is(":checked")) {
                formData.truckMud = true;
            }else{
                delete formData.truckMud;
            }

        });
        $(document).on('change', '#truckBed', function(e){
            e.preventDefault();
            if ($('#truckBed').is(":checked")) {
                formData.truckBed = true;
            }else{
                delete formData.truckBed;
            }
        });

    });
</script>
@endsection



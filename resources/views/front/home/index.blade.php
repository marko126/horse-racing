@extends('front.layout')

@section('content')
<!-- ======== @Region: #highlighted ======== -->
<div id="highlighted">
    <div class="container">
        <div class="header">
            <h2 class="page-title">
                <span>Horse racing</span>
                <small>Page short description</small>
            </h2>
        </div>
    </div>
</div>
<div id="content" class="demos">
    <div class="container">
        <div>
            <button class="btn btn-success" id="start-race">Start Race</button>
            {{ csrf_field() }}
        </div>
        <div id="race-container">
            
        </div>
        
        <h3 class="title-divider">
            <span>The last 5 results</span>
        </h3>
        <div id="results-container" class="row">
            
        </div>
        
        <h3 class="title-divider">
            <span>The best result</span>
        </h3>
        <div id="best-result-container" class="row">
            <?= \App\Models\Race::getBestResultHtml() ?>
        </div>
    </div>
</div>
@endsection

@push('footer_javascript')
<script src="/public/skins/front/js/script.js"></script>
<script type="text/javascript">
    
    var app = {
        activeRaces: {}
    };
    
    app.bindEvents = function() {
        $('#start-race').on('click', function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{route('front.race.create')}}",
                data: {},
                headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
                processData: false,
                success: function(data) {
                    app.getActiveRaces();
                    app.run();
                },
                error: function() {
                    alert(1);
                }
            });
        });
    }
    
    app.getActiveRaces = function() {
        $.ajax({
            type: "GET",
            url: "{{route('front.race.getactiveraceshtml')}}",
            processData: false,
            success: function(data) {
                $('#race-container').html(data);
                app.run();
            },
            error: function() {
                alert(1);
            }
        });
    }
    
    app.run = function() {
        $.ajax({
            type: "GET",
            url: "{{route('front.race.getactiveraces')}}",
            processData: false,
            success: function(data) {
                app.activeRaces = data;
                for (var i = 0; i < Object.keys(data).length; i ++) {
                    var horses = data[i]['horses'];
                    for (var j = 0; j < Object.keys(horses).length; j ++) {
                        app.move(horses[j], data[i]);
                    }
                }
            },
            error: function() {
                alert(1);
            }
        });
    }
    
    app.move = function (horse, race) {
        var elem = document.getElementById("myBar" + horse['horseId']);
        var distanceTd = document.getElementById("dist" + horse['horseId']);
        var timeTd = document.getElementById("time" + horse['horseId']);
        var positionTd = document.getElementById("pos" + horse['horseId']);
        if (elem == null || distanceTd == null || timeTd == null) {
            return false;
        }
        var width = horse['horseCurrentLength'] / 15;
        var time = race['currentTime'];
        if (width >= 100) {
            width = 100;
            time = horse['horseFinalTime'];
        }
        var id = setInterval(frame, 1000);
        var length = 100 / 1500;
        function frame() {
            if (width <= 100 * horse['horseEndurance'] / 15) {
                width = width + horse['horseMaxSpeed'] * length; 
                time++;
                elem.style.width = width + '%'; 
                distanceTd.innerText = parseInt(width * 15);
            } else if (width < 100) {
                width = width + horse['horseReducedSpeed'] * length; 
                if (width > 100) {
                    time = time + (horse['horseReducedSpeed'] * length - (width - 100)) / horse['horseReducedSpeed'] * length;
                    width = 100;
                } else {
                    time++;
                }
                elem.style.width = width + '%'; 
                distanceTd.innerText = parseInt(width * 15);
            } else {
                timeTd.innerHTML = parseFloat(horse['horseFinalTime']).toFixed(2);
                distanceTd.innerText = parseInt(1500);
                elem.style.width = '100%';
                positionTd.innerText = horse['horsePosition'];
                if (horse['horsePosition'] == Object.keys(race['horses']).length) {
                    app.getActiveRaces();
                    app.getLastRacesResults();
                    app.getBestResult();
                }
                clearInterval(id);
                return false;
            }
        }

    }
    
    app.getLastRacesResults = function () {
        $.ajax({
            type: "GET",
            url: "{{route('front.race.getlastresultshtml')}}",
            processData: false,
            success: function(data) {
                $('#results-container').html(data);
            },
            error: function() {
                alert(1);
            }
        });
    }
    
    app.getBestResult = function() {
        $.ajax({
            type: "GET",
            url: "{{route('front.race.getbestresulthtml')}}",
            processData: false,
            success: function(data) {
                $('#best-result-container').html(data);
            },
            error: function() {
                alert(1);
            }
        });
    }
    
    app.init = function () {
        app.bindEvents();
        app.getActiveRaces();
        app.getLastRacesResults();
    };

    $(app.init);
    
    
</script>
@endpush
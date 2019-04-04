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
    
    $('#start-race').on('click', function(e){
        e.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "{{route('front.race.create')}}",
            data: {},
            headers: {'X-CSRF-TOKEN': $('input[name=_token]').val()},
            processData: false,
            success: function(data) {
                getActiveRaces();
                run();
            },
            error: function() {
                alert(1);
            }
        });
    });
    
    function getActiveRaces() {
        $.ajax({
            type: "GET",
            url: "{{route('front.race.getactiveraceshtml')}}",
            processData: false,
            success: function(data) {
                $('#race-container').html(data);
                run();
            },
            error: function() {
                alert(1);
            }
        });
    }
    
    function run() {
    
        $.ajax({
            type: "GET",
            url: "{{route('front.race.getactiveraces')}}",
            processData: false,
            success: function(data) {
                console.log(data);
                for (var i = 0; i < Object.keys(data).length; i ++) {
                    var horses = data[i]['horses'];
                    for (var j = 0; j < Object.keys(horses).length; j ++) {
                        move(horses[j]['horseId'], horses[j]['horseMaxSpeed'], horses[j]['horseReducedSpeed'], horses[j]['horseEndurance'], horses[j]['horseCurrentLength'], data[i]['currentTime'], horses[j]['horseFinalTime']);
                    }
                }
            },
            error: function() {
                alert(1);
            }
        });
    }
    
    function move(id, maxSpeed, reducedSpeed, endurance, currentLength, currentTime, finalTime) {
        var elem = document.getElementById("myBar" + id);
        var distanceTd = document.getElementById("dist" + id);
        var timeTd = document.getElementById("time" + id);
        if (elem == null || distanceTd == null || timeTd == null) {
            return false;
        }
        var width = currentLength / 15;
        var time = currentTime;
        if (width >= 100) {
            width = 100;
            time = finalTime;
        }
        var id = setInterval(frame, 1000);
        var length = 100 / 1500;
        function frame() {
            if (width <= 100*endurance/15) {
                width = width + maxSpeed * length; 
                time++;
                elem.style.width = width + '%'; 
                distanceTd.innerText = parseInt(width * 15);
            } else if (width < 100) {
                width = width + reducedSpeed * length; 
                if (width > 100) {
                    time = time + (reducedSpeed * length - (width - 100)) / reducedSpeed * length;
                    width = 100;
                } else {
                    time++;
                }
                elem.style.width = width + '%'; 
                distanceTd.innerText = parseInt(width * 15);
            } else {
                timeTd.innerHTML = parseFloat(finalTime).toFixed(2);
                distanceTd.innerText = parseInt(1500);
                elem.style.width = '100%';
                clearInterval(id);
                return false;
            }
        }

    }
    
    function getLastRacesResults() {
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
    
    function getBestResult() {
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
    
    getActiveRaces();
    
    getLastRacesResults()
</script>
@endpush
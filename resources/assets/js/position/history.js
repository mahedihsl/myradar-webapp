import {Map} from './map.js';
import {Car} from './car.js';

const cars = [];
let speedFactor = 10;

function updateSpeedFactor() {
    $('.pull-down').each(function() {
        if ($(this).data('factor') == speedFactor) {
            $(this).find('i').css('visibility', 'visible');
        } else {
            $(this).find('i').css('visibility', 'hidden');
        }
    });

    for (var i = 0; i < cars.length; i++) {
        cars[i].setSpeedFactor(speedFactor);
    }
}

$(function() {
    let map = new Map('map');
    map.init();

    $('.pull-down').each(function() {
        let $this = $(this);
        $this.height(parseInt($this.data('height')));
        $this.css('background', $this.data('bg'));
        $this.css('margin-top', $this.parent().height() - $this.height());
        updateSpeedFactor();
    });

    $('.pull-down').click(function() {
        speedFactor = parseInt($(this).data('factor'));
        updateSpeedFactor();
    });

    let userId = $('input[name="user_id"]').val();
    $.get('/user/device/ids/' + userId, function(response) {
        for (var i = 0; i < response.length; i++) {
            let c = new Car(response[i]);
            c.setMap(map);
            cars.push(c);
        }
        updateSpeedFactor();
    });

    $('#filter').click(function() {
        let start = $('#datetimepicker1').val();
        let finish = $('#datetimepicker2').val();

        for (var i = 0; i < cars.length; i++) {
            cars[i].startPastTracking(start, finish);
        }

    });

});

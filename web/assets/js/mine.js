$(function(){
    $('#sbox').click(function() {
        $('#res').css('display', 'none');
        $.getJSON('getajax', function(data) {
            var html ="<br>";
            for(var x in data) {
                for (var s in data[x].date) {
                       html += "<div class=row>" + data[x].fio + " | " + data[x].positionId + " | " + data[x].salary + " | " + data[x].name + " </div><br>";
                       $('#myres').html(html);
                }
            }
        });
    });
});
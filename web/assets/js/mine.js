$(function(){
    $('#form_save').click(function(e) {
       e.preventDefault();
        $('#res').empty();
        $('#myres').empty();
        $('#create').css('display', 'none');
        $('.pagination').empty();
        var txt = $('#form_field').val();
            $.getJSON('ajaxsearch/'+txt, function(data) {
                var html = "";
                for(var x in data) {
                    html += "";
                    html += "<tr><td>" + data[x].id + "</td><td>" + data[x].fio + "</td><td>" + data[x].positionId + "</td><td>" + data[x].salary + "</td><td>" + data[x].date[x] + "</td><td>" + data[x].name + "</td><td colspan=2><a href="+ data[x].id +"/show class='btn btn-info'>Show</a>&nbsp;<a href="+ data[x].id +"/edit class='btn btn-warning'>Edit</td></tr>";
                    $('#myres').html(html);
                }
            })
                .fail(function() {
                    $('#myres').html('<p><div align=\"center\"><b>No matches found!</b></div></p>');
                });
    });
});
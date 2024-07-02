$(document).ready(function() {
    //toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'popup';     
    
    //make username editable
    $('#username').editable();
    $('#semaine1').editable();
    $('#semaine2').editable();
    $('#semaine3').editable();
    $('#semaine4').editable();
    $('#semaine5').editable();
    $('#semaine6').editable();
    $('#semaine7').editable();
    $('#semaine8').editable();
    $('#semaine9').editable();
    $('#semaine10').editable();
    $('#semaine11').editable();
    $('#semaine12').editable();
    $('#semaine13').editable();
    $('#semaine14').editable();
    $('#semaine15').editable();
    $('#semaine16').editable();
    $('#semaine17').editable();
    $('#semaine18').editable();
    $('#semaine19').editable();
    $('#semaine20').editable();
    $('#semaine21').editable();
    
    //make status editable
    $('#status').editable({
        type: 'select',
        title: 'Select status',
        placement: 'right',
        value: 2,
        source: [
            {value: 1, text: 'status 1'},
            {value: 2, text: 'status 2'},
            {value: 3, text: 'status 3'}
        ]
        /*
        //uncomment these lines to send data on server
        ,pk: 1
        ,url: '/post'
        */
    });
});

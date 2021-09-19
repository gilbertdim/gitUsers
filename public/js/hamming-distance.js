$(function(){
    $('#btnCalculate').on('click', function(){
        var toast = new bootstrap.Toast($('#msgError')[0])

        if($('#numFirstInteger').val() == '')
        {
            $('#msgError div.toast-body').html('Please enter an first interger');
            $('#numFirstInteger').prop('focused', true);
            toast.show();
        }
        else if($('#numSecondInteger').val() == '')
        {
            $('#msgError div.toast-body').html('Please enter an second interger');
            $('#numSecondInteger').prop('focused', true);
            toast.show();
        }
        else
        {
            $.post(
                '/api/challenge/hamming/distance',{
                    '_token' : $('[name="csrf-token"]').prop('content'),
                    firstInt : $('#numFirstInteger').val(),
                    secondInt : $('#numSecondInteger').val(),
                },function(data){
                    // console.log(data);
                    if('error' in data)
                    {
                        $('#msgError div.toast-body').html(data.error);
                        toast.show();                            
                        return false;
                    }

                    $('#tblBinary thead#th, #tblBinary tbody tr#rwX, #tblBinary tbody tr#rwY').html('');
                    var x = data.x.binary.split('');
                    var y = data.y.binary.split('');

                    for(i = 0; i < x.length; i++)
                    {
                        highlight = '';
                        if(data.distance.coordinates.find(function(e){ return e == i}) != undefined) highlight = 'bg-danger';
                        
                        $('#tblBinary thead#th').append('<th class="'+highlight+'"></th>')
                        $('#tblBinary tbody tr#rwX').append('<td class="text-center">'+x[i]+'</td>');
                        $('#tblBinary tbody tr#rwY').append('<td class="text-center">'+y[i]+'</td>');
                    }

                    $('#numHammingDistance').html(data.distance.value)
                    $('#results').removeClass('d-none');
                }
            );
        }
    });
})
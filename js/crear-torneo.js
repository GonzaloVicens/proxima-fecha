/**
 * Created by Gonzalo V on 16/12/2018.
 */
$(document).ready(function(){

    //liga
    var selectliga = "<select name='cantidad' id='cantidad' class='form-control'>";
    for(var i = 2; i < 31; i+= 2) {
        selectliga += "<option value='" + i + "'>" + i + "</option>";
    }
    selectliga += "</select>";

    //copa
    var selectcopa = "<select name='cantidad' id='cantidad' class='form-control'>";
    selectcopa += "  <option value='4'>4</option>";
    selectcopa += "  <option value='8'>8</option>";
    selectcopa += "  <option value='16'>16</option>";
    selectcopa += "  <option value='32'>32</option>";
    selectcopa += "</select>";

    //ligaiyv
    var selectligaiyv = "<select name='cantidad' id='cantidad' class='form-control'>";
    for(var i = 2; i < 31; i+= 2) {
        selectligaiyv += "<option value='" + i + "'>" + i + "</option>";
    }
    selectligaiyv += "</select>";

    $('#tipoTorneoL').click(function(){
        $('#cantidadEquipos').html(selectliga);
    });

    $('#tipoTorneoC').click(function(){
        $('#cantidadEquipos').html(selectcopa);
    });

    $('#tipoTorneoT').click(function(){
        $('#cantidadEquipos').html(selectligaiyv);
    })

});
/**
 * Created by Gonzalo V on 13/07/2018.
 */

var hoy = new Date;
$("#fechainicio").datepicker({ dateFormat:'yy-mm-dd',
                        monthNames:['Enero','Febrero','Marzo', 'Abril','Mayo',
                                    'Junio', 'Julio','Agosto','Septiembre', 'Octubre',
                                    'Noviembre', 'Diciembre'],
                        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju','Vi', 'Sa'],
                        firstDay: 1,
                        minDate: hoy,
                        });

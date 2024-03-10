
// Limpiar los campos
export const limpiarCampo = (campo:string | number):number => {
    let campoFinal = 0;
    if(typeof(campo) === "string")
    {
        return parseFloat(campo?.replace(/,/g,''));
    }

    return campo;

}

// Para cambiar el formato del dinero
export const formatoDinero = (value:number):string => {
    const formatter = new Intl.NumberFormat('en-IN',{
        minimumFractionDigits: 2,
    });
    // Devolver los datos
    return formatter.format(value);
}


// Fecha y hora
export const horaActual = ():string =>{
    // Obtener la fecha y hora actuales en la zona horaria local
    var fechaHoraActual = new Date();

    // Formatear la fecha y hora para que sea compatible con el input datetime-local
    var formatoFechaHora = fechaHoraActual.getFullYear() + '-' +
        ('0' + (fechaHoraActual.getMonth() + 1)).slice(-2) + '-' +
        ('0' + fechaHoraActual.getDate()).slice(-2) + 'T' +
        ('0' + fechaHoraActual.getHours()).slice(-2) + ':' +
        ('0' + fechaHoraActual.getMinutes()).slice(-2);

    return formatoFechaHora;
}


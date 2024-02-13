
// Limpiar los campos
export const limpiarCampo = (campo:string):number => {
    // Devolver los datos
    return parseFloat(campo?.replace(/,/g,''));
}

// Para cambiar el formato del dinero
export const formatoDinero = (value:number):string => {
    const formatter = new Intl.NumberFormat('en-IN',{
        minimumFractionDigits: 2,
    });
    // Devolver los datos
    return formatter.format(value);
}


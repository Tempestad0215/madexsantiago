
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


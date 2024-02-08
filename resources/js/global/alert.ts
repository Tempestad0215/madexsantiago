import Swal from "sweetalert2";


export const successHttp = (msj:string) =>{
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Registro guardado correctamente",
        showConfirmButton: false,
        timer: 1500
      });

}

export const errorHttp = (msj:string) => {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: msj,
      });
}

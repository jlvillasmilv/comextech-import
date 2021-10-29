
// sweetalert2 Library
// @param  type: "success", "error", "warning", "info" or "question"
//Title: description event


export default function Option(type, title) {
    return {
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        icon:type,
        title:title,
    }
};
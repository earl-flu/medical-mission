import Swal from 'sweetalert2';

export const useToast = () => {
  const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.onmouseenter = () => Swal.stopTimer();
      toast.onmouseleave = () => Swal.resumeTimer();
    },
  });

  const showToast = (title, icon = 'success') => {
    toast.fire({
      icon,
      title,
    });
  };

  return { showToast };
};
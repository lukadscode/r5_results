"use strict";
var KTModalNewAddress = (function () {
  var t, e, o, i, r;

  return {
    init: function () {
      (r = document.querySelector("#kt_modal_new_address")) &&
        ((i = new bootstrap.Modal(r)),
        (o = document.querySelector("#kt_modal_new_address_form")),
        (t = document.getElementById("kt_modal_new_address_submit")),
        (e = document.getElementById("kt_modal_new_address_cancel")),
        t.addEventListener("click", function (e) {
          e.preventDefault(),
            // Simulate a successful form submission
            t.setAttribute("data-kt-indicator", "on"),
            (t.disabled = !0),
            setTimeout(function () {
              t.removeAttribute("data-kt-indicator"),
                (t.disabled = !1),
                Swal.fire({
                  text: "Formulaire soumis avec succès!",
                  icon: "success",
                  buttonsStyling: !1,
                  confirmButtonText: "D'accord, compris!",
                  customClass: { confirmButton: "btn btn-primary" },
                }).then(function (e) {
                  e.isConfirmed && i.hide();
                });
            }, 2e3);
        }),
        e.addEventListener("click", function (e) {
          e.preventDefault(),
            Swal.fire({
              text: "Êtes-vous sûr de vouloir annuler?",
              icon: "warning",
              showCancelButton: !0,
              buttonsStyling: !1,
              confirmButtonText: "Oui, annuler!",
              cancelButtonText: "Non, retourner",
              customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-active-light",
              },
            }).then(function (e) {
              e.value ? (o.reset(), i.hide()) : "cancel" === e.dismiss;
            });
        }));
    },
  };
})();
KTUtil.onDOMContentLoaded(function () {
  KTModalNewAddress.init();
});

const modal = document.getElementById("qrmodal");

var pinmodal = new bootstrap.Modal(document.getElementById("pinmodal"), {
    keyboard: false,
});

var myModal = new bootstrap.Modal(modal, { keyboard: false });

const qrScanner = new QrScanner(
    document.getElementById("preview"),
    (result) => {
        if (result) {
            qrScanner.stop();
            myModal.hide();
            pinmodal.show();
            var data = {data:result}
            $("#pincode-input1").pincodeInput({
                inputs: 6,
                complete: function (value, e, errorElement) {
                    data.pin = value;
                    $.ajax({
                        method: "POST",
                        url: `/check-in-out`,
                        data: data,
                    }).done(function (data) {
                        if (data.error) {
                            Swal.fire("Error!", data.error, "error");
                            value= '';
                        } else {
                            Swal.fire("Success!", data.message, "success");
                            pinmodal.hide();
                            value= '';
                        }

                        $('.pincode-input-container .pincode-input-text').val('');
                        
                        $('.first').focus();
                    });
                },
            });
        } else {
            qrScanner.stop();
            myModal.hide();
            Swal.fire("Error!", "Something went wrong .", "error");
        }
    }
);


function scanCheck(cond){
    if (!cond){
        qrScanner.start();
    }else{
        qrScanner.stop();
    }
}

modal.addEventListener('show.bs.modal', function (event) {
    scanCheck(modal.classList.contains("show"));
})

modal.addEventListener('hide.bs.modal', function (event) {
    scanCheck(modal.classList.contains("show"));
})
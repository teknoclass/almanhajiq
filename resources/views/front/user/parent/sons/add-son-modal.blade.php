<!-- Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="studentModalLabel">{{ __('add_son') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Step 1: Enter Mobile Number -->
        <div id="mobileStep">
          <div class="mb-3">
            <label for="mobileNumber" class="form-label">{{ __('mobile') }}</label>
            <input type="number" class="form-control" id="mobileNumber"  />
           
          </div>
          <button class="btn btn-primary btn-sm" id="sendOtpBtn">{{ __('save') }}</button>
        </div>

        <!-- Step 2: Enter OTP -->
        <div id="otpStep" class="d-none">
          <div class="mb-3">
            <label for="otp" class="form-label">{{ __('enter_otp') }}</label>
            <input type="text" class="form-control" id="otp" />
          </div>
          <button class="btn btn-success w-100" id="verifyOtpBtn">{{ __('verify_otp') }}</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
  const sendOtpBtn = document.getElementById("sendOtpBtn");
  const verifyOtpBtn = document.getElementById("verifyOtpBtn");
  const mobileStep = document.getElementById("mobileStep");
  const otpStep = document.getElementById("otpStep");
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

  sendOtpBtn.addEventListener("click", function () {
    const mobileNumber = document.getElementById("mobileNumber").value;
    localStorage.setItem('son_mobile',mobileNumber);

    fetch("{{route('user.parent.sons.store')}}", {
      method: "POST",
      headers: { "Content-Type": "application/json" ,  "X-CSRF-TOKEN": csrfToken},
      body: JSON.stringify({ mobile: mobileNumber }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status) {
            customSweetAlert(
                            'success',
                            data.message,
                        );
          mobileStep.classList.add("d-none");
          otpStep.classList.remove("d-none");
        } else {
            customSweetAlert(
                            'error',
                            data.message,

                        );
        }
      })
      .catch((error) => {
        customSweetAlert(
                            'error',
                            'حدث خطأ',

                        );
      });
  });

  verifyOtpBtn.addEventListener("click", function () {
    const otp = document.getElementById("otp").value;
    const mobileNumber =  localStorage.getItem('son_mobile');
    fetch("{{route('user.parent.sons.makeActive')}}", {
      method: "POST",
      headers: { "Content-Type": "application/json","X-CSRF-TOKEN": csrfToken },
      body: JSON.stringify({ otp:otp,mobile: mobileNumber  }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status) {
            localStorage.removeItem('son_mobile');
            customSweetAlert(
                            'success',
                            data.message,

                        );
          // Close modal
         window.location.reload();
        } else {
            customSweetAlert(
                            'error',
                            data.message,

                        );
        }
      })
      .catch((error) => {
        customSweetAlert(
                            'error',
                            'حدث خطأ',

                        );
      });
  });
});

</script>
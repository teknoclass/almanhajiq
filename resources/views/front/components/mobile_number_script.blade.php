<script>

   $( document ).ready(function() {
       var input = document.querySelector("#phone");

       $.get("https://ipinfo.io", function(response) {
           var countryCode = response.country.toLowerCase();

           var iti = window.intlTelInput(input, {
               initialCountry: countryCode,
               utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
           });

           updateHiddenInputs(iti);

           input.addEventListener("change", function () {
               updateHiddenInputs(iti);
           });

           function updateHiddenInputs(iti) {
               var countryData = iti.getSelectedCountryData();
               document.querySelector(".code_country").value = countryData.dialCode;
               document.querySelector(".slug_country").value = countryData.iso2;
           }
       }, "jsonp");


        $('.code_counrty').val($('.iti__active').data('dial-code'));
        $('.slug_country').val($('.iti__active').data('country-code'));

    });

    $(document).on("click",".iti__country",function() {
        $('.code_counrty').val($(this).data('dial-code'));
        $('.slug_country').val($(this).data('country-code'));
    });


</script>

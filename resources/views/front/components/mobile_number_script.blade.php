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

           function updateHiddenInputs(iti)
           {
                var countryData = iti.getSelectedCountryData();

                var codeCountryElement = document.querySelector(".code_country");
                var slugCountryElement = document.querySelector(".slug_country");

                if (codeCountryElement) {
                    codeCountryElement.value = countryData.dialCode;
                } else {
                    console.error("Element with class 'code_country' not found.");
                }

                if (slugCountryElement) {
                    slugCountryElement.value = countryData.iso2;
                } else {
                    console.error("Element with class 'slug_country' not found.");
                }
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

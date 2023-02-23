<script src="{{ asset('front/js/jQuery-3.6.1.min.js') }}"></script>
<script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('front/js/inos.js') }}"></script>
<script src="{{ asset('front/js/custom.js') }}"></script>

<script>
    "use strict";

    function callToAction() {
        var registerUrl = "{{ route('front.register') }}";

        art.sendXhr({
            url: "{{route('front.call-to-action')}}",
            type: "POST",
            file: true,
            container: "#callToAction",
            disableButton: true,
            messageLocation: 'none',
            success: function(response) {
                if(response.status == 'success'){
                    var actionEmail = $('#action_email').val();

                    window.location.href = registerUrl + '?email=' + actionEmail;
                }
            }
        });
    }
</script>

<div class="preloader" id="preloader">
    <div class="preloader-inner">
        <button class="cancel-preloader" onclick="disablePreloader()">{{__('Cancel Preloader')}}</button>
        <div class="lds-ripple"><div></div><div></div></div>
    </div>
</div>
<script>
    function disablePreloader() {
        document.querySelector('#preloader').remove();
    }
</script>

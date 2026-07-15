<div class="preloader" id="preloader">
    <div class="preloader-inner">
        <button class="cancel-preloader" onclick="disablePreloader()">{{__('Cancel Preloader')}}</button>
        @php $site_preloader = get_static_option('preloader_default') @endphp

        @if($site_preloader == '1')
            <div class="windows8">
                <div class="wBall" id="wBall_1">
                    <div class="wInnerBall"></div>
                </div>
                <div class="wBall" id="wBall_2">
                    <div class="wInnerBall"></div>
                </div>
                <div class="wBall" id="wBall_3">
                    <div class="wInnerBall"></div>
                </div>
                <div class="wBall" id="wBall_4">
                    <div class="wInnerBall"></div>
                </div>
                <div class="wBall" id="wBall_5">
                    <div class="wInnerBall"></div>
                </div>
            </div>
        @elseif($site_preloader == '2')
            <div class="cssload-thecube">
                <div class="cssload-cube cssload-c1"></div>
                <div class="cssload-cube cssload-c2"></div>
                <div class="cssload-cube cssload-c4"></div>
                <div class="cssload-cube cssload-c3"></div>
            </div>
        @elseif($site_preloader == '3')
            <div class="bubblingG">
                <span id="bubblingG_1"></span>
                <span id="bubblingG_2"></span>
                <span id="bubblingG_3"></span>
            </div>
        @elseif($site_preloader == '4')
            <span class="cssload-loader"><span class="cssload-loader-inner"></span></span>
        @elseif($site_preloader == '5')
            <div class="cssload-container ">
                <div class="cssload-item cssload-moon"></div>
            </div>
        @elseif($site_preloader == '6')
            <div class="cssload-container-new">
                <div class="cssload-speeding-wheel"></div>
            </div>
        @elseif($site_preloader == '7')
            <div class="wrapper">
                <div class="cssload-loader"></div>
            </div>
        @elseif($site_preloader == '8')
            <div class="wrapper-08">
                <div class="cssload-loader"></div>
            </div>
        @endif
    </div>
</div>
<script>
    function disablePreloader() {
        document.querySelector('#preloader').remove();
    }
</script>

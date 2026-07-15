<div class="support-bar-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="left-content-area"><!-- left content area -->
                    <ul>
                        @foreach($all_support_item as $data)
                            <li><i class="{{$data->icon}}"></i> {{$data->details}}</li>
                        @endforeach
                    </ul>
                </div><!-- //.left conten tarea -->
                <div class="right-content-area"><!-- left content area -->
                    <ul class="social-icons">
                        @foreach($all_social_item as $data)
                            <li><a href="{{$data->url}}"><i class="{{$data->icon}}"></i></a></li>
                        @endforeach
                    </ul>
                    <select id="langchange">
                        @foreach($all_language as $lang)
                            <option @if( get_user_lang() == $lang->slug) selected @endif value="{{$lang->slug}}">{{$lang->name}}</option>
                        @endforeach
                    </select>
                </div><!-- //.left conten tarea -->
            </div>
        </div>
    </div>
</div>

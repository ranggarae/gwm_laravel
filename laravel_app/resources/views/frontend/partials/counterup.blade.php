<div class="coutnerup-area red-bg padding-80">
    <div class="container">
        <div class="row">
            @foreach($all_counterup as $data)
            <div class="col-lg-3 col-md-6">
                <div class="single-counterup-item">
                    <div class="icon">
                        <i class="{{$data->icon}}"></i>
                    </div>
                    <div class="content">
                        <span class="count-num">{{$data->number}}</span>
                        <h4 class="title">{{$data->title}}</h4>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

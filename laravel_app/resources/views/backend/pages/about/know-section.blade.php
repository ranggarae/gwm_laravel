@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button{
            padding: 0 !important;
        }
        div.dataTables_wrapper div.dataTables_length select {
            width: 60px;
            display: inline-block;
        }
    </style>
@endsection
@section('site-title')
    {{__('Know About Section')}}
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                @include('backend/partials/message')
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-lg-6 mt-t">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Know About Items')}}</h4>
                        <a href="#" class="btn btn-primary margin-bottom-30 btn-xs" data-toggle="modal" data-target="#know_about_us_item_add_new_modal">{{__('Add New Item')}}</a>

                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @php $a=0; @endphp
                                    @foreach($all_know_about_items as $key => $item)
                                            <a class="nav-item nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#known_about_tab_{{$key}}" role="tab"  aria-selected="true">{{get_language_by_slug($key)}}</a>
                                        @php $a++; @endphp
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30" id="nav-tabContent">
                                @php $b=0; @endphp
                                @foreach($all_know_about_items as $key => $item)
                                    <div class="tab-pane fade @if($b == 0) show active @endif" id="known_about_tab_{{$key}}" role="tabpanel" >
                                       <div class="table-wrap table-responsive">
                                           <table class="table table-default">
                                               <thead>
                                               <th>{{__('ID')}}</th>
                                               <th>{{__('Title')}}</th>
                                               <th>{{__('Image')}}</th>
                                               <th>{{__('Description')}}</th>
                                               <th>{{__('Action')}}</th>
                                               </thead>
                                               <tbody>
                                               @foreach($item as $data)
                                                   @php $img_url =''; @endphp
                                                   <tr>
                                                       <td>{{$data->id}}</td>
                                                       <td>{{$data->title}}</td>
                                                       <td>
                                                           @php
                                                           $know_section_img = get_attachment_image_by_id($data->image,null,true);
                                                           $img_url = '';
                                                       @endphp
                                                       @if (!empty($know_section_img))
                                                           <div class="attachment-preview">
                                                               <div class="thumbnail">
                                                                   <div class="centered">
                                                                       <img class="avatar user-thumb" src="{{$know_section_img['img_url']}}" alt="">
                                                                   </div>
                                                               </div>
                                                           </div>
                                                           @php  $img_url = $know_section_img['img_url']; @endphp
                                                           @endif
                                                           </td>
                                                           <td>{{$data->description}}</td>
                                                           <td>
                                                               <a tabindex="0" class="btn btn-lg btn-danger btn-sm mb-3 mr-1"
                                                                  role="button"
                                                                  data-toggle="popover"
                                                                  data-trigger="focus"
                                                                  data-html="true"
                                                                  title=""
                                                                  data-content="
                                                           <h6>{{__('Are you sure to delete this know about item ?')}}</h6>
                                                           <form method='post' action='{{route('know.about.delete',$data->id)}}'>
                                                           <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                           <br>
                                                            <input type='submit' class='btn btn-danger btn-sm' value='{{__('Yes,Please')}}'>
                                                            </form>
                                                            ">
                                                                   <i class="ti-trash"></i>
                                                               </a>
                                                               <a href="#"
                                                                  data-toggle="modal"
                                                                  data-target="#know_about_us_item_edit_modal"
                                                                  class="btn btn-lg btn-primary btn-sm mb-3 mr-1 known_about_edit_btn"
                                                                  data-id="{{$data->id}}"
                                                                  data-imageid="{{$data->image}}"
                                                                  data-image="{{$img_url}}"
                                                                  data-title="{{$data->title}}"
                                                                  data-link="{{$data->link}}"
                                                                  data-lang="{{$data->lang}}"
                                                                  data-description="{{$data->description}}"
                                                               >
                                                                   <i class="ti-pencil"></i>
                                                               </a>
                                                           </td>
                                                   </tr>
                                               @endforeach
                                               </tbody>
                                           </table>
                                       </div>
                                    </div>
                                    @php $b++; @endphp
                                @endforeach
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mt-t">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Know About Section Settings')}}</h4>
                        <form action="{{route('admin.about.know')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <nav>
                                <div class="nav nav-tabs" role="tablist">
                                    @foreach($all_languages as $key => $lang)
                                        <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-home-know-about-{{$lang->slug}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30">
                                @foreach($all_languages as $key => $lang)
                                    <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home-know-about-{{$lang->slug}}" role="tabpanel">
                                        <div class="form-group">
                                            <label for="about_page_{{$lang->slug}}_know_about_section_title">{{__('Title')}}</label>
                                            <input type="text" name="about_page_{{$lang->slug}}_know_about_section_title" value="{{get_static_option('about_page_'.$lang->slug.'_know_about_section_title')}}" class="form-control" id="about_page_{{$lang->slug}}_know_about_section_title">
                                        </div>
                                        <div class="form-group">
                                            <label for="about_page_{{$lang->slug}}_know_about_section_description">{{__('Description')}}</label>
                                            <textarea name="about_page_{{$lang->slug}}_know_about_section_description" class="form-control min-height-120" id="about_page_{{$lang->slug}}_know_about_section_description">{{get_static_option('about_page_'.$lang->slug.'_know_about_section_description')}}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="know_about_us_item_add_new_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Add New Know About Us Item')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('know.about.store')}}" id="add_new_know_about_modal_form"  method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="contact_info_id" value="">
                        <div class="form-group">
                            <label for="language">{{__('Languages')}}</label>
                            <select name="lang" id="language" class="form-control">
                                @foreach($all_languages as $lang)
                                    <option value="{{$lang->slug}}">{{$lang->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">{{__('Title')}}</label>
                            <input type="text" class="form-control"  id="title" name="title" placeholder="{{__('Title')}}">
                        </div>
                        <div class="form-group">
                            <label for="description">{{__('Description')}}</label>
                            <textarea  id="description"  name="description" class="form-control max-height-120" cols="30" rows="10" placeholder="{{__('Description')}}"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="link">{{__('Link')}}</label>
                            <input type="text" class="form-control"  id="link" name="link" placeholder="{{__('Link')}}">
                        </div>
                        <div class="form-group">
                            <label for="image">{{__('Image')}}</label>
                            <div class="media-upload-btn-wrapper">
                                <div class="img-wrap"></div>
                                <input type="hidden" name="image">
                                <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Know About Image" data-modaltitle="Upload Know About Image" data-toggle="modal" data-target="#media_upload_modal">
                                    {{__('Upload Image')}}
                                </button>
                            </div>
                            <small>{{__('recommended image size is 370x250 pixel')}}</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Add New')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="know_about_us_item_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Know About Us Item')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('know.about.update')}}" id="edit_know_about_modal_form"  method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="know_about_id" value="">
                        <div class="form-group">
                            <label for="edit_language">{{__('Languages')}}</label>
                            <select name="lang" id="edit_language" class="form-control">
                                @foreach($all_languages as $lang)
                                    <option value="{{$lang->slug}}">{{$lang->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_title">{{__('Title')}}</label>
                            <input type="text" class="form-control"  id="edit_title" name="title" placeholder="{{__('Title')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_description">{{__('Description')}}</label>
                            <textarea  id="edit_description"  name="description" class="form-control max-height-120" cols="30" rows="10" placeholder="{{__('Description')}}"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_link">{{__('Link')}}</label>
                            <input type="text" class="form-control"  id="edit_link" name="link" placeholder="{{__('Link')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_image">{{__('Image')}}</label>
                            <div class="media-upload-btn-wrapper">
                                <div class="img-wrap"></div>
                                <input type="hidden" id="edit_image" name="image" value="">
                                <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Know About Image" data-modaltitle="Upload Know About Image" data-toggle="modal" data-target="#media_upload_modal">
                                    {{__('Upload Image')}}
                                </button>
                            </div>
                            <small>{{__('recommended image size is 370x250 pixel')}}</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on('click','.known_about_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var title = el.data('title');
                var link = el.data('link');
                var description = el.data('description');
                var form = $('#edit_know_about_modal_form');
                var image = el.data('image');
                var imageid = el.data('imageid');

                form.find('#know_about_id').val(id);
                form.find('#edit_title').val(title);
                form.find('#edit_link').val(link);
                form.find('#edit_description').val(description);
                form.find('#edit_language option[value="'+el.data('lang')+'"]').attr('selected',true);

                if(imageid != ''){
                    form.find('.media-upload-btn-wrapper .img-wrap').html('<div class="attachment-preview"><div class="thumbnail"><div class="centered"><img class="avatar user-thumb" src="'+image+'" > </div></div></div>');
                    form.find('.media-upload-btn-wrapper input').val(imageid);
                    form.find('.media-upload-btn-wrapper .media_upload_form_btn').text('Change Image');
                }
            });

        });
    </script>
    <!-- Start datatable js -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.table-wrap > table').DataTable( {
                "order": [[ 0, "desc" ]]
            } );


        } );
    </script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')

@endsection
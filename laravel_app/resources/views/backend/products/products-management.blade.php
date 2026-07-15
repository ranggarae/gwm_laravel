@extends('backend.admin-master')
@section('site-title')
    {{__('Products Management')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button{ padding: 0 !important; }
        div.dataTables_wrapper div.dataTables_length select { width: 60px; display: inline-block; }
        /* Tab Styling Modernization */
        .nav-tabs .nav-link { color: #737373; font-weight: 600; padding: 12px 24px; border: none; border-bottom: 2px solid transparent; transition: all 0.2s; white-space: nowrap; }
        .nav-tabs .nav-link:hover { color: #171717; border-color: #E5E5E5; }
        .nav-tabs .nav-link.active { color: #171717; border-color: #0284c7; background: transparent; }
        .nav-tabs { border-bottom: 1px solid #E5E5E5; margin-bottom: 24px; flex-wrap: nowrap; overflow-x: auto; overflow-y: hidden; -webkit-overflow-scrolling: touch; }
        .nav-tabs::-webkit-scrollbar { height: 4px; }
        .nav-tabs::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .tab-content { padding-top: 10px; }
        .language-tabs { margin-bottom: 15px; border-bottom: none; }
        .language-tabs .nav-link { padding: 8px 16px; font-size: 14px; border-bottom: 1px solid #E5E5E5; }
        .language-tabs .nav-link.active { border-bottom: 2px solid #0284c7; }
        .attribute-field-wrapper { display: flex; gap: 10px; margin-bottom: 10px; align-items: flex-start; }
        .attribute-field-wrapper .icon-wrapper { display: flex; gap: 5px; margin-top: 5px; }
        .attribute-field-wrapper .icon-wrapper span { cursor: pointer; padding: 5px 10px; background: #e2e8f0; border-radius: 4px; }
    </style>
@endsection

@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                @include('backend/partials/message')
                @if($errors->any())
                    <div class="alert alert-danger"><ul>@foreach($errors->all() as $error)<li>{{$error}}</li>@endforeach</ul></div>
                @endif
            </div>

            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Products Management')}}</h4>

                        <ul class="nav nav-tabs" id="productsManagementTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="all-products-tab" data-toggle="tab" href="#all-products" role="tab"><i class="fas fa-box"></i> {{__('All Products')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="add-new-product-tab" data-toggle="tab" href="#add-new-product" role="tab"><i class="fas fa-plus"></i> {{__('Add New Product')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="categories-tab" data-toggle="tab" href="#categories" role="tab"><i class="fas fa-tags"></i> {{__('Categories')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="order-logs-tab" data-toggle="tab" href="#order-logs" role="tab"><i class="fas fa-shopping-cart"></i> {{__('Order Logs')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="ratings-tab" data-toggle="tab" href="#ratings" role="tab"><i class="fas fa-star"></i> {{__('Ratings')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="coupons-tab" data-toggle="tab" href="#coupons" role="tab"><i class="fas fa-ticket-alt"></i> {{__('Coupons')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="page-settings-tab" data-toggle="tab" href="#page-settings" role="tab"><i class="fas fa-cog"></i> {{__('Page Settings')}}</a>
                            </li>
                        </ul>

                        <div class="tab-content margin-top-40" id="productsManagementTabContent">
                            
                            <!-- TAB 1: All Products -->
                            <div class="tab-pane fade show active" id="all-products" role="tabpanel">
                                <div class="bulk-delete-wrapper mb-3">
                                    <div class="select-box-wrap d-inline-block">
                                        <select name="bulk_option" id="bulk_option" class="form-control d-inline-block w-auto">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                            <option value="draft">{{{__('Draft')}}}</option>
                                            <option value="publish">{{{__('Publish')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs language-tabs" role="tablist">
                                    @php $a=0; @endphp
                                    @foreach($all_products as $key => $product)
                                        <li class="nav-item">
                                            <a class="nav-link @if($a == 0) active @endif" data-toggle="tab" href="#product_tab_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                        </li>
                                        @php $a++; @endphp
                                    @endforeach
                                </ul>
                                <div class="tab-content margin-top-30">
                                    @php $b=0; @endphp
                                    @foreach($all_products as $key => $product)
                                        <div class="tab-pane fade @if($b == 0) show active @endif" id="product_tab_{{$key}}" role="tabpanel">
                                            <div class="table-wrap table-responsive">
                                                <table class="table table-default all_table">
                                                    <thead>
                                                        <th class="no-sort"><div class="mark-all-checkbox"><input type="checkbox" class="all-checkbox"></div></th>
                                                        <th>{{__('ID')}}</th>
                                                        <th>{{__('Title')}}</th>
                                                        <th>{{__('Image')}}</th>
                                                        <th>{{__('Price')}}</th>
                                                        <th>{{__('Category')}}</th>
                                                        <th>{{__('Sales')}}</th>
                                                        <th>{{__('Status')}}</th>
                                                        <th>{{__('Action')}}</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($product as $data)
                                                            <tr>
                                                                <td><div class="bulk-checkbox-wrapper"><input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}"></div></td>
                                                                <td>{{$data->id}}</td>
                                                                <td>{{$data->title}}</td>
                                                                <td>
                                                                    @php $img = get_attachment_image_by_id($data->image,'thumbnail',true); @endphp
                                                                    @if (!empty($img))
                                                                        <div class="attachment-preview">
                                                                            <div class="thumbnail"><div class="centered"><img class="avatar user-thumb" src="{{$img['img_url']}}" alt=""></div></div>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if(!empty($data->sale_price))
                                                                        <del>{{site_currency_symbol()}}{{$data->regular_price}}</del><br>
                                                                        {{site_currency_symbol()}}{{$data->sale_price}}
                                                                    @else
                                                                        {{site_currency_symbol()}}{{$data->regular_price}}
                                                                    @endif
                                                                </td>
                                                                <td>{{get_product_category_by_id($data->category_id)}}</td>
                                                                <td>{{$data->sales}}</td>
                                                                <td>
                                                                    @if($data->status == 'draft')
                                                                        <span class="badge badge-warning">{{__('Draft')}}</span>
                                                                    @else
                                                                        <span class="badge badge-success">{{__('Publish')}}</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                                        <h6>{{__('Are you sure to delete this product?')}}</h6>
                                                                        <form method='post' action='{{route('admin.products.delete',$data->id)}}'>
                                                                        <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                                        <br><input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                        </form>
                                                                    "><i class="ti-trash"></i></a>
                                                                    <a class="btn btn-primary btn-xs mb-3 mr-1" href="{{route('admin.products.edit',$data->id)}}"><i class="ti-pencil"></i></a>
                                                                    <a class="btn btn-light btn-xs mb-3 mr-1" target="_blank" href="{{route('frontend.products.single',$data->slug)}}"><i class="ti-eye"></i></a>
                                                                    <form action="{{route('admin.products.clone')}}" method="post" style="display: inline-block">
                                                                        @csrf
                                                                        <input type="hidden" name="item_id" value="{{$data->id}}">
                                                                        <button type="submit" title="clone this to new draft" class="btn btn-xs btn-secondary mb-3 mr-1"><i class="far fa-copy"></i></button>
                                                                    </form>
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

                            <!-- TAB 2: Add New Product -->
                            <div class="tab-pane fade" id="add-new-product" role="tabpanel">
                                <form action="{{route('admin.products.new')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="language"><strong>{{__('Language')}}</strong></label>
                                                <select name="lang" id="language" class="form-control">
                                                    @foreach($all_languages as $lang)
                                                        <option value="{{$lang->slug}}">{{$lang->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="title">{{__('Title')}}</label>
                                                <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}" placeholder="{{__('Title')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="slug">{{__('Slug')}}</label>
                                                <input type="text" class="form-control" id="slug" name="slug" value="{{old('slug')}}" placeholder="{{__('slug')}}">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="badge">{{__('Badge')}}</label>
                                                    <input type="text" class="form-control" id="badge" name="badge" value="{{old('badge')}}" placeholder="{{__('eg: New')}}">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="category">{{__('Category')}}</label>
                                                    <select name="category_id" class="form-control" id="category">
                                                        <option value="">{{__("Select Category")}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>{{__('Description')}}</label>
                                                <input type="hidden" name="description">
                                                <div class="summernote"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="short_description">{{__('Short Description')}}</label>
                                                <textarea name="short_description" id="short_description" class="form-control" cols="30" rows="4" placeholder="{{__('Short Description')}}"></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 form-group">
                                                    <label for="regular_price">{{__('Regular Price')}}</label>
                                                    <input type="text" class="form-control" id="regular_price" name="regular_price" placeholder="{{__('Regular Price')}}">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="sale_price">{{__('Sale Price')}}</label>
                                                    <input type="text" class="form-control" id="sale_price" name="sale_price" placeholder="{{__('Sale Price')}}">
                                                </div>
                                                <div class="col-md-4 form-group">
                                                    <label for="sku">{{__('SKU')}}</label>
                                                    <input type="text" class="form-control" id="sku" name="sku" placeholder="{{__('SKU')}}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="stock_status">{{__('Stock')}}</label>
                                                    <select name="stock_status" class="form-control" id="stock_status">
                                                        <option value="in_stock">{{__('In Stock')}}</option>
                                                        <option value="out_stock">{{__('Out Of Stock')}}</option>
                                                    </select>
                                                </div>
                                                @if(get_static_option('product_tax_type') == 'individual')
                                                <div class="col-md-6 form-group">
                                                    <label for="tax_percentage">{{__('Tax Percentage')}}</label>
                                                    <input type="text" class="form-control" name="tax_percentage" placeholder="{{__('eg: 10')}}">
                                                </div>
                                                @endif
                                            </div>
                                            <div class="form-group attributes-field">
                                                <label for="attributes">{{__('Attributes')}}</label>
                                               <div class="attribute-field-wrapper">
                                                   <input type="text" class="form-control w-25" id="attributes" name="attributes_title[]" placeholder="{{__('Title')}}">
                                                   <textarea name="attributes_description[]" class="form-control" rows="1" placeholder="{{__('Value')}}"></textarea>
                                                  <div class="icon-wrapper">
                                                      <span class="add_attributes"><i class="ti-plus"></i></span>
                                                  </div>
                                               </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="is_downloadable"><strong>{{__('Is Downloadable')}}</strong></label>
                                                <label class="switch">
                                                    <input type="checkbox" name="is_downloadable" id="is_downloadable">
                                                    <span class="slider"></span>
                                                </label>
                                            </div>
                                            <div class="form-group" style="display: none;">
                                                <label for="downloadable_file">{{__('Downloadable File')}}</label>
                                                <input type="file" name="downloadable_file" class="form-control" id="downloadable_file">
                                                <span class="info-text">{{__('only zip file is allowed')}}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_tags">{{__('Meta Tags')}}</label>
                                                <input type="text" name="meta_tags" class="form-control" data-role="tagsinput" id="meta_tags">
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_description">{{__('Meta Description')}}</label>
                                                <textarea name="meta_description" class="form-control" rows="5" id="meta_description"></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label for="image">{{__('Image')}}</label>
                                                    <div class="media-upload-btn-wrapper">
                                                        <div class="img-wrap"></div>
                                                        <input type="hidden" name="image">
                                                        <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Product Image" data-modaltitle="Upload Product Image" data-toggle="modal" data-target="#media_upload_modal">{{__('Upload Image')}}</button>
                                                    </div>
                                                    <small>{{__('Recommended image size 1920x1280')}}</small>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label for="image">{{__('Gallery')}}</label>
                                                    <div class="media-upload-btn-wrapper">
                                                        <div class="img-wrap"></div>
                                                        <input type="hidden" name="gallery">
                                                        <button type="button" class="btn btn-info media_upload_form_btn" data-mulitple="true" data-btntitle="Select Image" data-modaltitle="Upload Image" data-toggle="modal" data-target="#media_upload_modal">{{__('Upload Image')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="status">{{__('Status')}}</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="publish">{{__('Publish')}}</option>
                                                    <option value="draft">{{__('Draft')}}</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Product')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- TAB 3: Categories -->
                            <div class="tab-pane fade" id="categories" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6 border-right">
                                        <div class="bulk-delete-wrapper mb-3">
                                            <div class="select-box-wrap d-inline-block">
                                                <select name="bulk_option" id="bulk_option_cat" class="form-control d-inline-block w-auto">
                                                    <option value="">{{{__('Bulk Action')}}}</option>
                                                    <option value="delete">{{{__('Delete')}}}</option>
                                                    <option value="publish">{{{__('Publish')}}}</option>
                                                    <option value="draft">{{{__('Draft')}}}</option>
                                                </select>
                                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn_cat">{{__('Apply')}}</button>
                                            </div>
                                        </div>
                                        <ul class="nav nav-tabs language-tabs" role="tablist">
                                            @php $a=0; @endphp
                                            @foreach($all_categories as $key => $cat)
                                                <li class="nav-item">
                                                    <a class="nav-link @if($a == 0) active @endif" data-toggle="tab" href="#cat_tab_{{$key}}" role="tab">{{get_language_by_slug($key)}}</a>
                                                </li>
                                                @php $a++; @endphp
                                            @endforeach
                                        </ul>
                                        <div class="tab-content margin-top-30">
                                            @php $b=0; @endphp
                                            @foreach($all_categories as $key => $category)
                                                <div class="tab-pane fade @if($b == 0) show active @endif" id="cat_tab_{{$key}}" role="tabpanel">
                                                    <div class="table-wrap table-responsive">
                                                        <table class="table table-default all_table">
                                                            <thead>
                                                                <th class="no-sort"><div class="mark-all-checkbox"><input type="checkbox" class="all-checkbox-cat"></div></th>
                                                                <th>{{__('ID')}}</th>
                                                                <th>{{__('Name')}}</th>
                                                                <th>{{__('Status')}}</th>
                                                                <th>{{__('Action')}}</th>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($category as $data)
                                                                    <tr>
                                                                        <td><div class="bulk-checkbox-wrapper"><input type="checkbox" class="bulk-checkbox-cat" name="bulk_delete[]" value="{{$data->id}}"></div></td>
                                                                        <td>{{$data->id}}</td>
                                                                        <td>{{$data->title}}</td>
                                                                        <td>
                                                                            @if('publish' == $data->status)
                                                                                <span class="badge badge-success">{{ucfirst($data->status)}}</span>
                                                                            @else
                                                                                <span class="badge badge-warning">{{ucfirst($data->status)}}</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                                                <h6>{{__('Are you sure to delete this category item?')}}</h6>
                                                                                <form method='post' action='{{route('admin.products.category.delete',$data->id)}}'>
                                                                                <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                                                <br><input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                                </form>
                                                                            "><i class="ti-trash"></i></a>
                                                                            <a href="#" data-toggle="modal" data-target="#category_edit_modal" class="btn btn-primary btn-xs mb-3 mr-1 category_edit_btn" data-id="{{$data->id}}" data-name="{{$data->title}}" data-lang="{{$data->lang}}" data-status="{{$data->status}}"><i class="ti-pencil"></i></a>
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
                                    <div class="col-lg-6 pl-4">
                                        <h4 class="header-title">{{__('Add New Category')}}</h4>
                                        <form action="{{route('admin.products.category.new')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="cat_language">{{__('Language')}}</label>
                                                <select name="lang" id="cat_language" class="form-control">
                                                    @foreach($all_languages as $language)
                                                        <option value="{{$language->slug}}">{{$language->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="cat_name">{{__('Name')}}</label>
                                                <input type="text" class="form-control" id="cat_name" name="title" placeholder="{{__('Name')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="cat_status">{{__('Status')}}</label>
                                                <select name="status" class="form-control" id="cat_status">
                                                    <option value="publish">{{__("Publish")}}</option>
                                                    <option value="draft">{{__("Draft")}}</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 4: Order Logs -->
                            <div class="tab-pane fade" id="order-logs" role="tabpanel">
                                <div class="bulk-delete-wrapper mb-3">
                                    <div class="select-box-wrap d-inline-block">
                                        <select name="bulk_option" id="bulk_option_ord" class="form-control d-inline-block w-auto">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn_ord">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-default all_table" >
                                        <thead>
                                        <tr>
                                            <th class="no-sort"><div class="mark-all-checkbox"><input type="checkbox" class="all-checkbox-ord"></div></th>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Total Amount')}}</th>
                                            <th>{{__('Payment Status')}}</th>
                                            <th>{{__('Status')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_order_logs as $data)
                                            <tr>
                                                <td><div class="bulk-checkbox-wrapper"><input type="checkbox" class="bulk-checkbox-ord" name="bulk_delete[]" value="{{$data->id}}"></div></td>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->billing_name}}</td>
                                                <td>{{site_currency_symbol()}}{{$data->total}}</td>
                                                <td>
                                                    @if($data->payment_status == 'pending')
                                                        <span class="badge badge-warning text-capitalize">{{$data->payment_status}}</span>
                                                    @else
                                                        <span class="badge badge-success text-capitalize">{{$data->payment_status}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($data->status == 'pending')
                                                        <span class="badge badge-warning text-capitalize">{{$data->status}}</span>
                                                    @elseif($data->status == 'in_progress')
                                                        <span class="badge badge-info text-capitalize">{{str_replace('_',' ',$data->status)}}</span>
                                                    @elseif($data->status == 'shipped')
                                                        <span class="badge badge-info text-capitalize">{{$data->status}}</span>
                                                    @elseif($data->status == 'cancel')
                                                        <span class="badge badge-danger text-capitalize">{{$data->status}}</span>
                                                    @else
                                                        <span class="badge badge-success text-capitalize">{{$data->status}}</span>
                                                    @endif
                                                </td>
                                                <td>{{date_format($data->created_at,'d M Y')}}</td>
                                                <td>
                                                    <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                    <h6>{{__('Are you sure to delete this order?')}}</h6>
                                                    <form method='post' action='{{route('admin.product.payment.delete',$data->id)}}'>
                                                    <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                    <br><input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                    </form>
                                                    "><i class="ti-trash"></i></a>
                                                    
                                                    <a href="#" data-id="{{$data->id}}" data-status="{{$data->status}}" data-toggle="modal" data-target="#order_status_change_modal" class="btn btn-info btn-xs mb-3 mr-1 order_status_change_btn">{{__("Status")}}</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- TAB 5: Ratings -->
                            <div class="tab-pane fade" id="ratings" role="tabpanel">
                                <div class="bulk-delete-wrapper mb-3">
                                    <div class="select-box-wrap d-inline-block">
                                        <select name="bulk_option" id="bulk_option_rat" class="form-control d-inline-block w-auto">
                                            <option value="">{{{__('Bulk Action')}}}</option>
                                            <option value="delete">{{{__('Delete')}}}</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" id="bulk_delete_btn_rat">{{__('Apply')}}</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-default all_table" >
                                        <thead>
                                        <tr>
                                            <th class="no-sort"><div class="mark-all-checkbox"><input type="checkbox" class="all-checkbox-rat"></div></th>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Product Name')}}</th>
                                            <th>{{__('Ratings')}}</th>
                                            <th>{{__('Date')}}</th>
                                            <th>{{__('Action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all_ratings as $data)
                                            <tr>
                                                <td><div class="bulk-checkbox-wrapper"><input type="checkbox" class="bulk-checkbox-rat" name="bulk_delete[]" value="{{$data->id}}"></div></td>
                                                <td>{{$data->id}}</td>
                                                <td>{{get_product_title_by_id($data->product_id)}}</td>
                                                <td><div class="ratings">{!! render_ratings($data->ratings) !!}</div></td>
                                                <td>{{date_format($data->created_at,'d M Y')}}</td>
                                                <td>
                                                    <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                    <h6>{{__('Are you sure to delete this rating?')}}</h6>
                                                    <form method='post' action='{{route('admin.products.ratings.delete',$data->id)}}'>
                                                    <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                    <br><input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                    </form>
                                                    "><i class="ti-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- TAB 6: Coupons -->
                            <div class="tab-pane fade" id="coupons" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6 border-right">
                                        <div class="bulk-delete-wrapper mb-3">
                                            <div class="select-box-wrap d-inline-block">
                                                <select name="bulk_option" id="bulk_option_coup" class="form-control d-inline-block w-auto">
                                                    <option value="">{{{__('Bulk Action')}}}</option>
                                                    <option value="delete">{{{__('Delete')}}}</option>
                                                    <option value="publish">{{{__('Publish')}}}</option>
                                                    <option value="draft">{{{__('Draft')}}}</option>
                                                </select>
                                                <button class="btn btn-primary btn-sm" id="bulk_delete_btn_coup">{{__('Apply')}}</button>
                                            </div>
                                        </div>
                                        <div class="table-wrap table-responsive">
                                            <table class="table table-default all_table">
                                                <thead>
                                                    <th class="no-sort"><div class="mark-all-checkbox"><input type="checkbox" class="all-checkbox-coup"></div></th>
                                                    <th>{{__('ID')}}</th>
                                                    <th>{{__('Code')}}</th>
                                                    <th>{{__('Discount')}}</th>
                                                    <th>{{__('Expire Date')}}</th>
                                                    <th>{{__('Status')}}</th>
                                                    <th>{{__('Action')}}</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($all_coupons as $data)
                                                        <tr>
                                                            <td><div class="bulk-checkbox-wrapper"><input type="checkbox" class="bulk-checkbox-coup" name="bulk_delete[]" value="{{$data->id}}"></div></td>
                                                            <td>{{$data->id}}</td>
                                                            <td>{{$data->code}}</td>
                                                            <td>@if($data->discount_type == 'percentage') {{$data->discount}}% @else {{site_currency_symbol()}}{{$data->discount}} @endif</td>
                                                            <td>{{date('d M Y', strtotime($data->expire_date))}}</td>
                                                            <td>
                                                                @if('publish' == $data->status)
                                                                    <span class="badge badge-success">{{ucfirst($data->status)}}</span>
                                                                @else
                                                                    <span class="badge badge-warning">{{ucfirst($data->status)}}</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
                                                                    <h6>{{__('Are you sure to delete this coupon?')}}</h6>
                                                                    <form method='post' action='{{route('admin.products.coupon.delete',$data->id)}}'>
                                                                    <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                                    <br><input type='submit' class='btn btn-danger btn-xs' value='{{__('Yes,Please')}}'>
                                                                    </form>
                                                                "><i class="ti-trash"></i></a>
                                                                <a href="#" data-toggle="modal" data-target="#coupon_edit_modal" class="btn btn-primary btn-xs mb-3 mr-1 coupon_edit_btn" data-id="{{$data->id}}" data-code="{{$data->code}}" data-discount="{{$data->discount}}" data-discount_type="{{$data->discount_type}}" data-expire_date="{{$data->expire_date}}" data-status="{{$data->status}}"><i class="ti-pencil"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pl-4">
                                        <h4 class="header-title">{{__('Add New Coupon')}}</h4>
                                        <form action="{{route('admin.products.coupon.new')}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="code">{{__('Coupon Code')}}</label>
                                                <input type="text" class="form-control" id="code" name="code" placeholder="{{__('Code')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="discount">{{__('Discount')}}</label>
                                                <input type="text" class="form-control" id="discount" name="discount" placeholder="{{__('Discount')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="discount_type">{{__('Coupon Type')}}</label>
                                                <select name="discount_type" class="form-control" id="discount_type">
                                                    <option value="percentage">{{__("Percentage")}}</option>
                                                    <option value="amount">{{__("Amount")}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="expire_date">{{__('Expire Date')}}</label>
                                                <input type="date" class="form-control datepicker" id="expire_date" name="expire_date" placeholder="{{__('Expire Date')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="status">{{__('Status')}}</label>
                                                <select name="status" class="form-control" id="status">
                                                    <option value="publish">{{__("Publish")}}</option>
                                                    <option value="draft">{{__("Draft")}}</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New Coupon')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 7: Page Settings -->
                            <div class="tab-pane fade" id="page-settings" role="tabpanel">
                                <form action="{{route('admin.products.page.settings')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="site_product_post_items">{{__('Product Items')}}</label>
                                        <input type="text" name="site_product_post_items" class="form-control" value="{{get_static_option('site_product_post_items')}}" id="site_product_post_items">
                                    </div>
                                    <div class="form-group">
                                        <label for="product_tax_type">{{__('Tax System')}}</label>
                                        <select name="product_tax_type" id="product_tax_type" class="form-control">
                                            <option value="inclusive" @if(get_static_option('product_tax_type') == 'inclusive') selected @endif>{{__('Inclusive (Included with product price)')}}</option>
                                            <option value="exclusive" @if(get_static_option('product_tax_type') == 'exclusive') selected @endif>{{__('Exclusive (Added on checkout)')}}</option>
                                            <option value="individual" @if(get_static_option('product_tax_type') == 'individual') selected @endif>{{__('Individual (Added on product editing)')}}</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Changes')}}</button>
                                </form>
                            </div>

                        </div> <!-- end tab content -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="category_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Update Category')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.products.category.update')}}" method="post">
                    <input type="hidden" name="id" id="category_id">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="edit_language">{{__('Language')}}</label>
                            <select name="lang" id="edit_language" class="form-control">
                                @foreach($all_languages as $language)
                                    <option value="{{$language->slug}}">{{$language->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_name">{{__('Name')}}</label>
                            <input type="text" class="form-control" id="edit_name" name="title" placeholder="{{__('Name')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_status">{{__('Status')}}</label>
                            <select name="status" class="form-control" id="edit_status">
                                <option value="draft">{{__("Draft")}}</option>
                                <option value="publish">{{__("Publish")}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save Change')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="coupon_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Update Coupon')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.products.coupon.update')}}" method="post">
                    <input type="hidden" name="id" id="coupon_id">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="edit_code">{{__('Coupon Code')}}</label>
                            <input type="text" class="form-control" id="edit_code" name="code" placeholder="{{__('Code')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_discount">{{__('Discount')}}</label>
                            <input type="text" class="form-control" id="edit_discount" name="discount" placeholder="{{__('Discount')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_discount_type">{{__('Coupon Type')}}</label>
                            <select name="discount_type" class="form-control" id="edit_discount_type">
                                <option value="percentage">{{__("Percentage")}}</option>
                                <option value="amount">{{__("Amount")}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_expire_date">{{__('Expire Date')}}</label>
                            <input type="date" class="form-control datepicker" id="edit_expire_date" name="expire_date" placeholder="{{__('Expire Date')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_status">{{__('Status')}}</label>
                            <select name="status" class="form-control" id="edit_status">
                                <option value="draft">{{__("Draft")}}</option>
                                <option value="publish">{{__("Publish")}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save Change')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="order_status_change_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Order Status Change')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.product.order.status.change')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="form-group">
                            <label for="order_status">{{__('Order Status')}}</label>
                            <select name="order_status" class="form-control" id="order_status">
                                <option value="pending">{{__('Pending')}}</option>
                                <option value="in_progress">{{__('In Progress')}}</option>
                                <option value="shipped">{{__('Shipped')}}</option>
                                <option value="cancel">{{__('Cancel')}}</option>
                                <option value="complete">{{__('Complete')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Change Status')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('backend.partials.media-upload.media-upload-markup')
@endsection

@section('script')
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    <script src="{{asset('assets/backend/js/bootstrap-datepicker.min.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
    
    <!-- Start datatable js -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function () {
            // Tab persistence
            $('a[data-toggle="tab"][id$="-tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeProductsTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeProductsTab');
            if(activeTab){
                $('#productsManagementTab a[href="' + activeTab + '"]').tab('show');
            }

            // Category Edit Modal
            $(document).on('click','.category_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var name = el.data('name');
                var status = el.data('status');
                var modal = $('#category_edit_modal');
                modal.find('#category_id').val(id);
                modal.find('#edit_status option[value="'+status+'"]').attr('selected',true);
                modal.find('#edit_name').val(name);
                modal.find('#edit_language option[value="'+el.data('lang')+'"]').attr('selected',true);
            });

            // Coupon Edit Modal
            $(document).on('click','.coupon_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var code = el.data('code');
                var discount = el.data('discount');
                var discount_type = el.data('discount_type');
                var expire_date = el.data('expire_date');
                var status = el.data('status');
                var modal = $('#coupon_edit_modal');
                modal.find('#coupon_id').val(id);
                modal.find('#edit_status option[value="'+status+'"]').attr('selected',true);
                modal.find('#edit_code').val(code);
                modal.find('#edit_discount').val(discount);
                modal.find('#edit_discount_type option[value="'+discount_type+'"]').attr('selected',true);
                modal.find('#edit_expire_date').val(expire_date);
            });

            // Order Log Status Modal
            $(document).on('click','.order_status_change_btn',function(e){
                e.preventDefault();
                var el = $(this);
                var form = $('#order_status_change_modal');
                form.find('#order_id').val(el.data('id'));
                form.find('#order_status option[value="'+el.data('status')+'"]').attr('selected',true);
            });

            // Summernote setup
            $('.summernote').summernote({
                height: 400,
                codemirror: { theme: 'monokai' },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });

            // Dynamic Attribute fields
            $(document).on('click','.attribute-field-wrapper .add_attributes',function (e) {
               e.preventDefault();
                $(this).parent().parent().parent().append(' <div class="attribute-field-wrapper">\n' +
                    '<input type="text" class="form-control w-25" id="attributes" name="attributes_title[]" placeholder="{{__('Title')}}">\n' +
                    '<textarea name="attributes_description[]" class="form-control" rows="1" placeholder="{{__('Value')}}"></textarea>\n' +
                    '<div class="icon-wrapper">\n' +
                    '<span class="add_attributes"><i class="ti-plus"></i></span>\n' +
                    '<span class="remove_attributes"><i class="ti-minus"></i></span>\n' +
                    '</div>\n' +
                    '</div>');
            });
            $(document).on('click','.attribute-field-wrapper .remove_attributes',function (e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });

            // Downloadable file switch
            $(document).on('change','#is_downloadable',function (e) {
                e.preventDefault();
                isDownloadableCheck('#is_downloadable');
            });
            function isDownloadableCheck($selector) {
                var dnFile = $('#downloadable_file');
                if($($selector).is(':checked')){
                    dnFile.parent().show();
                }else{
                    dnFile.parent().hide();
                }
            }

            // Category Language Dropdown (Add New Product)
            function loadCategories(selectedLang){
                $.ajax({
                    url: "{{route('admin.products.category.by.lang')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang : selectedLang
                    },
                    success:function (data) {
                        $('#category').html('<option value="">{{__("Select Category")}}</option>');
                        $.each(data,function(index,value){
                            $('#category').append('<option value="'+value.id+'">'+value.title+'</option>')
                        });
                    }
                });
            }
            loadCategories($('#language').val());
            $(document).on('change','#language',function(e){
                e.preventDefault();
                loadCategories($(this).val());
            });

            // Bulk actions (General helper)
            function setupBulkAction(btnId, selectId, checkboxClass, url){
                $(document).on('click', '#' + btnId, function (e) {
                    e.preventDefault();
                    var bulkOption = $('#' + selectId).val();
                    var allCheckbox =  $('.' + checkboxClass + ':checked');
                    var allIds = [];
                    allCheckbox.each(function(index,value){
                        allIds.push($(this).val());
                    });
                    if(allIds.length > 0){
                        $(this).text('Processing...');
                        $.ajax({
                            'type' : "POST",
                            'url' : url,
                            'data' : {
                                _token: "{{csrf_token()}}",
                                ids: allIds,
                                type: bulkOption
                            },
                            success:function (data) { location.reload(); }
                        });
                    }
                });
            }

            setupBulkAction('bulk_delete_btn', 'bulk_option', 'bulk-checkbox', "{{route('admin.products.bulk.action')}}");
            setupBulkAction('bulk_delete_btn_cat', 'bulk_option_cat', 'bulk-checkbox-cat', "{{route('admin.products.category.bulk.action')}}");
            setupBulkAction('bulk_delete_btn_ord', 'bulk_option_ord', 'bulk-checkbox-ord', "{{route('admin.product.order.bulk.action')}}");
            setupBulkAction('bulk_delete_btn_rat', 'bulk_option_rat', 'bulk-checkbox-rat', "{{route('admin.products.ratings.bulk.action')}}");
            setupBulkAction('bulk_delete_btn_coup', 'bulk_option_coup', 'bulk-checkbox-coup', "{{route('admin.products.coupon.bulk.action')}}"); // Need to ensure route exists or ignore

            // Select all checkbox
            function setupSelectAll(selectAllClass, childClass){
                $('.' + selectAllClass).on('change',function(e){
                    $(this).closest('table').find('.' + childClass).prop('checked', $(this).is(':checked'));
                });
            }
            setupSelectAll('all-checkbox', 'bulk-checkbox');
            setupSelectAll('all-checkbox-cat', 'bulk-checkbox-cat');
            setupSelectAll('all-checkbox-ord', 'bulk-checkbox-ord');
            setupSelectAll('all-checkbox-rat', 'bulk-checkbox-rat');
            setupSelectAll('all-checkbox-coup', 'bulk-checkbox-coup');

            // DataTables
            $('.all_table').DataTable({
                "order": [[ 1, "desc" ]],
                "columnDefs": [ { "targets": 'no-sort', "orderable": false } ]
            });
        });
    </script>
@endsection

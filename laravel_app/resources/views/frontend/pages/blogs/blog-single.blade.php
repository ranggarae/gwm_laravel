@extends('frontend.frontend-page-master')
@section('og-meta')
    <meta property="og:url"  content="{{route('frontend.blog.single',$blog_post->slug)}}" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="{{$blog_post->title}}" />
    {!! render_og_meta_image_by_attachment_id($blog_post->image) !!}
@endsection
@section('meta-tags')
    <meta name="description" content="{{$blog_post->meta_description}}">
    <meta name="tags" content="{{$blog_post->meta_tags}}">
@endsection
@section('site-title')
    {{$blog_post->title}}
@endsection
@section('page-title')
    {{$blog_post->title}}
@endsection
@section('edit_link')
    <li><a href="{{route('admin.blog.edit',$blog_post->id)}}"><i class="far fa-edit"></i> {{__('Edit Blog')}}</a></li>
@endsection
@section('breadcrumb')
    <li><a href="{{route('frontend.blog.category',['id' => $blog_post->blog_categories_id, 'any' => Str::slug(get_blog_category_by_id($blog_post->id))])}}">{{get_blog_category_by_id($blog_post->id)}}</a></li>
    <li>{{$blog_post->title}}</li>
@endsection
@section('content')
    <section class="blog-details-content-area padding-100 ">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-details-item">
                        <div class="thumb">
                            {!! render_image_markup_by_attachment_id($blog_post->image,'','large') !!}
                        </div>
                        <div class="entry-content">
                            <ul class="post-meta">
                                <li><i class="fas fa-calendar"></i> {{ date_format($blog_post->created_at,'d M Y')}}</li>
                                <li><i class="fas fa-user"></i> {{ render_blog_author($blog_post->author)}}</li>
                                <li>
                                    <div class="cats">
                                        <i class="fas fa-calendar"></i>
                                        {!! get_blog_category_by_id($blog_post->id,'link') !!}
                                    </div>
                                </li>
                            </ul>
                           <div class="content-area">
                               {!! $blog_post->content !!}
                           </div>
                        </div>
                        <div class="blog-details-footer"><!-- entry footer -->
                            <div class="left">
                                <ul class="tags">
                                    <li class="title">{{get_static_option("blog_single_page_".$user_select_lang_slug."_tag_title")}}</li>
                                    @php
                                        $all_tags = explode(',',$blog_post->tags);
                                    @endphp
                                    @foreach($all_tags as $tag)
                                        <li><a href="{{route('frontend.blog.tags.page',['name' => Str::slug($tag)])}}">{{$tag}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="right">
                                <ul class="social-share">
                                    <li class="title">{{get_static_option("blog_single_page_".$user_select_lang_slug."_share_title")}}</li>
                                    @php
                                        $post_img = get_attachment_image_by_id($blog_post->image,'large');
                                        $post_img = !empty($post_img['img_url']) ? $post_img['img_url'] : '';
                                    @endphp

                                    {!! single_post_share(route('frontend.blog.single',$blog_post->slug),$blog_post->title,$post_img) !!}
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if(count($all_related_blog) > 1)
                    <div class="related-post-area margin-top-40">
                        <div class="section-title ">
                            <h4 class="title ">{{get_static_option('blog_single_page_'.$user_select_lang_slug.'_related_post_title')}}</h4>
                            <div class="related-news-carousel margin-top-50">
                                @foreach($all_related_blog as $data)
                                    @if($data->id === $blog_post->id) @continue @endif
                                    <div class="single-blog-grid-01">
                                        <div class="thumb">
                                            {!! render_image_markup_by_attachment_id($data->image) !!}
                                        </div>
                                        <div class="content">
                                            <h4 class="title"><a href="{{route('frontend.blog.single',$data->slug)}}">{{$data->title}}</a></h4>
                                            <ul class="post-meta">
                                                <li><a href="{{route('frontend.blog.single',$data->slug)}}"><i class="fas fa-calendar"></i> {{date_format($data->created_at,'d M y')}}</a></li>
                                                <li><a href="{{route('frontend.blog.single',$data->slug)}}"><i class="fas fa-user"></i> {{render_blog_author($data->author)}}</a></li>
                                                <li>
                                                    <div class="cats"><i class="fa fa-calendar"></i>
                                                        {!! get_blog_category_by_id($data->id,'link') !!}
                                                    </div>
                                                </li>
                                            </ul>
                                            <p>{{$data->excerpt}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="disqus-comment-area margin-top-40">
                        <div id="disqus_thread"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                   @include('frontend.partials.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @if(!empty(get_static_option('site_disqus_key')))
    <script>
        var disqus_config = function () {
        this.page.url = "{{route('frontend.blog.single',$blog_post->slug)}}";
        this.page.identifier = "{{$blog_post->id}}";
        };

        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = "https://{{get_static_option('site_disqus_key')}}.disqus.com/embed.js";
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    @endif
@endsection

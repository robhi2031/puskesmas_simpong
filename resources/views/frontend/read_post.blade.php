@extends('frontend.layouts', ['activeMenu' => '', 'activeSubMenu' => ''])
@section('content')
<div class="rbt-event-area rbt-section-gap bg-gradient-5 pt--50">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mb-5 mb-md-0">
                <div class="blog-content-wrapper blog-content-detail rbt-article-content-wrapper pt--50 rounded">
                    <div class="content">
                        <div class="breadcrumb-content-top text-center">
                            <ul class="meta-list justify-content-center mb--10">
                                <li class="list-item">
                                    <div class="author-thumbnail">
                                        <img src="{{ $data['postDetail']->url_userThumb }}" alt="{{ $data['postDetail']->user_thumb }}">
                                    </div>
                                    <div class="author-info">
                                        <a href="javascript:void(0);"><strong>{{ $data['postDetail']->user }}</strong></a>
                                    </div>
                                </li>
                                <li class="list-item">
                                    <i class="feather-calendar"></i>
                                    <span>{{ $data['postDetail']->tgl_postdot }}</span>
                                </li>
                            </ul>
                            <h1 class="title">{{ $data['postDetail']->title }}</h1>
                        </div>
                        @if ($data['postDetail']->post_format == 'VIDEO')
                            <div class="ratio ratio-16x9 alignwide mb--30">
                                <iframe class="square" src="{{ convertYoutubeEmbedLink($data['postDetail']->link_embed) }}" title="{{ $data['postDetail']->title }}" allowfullscreen=""></iframe>
                            </div>
                        @else
                            <div class="post-thumbnail mb--30 position-relative wp-block-image alignwide">
                                <figure>
                                    <img src="{{ $data['postDetail']->url_thumb }}" alt="{{ $data['postDetail']->thumb }}">
                                    <!-- <figcaption>Business and core management app are for enterprise.</figcaption> -->
                                </figure>
                            </div>
                        @endif
                        <div class="mt--10 mb--50 text-start">
                            {!! $data['postDetail']->content !!}

                            @if ($data['postDetail']->post_format == 'GALLERY')
                                <div class="rbt-gallery-area mt-5">
                                    <div class="row g-2 parent-gallery-container">
                                        @php
                                            $galleries = $data['postDetail']->gallery_src;
                                        @endphp
                                        @foreach ($galleries as $gallery)
                                            <a href="{{ $gallery['url_file'] }}" class="child-gallery-single col-lg-3 col-md-4 col-sm-6 col-6" title="{{ $gallery['caption'] }}">
                                                <div class="rbt-gallery">
                                                    <img class="w-100 rounded" src="{{ $gallery['url_file'] }}" alt="{{ $gallery['caption'] }}">
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        <hr class="mb-5" />
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-5">
                            <div class="tagcloud tagcloud-blog me-auto mb-4 mb-md-0">
                                @php
                                    $tags = $data['postDetail']->keyword_explode;
                                @endphp
                                @foreach ($tags as $tag)
                                    <a href="javascript:void(0);"><i class="feather-hash"></i>{{ $tag }}</a>
                                @endforeach
                            </div>
                            <div class="category-blog">
                                <a href="javascript:void(0);"><i class="feather-tag"></i> {{ $data['postDetail']->category }}</a>
                            </div>
                        </div>
                        <div class="social-share-block pb-3">
                            <div class="fw-medium mb-3 mb-md-0"><span>Bagikan:</span></div> 
                            <ul class="social-icon social-default transparent-with-border align-items-center pb-0">
                                <li>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $data['postDetail']->link_url }}" target="_blank" title="Bagikan ke facebook">
                                        <i class="feather-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/share?url={{ $data['postDetail']->link_url }}" target="_blank" title="Bagikan ke twitter">
                                        <i class="feather-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://api.whatsapp.com/send?text={{ $data['postDetail']->link_url }}" target="_blank" title="Bagikan ke WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $data['postDetail']->link_url }}" target="_blank" title="Bagikan ke LinkedIn">
                                        <i class="feather-linkedin"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- <div class="rbt-comment-area">
                            <div class="comment-respond">
                                <h3>Reaksi dan Komentar</h3>
                            </div>
                            <p>Comment by disquss</p>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <aside class="rbt-sidebar-widget-wrapper blog-sticky-sidebar" style="cursor:auto;">
                    <div class="rbt-single-widget rbt-widget-recent" id="sidebarWidget-01"></div>
                    <div class="rbt-single-widget rbt-widget-recent" id="sidebarWidget-02"></div>
                </aside>
            </div>
        </div>
    </div>
</div>
@endsection
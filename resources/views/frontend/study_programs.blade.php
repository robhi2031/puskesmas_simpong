@extends('frontend.layouts', ['activeMenu' => 'Program Studi', 'activeSubMenu' => ''])
@section('content')
<div class="rbt-event-area rbt-section-gap bg-gradient-5 pt--50">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <aside class="rbt-sidebar-widget-wrapper blog-sticky-sidebar" style="cursor:auto;">
                    <div class="inner">
                        <div class="content-item-content">
                            <div class="rbt-default-sidebar-wrapper">
                                <div class="section-title mb--20" id="titlePage"></div>
                                <nav class="mainmenu-nav" id="sidebarNavContent"></nav>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
            <div class="col-md-8 mb-5 mb-md-0">
                <div class="blog-content-wrapper blog-content-detail rbt-article-content-wrapper pt--50 rounded">
                    <div class="content" id="bodyNavContent">
                        <h3 class="placeholder-glow mb-5">
                            <span class="placeholder rounded col-12"></span>
                        </h3>
                        <div class="content mb--30">
                            <a href="javascript:void(0);" title="Card placeholder">
                                <svg class="bd-placeholder-img h-345px rounded" width="100%" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#868e96"></rect></svg>
                            </a>
                        </div>
                        <div class="description mt--30">
                            <h6 class="placeholder-glow">
                                <span class="placeholder rounded col-12 mb-3"></span>
                                <span class="placeholder rounded col-6 mb-3"></span>
                                <span class="placeholder rounded col-4 mb-3"></span>
                                <span class="placeholder rounded col-8 mb-3"></span>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
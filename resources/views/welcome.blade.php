@extends('user.layouts.head')
@section('title','home')
@section('content')
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-title">
                    <a>
                        <h2>{{ __('messages.hotNews') }}</h2>
                    </a>
                </div>
                @foreach($latestPosts as $post)
                <div class="post-entry-1 d-flex">
                    @foreach($imgPosts as $img)
                    @if ($img->imageable_id == $post->id)
                    <a href="{{ route('userPost.show', $post->id) }}">
                        <div class="thumbnail"><img class="img_home" src=" {{ url('storage/images/'.$img->link) }}"
                                alt="">
                        </div>
                    </a>
                    @endif
                    @endforeach
                    <div class="ml-3 contents">
                        <h2><a href="{{ route('userPost.show', $post->id) }}">{{ $post->title }}</a></h2>
                        <p class="mb-3">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->body), $maxBody, $end='...')}}</p>
                    </div>
                </div>
                @endforeach
                <br>
                <a href="{{ route('userCategory.showCategory', $worldPosts[0]->category['parent_id']) }}"
                    class="more">{{ __('messages.seeAll') }}<span class="icon-keyboard_arrow_right"></span></a>
            </div>


            <div class="col-lg-6">
                <div class="section-title">
                    <a>
                        <h2>{{ __('messages.Trending') }}</h2>
                    </a>
                </div>
                @foreach($worldPosts as $post)
                <div class="post-entry-1 d-flex">
                    @foreach($imgPosts as $img)
                    @if ($img->imageable_id == $post->id)
                    <a href="{{ route('userPost.show', $post->id) }}">
                        <div class="thumbnail"><img class="img_home" src="{{ url('storage/images/'.$img->link) }}"
                                alt=""></div>
                    </a>
                    @endif
                    @endforeach
                    <div class="ml-3 contents">
                        <h2><a href="{{ route('userPost.show', $post->id) }}">{{ $post->title }}</a></h2>
                        <p class="mb-3">{{ \Illuminate\Support\Str::limit($post->body, $maxBody, $end='...') }}</p>
                    </div>
                </div>
                @endforeach
                <br>
                <a href="{{ route('userCategory.showCategory', $worldPosts[0]->category['parent_id']) }}"
                    class="more">{{ __('messages.seeAll') }}<span class="icon-keyboard_arrow_right"></span></a>
            </div>
        </div>
        <!-- END section -->

        <div class="site-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="section-title">
                            <a>
                                <h2>{{ __('messages.World') }}</h2>
                            </a>
                        </div>
                        @foreach($worldPosts as $post)
                        <div class="post-entry-1 d-flex">
                            @foreach($imgPosts as $img)
                            @if ($img->imageable_id == $post->id)
                            <a href="{{ route('userPost.show', $post->id) }}">
                                <div class="thumbnail"><img class="img_home"
                                        src="{{ url('storage/images/'.$img->link) }}" alt=""></div>
                            </a>
                            @endif
                            @endforeach
                            <div class="ml-3 contents">
                                <h2><a href="{{ route('userPost.show', $post->id) }}">{{ $post->title }}</a></h2>
                                <p class="mb-3">{{ \Illuminate\Support\Str::limit($post->body, $maxBody, $end='...') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                        <br>
                        <a href="{{ route('userCategory.showCategory', $worldPosts[0]->category['parent_id']) }}"
                            class="more">{{ __('messages.seeAll') }}<span class="icon-keyboard_arrow_right"></span></a>
                    </div>


                    <div class="col-lg-6">
                        <div class="section-title">
                            <a>
                                <h2>{{ __('messages.Business') }}</h2>
                            </a>
                        </div>
                        @foreach($businessPosts as $post)
                        <div class="post-entry-1 d-flex">
                            @foreach($imgPosts as $img)
                            @if ($img->imageable_id == $post->id)
                            <a href="{{ route('userPost.show', $post->id) }}">
                                <div class="thumbnail"><img class="img_home"
                                        src="{{ url('storage/images/'.$img->link) }}" alt=""></div>
                            </a>
                            @endif
                            @endforeach
                            <div class="ml-3 contents">
                                <h2><a href="{{ route('userPost.show', $post->id) }}">{{ $post->title }}</a></h2>
                                <p class="mb-3">{{ \Illuminate\Support\Str::limit($post->body, $maxBody, $end='...') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                        <br>
                        <a href="{{ route('userCategory.showCategory', $worldPosts[0]->category['parent_id']) }}"
                            class="more">{{ __('messages.seeAll') }}<span class="icon-keyboard_arrow_right"></span></a>
                    </div>
                </div>



                <div class="site-section">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="section-title">
                                    <a>
                                        <h2>{{ __('messages.Tech') }}</h2>
                                    </a>
                                </div>
                                @foreach($techPosts as $post)
                                <div class="post-entry-2 d-flex">
                                    @foreach($imgPosts as $img)
                                    @if ($img->imageable_id == $post->id)
                                    <a href="{{ route('userPost.show', $post->id) }}"><img class="img_home"
                                            src="{{ url('storage/images/'.$img->link) }}" alt=""></a>
                                    @endif
                                    @endforeach
                                    <div class="ml-3 contents order-md-1 pl-0">
                                        <h2><a href="{{ route('userPost.show', $post->id) }}">{{ $post->title }}</a>
                                        </h2>
                                        <p class="mb-3">
                                            {{ \Illuminate\Support\Str::limit($post->body, $maxBody, $end='...') }}</p>
                                    </div>
                                </div>
                                @endforeach
                                @if (count($techPosts) > 0)
                                <a href="{{ route('userCategory.showCategory', $techPosts[0]->category['parent_id']) }}"
                                    class="more">{{ __('messages.seeAll') }} <span
                                        class="icon-keyboard_arrow_right"></span></a>
                                @endif
                            </div>

                            <div class="col-lg-3">
                                <div class="section-title">
                                    <a>
                                        <h2>{{ __('messages.Health') }} </h2>
                                    </a>
                                </div>
                                @foreach($healthPosts as $post)
                                <div class="trend-entry d-flex">
                                    <div class="trend-contents">
                                        @foreach($imgPosts as $img)
                                        @if ($img->imageable_id == $post->id)
                                        <a href="{{ route('userPost.show', $post->id) }}"><img class="img_home"
                                                src="{{ url('storage/images/'.$img->link) }}" alt=""></a>
                                        @endif
                                        @endforeach
                                        <h2 class="mt-2"><a
                                                href="{{ route('userPost.show', $post->id) }}">{{ $post->title }}</a>
                                        </h2>

                                    </div>
                                </div>
                                @endforeach

                                <p>
                                    <a href="{{ route('userCategory.showCategory', $healthPosts[0]->category['parent_id']) }}"
                                        class="more">{{ __('messages.seeAll') }} <span
                                            class="icon-keyboard_arrow_right"></span></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="footer">
        <div class="container">


            <div class="row">
                <div class="col-12">
                    <div class="copyright">
                        <p>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                            </script> Sun asterisk<i class="icon-heart text-danger" aria-hidden="true"></i> </a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- .site-wrap -->

@endsection

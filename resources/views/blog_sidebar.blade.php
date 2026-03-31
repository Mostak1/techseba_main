<div class="col-lg-4">
    <div class="optech-blog-sidebar">
        <div class="optech-blog-widgets">
            <h5>{{ __('translate.Search') }}</h5>
            <form action="{{ route('blogs') }}">
                <div class="optech-search-box">
                    <input type="search" placeholder="Type to search..." name="search" value="{{ request('search') }}">
                    <button id="optech-search-btn" type="button"><i class="ri-search-line"></i></button>
                </div>
            </form>
        </div>
        <div class="optech-blog-widgets">
            <h5>{{ __('translate.Categories') }}</h5>
            <div class="optech-blog-categorie">
                <ul>
                    @foreach($categories as $category)
                        <li><a href="{{ route('blogs', ['category' => $category->slug]) }}">{{ $category->translate->name }}<span>({{ $category->blogs_count }})</span></a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="optech-blog-widgets">
            <h5>{{ __('translate.Recent Posts') }}</h5>
            @forelse($recent_blogs as $recent_blog)
                <a class="optech-recent-post-item" href="{{ route('blog', $recent_blog->slug) }}">
                    <div class="optech-recent-post-thumb">
                        @if($recent_blog->image)
                            <img src="{{ asset($recent_blog->image) }}" alt="{{ $recent_blog->title }}">
                        @endif
                    </div>
                    <div class="optech-recent-post-data">
                        <p>{{ Str::limit($recent_blog->title, 60) }}</p>
                        <span>{{ $recent_blog->created_at->format('d F Y') }}</span>
                    </div>
                </a>
            @empty
                <div class="no-posts">
                    <p>{{ __('translate.No recent posts available') }}</p>
                </div>
            @endforelse
        </div>

        <div class="optech-blog-widgets">
            <h5>{{ __('translate.Tags') }}</h5>
            <div class="optech-blog-tags">
                <ul>
                    @foreach($allTags as $tag)
                    <li>
                        <a href="{{ route('blogs', ['tag' => $tag]) }}"
                           class="{{ request('tag') === $tag ? 'active' : '' }}">
                            {{ $tag }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

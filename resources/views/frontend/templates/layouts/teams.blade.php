
@php
    $currentLang = session()->get('front_lang');
    $expertTeamContent = getContent('expert_feature_section.content', true);
@endphp
<div class="section optech-section-padding2">
    <div class="container">
        <div class="optech-section-title center">
            <h2>{{ getTranslatedValue($expertTeamContent, 'heading', $currentLang) }}</h2>
        </div>
        <div class="row">
            @foreach($teams->take(4) as $team)
                <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-duration="400">
                    <div class="optech-team-wrap border_all">
                        <div class="optech-team-thumb">
                            <img src="{{ asset($team->image) }}" alt="Image">
                            <div class="optech-social-icon-box style-three position">
                                <ul>
                                    @if(!empty($team->facebook))
                                        <li><a href="{{ $team->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    @endif

                                    @if(!empty($team->twitter))
                                        <li><a href="{{ $team->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                    @endif

                                    @if(!empty($team->linkedin))
                                        <li><a href="{{ $team->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                    @endif

                                    @if(!empty($team->instagram))
                                        <li><a href="{{ $team->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="optech-team-data">
                            <a href="{{ route('teamPerson', $team->slug) }}">
                                <h5>{{ $team->translate->name }}</h5>
                            </a>
                            <p>{{ $team->translate->designation }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

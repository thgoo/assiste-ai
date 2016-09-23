@extends('layouts.master')

@section('title', 'Página Inicial')

@section('content')
    <div class="ui center aligned grid">
        <div class="outer-threads">
            <div class="ui inverted large loader active"></div>
            <p class="new text-right"><a href="{{ url('threads/create') }}" class="ui button"><i class="icon fa-plus"></i> Nova Indicação</a></p>
            <div class="ui segment">
                <div class="threads">
                    <div class="gap"></div>
                    <div class="gap"></div>
                    <div class="gap"></div>
                    <div class="gap"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/lib/mustache/mustache.min.js') }}"></script>
    <script id="thread-template" type="x-tmpl-mustache">
        <div class="thread mix active" data-title="@{{ movie.original_title }} (@{{ movie.year }})" data-title-ptbr="@{{ movie.title }}" data-id="@{{ id }}" data-slug="@{{ movie.slug }}">
            <a id="@{{ id }}-@{{ movie.slug }}"></a>
            <figure>
                <div class="image">
                    <img src="https://image.tmdb.org/t/p/w185@{{ movie.poster_path }}" alt="Pôster de @{{ movie.original_title }}">
                    <div class="ui bottom attached tiny @{{ rating_slug }} label">@{{ rating  }}<span class="author">@{{ user.name }}</span></div>
                </div>
                <div class="overlay">
                    <h3>@{{ movie.original_title }} (@{{ movie.year }})</h3>
                    <p><span class="ui tiny @{{ movie.category }} label">@{{ category }}</span></p>
                    <p>@{{ movie.description }}</p>
                    <p class="button"><a class="ui blue mini button see-more" href="#@{{ id }}-@{{ movie.slug }}">Mais Informações</a></p>
                </div>
            </figure>
            <div class="more-info">
                <ul class="buttons">
                    @{{ #can_edit }}
                        <li><a href="{{ url('threads') }}/@{{ id }}/@{{ movie.slug }}/edit" title="Editar"><i class="fa fa-pencil"></i></a></li>
                    @{{ /can_edit }}
                    <li><a class="no-action pop-permlink" href="" title="Link Permanente"><i class="fa fa-link"></i></a></li>
                    <li><a class="no-action close"href="" title="Fechar" ><i class="fa fa-times"></i></a></li>
                </ul>
                <div class="inner-wrapper"></div>
            </div>
        </div>
    </script>

    <script id="more-info-template" type="x-tmpl-mustache">
        <input class="ui custom popup inverted hidden permlink @{{ id }}" type="text" value="{{ url() }}/#@{{ id }}-@{{ movie.slug }}">
        @{{ #movie.backdrop_path }}
            <div class="backdrop" style="background: url('https://image.tmdb.org/t/p/w1280@{{ movie.backdrop_path }}');"></div>
            <div class="gradient-effect"></div>
        @{{ /movie.backdrop_path }}
        <div class="poster"><img src="https://image.tmdb.org/t/p/w300@{{ movie.poster_path }}" alt="Pôster de @{{ movie.title }}"></div>
        <div class="content">
            <h1>@{{ movie.original_title }} (@{{ movie.year }})</h1>
            <div class="original-title">Título no Brasil: @{{ movie.title }}</div>
            <div class="genre">
                @{{ #movie.genre }}
                    <span class="ui blue basic label">@{{ . }}</span>
                @{{ /movie.genre }}
            </div>
            <div class="synopsis">
                <p>@{{ movie.description }}</p>
            </div>
             @{{ #comment }}
                <div class="author-comment">
                    <p>@{{ comment }}</p>
                    <span class="author">@{{ rating }} &mdash; @{{ user.name }}</span>
                </div>
             @{{ /comment }}
             @{{ ^comment }}
                <div class="author-comment">
                    <span class="author-no-comment">@{{ rating }} &mdash; @{{ user.name }}</span>
                </div>
             @{{ /comment }}
        </div>
        <div class="clearfix"></div>
    </script>
    <script src="{{ asset('assets/lib/mixitup/jquery.mixitup.min.js') }}"></script>
    <script src="{{ asset('assets/js/home.min.js') }}"></script>
@endsection

<div class="ui inverted menu fixed">
    <div class="header item">
        <a href="{{ url('home') }}"><img src="{{ asset('assets/img/logo-dark.png') }}" alt="Logo Assiste Aí"></a>
    </div>
    <div class="ui dropdown item" tabindex="0">
        Categorias
        <i class="dropdown icon"></i>
        <div class="menu" tabindex="-1">
            <div class="item">Animações</div>
            <div class="item">Animes</div>
            <div class="item">Desenhos</div>
            <div class="item">Filmes</div>
            <div class="item">Seriados</div>
            <div class="item">Outros</div>
        </div>
    </div>
    <div class="item">
        <div class="ui transparent inverted icon input">
            <i class="search icon"></i>
            <input type="text" placeholder="Busca">
        </div>
    </div>
    <div class="right menu">
        <div class="ui dropdown item" tabindex="0">
            {{ Auth::user()->name }}
            <i class="dropdown icon"></i>
            <div class="menu" tabindex="-1">
                <div class="item">Minhas Recomendações</div>
                <div class="divider"></div>
                <a class="item" href="{{ url('auth/logout') }}">Sair</a>
            </div>
        </div>
    </div>
</div>
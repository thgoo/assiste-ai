@extends('layouts.master')

@section('title', 'Recomendar')

@section('content')
    <div class="ui center aligned grid">
        <div class="content">
            <div class="ui segment">
                {!! Form::open(['url' => url('threads'), 'class' => 'ui inverted form', 'method' => 'post']) !!}
                <div class="field">
                    <div class="two fields">
                        <div class="twelve wide required field">
                            {!! Form::label('external_url', 'Link IMDb/TMDb') !!}
                            {!! Form::text('external_url', null, ['id' => 'external_url', 'placeholder' => 'http://www.imdb.com/title/tt1234567 ou https://www.themoviedb.org/movie/123456-example']) !!}
                        </div>
                        <div class="four wide required field">
                            {!! Form::label('rating', 'Avaliação') !!}
                            {!! Form::select('rating', [
                            '' => 'Não Selecionado',
                            'Imperdível' => 'Imperdível',
                            'Muito Bom' => 'Muito Bom',
                            'Bom' => 'Bom',
                            'Legal' => 'Legal',
                            'Ruinzinho' => 'Ruinzinho',
                            'Muito Ruim' => 'Muito Ruim',
                            'Fique Longe' => 'Fique Longe'
                            ], null, ['class' => 'ui fluid dropdown', 'id' => 'rating', 'placeholder' => 'Título']) !!}
                        </div>
                    </div>
                    <div class="field">
                        {!! Form::label('comment', 'Comentários') !!}
                        {!! Form::textarea('comment', null, ['id' => 'comment', 'placeholder' => 'Comentário pessoal sobre a recomendação']) !!}
                    </div>
                    <div class="field text-right">
                        <a href="{{ url('home') }}" class="ui grey button">Descartar</a>
                        {!! Form::button('Finalizar', ['class' => 'ui blue button', 'type' => 'submit']) !!}
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.dropdown').dropdown();
        });
    </script>
@endsection
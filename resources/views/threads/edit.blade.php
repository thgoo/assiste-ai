@extends('layouts.master')

@section('title', 'Recomendar')

@section('content')
    <div class="ui center aligned grid">
        <div class="content">
            <div class="ui segment">
                {!! Form::open(['url' => url('threads/'.$thread->id.'/'.$thread->movie->slug), 'class' => 'ui inverted form', 'method' => 'patch']) !!}
                    <div class="two fields">
                        <div class="three wide required field">
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
                            ], (isset($thread->rating) ? $thread->rating : null), ['class' => 'ui fluid dropdown', 'id' => 'rating', 'placeholder' => 'Título']) !!}
                        </div>
                    </div>
                    <div class="field">
                        {!! Form::label('comment', 'Comentários') !!}
                        {!! Form::textarea('comment', (isset($thread->comment) ? $thread->comment : null), ['id' => 'comment', 'placeholder' => 'Comentário pessoal sobre a recomendação']) !!}
                    </div>
                    <div class="field text-right">
                        <a href="{{ url('home') }}" class="ui grey button">Descartar</a>
                        {!! Form::button('Finalizar', ['class' => 'ui blue button', 'type' => 'submit']) !!}
                    </div>
                {!! Form::close() !!}
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

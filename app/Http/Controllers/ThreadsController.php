<?php

namespace App\Http\Controllers;

use App\AssisteAi\TelegramBot;
use App\Movie;
use App\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $threads = Thread::orderBy('created_at', 'desc')->with('Movie', 'User')->get();

        foreach($threads as $thread) {
            $thread->movie->description = shorten($thread->movie->description, 88);
            $thread->rating_slug = Str::slug($thread->rating);
            $thread->tmdb_id = (isset($thread->movie->externalid[0])) ? $thread->movie->externalid[0]->external_id : null;
            $thread->imdb_id = (isset($thread->movie->externalid[1])) ? $thread->movie->externalid[1]->external_id : null;
            if($thread->user_id == Auth::user()->id) {
                $thread->can_edit = true;
            }
        }

        return response()->json($threads);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Thread::$rules);

        try {
            $movie = Movie::getOrCreate($request->input('external_url'));

            Thread::verifyIfExists($movie);

            $thread = new Thread([
                'rating'  => $request->input('rating'),
                'comment' => ($request->input('comment') == '') ? null : $request->input('comment'),
            ]);
            $thread->user()->associate(Auth::user());
            $thread->movie()->associate($movie);
            $thread->save();

            $tb = new TelegramBot();
            $tb->sendMessage($thread);

            flash()->success('Tudo Certo!', 'O título escolhido foi indicado com sucesso!');

            return redirect('/');
        } catch(\Exception $e) {
            flash()->error('Ops!', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $thread = Thread::with('movie', 'user')->find($id);

            $thread->setHidden(['created_at', 'updated_at', 'deleted_at']);
            $thread->user->setHidden(['id', 'avatar', 'username', 'email', 'remember_token', 'provider_id', 'last_login_at', 'created_at', 'updated_at', 'deleted_at', 'provider']);
            $thread->movie->setHidden(['created_at', 'updated_at', 'deleted_at']);

            return response()->json(['error' => false, 'thread' => $thread]);
        } catch(ModelNotFoundException $e) {
            return response()->json(['error' => true, 'message' => 'Indicação não encontrada.']);
        } catch(\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int    $id
     * @param  string $slug
     * @return Response
     */

    /**
     * @param $id
     * @param $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($id, $slug)
    {
        try {
            $thread = Thread::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->whereHas('movie', function ($query) use ($slug) {
                $query->where('slug', '=', $slug);
            })->firstOrFail();

            return view('threads.edit', ['thread' => $thread]);
        } catch(ModelNotFoundException $e) {
            flash()->error('Ops!', 'Indicação não encontrada.');

            return redirect('/');
        } catch(\Exception $e) {
            flash()->error('Ops!', $e->getMessage());

            return redirect('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     * @param  string  $slug
     * @return Response
     */
    public function update(Request $request, $id, $slug)
    {
        $this->validate($request, ['rating' => 'required']);

        try {
            $thread = Thread::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->whereHas('movie', function ($query) use ($slug) {
                $query->where('slug', '=', $slug);
            })->firstOrFail();

            $thread->rating = $request->input('rating');
            $thread->comment = $request->input('comment');
            $thread->save();

            flash()->success('Alterado!', 'Você alterou sua indicação com sucesso!');

            return redirect('/');
        } catch(ModelNotFoundException $e) {
            flash()->error('Ops!', 'Indicação não encontrada.');

            return redirect()->back()->withInput();
        } catch(\Exception $e) {
            flash()->error('Ops!', $e->getMessage());

            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

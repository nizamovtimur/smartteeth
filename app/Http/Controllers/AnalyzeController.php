<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyzeController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::check()) return view('auth.login');
        // if (!Auth::user()->is_moderator) abort(403, "Access denied");
        return view('analyzes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Auth::check()) abort(401, "Authentication required");

        $data = $request->validate([
            'patient_id' => 'required|integer',
            'photo' => 'photo'
        ]);

        if (($file = $request->File("image")) != null) {
            $data["source_photo"] = $file->store('public/input_images');
        }

        $data["user_id"] = Auth::user()->id;

        $data["predict_xml"] = "I LOVE PYTHON";
        $data["predict_photo"] = "WE LOVE PYTHON";

        $analyze = Analyze::create($data);

        return redirect()->route('analyzes.show')->with('analyze');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Analyze  $analyze
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Analyze $analyze)
    {
        if (!Auth::check()) abort(401, "Authentication required.");
        if (Auth::id() != $analyze->user_id) abort(403, "Access denied");
        return view('analyzes.show', compact('analyze'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Analyze $analyze
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Analyze $analyze)
    {
        if (!Auth::check()) abort(401, "Authentication required.");
        if (Auth::id() != $analyze->user_id) abort(403, "Access denied");
        $analyze->delete();
        return redirect()->route('home')->with('success', 'Анализ успешно удалён!');
    }
}

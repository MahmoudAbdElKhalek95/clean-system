<?php

namespace App\Http\Controllers;

use App\Models\TT;
use App\Http\Requests\StoreTTRequest;
use App\Http\Requests\UpdateTTRequest;

class TTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTTRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTTRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TT  $tT
     * @return \Illuminate\Http\Response
     */
    public function show(TT $tT)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TT  $tT
     * @return \Illuminate\Http\Response
     */
    public function edit(TT $tT)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTTRequest  $request
     * @param  \App\Models\TT  $tT
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTTRequest $request, TT $tT)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TT  $tT
     * @return \Illuminate\Http\Response
     */
    public function destroy(TT $tT)
    {
        //
    }
}

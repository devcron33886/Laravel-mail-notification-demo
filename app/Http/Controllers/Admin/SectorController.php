<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySectorRequest;
use App\Http\Requests\StoreSectorRequest;
use App\Http\Requests\UpdateSectorRequest;
use App\Models\Sector;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SectorController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sector_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sectors = Sector::all();

        return view('admin.sectors.index', compact('sectors'));
    }

    public function create()
    {
        abort_if(Gate::denies('sector_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sectors.create');
    }

    public function store(StoreSectorRequest $request)
    {
        $sector = Sector::create($request->all());

        return redirect()->route('admin.sectors.index');
    }

    public function edit(Sector $sector)
    {
        abort_if(Gate::denies('sector_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sectors.edit', compact('sector'));
    }

    public function update(UpdateSectorRequest $request, Sector $sector)
    {
        $sector->update($request->all());

        return redirect()->route('admin.sectors.index');
    }

    public function show(Sector $sector)
    {
        abort_if(Gate::denies('sector_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sectors.show', compact('sector'));
    }

    public function destroy(Sector $sector)
    {
        abort_if(Gate::denies('sector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sector->delete();

        return back();
    }

    public function massDestroy(MassDestroySectorRequest $request)
    {
        Sector::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Horse;

class HorsesController extends Controller {

    public function index() {
        return view('admin.horses.index');
    }

    public function datatable() {

        $columns = ['id', 'name', 'speed', 'strength', 'endurance', 'actions'];

        $request = request();

        $query = Horse::query();

        //Process search parameter

        $search = $request->get('search');

        if (is_array($search) && !empty($search['value'])) {

            $query->where(function($subQuery) use($search) {

                $subQuery->orWhere(
                        'horses.title', 'LIKE', '%' . $search['value'] . '%'
                );
            });
        }

        //Process ordering
        $order = $request->get('order');
        if (is_array($order) && !empty($order)) {
            foreach ($order as $orderColumn) {
                $columnName = $columns[$orderColumn['column']];
                $dir = $orderColumn['dir'];
                $query->orderBy('horses.' . $columnName, $dir);
            }
        }

        //Process Pagination
        $length = $request->get('length', 10);
        $start = $request->get('start', 0);

        $page = floor($start / $length) + 1;

        $horses = $query->paginate($length, ['horses.*'], 'page', $page);


        // Format JSON response
        $datatableJson = [
            'draw' => $request->get('draw', 1),
            'recordsTotal' => $horses->total(),
            'recordsFiltered' => $horses->total(),
            'data' => []
        ];

        foreach ($horses as $horse) {

            $row = [
                'id' => $horse->id,
                'name' => $horse->name,
                'speed' => $horse->speed,
                'strength' => $horse->strength,
                'endurance' => $horse->endurance,
                'actions' => view('admin.horses.partials.actions', ['horse' => $horse])->render()
            ];

            $datatableJson['data'][] = $row;
        }

        return response()->json($datatableJson);
    }

    public function add() {
        return view('admin.horses.add');
    }

    public function insert() {

        $request = request();

        $formData = $request->validate([
            'name' => 'required',
            'speed' => 'required|numeric|min:0|max:10',
            'strength' => 'required|numeric|min:0|max:10',
            'endurance' => 'required|numeric|min:0|max:10',
        ]);

        $horse = new Horse($formData);

        $horse->save();

        return redirect()->route('admin.horses.index')
                        ->with('systemMessage', 'Horse has been added!');
    }

    public function edit($id) {

        $horse = Horse::findOrFail($id);

        return view('admin.horses.edit', [
            'horse' => $horse
        ]);
    }

    public function update($id) {

        $horse = Horse::findOrFail($id);

        $request = request();

        $formData = $request->validate([
            'name' => 'required',
            'speed' => 'required|numeric|min:0|max:10',
            'strength' => 'required|numeric|min:0|max:10',
            'endurance' => 'required|numeric|min:0|max:10',
        ]);

        $horse->fill($formData);

        $horse->save();

        return redirect()->route('admin.horses.index')
                        ->with('systemMessage', 'Horse has been saved');
    }

    public function delete() {

        $request = request();

        $horse = Horse::findOrFail($request->input('id'));

        //delete from database
        $horse->delete();

        // delete relations to races table
        $product->races()->detach();

        return redirect()->route('admin.horses.index')
                        ->with('systemMessage', 'Horse has been deleted');
    }

}

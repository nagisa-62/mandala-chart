<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Debugbar;
use App\Chart;
use App\TableGroup;
use App\Cell;

class DataController extends Controller
{
    //
    public function init() {
        
        $user = auth()->user();
        $chartInfos = Chart::where('user_id', $user->id)
                            ->orderBy('id', 'asc')->get();
        
        $tables = TableGroup::where('chart_id', $chartInfos[0]->id)
                                ->orderBy('table_number', 'asc')->get();

        $chartData = array();
        foreach ($tables as $table_index => $table) {
            $cells = Cell::where('table_id', $table->id)
                            ->orderBy('cell_number', 'asc')->get();
            $chartData[] = $cells;
        }
        
        return response()->json(compact('chartInfos', 'chartData'));

    }

    public function read($id) {
        
        $tables = TableGroup::where('chart_id', $id)
                                ->orderBy('table_number', 'asc')->get();

        $chartData = array();
        foreach ($tables as $table_index => $table) {
            $cells = Cell::where('table_id', $table->id)
                            ->orderBy('cell_number', 'asc')->get();
            $chartData[] = $cells;
        }

        return response()->json(compact('chartData'));

    }

    public function create(Request $request) {

        $chartInfo = $request->input('chartInfo');
        $chartData = $request->input('chartData');
        $user = auth()->user();

        $countChart = Chart::where('user_id', $user->id)->count();
        if ($countChart >= 3) {
            return response()->json(['message'=>'register only 3 chart!'], 400);
        }

        $createChart = Chart::create([
            'chart_name' => $chartInfo['name'],
            'user_id' => $user->id
        ]);

        foreach ($chartData as $table_index => $table) {
            $createTable = TableGroup::create([
                'table_number' => $table_index,
                'chart_id' => $createChart->id
            ]);
            foreach ($table as $cell_index => $cell) {
                $createCell = Cell::create([
                    'cell_number' => $cell_index,
                    'value' => $cell['value'],
                    'table_id' => $createTable->id 
                ]);
            }
        }

        return response()->json(compact('createChart'));
    }

    public function update(Request $request) {

        $chartInfo = $request->input('chartInfo');
        $chartData = $request->input('chartData');

        $updateChart = Chart::findOrFail($chartInfo['id']);
        $updateChart->chart_name = $chartInfo['name'];
        $updateChart->save();

        $updateTables = TableGroup::where('chart_id', $updateChart->id)
                                    ->orderBy('table_number', 'asc')->get();

        foreach ($chartData as $table_index => $table) {
            foreach ($table as $cell_index => $cell) {
                $updateCell = Cell::where('table_id', $updateTables[$table_index]['id'])
                                    ->where('cell_number', $cell_index)->firstOrFail();
                $updateCell->value = $cell['value'];
                $updateCell->save();
            }
        }

        return response()->json(['message'=>'successfully updated']);

    }

    public function delete($id) {
        
        $deleteChart = Chart::findOrFail($id);
        $deleteChart->delete();

        return response()->json(['message'=>'successfully deleted']);

    }

}

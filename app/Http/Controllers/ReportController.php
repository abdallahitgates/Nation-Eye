<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Models\Report;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('type')
            ->where('user_id', auth()->id())
            ->get()
            ->map(function ($report) {
                return [
                    'id' => $report->id,
                    'description' => $report->description,
                    'type' => $report->type,
                    'user_id' => $report->user_id,
                    'user' => $report->user->name,
                    'location' => $report->location,
                    'll' => $report->ll,
                    'lg' => $report->lg,
                    'location' => $report->location,
                    'file_url' => $report->file_url,
                    'created_at' => Carbon::parse($report->created_at)->toDateTimeString(),
                    'updated_at' => Carbon::parse($report->updated_at)->toDateTimeString(),
                ];
            });

        return response()->json(['reports' => $reports]);
    }
    public function store(StoreReportRequest $request)
    {
        $path = $request->hasFile('file')
            ? $request->file('file')->store('reports', 'public')
            : null;
        $report = Report::create([
            'user_id' => auth()->id(),
            'report_type_id' => $request->report_type_id,
            'description' => $request->description,
            'location' => $request->location,
            'll' => $request->ll,
            'lg' => $request->lg,
            'file_path' => $path,
        ]);

        return response()->json(['message' => __('messages.report_created'), 'report' => $report]);
    }

    public function show(Report $report)
    {
        $report->load('type');

        return response()->json([
            'message' => __('messages.report_details'), // optional translation
            'report' => $report,
        ]);
    }
}

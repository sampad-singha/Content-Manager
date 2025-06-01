<?php

namespace App\Http\Controllers;

use App\DataTables\ContentsDataTable;
use App\Models\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Yajra\DataTables\DataTables;

class ContentController extends Controller
{

    /**
     * @throws \Exception
     */
    public function showContent(ContentsDataTable $dataTable)
    {
        $universities = \App\Models\Content::select('university')->distinct()->pluck('university');
//        return view('contents.index', compact('universities'));

        return $dataTable->render('all-contents',compact('universities'));
    }

    public function showContentById($id)
    {
        $content = Content::with('media')->where('id', $id)->first();
        return view('content', ['content' => $content]);
    }

    public function updateContent(Request $request, $id): RedirectResponse
    {
        $content = Content::findOrFail($id);

        $content->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ]);

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('media', 'public');

                $content->media()->create([
                    'name' => $file->getClientOriginalName(),
                    'type' => $file->getMimeType(),
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('contents.show', $id)->with('success', 'Content updated successfully.');

    }

    public function destroy($id): RedirectResponse
    {
        $content = Content::findOrFail($id);

        // Optional: Delete associated media files from storage
        foreach ($content->media as $media) {
            \Storage::disk('public')->delete($media->path);
            $media->delete();
        }

        $content->delete();

        return redirect()->route('contents.index')->with('success', 'Content deleted successfully.');
    }

    public function store(Request $request)
    {
        $description = json_decode($request->description, true);

        // Create content
        $content = Content::create([
            'name' => $request['name'],
            'description' => $description,
            'status' => $request['status'],
        ]);

        // Handle media uploads, if any
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('media', 'public');
                $content->media()->create([
                    'name' => $file->getClientOriginalName(),
                    'type' => $file->getMimeType(),
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('contents.show', $content->id)
            ->with('success', 'Content created successfully.');
    }

    public function create()
    {
        return view('create-content');
    }

    public function export(): StreamedResponse
    {
        $filename = 'contents_' . now()->format('Ymd_His') . '.csv';

        $contents = Content::all(['id', 'name', 'description', 'status']);

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($contents) {
            $columns = ['ID', 'Name', 'Description', 'Status'];
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($contents as $content) {
                fputcsv($file, [
                    $content->id,
                    $content->name,
                    $content->description,
                    ucfirst($content->status),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

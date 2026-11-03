<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PostReportController extends Controller
{
    public function index(Request $request): View
    {
        $data = $this->getReportData($request);

        return view('posts.reports.index', $data);
    }

    public function exportPdf(Request $request): Response
    {
        $data = $this->getReportData($request);

        $pdf = Pdf::loadView('posts.reports.pdf', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download('lastname_blog_report.pdf');
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $data = $this->getReportData($request);
        $posts = $data['posts'];

        return response()->streamDownload(function () use ($posts) {
            $file = fopen('php://output', 'w');

            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['ID', 'Title', 'Body', 'Created At'], ',', '"', '');

            foreach ($posts as $post) {
                fputcsv($file, [
                    $post->id,
                    $this->csvText($post->title),
                    $this->csvText($post->body),
                    $post->created_at->format('Y-m-d H:i:s'),
                ], ',', '"', '');
            }

            fclose($file);
        }, 'lastname_blog_report.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function getReportData(Request $request): array
    {
        $endDateRules = ['nullable', 'date_format:Y-m-d'];

        if ($request->filled('start_date')) {
            $endDateRules[] = 'after_or_equal:start_date';
        }

        $validated = $request->validate([
            'start_date' => ['nullable', 'date_format:Y-m-d'],
            'end_date' => $endDateRules,
        ]);

        $startDate = $validated['start_date'] ?? null;
        $endDate = $validated['end_date'] ?? null;

        $query = $request->user()->posts();

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $posts = $query->latest()->orderByDesc('id')->get();

        return [
            'posts' => $posts,
            'totalPosts' => $posts->count(),
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
    }

    private function csvText(?string $value): string
    {
        return trim((string) preg_replace('/\s+/', ' ', $value ?? ''));
    }
}

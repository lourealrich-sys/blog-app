<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Post Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 12px;
        }

        h1 {
            margin-bottom: 8px;
            font-size: 24px;
        }

        .meta {
            margin-bottom: 16px;
            color: #4b5563;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
        }
    </style>
</head>
<body>
    <h1>Post Report</h1>
    <div class="meta">
        <p>Generated: {{ now()->format('F j, Y') }}</p>
        <p>Total posts: {{ $totalPosts }}</p>
        @if ($startDate || $endDate)
            <p>Date range: {{ $startDate ?: 'Earliest' }} to {{ $endDate ?: 'Latest' }}</p>
        @endif
    </div>

    @if ($posts->isEmpty())
        <p>No posts match the selected dates.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->body }}</td>
                        <td>{{ $post->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>

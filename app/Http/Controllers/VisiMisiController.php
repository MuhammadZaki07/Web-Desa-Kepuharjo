<?php

namespace App\Http\Controllers;

use App\Helpers\TimeHelper;
use App\Models\ProfileDesa;
use App\Services\ArticleService;

class VisiMisiController extends Controller
{
    public function index()
    {
        $timeData = TimeHelper::getFormattedTime();
        $tanggal = $timeData['tanggal'];
        $jam = $timeData['jam'];
        $format = $timeData['format'];

        $headlines = ArticleService::getHeadlines();
        $blogs = ArticleService::getLatestPublishedBlogs();

        $ProfileDesa = ProfileDesa::first();
        $title = 'Visi Misi';

        return view('pages.VisiMisi', compact(
            'tanggal',
            'jam',
            'format',
            'ProfileDesa',
            'headlines',
            'blogs',
            'title'
        ));
    }
}
?>

<?php
/**
 * This file is part of the Volta Project.
 *
 * Copyright (c) 2018 - 2019. AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

namespace App\Http\Controllers;

use App\Documentation;
use Symfony\Component\DomCrawler\Crawler;

class DocsController extends Controller
{
    /**
     * The documentation repository.
     *
     * @var Documentation
     */
    protected $docs;

    /**
     * Create a new controller instance.
     *
     * @param  Documentation $docs
     * @return void
     */
    public function __construct(Documentation $docs)
    {
        $this->middleware('auth'); // Only registered users can read the docs (for now)
        $this->docs = $docs;
    }

    /**
     * Show a documentation page.
     *
     * @param  string|null $page
     * @return \Illuminate\View\View
     */
    public function show($page = null)
    {
        $sectionPage = $page ?: 'introduction';
        $content = $this->docs->get($sectionPage);

        if (\is_null($content)) {
            return response()->view('docs', [
                'title' => 'Page not found',
                'index' => $this->docs->getIndex(),
                'content' => view('partials.doc_missing'),
            ], 404);
        }

        $title = (new Crawler($content))->filterXPath('//h1');

        return view('layouts.docs', [
            'title' => \count($title) ? $title->text() : null,
            'index' => $this->docs->getIndex(),
            'content' => $content,
        ]);
    }

    /**
     * Shows the wishlist page.
     *
     * This page is slightly different as it is generated using a JSON file
     * containing the list of feature requests.
     *
     * @return \Illuminate\View\View
     */
    public function wishlist()
    {
        $title = 'Wishlist / Feature Requests';

        $content = view('wishlist', ['title' => $title, 'requests' => \json_decode(\file_get_contents(resource_path('docs/requests.json')), true)]);

        return view('layouts.docs', [
            'title' => $title,
            'index' => $this->docs->getIndex(),
            'content' => $content,
        ]);
    }
}

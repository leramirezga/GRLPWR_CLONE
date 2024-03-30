<?php

namespace App\View\Composers;

use App\HighlightSection;
use Illuminate\View\View;

class HighlightComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $highlightSections = HighlightSection::where('end_date', '>=', today())
            ->where(function($q) {
                $q->where('start_date', '<=', today())
                    ->orWhereNull('start_date');
            })->get();
        $view->with([
            'highlightSections' => $highlightSections,
        ]);
    }
}
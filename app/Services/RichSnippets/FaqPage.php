<?php

namespace App\Services\RichSnippets;

use Post;

class FaqPage
{
    public function render()
    {
        $faqs = Post::allBlocks()
        ->filter(fn ($block) => $block['blockName'] === 'acf/accordion')
        ->filter(fn ($block) => isset($block['attrs']['data']['items']) && $block['attrs']['data']['items'] > 0)
        ->flatMap(function ($block) {
            $itemCount = $block['attrs']['data']['items'];

            return collect(range(0, $itemCount - 1))->map(function ($index) use ($block) {
                return [
                    'question' => $block['attrs']['data']["items_{$index}_question"],
                    'answer' => $block['attrs']['data']["items_{$index}_answer"],
                ];
            });
        })
        ->map(function ($item) {
            return [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['answer'],
                ],
            ];
        });

        if ($faqs->isNotEmpty()) {
            echo view('partials.schema.faq', [
                'items' => $faqs->take(20)->toJson(),
            ])->render();
        }
    }
}

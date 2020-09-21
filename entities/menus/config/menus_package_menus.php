<?php

return [

    'menuable' => [
        [
            'type' => 'category',
            'title' => 'Категория',
            'suggestions' => 'back.categories.getSuggestions',
        ],
        [
            'type' => 'tag',
            'title' => 'Тег',
            'suggestions' => 'back.tags.getSuggestions',
        ],
        [
            'type' => 'article',
            'title' => 'Статья',
            'suggestions' => 'back.articles.getSuggestions',
        ],
        [
            'type' => 'ingredient',
            'title' => 'Ингредиент',
            'suggestions' => 'back.ingredients.getSuggestions',
        ],
        [
            'type' => 'page',
            'title' => 'Страница',
            'suggestions' => 'back.pages.getSuggestions',
        ],
    ],
];

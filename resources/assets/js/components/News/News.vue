<!--
  - This file is part of the Volta Project.
  -
  - Copyright (c) 2018 - 2019. AzuyaLabs
  -
  - For the full copyright and license information, please view the LICENSE
  - file that was distributed with this source code.
  -
  - @author Sacha Telgenhof <me@sachatelgenhof.com>
  -->

<template>
    <div class="card card-default">
        <!-- Card Header -->
        <div class="container-fluid row pr-0">
            <i18n path="main_title" tag="div" class="card-title pl-2">
                <a place="feed" href="https://3dprint.com/" target="_blank" rel="noreferrer">3DPrint.com</a>
            </i18n>
        </div>

        <!-- Card Body -->
        <div class="card-body pt-0">
            <b-list-group flush v-if="articles.length">
                <b-list-group-item
                    :href="article.link"
                    target="_blank"
                    rel="noreferrer"
                    v-for="article in articles"
                    :key="article.guid"
                >
                    {{ article.title }}
                </b-list-group-item>
            </b-list-group>
        </div>

        <!-- Card Footer -->
        <div class="footer-text">
            {{ $t('footer_text') }}
        </div>
    </div>
</template>

<script>
import RSSParser from 'rss-parser';

export default {
    i18n: require('./news_i18n.js'),

    data() {
        return {
            articles: [],
        };
    },
    created() {
        this.refreshFeed();
        setInterval(this.refreshFeed, 3600 * 1000); // Refresh every hour
    },
    methods: {
        async refreshFeed() {
            let parser = new RSSParser();
            let feed = await parser.parseURL(
                'https://cors-anywhere.herokuapp.com/https://3dprint.com/feed/'
            );

            // Get most recent articles
            this.articles = feed.items
                .sort(function(a, b) {
                    return new Date(b.isoDate) - new Date(a.isoDate);
                })
                .slice(0, 4);
        },
    },
};
</script>

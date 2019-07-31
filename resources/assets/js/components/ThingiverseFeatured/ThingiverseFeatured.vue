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
                <a place="feed" href="https://thingiverse.com/" target="_blank" rel="noreferrer"
                    >Thingiverse</a
                >
            </i18n>
        </div>

        <!-- Card Body -->
        <div class="card-body pt-0">
            <b-carousel
                v-if="thingies.length"
                id="carousel-thingiverse"
                style="text-shadow: 0 0 2px #000"
                fade
                indicators
                img-height="200"
                img-width="50"
            >
                <b-link
                    v-for="thing in thingies"
                    :key="thing.guid"
                    :href="thing.link"
                    target="_blank"
                    rel="noreferrer"
                >
                    <b-carousel-slide
                        :caption="thing.title"
                        :img-src="getImage(thing.content)"
                    ></b-carousel-slide>
                </b-link>
            </b-carousel>
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
    i18n: require('./thingiverse_featured_i18n.js'),

    data() {
        return {
            thingies: [],
        };
    },

    created() {
        this.refreshFeed();
        setInterval(this.refreshFeed, 3600 * 1000); // Refresh every hour
    },

    methods: {
        getImage(content) {
            let elem = document.createElement('div');
            elem.innerHTML = content;

            let images = elem.getElementsByTagName('img');

            return images[0].src;
        },

        async refreshFeed() {
            let parser = new RSSParser();
            let feed = await parser.parseURL(
                'https://cors-anywhere.herokuapp.com/https://www.thingiverse.com/rss/popular/'
            );

            // Get most recent 5 thingies
            this.thingies = feed.items
                .sort(function(a, b) {
                    return new Date(b.isoDate) - new Date(a.isoDate);
                })
                .slice(0, 5);
        },
    },
};
</script>

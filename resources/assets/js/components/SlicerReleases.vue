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
            <div class="card-title pl-2">
                The latest releases of your favourite slicers
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body pt-0">
            <div class="list-group list-group-flush" v-if="releases.length">
                <div
                    class="list-group-item list-group-item-action flex-column align-items-start"
                    v-for="release in releases"
                >
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">{{ release.name }}</h6>
                        <small>
                            <relative-date :moment="release.date"></relative-date>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Footer -->
        <div class="footer-text"></div>
    </div>
</template>

<script>
import github from '../services/github/Github';
import RelativeDate from './atoms/RelativeDate';
import moment from 'moment';

export default {
    components: {
        RelativeDate,
    },

    data() {
        return {
            releases: [],
        };
    },
    created() {
        this.fetchLatestSlic3rPE();
        this.fetchLatestSlic3r();
        this.fetchLatestCura();
        this.fetchLatestSimplify3D();
    },
    methods: {
        async fetchLatestSlic3rPE() {
            const release = await github.latestRelease('prusa3d', 'Slic3r');

            this.releases.push({
                name: release.name,
                date: moment(release.published_at, 'YYYY-MM-DDTHH:mm:ssZ'),
            });
        },

        async fetchLatestSlic3r() {
            const release = await github.latestRelease('alexrj', 'Slic3r');

            this.releases.push({
                name: release.name,
                date: moment(release.published_at, 'YYYY-MM-DDTHH:mm:ssZ'),
            });
        },

        async fetchLatestSimplify3D() {
            this.releases.push({
                name: 'Simplify3D 4.1.0',
                date: moment('2018-11-06', 'YYYY-MM-DDTHH:mm:ssZ'),
            });
        },

        async fetchLatestCura() {
            const release = await github.latestRelease('Ultimaker', 'Cura');

            this.releases.push({
                name: 'Cura ' + release.name,
                date: moment(release.published_at, 'YYYY-MM-DDTHH:mm:ssZ'),
            });
        },
    },
};
</script>

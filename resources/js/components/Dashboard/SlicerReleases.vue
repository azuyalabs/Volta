<template>
    <tile :position="position">
        <section>
            <h1 v-text="$t('title')" />
            <ul v-if="slicer_releases.length > 0">
                <li v-for="slicer in slicer_releases" class="slicer__release">
                    <span
                        v-text="slicer.name + ' ' + slicer.version"
                        class="slicer__release-version"
                    />
                    <span class="pill-new" v-if="isNew(slicer.release_date)" v-text="$t('new')" />
                    <span
                        v-else
                        v-text="diffForHumans(slicer.release_date)"
                        class="slicer__release-date"
                    />
                </li>
            </ul>
            <div v-else class="content-center" v-text="$t('no_releases')"></div>
        </section>
    </tile>
</template>

<script>
import Tile from './atoms/Tile';
import saveState from 'vue-save-state';
import { diffForHumans, isNew } from '../../helpers';
import axios from 'axios';

export default {
    i18n: {
        messages: {
            'en-US': {
                title: 'Slicer Releases',
                no_releases: 'No releases discovered (yet)',
                new: 'New',
            },
        },
    },

    props: ['position'],

    components: {
        Tile,
    },

    mixins: [saveState],

    data() {
        return {
            slicer_releases: [],
        };
    },

    created() {
        // Nudge Volta to fetch the slicer releases
        if (_.isEmpty(this.slicer_releases)) {
            axios.post('/api/dashboard/update/slicers');
        }

        this.$root.echo
            .channel('slicer_releases')
            .listen('SlicerReleases.SlicerReleasesFetched', response => {
                this.slicer_releases = response.slicer_releases;
            });
    },

    methods: {
        diffForHumans,
        isNew,

        getSaveStateConfig() {
            return {
                cacheKey: 'slicer-releases',
            };
        },
    },
};
</script>
